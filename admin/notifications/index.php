<?php
// =================================================================
// HISTORIQUE DES NOTIFICATIONS
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Notifications';
$page = max(1, intval($_GET['page'] ?? 1));
$result = Notification::getHistory($page);
$notifications = $result['data'];
$totalPages = $result['totalPages'];

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:20px;display:flex;justify-content:flex-end">
    <a href="composer.php" class="btn-admin btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouvelle notification
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Historique des notifications envoyées</h2></div>
    <div class="admin-table-wrap">
        <?php if (!empty($notifications)): ?>
        <table class="admin-table">
            <thead><tr><th>Sujet</th><th>Type</th><th>Destinataires</th><th>Envoyé par</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($notifications as $n): ?>
            <tr>
                <td><strong><?= e($n['sujet']) ?></strong><br><small style="color:var(--admin-text-muted)"><?= e(truncate($n['message'], 60)) ?></small></td>
                <td><span class="badge badge-info"><?= e($n['type_cible']) ?></span></td>
                <td><strong><?= $n['nb_destinataires'] ?></strong> personne(s)</td>
                <td><?= e($n['admin_nom'] ?? '—') ?></td>
                <td><?= date_fr($n['envoye_le']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state"><h3>Aucune notification envoyée</h3><p>Les notifications apparaîtront ici après envoi.</p></div>
        <?php endif; ?>
    </div>
    <?php if ($totalPages > 1): ?>
    <div class="admin-pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
