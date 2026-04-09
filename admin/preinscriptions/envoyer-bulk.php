<?php
// =================================================================
// ENVOI GROUPÉ - PRÉINSCRIPTIONS
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
$stmt = $pdo->prepare("SELECT id, email, nom, prenom FROM preinscriptions WHERE id IN ($placeholders)");
$stmt->execute($ids);
$preinscriptions = $stmt->fetchAll();

if (empty($preinscriptions)) {
    set_flash('error', 'Aucune préinscription trouvée.');
    redirect('index.php');
}

$mailer = new Mailer();
$success = 0;
$fail = 0;

foreach ($preinscriptions as $p) {
    $html = '<div style="font-family:Arial,sans-serif;padding:20px;max-width:600px;margin:0 auto">';
    $html .= '<div style="background:linear-gradient(135deg,#180391,#8B0000);padding:24px;border-radius:12px 12px 0 0;text-align:center">';
    $html .= '<h1 style="color:#FFFFFF;margin:0;font-size:20px">UCAO Pré-inscription</h1>';
    $html .= '</div>';
    $html .= '<div style="background:#fff;padding:28px;border:1px solid #eee;border-radius:0 0 12px 12px">';
    $html .= '<p>Bonjour ' . e($p['prenom']) . ' ' . e($p['nom']) . ',</p>';
    $html .= nl2br(e($message));
    $html .= '</div>';
    $html .= '<p style="text-align:center;color:#999;font-size:12px;margin-top:16px">UCAO-UUC — Cotonou, Bénin</p>';
    $html .= '</div>';

    $result = $mailer->send($p['email'], $sujet, $html);

    if ($result['success']) {
        $success++;
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
