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

if (empty($ids) || !is_array($ids) || empty($sujet) || empty($message)) {
    set_flash('error', 'Veuillez remplir tous les champs.');
    redirect('index.php');
}

$ids = array_filter(array_map('intval', $ids));
if (empty($ids)) {
    set_flash('error', 'IDs invalides.');
    redirect('index.php');
}

$pdo = Database::getInstance();
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, email, nom, prenom, rapport_pdf_path FROM orientations WHERE id IN ($placeholders)");
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
    $html = '<div style="font-family:Arial,sans-serif;padding:20px;max-width:600px;margin:0 auto">';
    $html .= '<div style="background:linear-gradient(135deg,#180391,#8B0000);padding:24px;border-radius:12px 12px 0 0;text-align:center">';
    $html .= '<h1 style="color:#FFFFFF;margin:0;font-size:20px">UCAO Orientation</h1>';
    $html .= '</div>';
    $html .= '<div style="background:#fff;padding:28px;border:1px solid #eee;border-radius:0 0 12px 12px">';
    $html .= '<p>Bonjour ' . e($o['prenom']) . ' ' . e($o['nom']) . ',</p>';
    $html .= nl2br(e($message));

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

    $result = $mailer->send($o['email'], $sujet, $html, $attachments);

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
