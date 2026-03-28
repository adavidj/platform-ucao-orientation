<?php
// Modifier une filière
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pdo = Database::getInstance();
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if (!$id) { set_flash('error', 'Filière introuvable.'); redirect('index.php'); }
$stmt = $pdo->prepare("SELECT * FROM filieres WHERE id = ?"); $stmt->execute([$id]);
$filiere = $stmt->fetch();
if (!$filiere) { set_flash('error', 'Filière introuvable.'); redirect('index.php'); }
$pageTitle = 'Modifier — ' . $filiere['nom_filiere'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('modifier.php?id=' . $id); }
    $stmt = $pdo->prepare("UPDATE filieres SET ecole_faculte=?, nom_filiere=?, niveau=?, duree=?, description=?, debouches=?, slug=?, actif=? WHERE id=?");
    $stmt->execute([trim($_POST['ecole_faculte']), trim($_POST['nom_filiere']), trim($_POST['niveau']), trim($_POST['duree']), trim($_POST['description']), trim($_POST['debouches']), slugify($_POST['nom_filiere']), isset($_POST['actif']) ? 1 : 0, $id]);
    set_flash('success', 'Filière modifiée avec succès.');
    redirect('index.php');
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Modifier la filière</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-row">
                <div class="form-group"><label class="form-label">École / Faculté</label>
                    <select name="ecole_faculte" class="form-control" required>
                        <?php foreach (ECOLES_FACULTES as $code => $nom): ?>
                        <option value="<?= $code ?>" <?= $filiere['ecole_faculte'] === $code ? 'selected' : '' ?>><?= e($code . ' — ' . $nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Nom</label><input type="text" name="nom_filiere" class="form-control" value="<?= e($filiere['nom_filiere']) ?>" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Niveau</label><select name="niveau" class="form-control"><option value="Licence" <?= $filiere['niveau']==='Licence'?'selected':'' ?>>Licence</option><option value="Master" <?= $filiere['niveau']==='Master'?'selected':'' ?>>Master</option></select></div>
                <div class="form-group"><label class="form-label">Durée</label><input type="text" name="duree" class="form-control" value="<?= e($filiere['duree']) ?>"></div>
            </div>
            <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4"><?= e($filiere['description']) ?></textarea></div>
            <div class="form-group"><label class="form-label">Débouchés</label><textarea name="debouches" class="form-control" rows="3"><?= e($filiere['debouches']) ?></textarea></div>
            <div class="form-group" style="display:flex;align-items:center;gap:12px">
                <label class="toggle-switch"><input type="checkbox" name="actif" <?= $filiere['actif'] ? 'checked' : '' ?>><span class="toggle-slider"></span></label>
                <label class="form-label" style="margin:0">Filière active</label>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
