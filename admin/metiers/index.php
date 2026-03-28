<?php
// =================================================================
// GESTION DES MÉTIERS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Gestion des métiers';
$pdo = Database::getInstance();
$metiers = $pdo->query("
    SELECT m.*, GROUP_CONCAT(f.nom_filiere ORDER BY mf.priorite SEPARATOR ', ') AS filieres_noms,
    (SELECT COUNT(*) FROM metiers_filieres mf2 WHERE mf2.metier_id = m.id) AS nb_filieres
    FROM metiers m
    LEFT JOIN metiers_filieres mf ON m.id = mf.metier_id
    LEFT JOIN filieres f ON mf.filiere_id = f.id
    GROUP BY m.id
    ORDER BY m.nom_metier
")->fetchAll();

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:20px;display:flex;justify-content:flex-end">
    <a href="ajouter.php" class="btn-admin btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Ajouter un métier
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><?= count($metiers) ?> métier(s)</h2>
        <div class="admin-card-actions">
            <input type="text" id="tableSearch" class="form-control" placeholder="Rechercher..." style="max-width:250px;padding:8px 12px;font-size:0.8125rem">
        </div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Métier</th><th>Filières associées</th><th>Nb</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($metiers as $m): ?>
            <tr>
                <td><strong><?= e($m['nom_metier']) ?></strong></td>
                <td><small style="color:var(--admin-text-muted)"><?= e(truncate($m['filieres_noms'] ?? 'Aucune', 60)) ?></small></td>
                <td><span class="badge badge-gold"><?= $m['nb_filieres'] ?></span></td>
                <td><?= $m['actif'] ? '<span class="badge badge-success">Actif</span>' : '<span class="badge badge-error">Inactif</span>' ?></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="modifier.php?id=<?= $m['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <form method="POST" action="supprimer.php" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $m['id'] ?>">
                            <button type="submit" class="btn-admin btn-admin-ghost btn-admin-sm" data-confirm="Supprimer ce métier et ses associations ?">
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
