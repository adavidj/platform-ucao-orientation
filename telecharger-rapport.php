<?php
/**
 * Script de téléchargement du rapport d'orientation PDF
 */

require_once __DIR__ . '/config/app.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Basic security check: prevent completely anonymous downloads if possible,
// but since it's a public form, anyone with the ID can download their report.
// To be fully secure, a unique token should be used instead of ID.

if (!$id) {
    redirect('index.php');
}

try {
    $orientation = Orientation::getById($id);
    
    if (!$orientation || empty($orientation['rapport_pdf_path'])) {
        die("Le rapport n'existe pas ou n'est plus disponible.");
    }
    
    $filePath = RAPPORTS_DIR . '/' . $orientation['rapport_pdf_path'];
    
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Orientation_UCAO_' . $orientation['nom'] . '.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        
        // Vider le buffer pour éviter la corruption du PDF
        ob_clean();
        flush();
        
        readfile($filePath);
        exit;
    } else {
        die("Le fichier physique du rapport est introuvable sur le serveur.");
    }

} catch (Exception $e) {
    die("Erreur serveur de téléchargement.");
}
