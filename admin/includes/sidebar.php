<?php
// Sidebar admin
$sidebarItems = [
    ['section' => 'dashboard', 'label' => 'Tableau de bord', 'url' => APP_URL . '/admin/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>'],
    ['section' => 'orientations', 'label' => 'Orientations', 'url' => APP_URL . '/admin/orientations/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>', 'badge' => $totalOrientations],
    ['section' => 'preinscriptions', 'label' => 'Préinscriptions', 'url' => APP_URL . '/admin/preinscriptions/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>', 'badge' => $totalPreinscriptions],
    ['section' => 'notifications', 'label' => 'Notifications', 'url' => APP_URL . '/admin/notifications/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>'],
    ['section' => 'formations', 'label' => 'Filières', 'url' => APP_URL . '/admin/formations/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>'],
    ['section' => 'metiers', 'label' => 'Métiers', 'url' => APP_URL . '/admin/metiers/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>'],
    ['section' => 'parametres', 'label' => 'Paramètres', 'url' => APP_URL . '/admin/parametres/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>'],
];

// Ajouter la gestion des admins pour les super_admin
if (Auth::isSuperAdmin()) {
    $sidebarItems[] = ['section' => 'admins', 'label' => 'Administrateurs', 'url' => APP_URL . '/admin/admins/index.php', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'];
}
?>

<!-- ============================================================
     SIDEBAR
     ============================================================ -->
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Logo -->
    <div class="sidebar-header">
        <a href="<?= APP_URL ?>/admin/index.php" class="sidebar-logo">
            <div class="sidebar-logo-icon">UO</div>
            <div class="sidebar-logo-text">
                <span class="sidebar-logo-title">UCAO</span>
                <span class="sidebar-logo-sub">Administration</span>
            </div>
        </a>
        <button class="sidebar-close" id="sidebarClose" aria-label="Fermer le menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <ul>
            <?php foreach ($sidebarItems as $item): ?>
            <li>
                <a href="<?= $item['url'] ?>" class="sidebar-link<?= $currentSection === $item['section'] ? ' active' : '' ?>">
                    <span class="sidebar-icon"><?= $item['icon'] ?></span>
                    <span class="sidebar-label"><?= e($item['label']) ?></span>
                    <?php if (isset($item['badge']) && $item['badge'] > 0): ?>
                    <span class="sidebar-badge"><?= $item['badge'] ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Admin Info -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                <?= strtoupper(substr($currentAdmin['nom'], 0, 1)) ?>
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name"><?= e($currentAdmin['nom']) ?></span>
                <span class="sidebar-user-role"><?= e(ADMIN_ROLES[$currentAdmin['role']] ?? $currentAdmin['role']) ?></span>
            </div>
        </div>
        <a href="<?= APP_URL ?>/admin/logout.php" class="sidebar-logout" title="Déconnexion">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        </a>
    </div>
</aside>

<!-- ============================================================
     TOPBAR + MAIN CONTENT WRAPPER
     ============================================================ -->
<div class="admin-main">
    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="topbar-hamburger" id="sidebarToggle" aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <h1 class="topbar-title"><?= e($pageTitle ?? 'Tableau de bord') ?></h1>
        </div>
        <div class="topbar-right">
            <a href="<?= APP_URL ?>" class="topbar-link" target="_blank" title="Voir le site">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Voir le site</span>
            </a>
        </div>
    </header>

    <!-- Content Area -->
    <main class="admin-content">
        <?php
        // Afficher les messages flash
        $flash = get_flash();
        if ($flash):
        ?>
        <div class="admin-alert admin-alert-<?= e($flash['type']) ?>" id="flashAlert">
            <span class="admin-alert-icon">
                <?php if ($flash['type'] === 'success'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <?php elseif ($flash['type'] === 'error'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <?php endif; ?>
            </span>
            <span><?= e($flash['message']) ?></span>
            <button class="admin-alert-close" onclick="this.parentElement.remove()">×</button>
        </div>
        <?php endif; ?>
