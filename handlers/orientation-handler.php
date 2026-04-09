<?php
/**
 * Handler d'Orientation
 * Reçoit les données POST via AJAX, exécute l'algo de recommandation, génère le PDF et retourne l'URL.
 */

// Inclure la configuration globale (autoload, session, db)
require_once dirname(__DIR__) . '/config/config.php';
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
$nom = trim(htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8'));
$prenom = trim(htmlspecialchars($_POST['prenom'] ?? '', ENT_QUOTES, 'UTF-8'));
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$telephone = trim(htmlspecialchars($_POST['telephone'] ?? '', ENT_QUOTES, 'UTF-8'));
$serie_bac = trim(htmlspecialchars($_POST['serie_bac'] ?? '', ENT_QUOTES, 'UTF-8'));
$numero_table = trim(htmlspecialchars($_POST['numero_table'] ?? '', ENT_QUOTES, 'UTF-8'));
$metier_souhaite = trim(htmlspecialchars($_POST['metier_souhaite'] ?? '', ENT_QUOTES, 'UTF-8'));

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
    
    // 3. Envoi de l'email avec la pièce jointe PDF
    $emailSent = false;
    try {
        $mailer = new Mailer();
        $emailSujet = "Votre Rapport d'Orientation UCAO";

        $emailCorps = '
        <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f5f5f5;">
            <tr>
                <td align="center" style="padding: 20px;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <tr>
                            <td style="background: linear-gradient(135deg, #180391 0%, #8B0000 100%); padding: 32px 24px; text-align: center;">
                                <h1 style="color: #FFFFFF; margin: 0; font-size: 24px; font-weight: 700; font-family: Arial, sans-serif;">UCAO Orientation</h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 32px 24px; color: #333333; font-family: Arial, sans-serif; line-height: 1.6; font-size: 15px;">
                                <h2 style="margin: 0 0 16px 0; color: #180391; font-size: 18px;">Bonjour ' . htmlspecialchars($prenom) . ',</h2>
                                <p style="margin: 0 0 16px 0;">Merci d\'avoir utilisé notre <strong>plateforme décisionnelle d\'orientation</strong> !</p>
                                <p style="margin: 0 0 16px 0;">Suite à votre souhait pour le domaine de <strong style="color: #8B0000;">' . htmlspecialchars($metier_souhaite) . '</strong>, vous trouverez en pièce jointe votre rapport détaillé d\'orientation généré automatiquement.</p>
                                <div style="margin: 24px 0; padding: 16px; background: #f0f7ff; border-radius: 8px; border-left: 4px solid #180391;">
                                    <p style="margin: 0; color: #1a56db;"><strong>📎 Pièce jointe :</strong> Votre rapport d\'orientation personnalisé</p>
                                </div>
                                <p style="margin: 24px 0 0 0;">Cordialement,<br><strong>L\'équipe d\'Orientation de l\'UCAO BENIN</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #f9f9f9; padding: 24px; border-top: 1px solid #eee; text-align: center; color: #999999; font-family: Arial, sans-serif; font-size: 12px;">
                                <p style="margin: 0 0 8px 0;"><strong>UCAO-UUC — Cotonou, Bénin</strong></p>
                                <p style="margin: 0;">Ceci est un mail automatique. Merci de ne pas y répondre.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        // $pdfPath est déjà le chemin absolu complet retourné par Rapport::generateOrientationPDF()
        $cheminAbsoluPdf = $pdfPath;

        $result = $mailer->send($email, $emailSujet, $emailCorps, [$cheminAbsoluPdf]);

        if ($result['success']) {
            $emailSent = true;
            // Marquer l'email comme envoyé
            $stmtUpdate = $pdo->prepare("UPDATE orientations SET email_envoye = 1 WHERE id = ?");
            $stmtUpdate->execute([$orientationId]);
        }

    } catch (Exception $e) {
        // Enregistrement de l'erreur email silencieusement, l'utilisateur a toujours le lien de téléchargement direct
        error_log("Alerte: Impossible d'envoyer le mail - " . $e->getMessage());
    }
    
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
