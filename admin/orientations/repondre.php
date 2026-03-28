<?php
// =================================================================
// RÉPONDRE À UNE ORIENTATION (handler POST)
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('index.php'); }

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    set_flash('error', 'Session expirée. Veuillez réessayer.');
    redirect('index.php');
}

$orientationId = intval($_POST['orientation_id'] ?? 0);
$email = trim($_POST['email'] ?? '');
$sujet = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$orientationId || !$email || !$sujet || !$message) {
    set_flash('error', 'Tous les champs sont requis.');
    redirect('index.php');
}

// Envoyer l'email
$mailer = new Mailer();
$htmlMessage = '<div style="font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto;">';
$htmlMessage .= '<div style="background: linear-gradient(135deg, #180391, #8B0000); padding: 24px; border-radius: 12px 12px 0 0; text-align: center;">';
$htmlMessage .= '<h1 style="color: #FFD700; margin: 0; font-size: 20px;">UCAO Orientation</h1>';
$htmlMessage .= '</div>';
$htmlMessage .= '<div style="background: #ffffff; padding: 28px; border: 1px solid #eee; border-radius: 0 0 12px 12px;">';
$htmlMessage .= nl2br(htmlspecialchars($message));
$htmlMessage .= '</div>';
$htmlMessage .= '<p style="text-align: center; color: #999; font-size: 12px; margin-top: 16px;">UCAO-UUC — Cotonou, Bénin</p>';
$htmlMessage .= '</div>';

$result = $mailer->send($email, $sujet, $htmlMessage);

if ($result['success']) {
    Orientation::markEmailSent($orientationId);
    set_flash('success', 'Réponse envoyée avec succès à ' . $email);
} else {
    set_flash('error', 'Erreur lors de l\'envoi : ' . $result['message']);
}

redirect('index.php');
