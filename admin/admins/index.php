<?php
// =================================================================
// GESTION DES ADMINISTRATEURS (Super Admin uniquement)
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
Auth::requireSuperAdmin();
$pageTitle = 'Gestion des administrateurs';
$admins = Auth::getAllAdmins();

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:20px;display:flex;justify-content:flex-end">
    <a href="ajouter.php" class="btn-admin btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Ajouter un admin
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title"><?= count($admins) ?> administrateur(s)</h2></div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Dernière connexion</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($admins as $a): ?>
            <tr>
                <td><strong><?= e($a['nom']) ?></strong></td>
                <td><?= e($a['email']) ?></td>
                <td><span class="badge <?= $a['role'] === 'super_admin' ? 'badge-gold' : 'badge-info' ?>"><?= e(ADMIN_ROLES[$a['role']] ?? $a['role']) ?></span></td>
                <td><?= $a['actif'] ? '<span class="badge badge-success">Actif</span>' : '<span class="badge badge-error">Désactivé</span>' ?></td>
                <td><?= $a['last_login'] ? date_fr($a['last_login']) : '<span style="color:var(--admin-text-muted)">Jamais</span>' ?></td>
                <td>
                    <a href="modifier.php?id=<?= $a['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Modifier">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </a>
                    <a href="supprimer.php?id=<?= $a['id'] ?>" class="btn-admin btn-admin-danger btn-admin-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
