<?php
// =================================================================
// VOIR UNE ORIENTATION
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { set_flash('error', 'Orientation introuvable.'); redirect('index.php'); }

$orientation = Orientation::getById($id);
if (!$orientation) { set_flash('error', 'Orientation introuvable.'); redirect('index.php'); }

$pageTitle = 'Orientation #' . $id;
require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:16px">
    <a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour à la liste</a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Fiche d'orientation — <?= e($orientation['nom'] . ' ' . $orientation['prenom']) ?></h2>
        <div class="admin-card-actions">
            <?php if (!empty($orientation['rapport_pdf_path'])): ?>
            <a href="<?= APP_URL ?>/uploads/rapports/<?= e($orientation['rapport_pdf_path']) ?>" class="btn-admin btn-admin-primary btn-admin-sm" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Télécharger le rapport PDF
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="admin-card-body">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nom</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px;font-weight:600"><?= e($orientation['nom']) ?></div>
            </div>
            <div class="form-group">
                <label class="form-label">Prénom</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px;font-weight:600"><?= e($orientation['prenom']) ?></div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Email</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($orientation['email']) ?></div>
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($orientation['telephone']) ?></div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Série du Bac</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><span class="badge badge-gold"><?= e($orientation['serie_bac']) ?></span></div>
            </div>
            <div class="form-group">
                <label class="form-label">Numéro de table</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($orientation['numero_table'] ?: '—') ?></div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Métier souhaité</label>
            <div style="padding:10px 14px;background:rgba(24,3,145,0.04);border-left:4px solid var(--admin-primary);border-radius:6px;font-weight:600;font-size:1.05rem;color:var(--admin-primary)"><?= e($orientation['metier_souhaite']) ?></div>
        </div>
        <div class="form-group">
            <label class="form-label">Filières recommandées</label>
            <div style="padding:14px;background:rgba(16,185,129,0.04);border-left:4px solid var(--admin-success);border-radius:6px"><?= nl2br(e($orientation['filieres_recommandees'] ?: 'Aucune filière recommandée')) ?></div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Date d'orientation</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= date_fr($orientation['created_at']) ?></div>
            </div>
            <div class="form-group">
                <label class="form-label">Statut email</label>
                <div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px">
                    <?= $orientation['email_envoye'] ? '<span class="badge badge-success">✓ Email envoyé</span>' : '<span class="badge badge-warning">En attente</span>' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
