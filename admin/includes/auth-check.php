<?php
// =================================================================
// VÉRIFICATION AUTHENTIFICATION ADMIN
// Inclure en haut de chaque page admin (sauf login.php)
// =================================================================

require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once dirname(dirname(__DIR__)) . '/config/constantes.php';

// Vérifier que l'admin est connecté
Auth::requireLogin();

// Charger les infos de l'admin courant
$currentAdmin = Auth::getCurrentAdmin();

// Récupérer les statistiques pour les badges sidebar
try {
    $totalOrientations = Orientation::getCount();
    $totalPreinscriptions = Preinscription::getCount();
} catch (Exception $e) {
    $totalOrientations = 0;
    $totalPreinscriptions = 0;
}

// Page courante pour l'état actif de la sidebar
$currentPage = basename(dirname($_SERVER['PHP_SELF'])) . '/' . basename($_SERVER['PHP_SELF']);
$currentSection = basename(dirname($_SERVER['PHP_SELF']));
if ($currentSection === 'admin') {
    $currentSection = 'dashboard';
}
