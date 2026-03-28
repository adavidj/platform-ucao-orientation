<?php
// Header admin - reçoit $pageTitle de la page
if (!isset($pageTitle)) $pageTitle = 'Administration';
$fullTitle = $pageTitle . ' — UCAO Admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($fullTitle) ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Admin CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/admin/assets/css/admin.css">

    <?php if (isset($pageCSS)): ?>
    <link rel="stylesheet" href="<?= e($pageCSS) ?>">
    <?php endif; ?>
</head>
<body class="admin-body">

    <!-- Mobile Overlay -->
    <div class="admin-overlay" id="adminOverlay"></div>
