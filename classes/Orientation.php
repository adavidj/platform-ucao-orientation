<?php
// =================================================================
// CLASSE Orientation — Gestion des orientations
// =================================================================

class Orientation {

    /**
     * Lister les orientations avec filtres et pagination
     */
    public static function getAll($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $pdo = Database::getInstance();
        $where = [];
        $params = [];

        if (!empty($filters['date_debut'])) {
            $where[] = "o.created_at >= ?";
            $params[] = $filters['date_debut'] . ' 00:00:00';
        }
        if (!empty($filters['date_fin'])) {
            $where[] = "o.created_at <= ?";
            $params[] = $filters['date_fin'] . ' 23:59:59';
        }
        if (!empty($filters['serie_bac'])) {
            $where[] = "o.serie_bac = ?";
            $params[] = $filters['serie_bac'];
        }
        if (!empty($filters['metier'])) {
            $where[] = "o.metier_souhaite LIKE ?";
            $params[] = '%' . $filters['metier'] . '%';
        }
        if (!empty($filters['filiere'])) {
            $where[] = "o.filieres_recommandees LIKE ?";
            $params[] = '%' . $filters['filiere'] . '%';
        }
        if (!empty($filters['search'])) {
            $where[] = "(o.nom LIKE ? OR o.prenom LIKE ? OR o.email LIKE ?)";
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Compter le total
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM orientations o $whereClause");
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();

        // Pagination
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("SELECT o.* FROM orientations o $whereClause ORDER BY o.created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
        ];
    }

    /**
     * Obtenir une orientation par ID
     */
    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM orientations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Compter les orientations (total ou ce mois)
     */
    public static function getCount($period = 'total') {
        $pdo = Database::getInstance();
        if ($period === 'month') {
            $stmt = $pdo->query("SELECT COUNT(*) FROM orientations WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
        } else {
            $stmt = $pdo->query("SELECT COUNT(*) FROM orientations");
        }
        return $stmt->fetchColumn();
    }

    /**
     * Compter les rapports PDF générés
     */
    public static function getPDFCount() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT COUNT(*) FROM orientations WHERE rapport_pdf_path IS NOT NULL AND rapport_pdf_path != ''");
        return $stmt->fetchColumn();
    }

    /**
     * Top métiers demandés (pour graphique barres)
     */
    public static function getTopMetiers($limit = 10) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT metier_souhaite AS label, COUNT(*) AS total
            FROM orientations
            GROUP BY metier_souhaite
            ORDER BY total DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Top filières recommandées (pour graphique camembert)
     */
    public static function getTopFilieres($limit = 8) {
        $pdo = Database::getInstance();
        // Les filières sont stockées en JSON/texte, on fait un GROUP BY sur le champ
        $stmt = $pdo->prepare("
            SELECT filieres_recommandees AS label, COUNT(*) AS total
            FROM orientations
            WHERE filieres_recommandees IS NOT NULL AND filieres_recommandees != ''
            GROUP BY filieres_recommandees
            ORDER BY total DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Obtenir l'évolution temporelle (30 derniers jours) pour les graphiques
     */
    public static function getEvolutionData($days = 30) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT DATE(created_at) AS date, COUNT(*) AS total
            FROM orientations
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtenir la répartition par série de BAC
     */
    public static function getSerieBacRepartition() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("
            SELECT serie_bac AS label, COUNT(*) AS total
            FROM orientations
            WHERE serie_bac IS NOT NULL AND serie_bac != ''
            GROUP BY serie_bac
            ORDER BY total DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Calculer le taux de conversion (Orientés -> Préinscrits)
     */
    public static function getConversionRate() {
        $pdo = Database::getInstance();
        $total_o = $pdo->query("SELECT COUNT(*) FROM orientations")->fetchColumn();
        $total_p = $pdo->query("SELECT COUNT(*) FROM preinscriptions")->fetchColumn();
        
        if ($total_o == 0) return 0;
        return round(($total_p / $total_o) * 100, 1);
    }

    /**
     * Dernières orientations
     */
    public static function getRecent($limit = 10) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM orientations ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Marquer l'email comme envoyé
     */
    public static function markEmailSent($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE orientations SET email_envoye = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Exporter en CSV
     */
    public static function exportCSV($filters = []) {
        $result = self::getAll($filters, 1, 999999);
        $data = $result['data'];

        $filename = 'orientations_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        // BOM pour Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // En-têtes
        fputcsv($output, ['ID', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Série Bac', 'Numéro Table', 'Métier Souhaité', 'Filières Recommandées', 'Email Envoyé', 'Date'], ';');
        
        foreach ($data as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['telephone'],
                $row['serie_bac'],
                $row['numero_table'] ?? '',
                $row['metier_souhaite'],
                $row['filieres_recommandees'],
                $row['email_envoye'] ? 'Oui' : 'Non',
                date_fr($row['created_at']),
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
