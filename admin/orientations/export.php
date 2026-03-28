<?php
// =================================================================
// EXPORT CSV DES ORIENTATIONS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

$filters = [
    'date_debut' => $_GET['date_debut'] ?? '',
    'date_fin' => $_GET['date_fin'] ?? '',
    'serie_bac' => $_GET['serie_bac'] ?? '',
    'metier' => $_GET['metier'] ?? '',
    'search' => $_GET['search'] ?? '',
];

Orientation::exportCSV($filters);
