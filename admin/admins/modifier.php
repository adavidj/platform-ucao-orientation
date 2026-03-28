<?php
// Modifier un admin
require_once dirname(__DIR__) . '/includes/auth-check.php';
Auth::requireSuperAdmin();
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if (!$id) { set_flash('error', 'Admin introuvable.'); redirect('index.php'); }
$admin = Auth::getAdminById($id);
if (!$admin) { set_flash('error', 'Admin introuvable.'); redirect('index.php'); }
$pageTitle = 'Modifier — ' . $admin['nom'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('modifier.php?id=' . $id); }
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'admin';
    $actif = isset($_POST['actif']) ? 1 : 0;
    $newPassword = !empty($_POST['password']) ? $_POST['password'] : null;

    if ($newPassword && strlen($newPassword) < 8) {
        set_flash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
        redirect('modifier.php?id=' . $id);
    }

    $result = Auth::updateAdmin($id, $nom, $email, $role, $actif, $newPassword);
    set_flash($result['success'] ? 'success' : 'error', $result['message']);
    redirect($result['success'] ? 'index.php' : 'modifier.php?id=' . $id);
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Modifier l'administrateur</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nom complet</label><input type="text" name="nom" class="form-control" value="<?= e($admin['nom']) ?>" required></div>
                <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= e($admin['email']) ?>" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nouveau mot de passe</label><input type="password" name="password" class="form-control" minlength="8" placeholder="Laisser vide pour ne pas changer"><small style="color:var(--admin-text-muted)">Laisser vide pour conserver l'actuel</small></div>
                <div class="form-group"><label class="form-label">Rôle</label>
                    <select name="role" class="form-control">
                        <option value="admin" <?= $admin['role'] === 'admin' ? 'selected' : '' ?>>Administrateur standard</option>
                        <option value="super_admin" <?= $admin['role'] === 'super_admin' ? 'selected' : '' ?>>Super Administrateur</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:12px">
                <label class="toggle-switch"><input type="checkbox" name="actif" <?= $admin['actif'] ? 'checked' : '' ?>><span class="toggle-slider"></span></label>
                <label class="form-label" style="margin:0">Compte actif</label>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
