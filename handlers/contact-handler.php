<?php
/**
 * Handler Contact
 * Traite les soumissions du formulaire de contact
 * Envoie les email de confirmation et notification admin
 */

// Activer la gestion des erreurs gracieuse
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // Ignorer les warnings de dépréciation
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
        error_log("Deprecated: $errstr in $errfile:$errline");
        return true; // Ignorer sans arrêter
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur: ' . $errstr,
        'error' => [
            'file' => $errfile,
            'line' => $errline,
            'code' => $errno
        ]
    ]);
    exit;
});

// Gérer les exceptions non capturées
set_exception_handler(function($exception) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $exception->getMessage(),
        'error' => [
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    ]);
    exit;
});

// Inclure la configuration globale
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/app.php';

header('Content-Type: application/json; charset=utf-8');

// Uniquement POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// Nettoyage des entrées
$nom = trim(filter_input(INPUT_POST, 'nom', FILTER_UNSAFE_RAW) ?? '');
$prenom = trim(filter_input(INPUT_POST, 'prenom', FILTER_UNSAFE_RAW) ?? '');
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$telephone = trim(filter_input(INPUT_POST, 'telephone', FILTER_UNSAFE_RAW) ?? '') ?: '';
$sujet = trim(filter_input(INPUT_POST, 'sujet', FILTER_UNSAFE_RAW) ?? '');
$message = trim(filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW) ?? '');

// Validation basique
$erreurs = [];

if (empty($nom)) {
    $erreurs[] = 'Le nom est obligatoire.';
}

if (empty($prenom)) {
    $erreurs[] = 'Le prénom est obligatoire.';
}

if (empty($email)) {
    $erreurs[] = 'L\'email est obligatoire.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = 'L\'adresse email est invalide.';
}

if (empty($sujet)) {
    $erreurs[] = 'Le sujet est obligatoire.';
}

if (empty($message)) {
    $erreurs[] = 'Le message est obligatoire.';
}

// Limiter la longueur du message
if (strlen($message) > 5000) {
    $erreurs[] = 'Le message ne doit pas dépasser 5000 caractères.';
}

// Retourner les erreurs s'il y en a
if (!empty($erreurs)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Veuillez corriger les erreurs suivantes :',
        'errors' => $erreurs
    ]);
    exit;
}

try {
    $pdo = Database::getInstance();
    
    // ==========================================
    // ENREGISTREMENT DU MESSAGE DE CONTACT
    // ==========================================
    
    // Créer la table de messages si elle n'existe pas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages_contact (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nom VARCHAR(100) NOT NULL,
            prenom VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            telephone VARCHAR(20),
            sujet VARCHAR(100) NOT NULL,
            message LONGTEXT NOT NULL,
            lu TINYINT DEFAULT 0,
            repondu TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_email (email),
            INDEX idx_created_at (created_at)
        )
    ");
    
    // Enregistrer le message dans la BD
    $stmtInsert = $pdo->prepare("
        INSERT INTO messages_contact 
        (nom, prenom, email, telephone, sujet, message, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmtInsert->execute([
        $nom,
        $prenom,
        $email,
        $telephone,
        $sujet,
        $message
    ]);
    
    $messageId = $pdo->lastInsertId();
    
    // ==========================================
    // ENVOI DES EMAILS
    // ==========================================
    
    $mailer = new Mailer();
    
    // Échapper les variables pour l'HTML (prévention XSS)
    $nom_safe = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
    $prenom_safe = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
    $email_safe = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $telephone_safe = htmlspecialchars($telephone, ENT_QUOTES, 'UTF-8');
    $sujet_safe = htmlspecialchars($sujet, ENT_QUOTES, 'UTF-8');
    $message_safe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    
    // Email de confirmation à l'utilisateur
    $htmlBody = <<<HTML
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background-color: #180391; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 28px;">$site_name</h1>
            <p style="margin: 5px 0 0 0;">Confirmation de message reçu</p>
        </div>
        
        <div style="background-color: #f8f9fc; padding: 30px; border-radius: 0 0 8px 8px;">
            <h2 style="color: #1a1a2e; margin-top: 0;">Bonjour $prenom_safe $nom_safe,</h2>
            
            <p style="color: #2d3436; line-height: 1.6;">
                Merci pour votre message ! Nous avons bien reçu votre demande et nous vous remercions de votre intérêt envers UCAO.
            </p>
            
            <div style="background-color: white; border-left: 4px solid #180391; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <h3 style="color: #180391; margin-top: 0;">Récapitulatif de votre message :</h3>
                <p><strong>Sujet :</strong> $sujet_safe</p>
                <p><strong>Message :</strong></p>
                <p style="background-color: #f0f0f0; padding: 10px; border-radius: 4px; white-space: pre-wrap;">
                    $message_safe
                </p>
            </div>
            
            <p style="color: #2d3436; line-height: 1.6;">
                Notre équipe a reçu votre message et s'engage à vous répondre dans les plus brefs délais. 
                Nous vous remercions de votre patience.
            </p>
            
            <p style="color: #2d3436; line-height: 1.6;">
                Si vous avez d'autres questions, n'hésitez pas à nous contacter :
            </p>
            
            <div style="background-color: white; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>📞 Téléphone :</strong> +229 01 21 60 40 70</p>
                <p style="margin: 5px 0;"><strong>📱 Mobile :</strong> +229 01 56 35 14 41</p>
                <p style="margin: 5px 0;"><strong>✉️ Email :</strong> contact@ucaobenin.org</p>
                <p style="margin: 5px 0;"><strong>📍 Adresse :</strong> Lot 246 St Jean, Cotonou</p>
            </div>
            
            <hr style="border: none; border-top: 1px solid #e5e8ef; margin: 30px 0;">
            
            <p style="color: #808080; font-size: 12px; text-align: center; margin: 0;">
                Cet email a été généré automatiquement. Veuillez ne pas répondre directement à ce message.
                <br>
                Utilisez plutôt le formulaire de contact ou appelez-nous directement.
            </p>
        </div>
    </div>
    HTML;
    
    $resultConfirmation = $mailer->send(
        $email,
        "Confirmation : Nous avons reçu votre message",
        $htmlBody
    );
    
    // Email de notification aux admins - récupérer depuis les paramètres
    $stmtParamEmail = $pdo->prepare("SELECT valeur FROM parametres WHERE cle = 'site_email' LIMIT 1");
    $stmtParamEmail->execute();
    $paramEmail = $stmtParamEmail->fetch();
    $adminEmail = ($paramEmail && !empty($paramEmail['valeur'])) ? $paramEmail['valeur'] : 'contact@ucaobenin.org';
    
    $htmlBodyAdmin = <<<HTML
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background-color: #180391; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 28px;">$site_name</h1>
            <p style="margin: 5px 0 0 0;">Nouveau message de contact</p>
        </div>
        
        <div style="background-color: #f8f9fc; padding: 30px; border-radius: 0 0 8px 8px;">
            <h2 style="color: #1a1a2e; margin-top: 0;">Nouveau message reçu</h2>
            
            <div style="background-color: white; border-left: 4px solid #8B0000; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <p style="margin: 0;"><strong>De :</strong> $nom_safe $prenom_safe</p>
                <p style="margin: 5px 0;"><strong>Email :</strong> <a href="mailto:$email_safe">$email_safe</a></p>
                <p style="margin: 5px 0;"><strong>Téléphone :</strong> $telephone_safe</p>
                <p style="margin: 5px 0 0 0;"><strong>Sujet :</strong> $sujet_safe</p>
            </div>
            
            <div style="background-color: white; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <h3 style="color: #1a1a2e; margin-top: 0;">Message :</h3>
                <p style="background-color: #f0f0f0; padding: 10px; border-radius: 4px; white-space: pre-wrap; margin: 0;">
                    $message_safe
                </p>
            </div>
            
            <div style="background-color: #fffacd; border-left: 4px solid #ffd700; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <p style="margin: 0;">
                    <strong>ID du message :</strong> #$messageId<br>
                    <strong>Date :</strong> <span>$messageId</span>
                </p>
            </div>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="#" style="background-color: #180391; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">
                    Répondre au message
                </a>
            </p>
        </div>
    </div>
    HTML;
    
    $resultAdmin = $mailer->send(
        $adminEmail,
        "UCAO - Nouveau message de contact : $sujet",
        $htmlBodyAdmin
    );

    if (empty($resultConfirmation['success']) || empty($resultAdmin['success'])) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Le message a ete enregistre, mais l\'envoi email a echoue.',
            'mail' => [
                'confirmation' => $resultConfirmation,
                'admin' => $resultAdmin
            ]
        ]);
        exit;
    }
    
    // ==========================================
    // RÉPONSE FINALE
    // ==========================================
    
    echo json_encode([
        'success' => true,
        'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.',
        'messageId' => $messageId
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur BD contact: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.'
    ]);
    exit;
} catch (Exception $e) {
    error_log("Erreur générale contact: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors du traitement de votre message.'
    ]);
    exit;
}
