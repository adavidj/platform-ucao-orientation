<?php
// Ajouter un métier
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Ajouter un métier';
$pdo = Database::getInstance();
$filieres = $pdo->query("SELECT id, nom_filiere, ecole_faculte FROM filieres WHERE actif = 1 ORDER BY ecole_faculte, nom_filiere")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('ajouter.php'); }
    $nom = trim($_POST['nom_metier'] ?? '');
    if (empty($nom)) { set_flash('error', 'Le nom du métier est requis.'); redirect('ajouter.php'); }

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO metiers (nom_metier, slug) VALUES (?, ?)");
        $stmt->execute([$nom, slugify($nom)]);
        $metierId = $pdo->lastInsertId();

        // Associations filières
        $selectedFilieres = $_POST['filieres'] ?? [];
        foreach ($selectedFilieres as $index => $filiereId) {
            $priorite = $index + 1;
            $pdo->prepare("INSERT INTO metiers_filieres (metier_id, filiere_id, priorite) VALUES (?, ?, ?)")
                ->execute([$metierId, intval($filiereId), $priorite]);
        }

        $pdo->commit();
        set_flash('success', 'Métier ajouté avec succès.');
        redirect('index.php');
    } catch (Exception $e) {
        $pdo->rollBack();
        set_flash('error', 'Erreur : ' . $e->getMessage());
        redirect('ajouter.php');
    }
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>
<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour</a></div>
<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Nouveau métier</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <div class="form-group"><label class="form-label">Nom du métier <span class="required">*</span></label><input type="text" name="nom_metier" class="form-control" required></div>
            <div class="form-group">
                <label class="form-label">Filières associées (dans l'ordre de priorité)</label>
                <div style="max-height:300px;overflow-y:auto;border:1.5px solid var(--admin-border);border-radius:6px;padding:12px">
                    <?php foreach ($filieres as $f): ?>
                    <label style="display:flex;align-items:center;gap:8px;padding:6px 4px;cursor:pointer;border-bottom:1px solid rgba(0,0,0,0.04)">
                        <input type="checkbox" name="filieres[]" value="<?= $f['id'] ?>" style="width:16px;height:16px">
                        <span class="badge badge-primary" style="font-size:0.65rem"><?= e($f['ecole_faculte']) ?></span>
                        <span style="font-size:0.8125rem"><?= e($f['nom_filiere']) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <small style="color:var(--admin-text-muted)">L'ordre de sélection détermine la priorité</small>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
