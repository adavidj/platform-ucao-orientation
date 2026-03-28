<?php
// =================================================================
// CLASSE Notification — Gestion des notifications email admin
// =================================================================

class Notification {

    /**
     * Envoyer une notification groupée
     */
    public static function send($sujet, $message, $typeCible, $filtreSerie = null, $filtreFiliere = null, $adminId = null) {
        $pdo = Database::getInstance();
        
        // Récupérer les destinataires
        $destinataires = self::getDestinataires($typeCible, $filtreSerie, $filtreFiliere);
        
        if (empty($destinataires)) {
            return ['success' => false, 'message' => 'Aucun destinataire trouvé avec ces critères.'];
        }

        // Envoyer les emails
        $mailer = new Mailer();
        $emails = array_column($destinataires, 'email');
        $result = $mailer->sendBulk($emails, $sujet, $message);

        // Enregistrer en historique
        $stmt = $pdo->prepare("
            INSERT INTO notifications (sujet, message, destinataires, nb_destinataires, type_cible, filtre_serie, filtre_filiere, admin_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $sujet,
            $message,
            json_encode($emails),
            count($emails),
            $typeCible,
            $filtreSerie,
            $filtreFiliere,
            $adminId
        ]);

        return [
            'success' => true,
            'message' => 'Notification envoyée à ' . count($emails) . ' destinataire(s).',
            'count' => count($emails)
        ];
    }

    /**
     * Récupérer les destinataires selon le ciblage
     */
    public static function getDestinataires($typeCible, $filtreSerie = null, $filtreFiliere = null) {
        $pdo = Database::getInstance();
        $where = [];
        $params = [];

        if ($typeCible === 'orientations' || $typeCible === 'tous') {
            $query = "SELECT DISTINCT email, nom, prenom FROM orientations";
            if ($filtreSerie) {
                $where[] = "serie_bac = ?";
                $params[] = $filtreSerie;
            }
            $whereClause = !empty($where) ? ' WHERE ' . implode(' AND ', $where) : '';
            $stmt = $pdo->prepare($query . $whereClause);
            $stmt->execute($params);
            $orientations = $stmt->fetchAll();
        }

        if ($typeCible === 'preinscriptions' || $typeCible === 'tous') {
            $where2 = [];
            $params2 = [];
            $query2 = "SELECT DISTINCT email, nom, prenom FROM preinscriptions";
            if ($filtreSerie) {
                $where2[] = "serie_bac = ?";
                $params2[] = $filtreSerie;
            }
            if ($filtreFiliere) {
                $where2[] = "filiere_choisie = ?";
                $params2[] = $filtreFiliere;
            }
            $whereClause2 = !empty($where2) ? ' WHERE ' . implode(' AND ', $where2) : '';
            $stmt2 = $pdo->prepare($query2 . $whereClause2);
            $stmt2->execute($params2);
            $preinscriptions = $stmt2->fetchAll();
        }

        // Fusionner et dédupliquer par email
        $all = [];
        if (isset($orientations)) {
            foreach ($orientations as $o) $all[$o['email']] = $o;
        }
        if (isset($preinscriptions)) {
            foreach ($preinscriptions as $p) $all[$p['email']] = $p;
        }

        return array_values($all);
    }

    /**
     * Compter les destinataires potentiels (pour l'aperçu AJAX)
     */
    public static function countDestinataires($typeCible, $filtreSerie = null, $filtreFiliere = null) {
        return count(self::getDestinataires($typeCible, $filtreSerie, $filtreFiliere));
    }

    /**
     * Historique des notifications
     */
    public static function getHistory($page = 1, $perPage = ITEMS_PER_PAGE) {
        $pdo = Database::getInstance();
        
        $countStmt = $pdo->query("SELECT COUNT(*) FROM notifications");
        $total = $countStmt->fetchColumn();

        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("
            SELECT n.*, a.nom AS admin_nom
            FROM notifications n
            LEFT JOIN admins a ON n.admin_id = a.id
            ORDER BY n.envoye_le DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$perPage, $offset]);
        $data = $stmt->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
        ];
    }
}
