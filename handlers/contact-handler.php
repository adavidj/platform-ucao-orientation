<?php
/**
 * Handler Contact
 * Traite les soumissions du formulaire de contact
 * Envoie les email de confirmation et notification admin
 */

// Activer la gestion des erreurs gracieuse
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED || $errno === E_NOTICE || $errno === E_WARNING) {
        error_log("Notice/Warning: $errstr in $errfile on line $errline");
        return true;
    }
    if (ob_get_length()) ob_clean();
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $errstr]);
    exit;
});

set_exception_handler(function($exception) {
    if (ob_get_length()) ob_clean();
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'message' => 'Exception: ' . $exception->getMessage()]);
    exit;
});

ob_start();
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/app.php';
if (ob_get_length()) ob_clean();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

$nom = trim(filter_input(INPUT_POST, 'nom', FILTER_UNSAFE_RAW) ?? '');
$prenom = trim(filter_input(INPUT_POST, 'prenom', FILTER_UNSAFE_RAW) ?? '');
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$telephone = trim(filter_input(INPUT_POST, 'telephone', FILTER_UNSAFE_RAW) ?? '') ?: '';
$sujet = trim(filter_input(INPUT_POST, 'sujet', FILTER_UNSAFE_RAW) ?? '');
$message = trim(filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW) ?? '');

$erreurs = [];
if (empty($nom)) $erreurs[] = 'Le nom est obligatoire.';
if (empty($prenom)) $erreurs[] = 'Le prénom est obligatoire.';
if (empty($email)) { $erreurs[] = 'L\'email est obligatoire.'; } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erreurs[] = 'L\'adresse email est invalide.'; }
if (empty($sujet)) $erreurs[] = 'Le sujet est obligatoire.';
if (empty($message)) $erreurs[] = 'Le message est obligatoire.';

if (!empty($erreurs)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Veuillez corriger les erreurs suivantes :', 'errors' => $erreurs]);
    exit;
}

try {
    $pdo = Database::getInstance();
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages_contact (id INT PRIMARY KEY AUTO_INCREMENT, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(20), sujet VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, lu TINYINT DEFAULT 0, repondu TINYINT DEFAULT 0, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX idx_email (email), INDEX idx_created_at (created_at))");
    
    $stmtInsert = $pdo->prepare("INSERT INTO messages_contact (nom, prenom, email, telephone, sujet, message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmtInsert->execute([$nom, $prenom, $email, $telephone, $sujet, $message]);
    $messageId = $pdo->lastInsertId();
    
    $mailer = new Mailer();
    $nom_safe = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
    $prenom_safe = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
    $email_safe = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $sujet_safe = htmlspecialchars($sujet, ENT_QUOTES, 'UTF-8');
    $message_safe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    
    $site_name = defined('SITE_NAME') ? SITE_NAME : 'UCAO';
    
    $htmlBody = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'><div style='background-color: #180391; color: white; padding: 20px; text-align: center;'><h1 style='margin: 0;'>$site_name</h1><p>Confirmation de message reçu</p></div><div style='background-color: #f8f9fc; padding: 30px;'><h2 style='color: #1a1a2e;'>Bonjour $prenom_safe $nom_safe,</h2><p>Nous avons bien reçu votre message :</p><div style='background-color: white; border-left: 4px solid #180391; padding: 15px;'><strong>Sujet :</strong> $sujet_safe<br><strong>Message :</strong><br>$message_safe</div><p>Cordialement,<br>L'équipe UCAO.</p></div></div>";
    
    // 1. Envoyer l'accusé de réception au VISITEUR
    $resultConfirmation = $mailer->send($email, "Confirmation : Nous avons reçu votre message", $htmlBody);
    
    // 2. Envoyer la notification à l'ADMIN (Utilise l'adresse définie dans app.php)
    $adminEmail = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'ucaotech@gmail.com'; 
    $htmlBodyAdmin = "<div style='font-family: Arial, sans-serif;'><h2 style='color: #1a1a2e;'>Nouveau message de $nom_safe</h2><p><strong>De :</strong> $nom_safe $prenom_safe ($email_safe)<br><strong>Sujet :</strong> $sujet_safe</p><div style='background-color: #f0f0f0; padding: 15px;'>$message_safe</div></div>";
    
    // On passe l'email de l'expéditeur en replyTo
    $resultAdmin = $mailer->send($adminEmail, "URGENT - Nouveau message : $sujet", $htmlBodyAdmin, [], $email);

    if (!$resultConfirmation || !$resultAdmin) {
        // Loguer l'erreur mailer précise pour débugger
        error_log("MAILER ERROR [CONF]: " . ($resultConfirmation ? 'OK' : $mailer->getError()));
        error_log("MAILER ERROR [ADMIN]: " . ($resultAdmin ? 'OK' : $mailer->getError()));

        echo json_encode([
            'success' => true, 
            'message' => "Votre message a été enregistré, mais l'envoi de l'email de notification a échoué. Notre équipe est tout de même informée.",
            'messageId' => $messageId,
            'debug' => $mailer->getError()
        ]);
        exit;
    }
    
    echo json_encode(['success' => true, 'message' => 'Votre message a été envoyé avec succès.', 'messageId' => $messageId]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur base de données: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur système: ' . $e->getMessage()]);
}
