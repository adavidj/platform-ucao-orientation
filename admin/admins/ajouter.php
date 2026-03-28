<?php
// Ajouter un admin
require_once dirname(__DIR__) . '/includes/auth-check.php';
Auth::requireSuperAdmin();
$pageTitle = 'Ajouter un administrateur';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('ajouter.php'); }
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'admin';

    if (empty($nom) || empty($email) || empty($password)) {
        set_flash('error', 'Tous les champs sont requis.');
        redirect('ajouter.php');
    }
    if (strlen($password) < 8) {
        set_flash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
        redirect('ajouter.php');
    }

    $result = Auth::createAdmin($nom, $email, $password, $role);
    set_flash($result['success'] ? 'success' : 'error', $result['message']);
    redirect($result['success'] ? 'index.php' : 'ajouter.php');
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Nouvel administrateur</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nom complet <span class="required">*</span></label><input type="text" name="nom" class="form-control" required></div>
                <div class="form-group"><label class="form-label">Email <span class="required">*</span></label><input type="email" name="email" class="form-control" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Mot de passe <span class="required">*</span></label><input type="password" name="password" class="form-control" minlength="8" required><small style="color:var(--admin-text-muted)">Minimum 8 caractères</small></div>
                <div class="form-group"><label class="form-label">Rôle</label>
                    <select name="role" class="form-control">
                        <option value="admin">Administrateur standard</option>
                        <option value="super_admin">Super Administrateur</option>
                    </select>
                </div>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Créer le compte</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
