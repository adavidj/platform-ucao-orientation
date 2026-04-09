<?php
// =================================================================
// EXPORT PDF DES ORIENTATIONS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

$filters = [
    'date_debut' => $_GET['date_debut'] ?? '',
    'date_fin' => $_GET['date_fin'] ?? '',
    'serie_bac' => $_GET['serie_bac'] ?? '',
    'metier' => $_GET['metier'] ?? '',
    'search' => $_GET['search'] ?? '',
];

// Récupérer toutes les orientations (sans pagination)
$result = Orientation::getAll($filters, 1, 10000);
$orientations = $result['data'];

if (empty($orientations)) {
    set_flash('error', 'Aucune donnée à exporter.');
    redirect('index.php');
}

$titre = 'Liste des orientations';
if (!empty($filters['serie_bac'])) {
    $titre .= ' — Série ' . $filters['serie_bac'];
}
if (!empty($filters['date_debut']) || !empty($filters['date_fin'])) {
    $titre .= ' — ' . ($filters['date_debut'] ?: '...') . ' au ' . ($filters['date_fin'] ?: '...');
}

$pdfContent = Rapport::generateOrientationsListePDF($orientations, $titre);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="orientations_' . date('Y-m-d_His') . '.pdf"');
header('Content-Length: ' . strlen($pdfContent));

echo $pdfContent;
exit;
