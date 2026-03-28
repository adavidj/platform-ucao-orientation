<?php
// =================================================================
// PARAMÈTRES DU SITE
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Paramètres';
$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('index.php'); }
    
    $params = [
        'periode_nouveaux_bacheliers' => isset($_POST['periode_nouveaux_bacheliers']) ? '1' : '0',
        'site_nom' => trim($_POST['site_nom'] ?? 'UCAO Orientation'),
        'site_email' => trim($_POST['site_email'] ?? 'contact@ucaobenin.org'),
        'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0',
    ];

    foreach ($params as $cle => $valeur) {
        $stmt = $pdo->prepare("INSERT INTO parametres (cle, valeur) VALUES (?, ?) ON DUPLICATE KEY UPDATE valeur = ?");
        $stmt->execute([$cle, $valeur, $valeur]);
    }

    set_flash('success', 'Paramètres mis à jour avec succès.');
    redirect('index.php');
}

// Charger les paramètres actuels
$stmt = $pdo->query("SELECT cle, valeur FROM parametres");
$parametres = [];
while ($row = $stmt->fetch()) {
    $parametres[$row['cle']] = $row['valeur'];
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Paramètres de l'application</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>

            <!-- Période Nouveaux Bacheliers -->
            <div class="admin-card" style="background:var(--admin-bg);box-shadow:none;padding:20px;margin-bottom:24px;border-radius:12px">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                    <div>
                        <h3 style="font-family:var(--admin-font-primary);font-size:0.95rem;font-weight:600;margin-bottom:4px">Période Nouveaux Bacheliers</h3>
                        <p style="color:var(--admin-text-muted);font-size:0.8125rem;margin:0">Lorsqu'activé, le champ « Numéro de table » apparaît dans le formulaire d'orientation</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="periode_nouveaux_bacheliers" <?= ($parametres['periode_nouveaux_bacheliers'] ?? '0') === '1' ? 'checked' : '' ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Mode Maintenance -->
            <div class="admin-card" style="background:var(--admin-bg);box-shadow:none;padding:20px;margin-bottom:24px;border-radius:12px">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                    <div>
                        <h3 style="font-family:var(--admin-font-primary);font-size:0.95rem;font-weight:600;margin-bottom:4px">Mode Maintenance</h3>
                        <p style="color:var(--admin-text-muted);font-size:0.8125rem;margin:0">Active une page de maintenance pour les visiteurs du site public</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="maintenance_mode" <?= ($parametres['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Infos Site -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nom du site</label>
                    <input type="text" name="site_nom" class="form-control" value="<?= e($parametres['site_nom'] ?? 'UCAO Orientation') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Email de contact</label>
                    <input type="email" name="site_email" class="form-control" value="<?= e($parametres['site_email'] ?? 'contact@ucaobenin.org') ?>">
                </div>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px">
                <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg">Enregistrer les paramètres</button>
            </div>
        </form>
    </div>
</div>

<!-- Infos Système -->
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Informations système</h2></div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <tbody>
                    <tr><td><strong>Version PHP</strong></td><td><?= phpversion() ?></td></tr>
                    <tr><td><strong>Environnement</strong></td><td><span class="badge <?= APP_ENV === 'dev' ? 'badge-warning' : 'badge-success' ?>"><?= APP_ENV ?></span></td></tr>
                    <tr><td><strong>URL du site</strong></td><td><?= e(APP_URL) ?></td></tr>
                    <tr><td><strong>Timezone</strong></td><td><?= e(APP_TIMEZONE) ?></td></tr>
                    <tr><td><strong>Upload max</strong></td><td><?= ini_get('upload_max_filesize') ?></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
