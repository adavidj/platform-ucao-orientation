<?php

/**
 * Handler AJAX du formulaire de contact
 */

header("Content-Type: application/json; charset=UTF-8");

$configPath = dirname(__DIR__) . "/config/config.php";
if (file_exists($configPath)) {
    require_once $configPath;
}

require_once dirname(__DIR__) . "/config/app.php";
require_once dirname(__DIR__) . "/classes/Mailer.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "M�thode non autoris�e."
    ]);
    exit;
}

$formData = [
    "nom" => trim((string) ($_POST["nom"] ?? "")),
    "prenom" => trim((string) ($_POST["prenom"] ?? "")),
    "email" => trim((string) ($_POST["email"] ?? "")),
    "telephone" => trim((string) ($_POST["telephone"] ?? "")),
    "sujet" => trim((string) ($_POST["sujet"] ?? "")),
    "message" => trim((string) ($_POST["message"] ?? "")),
    "ip" => $_SERVER["REMOTE_ADDR"] ?? "unknown"
];

$errors = [];

if ($formData["nom"] === "") {
    $errors[] = "Le nom est obligatoire.";
}

if ($formData["prenom"] === "") {
    $errors[] = "Le pr�nom est obligatoire.";
}

if ($formData["email"] === "" || !filter_var($formData["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email est invalide.";
}

if ($formData["sujet"] === "") {
    $errors[] = "Le sujet est obligatoire.";
}

if ($formData["message"] === "") {
    $errors[] = "Le message est obligatoire.";
}

if (!isset($_POST["consent"])) {
    $errors[] = "Vous devez accepter la politique de confidentialit�.";
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        "success" => false,
        "errors" => $errors,
        "message" => "Le formulaire contient des erreurs."
    ]);
    exit;
}

try {
    // Enregistrement en base si la table existe.
    if (file_exists(dirname(__DIR__) . "/config/database.php")) {
        require_once dirname(__DIR__) . "/config/database.php";

        $db = Database::getInstance();
        $stmt = $db->query("SHOW TABLES LIKE 'messages_contact'");

        if ($stmt && $stmt->rowCount() > 0) {
            $insert = $db->prepare(
                "INSERT INTO messages_contact (nom, prenom, email, telephone, sujet, message, ip, created_at)
                 VALUES (:nom, :prenom, :email, :telephone, :sujet, :message, :ip, NOW())"
            );

            $insert->execute([
                ":nom" => $formData["nom"],
                ":prenom" => $formData["prenom"],
                ":email" => $formData["email"],
                ":telephone" => $formData["telephone"],
                ":sujet" => $formData["sujet"],
                ":message" => $formData["message"],
                ":ip" => $formData["ip"]
            ]);
        }
    }

    $mailer = new Mailer();
    if (!$mailer->sendContactEmail($formData)) {
        throw new RuntimeException($mailer->getError() ?: "�chec d'envoi email.");
    }

    echo json_encode([
        "success" => true,
        "message" => "Message envoy� avec succ�s."
    ]);
} catch (Throwable $e) {
    echo json_encode([
        "success" => false,
        "message" => "Une erreur technique est survenue.",
        "debug" => $e->getMessage()
    ]);
}
