<?php
// Supprimer un admin
require_once dirname(__DIR__) . '/includes/auth-check.php';
Auth::requireSuperAdmin();

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if (!$id) {
    set_flash('error', 'Admin introuvable.');
    redirect('index.php');
}

$admin = Auth::getAdminById($id);
if (!$admin) {
    set_flash('error', 'Admin introuvable.');
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Session expirée.');
        redirect('supprimer.php?id=' . $id);
    }

    $result = Auth::deleteAdmin($id);
    set_flash($result['success'] ? 'success' : 'error', $result['message']);
    redirect('index.php');
}

$pageTitle = 'Supprimer — ' . $admin['nom'];
require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card" style="border-left: 4px solid #dc2626;">
    <div class="admin-card-header"><h2 class="admin-card-title" style="color: #dc2626;">Supprimer l'administrateur</h2></div>
    <div class="admin-card-body">
        <div style="background-color: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
            <p style="margin: 0; color: #991b1b;"><strong>⚠️ Attention :</strong> Cette action est irréversible. Vous allez supprimer l'administrateur <strong><?= e($admin['nom']) ?></strong> et tous ses accès.</p>
        </div>

        <div style="background-color: #f3f4f6; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            <p><strong>Administrateur à supprimer :</strong></p>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li><strong>Nom :</strong> <?= e($admin['nom']) ?></li>
                <li><strong>Email :</strong> <?= e($admin['email']) ?></li>
                <li><strong>Rôle :</strong> <?= e(ADMIN_ROLES[$admin['role']] ?? $admin['role']) ?></li>
                <li><strong>Statut :</strong> <?= $admin['actif'] ? 'Actif' : 'Désactivé' ?></li>
            </ul>
        </div>

        <form method="POST" style="display: flex; gap: 12px; justify-content: flex-end;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
            <button type="submit" class="btn-admin" style="background-color: #dc2626; color: white; border: none;">Confirmer la suppression</button>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
