<?php
// =================================================================
// ENVOI GROUPÉ - ORIENTATIONS (avec PDF personnalisé)
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    set_flash('error', 'Session expirée.');
    redirect('index.php');
}

$ids = $_POST['ids'] ?? [];
$sujet = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');
$joindrePdf = isset($_POST['joindre_pdf']) && $_POST['joindre_pdf'] == '1';

if (empty($ids) || !is_array($ids)) {
    set_flash('error', 'Veuillez sélectionner au moins une orientation.');
    redirect('index.php');
}

// Si le sujet est vide, utiliser un sujet par défaut
if (empty($sujet)) {
    $sujet = "Votre rapport d'orientation UCAO";
}

// Si le message est vide, utiliser un message par défaut
if (empty($message)) {
    $message = "Veuillez trouver en pièce jointe votre rapport d'orientation personnalisé.";
}

$ids = array_filter(array_map('intval', $ids));
if (empty($ids)) {
    set_flash('error', 'IDs invalides.');
    redirect('index.php');
}

$pdo = Database::getInstance();
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("
    SELECT o.id, o.email, o.nom, o.prenom, o.rapport_pdf_path, GROUP_CONCAT(f.nom_filiere SEPARATOR '|') as filieres_recommandees
    FROM orientations o
    LEFT JOIN orientation_filiere of ON o.id = of.orientation_id
    LEFT JOIN filieres f ON of.filiere_id = f.id
    WHERE o.id IN ($placeholders)
    GROUP BY o.id
");
$stmt->execute($ids);
$orientations = $stmt->fetchAll();

if (empty($orientations)) {
    set_flash('error', 'Aucune orientation trouvée.');
    redirect('index.php');
}

$mailer = new Mailer();
$success = 0;
$fail = 0;

foreach ($orientations as $o) {
    // Placeholders
    $replacements = [
        '{{nom}}' => e($o['nom']),
        '{{prenom}}' => e($o['prenom']),
        '{{filieres_recommandees}}' => '',
    ];

    if (!empty($o['filieres_recommandees'])) {
        $filieres = explode('|', $o['filieres_recommandees']);
        $filieresHtml = '<ul>';
        foreach ($filieres as $filiere) {
            $filieresHtml .= '<li>' . e($filiere) . '</li>';
        }
        $filieresHtml .= '</ul>';
        $replacements['{{filieres_recommandees}}'] = $filieresHtml;
    } else {
        $replacements['{{filieres_recommandees}}'] = 'Aucune filière spécifique recommandée pour le moment.';
    }

    $current_sujet = str_replace(array_keys($replacements), array_values($replacements), $sujet);
    $current_message = str_replace(array_keys($replacements), array_values($replacements), $message);

    $html = '<div style="font-family:Arial,sans-serif;padding:20px;max-width:600px;margin:0 auto">';
    $html .= '<div style="background:linear-gradient(135deg,#180391,#8B0000);padding:24px;border-radius:12px 12px 0 0;text-align:center">';
    $html .= '<h1 style="color:#FFFFFF;margin:0;font-size:20px">UCAO Orientation</h1>';
    $html .= '</div>';
    $html .= '<div style="background:#fff;padding:28px;border:1px solid #eee;border-radius:0 0 12px 12px">';
    $html .= '<p>Bonjour ' . e($o['prenom']) . ' ' . e($o['nom']) . ',</p>';
    $html .= nl2br($current_message);

    if ($joindrePdf && !empty($o['rapport_pdf_path'])) {
        $html .= '<p style="margin-top:20px;padding:12px;background:#f0f7ff;border-radius:6px;color:#1a56db"><strong>Pièce jointe :</strong> Votre rapport d\'orientation personnalisé est joint à ce mail.</p>';
    }

    $html .= '</div>';
    $html .= '<p style="text-align:center;color:#999;font-size:12px;margin-top:16px">UCAO-UUC — Cotonou, Bénin</p>';
    $html .= '</div>';

    $attachments = [];
    if ($joindrePdf && !empty($o['rapport_pdf_path'])) {
        $pdfPath = RAPPORTS_DIR . '/' . $o['rapport_pdf_path'];
        if (file_exists($pdfPath)) {
            $attachments[] = $pdfPath;
        }
    }

    $result = $mailer->send($o['email'], $current_sujet, $html, $attachments);

    if ($result['success']) {
        $success++;
        Orientation::markEmailSent($o['id']);
    } else {
        $fail++;
    }
}

$msg = "$success email(s) envoyé(s)";
if ($fail > 0) {
    $msg .= " ($fail échoué)";
}

set_flash('success', $msg);
redirect('index.php');
