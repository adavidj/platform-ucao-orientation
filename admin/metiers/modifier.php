<?php
// Modifier un métier
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pdo = Database::getInstance();
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if (!$id) { set_flash('error', 'Métier introuvable.'); redirect('index.php'); }
$stmt = $pdo->prepare("SELECT * FROM metiers WHERE id = ?"); $stmt->execute([$id]);
$metier = $stmt->fetch();
if (!$metier) { set_flash('error', 'Métier introuvable.'); redirect('index.php'); }
$pageTitle = 'Modifier — ' . $metier['nom_metier'];

$filieres = $pdo->query("SELECT id, nom_filiere, ecole_faculte FROM filieres WHERE actif = 1 ORDER BY ecole_faculte, nom_filiere")->fetchAll();
$associees = $pdo->prepare("SELECT filiere_id FROM metiers_filieres WHERE metier_id = ? ORDER BY priorite");
$associees->execute([$id]);
$associeesIds = $associees->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('modifier.php?id=' . $id); }
    $nom = trim($_POST['nom_metier'] ?? '');

    $pdo->beginTransaction();
    try {
        $pdo->prepare("UPDATE metiers SET nom_metier=?, slug=?, actif=? WHERE id=?")
            ->execute([$nom, slugify($nom), isset($_POST['actif']) ? 1 : 0, $id]);

        // Recréer les associations
        $pdo->prepare("DELETE FROM metiers_filieres WHERE metier_id = ?")->execute([$id]);
        $selectedFilieres = $_POST['filieres'] ?? [];
        foreach ($selectedFilieres as $index => $filiereId) {
            $pdo->prepare("INSERT INTO metiers_filieres (metier_id, filiere_id, priorite) VALUES (?, ?, ?)")
                ->execute([$id, intval($filiereId), $index + 1]);
        }

        $pdo->commit();
        set_flash('success', 'Métier modifié avec succès.');
        redirect('index.php');
    } catch (Exception $e) {
        $pdo->rollBack();
        set_flash('error', 'Erreur : ' . $e->getMessage());
        redirect('modifier.php?id=' . $id);
    }
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Modifier le métier</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-group"><label class="form-label">Nom du métier</label><input type="text" name="nom_metier" class="form-control" value="<?= e($metier['nom_metier']) ?>" required></div>
            <div class="form-group">
                <label class="form-label">Filières associées</label>
                <div style="max-height:300px;overflow-y:auto;border:1.5px solid var(--admin-border);border-radius:6px;padding:12px">
                    <?php foreach ($filieres as $f): ?>
                    <label style="display:flex;align-items:center;gap:8px;padding:6px 4px;cursor:pointer;border-bottom:1px solid rgba(0,0,0,0.04)">
                        <input type="checkbox" name="filieres[]" value="<?= $f['id'] ?>" <?= in_array($f['id'], $associeesIds) ? 'checked' : '' ?> style="width:16px;height:16px">
                        <span class="badge badge-primary" style="font-size:0.65rem"><?= e($f['ecole_faculte']) ?></span>
                        <span style="font-size:0.8125rem"><?= e($f['nom_filiere']) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:12px">
                <label class="toggle-switch"><input type="checkbox" name="actif" <?= $metier['actif'] ? 'checked' : '' ?>><span class="toggle-slider"></span></label>
                <label class="form-label" style="margin:0">Métier actif</label>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
