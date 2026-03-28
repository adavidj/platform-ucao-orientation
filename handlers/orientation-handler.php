<?php
/**
 * Handler d'Orientation
 * Reçoit les données POST via AJAX, exécute l'algo de recommandation, génère le PDF et retourne l'URL.
 */

// Inclure la configuration globale (autoload, session, db)
require_once dirname(__DIR__) . '/config/app.php';

header('Content-Type: application/json');

// Uniquement POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Vérification CSRF
$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? '';
if (!verify_csrf($csrf_token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Session expirée ou requête invalide (CSRF).']);
    exit;
}

// Nettoyage des entrées
$nom = trim(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING));
$prenom = trim(filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING));
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$telephone = trim(filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING));
$serie_bac = trim(filter_input(INPUT_POST, 'serie_bac', FILTER_SANITIZE_STRING));
$numero_table = trim(filter_input(INPUT_POST, 'numero_table', FILTER_SANITIZE_STRING));
$metier_souhaite = trim(filter_input(INPUT_POST, 'metier_souhaite', FILTER_SANITIZE_STRING));

// Validation basique
if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($serie_bac) || empty($metier_souhaite)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'L\'adresse email est invalide.']);
    exit;
}

try {
    $pdo = Database::getInstance();
    
    // ==========================================
    // MOTEUR DE RECOMMANDATION (Métier -> Filières)
    // ==========================================
    $filieres_recommandees = '';
    
    // Recherche par concordance (LIKE) du métier
    $stmt = $pdo->prepare("SELECT id FROM metiers WHERE nom_metier LIKE ? LIMIT 1");
    $stmt->execute(['%' . $metier_souhaite . '%']);
    $metier = $stmt->fetch();
    
    if ($metier) {
        // Le métier existe, trouver les filières associées
        $stmtFil = $pdo->prepare("
            SELECT f.nom_filiere, f.ecole_faculte 
            FROM filieres f
            JOIN metiers_filieres mf ON f.id = mf.filiere_id
            WHERE mf.metier_id = ?
        ");
        $stmtFil->execute([$metier['id']]);
        $filieres = $stmtFil->fetchAll();
        
        if ($filieres) {
            $noms_filieres = [];
            foreach ($filieres as $f) {
                // Construction du bloc de texte pour le PDF
                $noms_filieres[] = "• " . $f['nom_filiere'] . " (" . $f['ecole_faculte'] . ")";
            }
            $filieres_recommandees = implode("<br>", $noms_filieres);
        }
    }
    
    // Fallback si aucune filière exacte n'a été trouvée pour ce métier
    if (empty($filieres_recommandees)) {
        $filieres_recommandees = "Nous vous recommandons de prendre rendez-vous avec notre conseiller d'orientation pour explorer la meilleure voie académique concernant le métier de : " . htmlspecialchars($metier_souhaite);
    }
    
    // ==========================================
    // ENREGISTREMENT ET GÉNÉRATION
    // ==========================================
    
    // 1. Insertion dans la BD
    $stmtInsert = $pdo->prepare("
        INSERT INTO orientations 
        (nom, prenom, email, telephone, serie_bac, numero_table, metier_souhaite, filieres_recommandees, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmtInsert->execute([
        $nom, $prenom, $email, $telephone, $serie_bac, $numero_table, $metier_souhaite, $filieres_recommandees
    ]);
    
    $orientationId = $pdo->lastInsertId();
    
    // 2. Générer le PDF (Délègue à la classe existante qui crée le DOMPDF et update la DB)
    $pdfPath = Rapport::generateOrientationPDF($orientationId);
    
    // 3. Envoi potentiel de l'email (si activé/configuré)
    // Par défaut, le cron admin enverra les réponses détaillées ou on pourrait le faire ici directement
    
    // Fin, on retourne les liens à l'interface
    echo json_encode([
        'success' => true,
        'message' => 'Votre rapport a été généré avec succès !',
        'download_url' => 'telecharger-rapport.php?id=' . $orientationId
    ]);

} catch (Exception $e) {
    http_response_code(500);
    // Log exception in real world, hide details to user
    echo json_encode(['success' => false, 'message' => 'Erreur serveur lors de la génération: ' . $e->getMessage()]);
}
