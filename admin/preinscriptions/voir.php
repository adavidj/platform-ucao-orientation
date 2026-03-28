<?php
// =================================================================
// VOIR UN DOSSIER DE PRÉINSCRIPTION
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { set_flash('error', 'Préinscription introuvable.'); redirect('index.php'); }

$preinscription = Preinscription::getById($id);
if (!$preinscription) { set_flash('error', 'Préinscription introuvable.'); redirect('index.php'); }

$pageTitle = 'Dossier #' . $id;
require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour à la liste</a></div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Dossier de préinscription — <?= e($preinscription['nom'] . ' ' . $preinscription['prenom']) ?></h2>
    </div>
    <div class="admin-card-body">
        <div class="form-row">
            <div class="form-group"><label class="form-label">Nom</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px;font-weight:600"><?= e($preinscription['nom']) ?></div></div>
            <div class="form-group"><label class="form-label">Prénom</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px;font-weight:600"><?= e($preinscription['prenom']) ?></div></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Date de naissance</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= date_fr($preinscription['date_naissance'], 'd/m/Y') ?></div></div>
            <div class="form-group"><label class="form-label">Nationalité</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['nationalite']) ?></div></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Email</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['email']) ?></div></div>
            <div class="form-group"><label class="form-label">Téléphone</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['telephone']) ?></div></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Série du Bac</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><span class="badge badge-gold"><?= e($preinscription['serie_bac']) ?></span></div></div>
            <div class="form-group"><label class="form-label">Année du Bac</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['annee_bac']) ?></div></div>
        </div>
        <div class="form-group"><label class="form-label">Établissement d'origine</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['etablissement_origine']) ?></div></div>
        <div class="form-row">
            <div class="form-group"><label class="form-label">Filière choisie</label><div style="padding:10px 14px;background:rgba(24,3,145,0.04);border-left:4px solid var(--admin-primary);border-radius:6px;font-weight:600"><span class="badge badge-primary"><?= e($preinscription['ecole_faculte'] ?? '') ?></span> <?= e($preinscription['nom_filiere'] ?? 'N/A') ?></div></div>
            <div class="form-group"><label class="form-label">Niveau d'entrée</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= e($preinscription['niveau_entree']) ?></div></div>
        </div>
        <div class="form-group"><label class="form-label">Date de préinscription</label><div style="padding:10px 14px;background:var(--admin-bg);border-radius:6px"><?= date_fr($preinscription['created_at']) ?></div></div>

        <!-- Documents soumis -->
        <h3 style="font-family:var(--admin-font-primary);font-size:1rem;font-weight:600;margin:24px 0 16px;color:var(--admin-text);display:flex;align-items:center;gap:8px">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            Documents soumis
        </h3>
        <div class="form-row">
            <?php
            $docs = [
                'doc_releve' => 'Relevé de notes',
                'doc_bac' => 'Diplôme / Attestation du Bac',
                'doc_identite' => 'Pièce d\'identité',
            ];
            foreach ($docs as $key => $label):
            ?>
            <div class="form-group">
                <label class="form-label"><?= $label ?></label>
                <?php if (!empty($preinscription[$key])): ?>
                <a href="<?= APP_URL ?>/uploads/dossiers/<?= e($preinscription[$key]) ?>" class="btn-admin btn-admin-outline btn-admin-sm" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Télécharger
                </a>
                <?php else: ?>
                <div style="padding:10px;color:var(--admin-text-muted);font-size:0.8125rem">Non fourni</div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
