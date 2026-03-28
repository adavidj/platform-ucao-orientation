<?php
// =================================================================
// CLASSE Preinscription — Gestion des préinscriptions
// =================================================================

class Preinscription {

    /**
     * Lister avec filtres et pagination
     */
    public static function getAll($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $pdo = Database::getInstance();
        $where = [];
        $params = [];

        if (!empty($filters['filiere'])) {
            $where[] = "p.filiere_choisie = ?";
            $params[] = $filters['filiere'];
        }
        if (!empty($filters['date_debut'])) {
            $where[] = "p.created_at >= ?";
            $params[] = $filters['date_debut'] . ' 00:00:00';
        }
        if (!empty($filters['date_fin'])) {
            $where[] = "p.created_at <= ?";
            $params[] = $filters['date_fin'] . ' 23:59:59';
        }
        if (!empty($filters['serie_bac'])) {
            $where[] = "p.serie_bac = ?";
            $params[] = $filters['serie_bac'];
        }
        if (!empty($filters['search'])) {
            $where[] = "(p.nom LIKE ? OR p.prenom LIKE ? OR p.email LIKE ?)";
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Compter le total
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM preinscriptions p $whereClause");
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();

        // Pagination
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("
            SELECT p.*, f.nom_filiere, f.ecole_faculte
            FROM preinscriptions p
            LEFT JOIN filieres f ON p.filiere_choisie = f.id
            $whereClause
            ORDER BY p.created_at DESC
            LIMIT $perPage OFFSET $offset
        ");
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
     * Obtenir une préinscription par ID (dossier complet)
     */
    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT p.*, f.nom_filiere, f.ecole_faculte, f.description AS filiere_description, f.debouches
            FROM preinscriptions p
            LEFT JOIN filieres f ON p.filiere_choisie = f.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Compter (total ou ce mois)
     */
    public static function getCount($period = 'total') {
        $pdo = Database::getInstance();
        if ($period === 'month') {
            $stmt = $pdo->query("SELECT COUNT(*) FROM preinscriptions WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
        } else {
            $stmt = $pdo->query("SELECT COUNT(*) FROM preinscriptions");
        }
        return $stmt->fetchColumn();
    }

    /**
     * Obtenir l'évolution temporelle (30 derniers jours) pour graphiques
     */
    public static function getEvolutionData($days = 30) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT DATE(created_at) AS date, COUNT(*) AS total
            FROM preinscriptions
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Dernières préinscriptions
     */
    public static function getRecent($limit = 10) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT p.*, f.nom_filiere, f.ecole_faculte
            FROM preinscriptions p
            LEFT JOIN filieres f ON p.filiere_choisie = f.id
            ORDER BY p.created_at DESC LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Exporter en CSV
     */
    public static function exportCSV($filters = []) {
        $result = self::getAll($filters, 1, 999999);
        $data = $result['data'];

        $filename = 'preinscriptions_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Nom', 'Prénom', 'Date Naissance', 'Nationalité', 'Série Bac', 'Année Bac', 'Établissement', 'Filière Choisie', 'Niveau Entrée', 'Email', 'Téléphone', 'Date'], ';');
        
        foreach ($data as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['date_naissance'],
                $row['nationalite'],
                $row['serie_bac'],
                $row['annee_bac'],
                $row['etablissement_origine'],
                $row['nom_filiere'] ?? 'N/A',
                $row['niveau_entree'],
                $row['email'],
                $row['telephone'],
                date_fr($row['created_at']),
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}
