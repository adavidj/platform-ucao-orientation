<?php
// =================================================================
// SUPPRIMER UNE ORIENTATION
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$csrf_token = $_POST['csrf_token'] ?? '';

if (!$id || !verify_csrf($csrf_token)) {
    set_flash('danger', 'Requête invalide ou session expirée.');
    redirect('index.php');
}

try {
    // Récupérer les infos pour supprimer le PDF si nécessaire
    $orientation = Orientation::getById($id);
    
    if ($orientation) {
        $pdo = Database::getInstance();
        
        // Supprimer le PDF physique s'il existe
        if (!empty($orientation['rapport_pdf_path'])) {
            $pdfPath = RAPPORTS_DIR . '/' . $orientation['rapport_pdf_path'];
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
        
        // Supprimer du Dashboard
        $stmt = $pdo->prepare("DELETE FROM orientations WHERE id = ?");
        $stmt->execute([$id]);
        
        set_flash('success', 'L\'orientation et les fichiers associés ont été supprimés avec succès.');
    } else {
        set_flash('danger', 'L\'orientation demandée est introuvable.');
    }
} catch (Exception $e) {
    set_flash('danger', 'Erreur lors de la suppression : ' . $e->getMessage());
}

redirect('index.php');
