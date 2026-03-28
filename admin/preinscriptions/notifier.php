<?php
// Notifier un préinscrit par email (POST handler)
require_once dirname(__DIR__) . '/includes/auth-check.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('index.php'); }

$id = intval($_POST['preinscription_id'] ?? 0);
$preinscription = Preinscription::getById($id);
if (!$preinscription) { set_flash('error', 'Préinscription introuvable.'); redirect('index.php'); }

$sujet = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');
if (!$sujet || !$message) { set_flash('error', 'Veuillez remplir tous les champs.'); redirect('voir.php?id=' . $id); }

$mailer = new Mailer();
$html = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto">';
$html .= '<div style="background:linear-gradient(135deg,#180391,#8B0000);padding:24px;border-radius:12px 12px 0 0;text-align:center"><h1 style="color:#FFD700;margin:0;font-size:20px">UCAO Orientation</h1></div>';
$html .= '<div style="background:#fff;padding:28px;border:1px solid #eee;border-radius:0 0 12px 12px">' . nl2br(e($message)) . '</div></div>';

$result = $mailer->send($preinscription['email'], $sujet, $html);
set_flash($result['success'] ? 'success' : 'error', $result['message']);
redirect('voir.php?id=' . $id);
