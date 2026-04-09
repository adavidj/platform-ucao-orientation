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

// Récupérer l'orientation pour le PDF
$orientation = Orientation::getById($orientationId);
if (!$orientation) {
    set_flash('error', 'Orientation introuvable.');
    redirect('index.php');
}

// Envoyer l'email
$mailer = new Mailer();
$htmlMessage = '<div style="font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto;">';
$htmlMessage .= '<div style="background: linear-gradient(135deg, #180391, #8B0000); padding: 24px; border-radius: 12px 12px 0 0; text-align: center;">';
$htmlMessage .= '<h1 style="color: #FFFFFF; margin: 0; font-size: 20px;">UCAO Orientation</h1>';
$htmlMessage .= '</div>';
$htmlMessage .= '<div style="background: #ffffff; padding: 28px; border: 1px solid #eee; border-radius: 0 0 12px 12px;">';
$htmlMessage .= nl2br(htmlspecialchars($message));

// Ajouter une note si le PDF est joint
if (!empty($orientation['rapport_pdf_path'])) {
    $htmlMessage .= '<p style="margin-top: 20px; padding: 12px; background: #f0f7ff; border-radius: 6px; color: #1a56db;"><strong>Pièce jointe :</strong> Votre rapport d\'orientation personnalisé est joint à ce mail.</p>';
}

$htmlMessage .= '</div>';
$htmlMessage .= '<p style="text-align: center; color: #999; font-size: 12px; margin-top: 16px;">UCAO-UUC — Cotonou, Bénin</p>';
$htmlMessage .= '</div>';

// Préparer la pièce jointe PDF
$attachments = [];
if (!empty($orientation['rapport_pdf_path'])) {
    $pdfPath = RAPPORTS_DIR . '/' . $orientation['rapport_pdf_path'];
    if (file_exists($pdfPath)) {
        $attachments[] = $pdfPath;
    }
}

$result = $mailer->send($email, $sujet, $htmlMessage, $attachments);

if ($result['success']) {
    Orientation::markEmailSent($orientationId);
    set_flash('success', 'Réponse envoyée avec succès à ' . $email);
} else {
    set_flash('error', 'Erreur lors de l\'envoi : ' . $result['message']);
}

redirect('index.php');
