<?php
// =================================================================
// LISTE DES PRÉINSCRIPTIONS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Gestion des préinscriptions';

// Charger les filières pour le filtre
$pdo = Database::getInstance();
$filieres = $pdo->query("SELECT id, nom_filiere, ecole_faculte FROM filieres WHERE actif = 1 ORDER BY ecole_faculte, nom_filiere")->fetchAll();

$filters = [
    'filiere' => $_GET['filiere'] ?? '',
    'date_debut' => $_GET['date_debut'] ?? '',
    'date_fin' => $_GET['date_fin'] ?? '',
    'serie_bac' => $_GET['serie_bac'] ?? '',
    'search' => $_GET['search'] ?? '',
];
$page = max(1, intval($_GET['page'] ?? 1));

$result = Preinscription::getAll($filters, $page);
$preinscriptions = $result['data'];
$totalPages = $result['totalPages'];
$total = $result['total'];

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div class="admin-card" style="margin-bottom:24px">
    <form method="GET" class="filters-bar">
        <div class="filter-group">
            <label>Recherche</label>
            <input type="text" name="search" value="<?= e($filters['search']) ?>" placeholder="Nom, email...">
        </div>
        <div class="filter-group">
            <label>Filière</label>
            <select name="filiere">
                <option value="">Toutes</option>
                <?php foreach ($filieres as $f): ?>
                <option value="<?= $f['id'] ?>" <?= $filters['filiere'] == $f['id'] ? 'selected' : '' ?>><?= e($f['ecole_faculte'] . ' — ' . $f['nom_filiere']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label>Série Bac</label>
            <select name="serie_bac">
                <option value="">Toutes</option>
                <?php foreach (SERIES_BAC as $key => $label): ?>
                <option value="<?= $key ?>" <?= $filters['serie_bac'] === $key ? 'selected' : '' ?>><?= $key ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label>Date début</label>
            <input type="date" name="date_debut" value="<?= e($filters['date_debut']) ?>">
        </div>
        <div class="filter-group" style="justify-content:flex-end">
            <label>&nbsp;</label>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn-admin btn-admin-primary btn-admin-sm">Filtrer</button>
                <a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><?= $total ?> préinscription(s)<?= !empty(array_filter($filters)) ? ' trouvée(s)' : '' ?></h2>
        <div class="admin-card-actions">
            <a href="export-csv.php?<?= http_build_query($filters) ?>" class="btn-admin btn-admin-outline btn-admin-sm">Export CSV</a>
            <a href="export-pdf.php?<?= http_build_query($filters) ?>" class="btn-admin btn-admin-outline btn-admin-sm">Export PDF</a>
        </div>
    </div>
    <div class="admin-table-wrap">
        <?php if (!empty($preinscriptions)): ?>
        <table class="admin-table">
            <thead><tr><th>Nom</th><th>Email</th><th>Série</th><th>Filière</th><th>Niveau</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($preinscriptions as $p): ?>
                <tr>
                    <td><strong><?= e($p['nom'] . ' ' . $p['prenom']) ?></strong></td>
                    <td><?= e($p['email']) ?></td>
                    <td><span class="badge badge-gold"><?= e($p['serie_bac']) ?></span></td>
                    <td><span class="badge badge-primary"><?= e(truncate($p['nom_filiere'] ?? 'N/A', 25)) ?></span></td>
                    <td><?= e($p['niveau_entree']) ?></td>
                    <td><?= date_fr($p['created_at'], 'd/m/Y') ?></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="voir.php?id=<?= $p['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Voir le dossier">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state"><h3>Aucune préinscription trouvée</h3><p>Aucun résultat ne correspond à vos critères.</p></div>
        <?php endif; ?>
    </div>
    <?php if ($totalPages > 1): ?>
    <div class="admin-pagination">
        <?php if ($page > 1): ?><a href="?<?= http_build_query(array_merge($filters, ['page' => $page - 1])) ?>">← Précédent</a><?php endif; ?>
        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
        <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?><a href="?<?= http_build_query(array_merge($filters, ['page' => $page + 1])) ?>">Suivant →</a><?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
