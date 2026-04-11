<?php
// =================================================================
// LISTE DES ORIENTATIONS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Gestion des orientations';

// Filtres
$filters = [
    'date_debut' => $_GET['date_debut'] ?? '',
    'date_fin' => $_GET['date_fin'] ?? '',
    'serie_bac' => $_GET['serie_bac'] ?? '',
    'metier' => $_GET['metier'] ?? '',
    'search' => $_GET['search'] ?? '',
];
$page = max(1, intval($_GET['page'] ?? 1));

$result = Orientation::getAll($filters, $page);
$orientations = $result['data'];
$totalPages = $result['totalPages'];
$total = $result['total'];

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<!-- Filters -->
<div class="admin-card" style="margin-bottom:24px">
    <form method="GET" class="filters-bar">
        <div class="filter-group">
            <label>Recherche</label>
            <input type="text" name="search" value="<?= e($filters['search']) ?>" placeholder="Nom, email...">
        </div>
        <div class="filter-group">
            <label>Date début</label>
            <input type="date" name="date_debut" value="<?= e($filters['date_debut']) ?>">
        </div>
        <div class="filter-group">
            <label>Date fin</label>
            <input type="date" name="date_fin" value="<?= e($filters['date_fin']) ?>">
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
            <label>Métier</label>
            <input type="text" name="metier" value="<?= e($filters['metier']) ?>" placeholder="Filtrer par métier...">
        </div>
        <div class="filter-group" style="justify-content:flex-end">
            <label>&nbsp;</label>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn-admin btn-admin-primary btn-admin-sm">Filtrer</button>
                <a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">Réinitialiser</a>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><?= $total ?> orientation(s)<?= !empty(array_filter($filters)) ? ' trouvée(s)' : '' ?></h2>
        <div class="admin-card-actions">
            <button class="btn-admin btn-admin-outline btn-admin-sm" id="bulk-send-btn" style="display:none;" onclick="openBulkModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                Envoyer un mail
            </button>
            <a href="export.php?<?= http_build_query($filters) ?>" class="btn-admin btn-admin-outline btn-admin-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export CSV
            </a>
            <a href="export-pdf.php?<?= http_build_query($filters) ?>" class="btn-admin btn-admin-outline btn-admin-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                Export PDF
            </a>
        </div>
    </div>
    <div class="admin-table-wrap">
        <?php if (!empty($orientations)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" id="select-all" onchange="toggleSelectAll(this)"></th>
                    <th>Nom / Prénom</th>
                    <th>Email</th>
                    <th>Série</th>
                    <th>Métier souhaité</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orientations as $o): ?>
                <tr>
                    <td><input type="checkbox" class="row-select" value="<?= $o['id'] ?>" onchange="updateBulkBtn()"></td>
                    <td><strong><?= e($o['nom'] . ' ' . $o['prenom']) ?></strong></td>
                    <td><?= e($o['email']) ?></td>
                    <td><span class="badge badge-gold"><?= e($o['serie_bac']) ?></span></td>
                    <td><?= e(truncate($o['metier_souhaite'], 35)) ?></td>
                    <td><?= date_fr($o['created_at'], 'd/m/Y') ?></td>
                    <td><?= $o['email_envoye'] ? '<span class="badge badge-success">Envoyé</span>' : '<span class="badge badge-warning">En attente</span>' ?></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="voir.php?id=<?= $o['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <?php if (!empty($o['rapport_pdf_path'])): ?>
                            <a href="<?= APP_URL ?>/telecharger-rapport.php?id=<?= $o['id'] ?>" class="btn-admin btn-admin-ghost btn-admin-sm" title="Télécharger PDF">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            </a>
                            <?php endif; ?>
                            <button class="btn-admin btn-admin-ghost btn-admin-sm" title="Répondre" onclick="openReplyModal(<?= $o['id'] ?>, '<?= e(addslashes($o['email'])) ?>', '<?= e(addslashes($o['metier_souhaite'])) ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </button>
                            <form action="supprimer.php" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette orientation ? Cette action est irréversible.');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                <button type="submit" class="btn-admin btn-admin-ghost btn-admin-sm" title="Supprimer" style="color:#d9534f;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <h3>Aucune orientation trouvée</h3>
            <p>Aucun résultat ne correspond à vos critères de recherche.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="admin-pagination">
        <?php if ($page > 1): ?>
        <a href="?<?= http_build_query(array_merge($filters, ['page' => $page - 1])) ?>">← Précédent</a>
        <?php endif; ?>
        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
        <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
        <a href="?<?= http_build_query(array_merge($filters, ['page' => $page + 1])) ?>">Suivant →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Réponse Personnalisée -->
<div class="admin-modal" id="replyModal">
    <div class="modal-header">
        <h3 class="modal-title">Réponse personnalisée</h3>
        <button class="modal-close" onclick="closeModal('replyModal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <form method="POST" action="repondre.php">
        <?= csrf_field() ?>
        <input type="hidden" name="orientation_id" id="replyOrientationId">
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Destinataire</label>
                <input type="email" class="form-control" id="replyEmail" name="email" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Sujet</label>
                <input type="text" class="form-control" name="sujet" id="replySujet" value="Votre orientation à l'UCAO">
            </div>
            <div class="form-group">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="message" id="replyMessage" rows="8"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-admin btn-admin-outline" onclick="closeModal('replyModal')">Annuler</button>
            <button type="submit" class="btn-admin btn-admin-primary">Envoyer</button>
        </div>
    </form>
</div>

<!-- Modal Envoi Groupé -->
<div class="admin-modal" id="bulkModal">
    <div class="modal-header">
        <h3 class="modal-title">Envoi groupé</h3>
        <button class="modal-close" onclick="closeModal('bulkModal')">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <form method="POST" action="envoyer-bulk.php">
        <?= csrf_field() ?>
        <div class="modal-body">
            <div id="selected-count" style="padding:12px;background:#e8f5e9;border-radius:6px;margin-bottom:16px;color:#2e7d32;font-weight:500"></div>
            <div class="form-group">
                <label class="form-label">Sujet</label>
                <input type="text" class="form-control" name="sujet" placeholder="Optionnel - Sujet par défaut si vide">
            </div>
            <div class="form-group">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="message" rows="8" placeholder="Optionnel - Message par défaut si vide"></textarea>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:10px;padding:12px;background:#f0f7ff;border-radius:6px">
                <input type="checkbox" name="joindre_pdf" id="joindre_pdf" value="1" checked style="width:18px;height:18px">
                <label for="joindre_pdf" style="margin:0;cursor:pointer">
                    <strong>Joindre le rapport PDF personnalisé</strong>
                    <small style="display:block;color:#666">Le rapport d'orientation de chaque personne sera joint à son email</small>
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-admin btn-admin-outline" onclick="closeModal('bulkModal')">Annuler</button>
            <button type="submit" class="btn-admin btn-admin-primary">Envoyer</button>
        </div>
    </form>
</div>

<?php
$inlineJS = "
function openReplyModal(id, email, metier) {
    document.getElementById('replyOrientationId').value = id;
    document.getElementById('replyEmail').value = email;
    document.getElementById('replySujet').value = 'Votre orientation UCAO — ' + metier;
    document.getElementById('replyMessage').value = 'Bonjour,\\n\\nSuite à votre demande d\\'orientation pour le métier de « ' + metier + ' », nous avons le plaisir de vous informer que l\\'UCAO propose des formations parfaitement adaptées à votre projet professionnel.\\n\\nNous vous invitons à consulter votre rapport d\\'orientation et à procéder à votre pré-inscription en ligne.\\n\\nL\\'équipe UCAO reste à votre disposition pour tout complément d\\'information.\\n\\nCordialement,\\nL\\'équipe UCAO-Orientation';
    openModal('replyModal');
}

function toggleSelectAll(cb) {
    document.querySelectorAll('.row-select').forEach(c => c.checked = cb.checked);
    updateBulkBtn();
}

function updateBulkBtn() {
    const count = document.querySelectorAll('.row-select:checked').length;
    document.getElementById('bulk-send-btn').style.display = count > 0 ? 'inline-flex' : 'none';
}

function openBulkModal() {
    const selected = document.querySelectorAll('.row-select:checked');
    if (selected.length === 0) { alert('Sélectionnez au moins une orientation'); return; }

    const form = document.getElementById('bulkModal').querySelector('form');
    form.querySelectorAll('input[name=\"ids[]\"]').forEach(i => i.remove());
    selected.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden'; input.name = 'ids[]'; input.value = cb.value;
        form.appendChild(input);
    });

    document.getElementById('selected-count').textContent = selected.length + ' personne(s) sélectionnée(s)';
    openModal('bulkModal');
}
";

require_once dirname(__DIR__) . '/includes/footer-admin.php';
?>

