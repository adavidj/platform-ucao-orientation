<?php
/**
 * Handler de traitement des préinscriptions
 */

require_once dirname(__DIR__) . '/config/config.php';

header('Content-Type: application/json; charset=utf-8');

// Vérifier méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Méthode non autorisée']));
}

// Récupérer les données
$data = [
    'nom' => trim($_POST['nom'] ?? ''),
    'prenom' => trim($_POST['prenom'] ?? ''),
    'date_naissance' => trim($_POST['date_naissance'] ?? ''),
    'nationalite' => trim($_POST['nationalite'] ?? ''),
    'serie_bac' => trim($_POST['serie_bac'] ?? ''),
    'annee_bac' => trim($_POST['annee_bac'] ?? ''),
    'etablissement' => trim($_POST['etablissement'] ?? ''),
    'ecole' => trim($_POST['ecole'] ?? ''),
    'filiere' => trim($_POST['filiere'] ?? ''),
    'niveau_entree' => trim($_POST['niveau_entree'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'telephone' => trim($_POST['telephone'] ?? ''),
];

// Validation des champs obligatoires
$required = ['nom', 'prenom', 'date_naissance', 'nationalite', 'serie_bac', 'annee_bac', 'etablissement', 'filiere', 'niveau_entree', 'email', 'telephone'];
$errors = [];

foreach ($required as $field) {
    if (empty($data[$field])) {
        $errors[$field] = 'Ce champ est obligatoire';
    }
}

// Validation email
if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Adresse email invalide';
}

// Vérifier si email existe déjà
if (!empty($data['email']) && Preinscription::emailExists($data['email'])) {
    $errors['email'] = 'Cette adresse email est déjà utilisée pour une pré-inscription';
}

// Validation date de naissance (doit être dans le passé)
if (!empty($data['date_naissance'])) {
    $birthDate = strtotime($data['date_naissance']);
    if ($birthDate === false || $birthDate > time()) {
        $errors['date_naissance'] = 'Date de naissance invalide';
    }
}

// Si erreurs, retourner
if (!empty($errors)) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'errors' => $errors]));
}

try {
    // Récupérer les infos de la filière
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT id, nom_filiere, ecole_faculte FROM filieres WHERE id = ?");
    $stmt->execute([$data['filiere']]);
    $filiere = $stmt->fetch();

    if (!$filiere) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'message' => 'Filière invalide']));
    }

    // Insérer la préinscription
    $preinscriptionId = Preinscription::create($data);

    // Préparer l'email de confirmation
    $emailData = [
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'filiere' => $filiere['nom_filiere'],
        'ecole' => $filiere['ecole_faculte'],
        'niveau' => $data['niveau_entree'],
        'reference' => 'PRE-' . date('Y') . '-' . str_pad($preinscriptionId, 5, '0', STR_PAD_LEFT),
    ];

    // Charger et personnaliser le template email
    $emailTemplate = file_get_contents(APP_ROOT . '/templates/emails/email-preinscription.html');
    $emailBody = str_replace(
        ['{{NOM}}', '{{PRENOM}}', '{{FILIERE}}', '{{ECOLE}}', '{{NIVEAU}}', '{{REFERENCE}}', '{{ANNEE}}', '{{APP_URL}}'],
        [$emailData['nom'], $emailData['prenom'], $emailData['filiere'], $emailData['ecole'], $emailData['niveau'], $emailData['reference'], date('Y'), APP_URL],
        $emailTemplate
    );

    // Envoyer l'email
    $mailer = new Mailer();
    $emailResult = $mailer->send(
        $data['email'],
        'Confirmation de pré-inscription - UCAO',
        $emailBody
    );

    // Réponse
    echo json_encode([
        'success' => true,
        'message' => 'Votre pré-inscription a été enregistrée avec succès',
        'reference' => $emailData['reference'],
        'email_sent' => $emailResult['success']
    ]);

} catch (Exception $e) {
    error_log('Erreur préinscription: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue. Veuillez réessayer.']);
}
