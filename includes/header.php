<?php
// Include config if not already included
if (!isset($site_name)) {
    require_once __DIR__ . '/../config/app.php';
}

if (!isset($site_logo_path)) {
    $site_logo_path = 'assets/images/logo-ucao.png';
}

// Default page title
$page_title = isset($page_title) ? $page_title . ' - ' . $site_name : $site_name;

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($site_lang) ?>">
<head>
    <meta charset="<?= htmlspecialchars($site_charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="UCAO - Plateforme d'orientation et de pré-inscription universitaire">
    <title><?= htmlspecialchars($page_title) ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Shared CSS -->
    <link rel="stylesheet" href="assets/css/shared.css">

    <?php if (isset($page_css)): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($page_css) ?>">
    <?php endif; ?>
</head>
<body>

    <!-- =================================================================
       HEADER / NAVBAR
       ================================================================= -->
    <header class="main-header<?= isset($header_solid) && $header_solid ? ' solid' : '' ?>" id="main-header">
        <div class="container">
            <a href="index.php" class="logo">
                <?php if (file_exists(__DIR__ . '/../' . $site_logo_path)): ?>
                    <img src="<?= htmlspecialchars($site_logo_path) ?>" alt="<?= htmlspecialchars($site_name) ?>" class="logo-img">
                <?php else: ?>
                    <?= htmlspecialchars(explode(' ', $site_name)[0]) ?><span>.</span>
                <?php endif; ?>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php"<?= $current_page === 'index.php' ? ' class="active"' : '' ?>>Accueil</a></li>
                    <?php foreach ($nav_items as $item): ?>
                        <?php $item_page = basename($item['url']); ?>
                        <li><a href="<?= htmlspecialchars($item['url']) ?>"<?= $current_page === $item_page ? ' class="active"' : '' ?>><?= htmlspecialchars($item['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <div class="nav-cta">
                <a href="orientation.php" class="btn btn-primary">Je m'oriente</a>
            </div>
            <button class="hamburger" id="hamburger-btn" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-overlay"></div>

    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobile-menu" aria-label="Menu mobile">
        <div class="mobile-menu-header">
            <a href="index.php" class="logo">
                <?php if (file_exists(__DIR__ . '/../' . $site_logo_path)): ?>
                    <img src="<?= htmlspecialchars($site_logo_path) ?>" alt="<?= htmlspecialchars($site_name) ?>" class="logo-img">
                <?php else: ?>
                    <?= htmlspecialchars(explode(' ', $site_name)[0]) ?><span>.</span>
                <?php endif; ?>
            </a>
            <button class="mobile-menu-close" id="mobile-close-btn" aria-label="Fermer le menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="mobile-menu-content">
            <ul>
                <li><a href="index.php"<?= $current_page === 'index.php' ? ' class="active"' : '' ?>>Accueil</a></li>
                <?php foreach ($nav_items as $item): ?>
                    <?php $item_page = basename($item['url']); ?>
                    <li><a href="<?= htmlspecialchars($item['url']) ?>"<?= $current_page === $item_page ? ' class="active"' : '' ?>><?= htmlspecialchars($item['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="mobile-cta">
                <a href="orientation.php" class="btn btn-primary">Je m'oriente</a>
            </div>
        </div>
    </nav>

    <main>
