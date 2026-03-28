<?php
// Ajouter une filière
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Ajouter une filière';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('ajouter.php'); }
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("INSERT INTO filieres (ecole_faculte, nom_filiere, niveau, duree, description, debouches, slug) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['ecole_faculte']),
        trim($_POST['nom_filiere']),
        trim($_POST['niveau']),
        trim($_POST['duree']),
        trim($_POST['description']),
        trim($_POST['debouches']),
        slugify($_POST['nom_filiere']),
    ]);
    set_flash('success', 'Filière ajoutée avec succès.');
    redirect('index.php');
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Nouvelle filière</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="form-group"><label class="form-label">École / Faculté <span class="required">*</span></label>
                    <select name="ecole_faculte" class="form-control" required>
                        <?php foreach (ECOLES_FACULTES as $code => $nom): ?>
                        <option value="<?= $code ?>"><?= e($code . ' — ' . $nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Nom de la filière <span class="required">*</span></label><input type="text" name="nom_filiere" class="form-control" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Niveau</label><select name="niveau" class="form-control"><option value="Licence">Licence</option><option value="Master">Master</option></select></div>
                <div class="form-group"><label class="form-label">Durée</label><input type="text" name="duree" class="form-control" value="3 ans"></div>
            </div>
            <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4"></textarea></div>
            <div class="form-group"><label class="form-label">Débouchés</label><textarea name="debouches" class="form-control" rows="3"></textarea></div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
