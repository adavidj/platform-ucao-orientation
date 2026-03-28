<?php
// =================================================================
// GESTION DES FILIÈRES
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Gestion des filières';
$pdo = Database::getInstance();
$filieres = $pdo->query("SELECT f.*, (SELECT COUNT(*) FROM metiers_filieres mf WHERE mf.filiere_id = f.id) AS nb_metiers FROM filieres f ORDER BY f.ecole_faculte, f.nom_filiere")->fetchAll();

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:20px;display:flex;justify-content:flex-end">
    <a href="ajouter.php" class="btn-admin btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Ajouter une filière
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title"><?= count($filieres) ?> filière(s)</h2></div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>École</th><th>Filière</th><th>Niveau</th><th>Durée</th><th>Métiers liés</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($filieres as $f): ?>
            <tr>
                <td><span class="badge badge-primary"><?= e($f['ecole_faculte']) ?></span></td>
                <td><strong><?= e($f['nom_filiere']) ?></strong></td>
                <td><?= e($f['niveau']) ?></td>
                <td><?= e($f['duree']) ?></td>
                <td><span class="badge badge-gold"><?= $f['nb_metiers'] ?></span></td>
                <td><?= $f['actif'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-error">Inactive</span>' ?></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="modifier.php?id=<?= $f['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <form method="POST" action="supprimer.php" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $f['id'] ?>">
                            <button type="submit" class="btn-admin btn-admin-ghost btn-admin-sm" title="Supprimer" data-confirm="Supprimer cette filière ?">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--admin-error)"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
