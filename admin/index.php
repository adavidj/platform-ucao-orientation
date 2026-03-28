<?php
// =================================================================
// DASHBOARD ADMIN
// =================================================================
require_once __DIR__ . '/includes/auth-check.php';

$pageTitle = 'Tableau de bord';

// Récupérer les statistiques
try {
    $orientationsTotal = Orientation::getCount();
    $orientationsMois = Orientation::getCount('month');
    $preinscriptionsTotal = Preinscription::getCount();
    $preinscriptionsMois = Preinscription::getCount('month');
    $pdfCount = Orientation::getPDFCount();
    $conversionRate = Orientation::getConversionRate();
    $evolutionOrientations = Orientation::getEvolutionData();
    $evolutionPreinscriptions = Preinscription::getEvolutionData();
    $serieBacRepartition = Orientation::getSerieBacRepartition();
    $topMetiers = Orientation::getTopMetiers(8);
    $topFilieres = Orientation::getTopFilieres(6);
    $recentOrientations = Orientation::getRecent(5);
    $recentPreinscriptions = Preinscription::getRecent(5);
} catch (Exception $e) {
    $orientationsTotal = $orientationsMois = $preinscriptionsTotal = $preinscriptionsMois = $pdfCount = $conversionRate = 0;
    $topMetiers = $topFilieres = $recentOrientations = $recentPreinscriptions = $evolutionOrientations = $evolutionPreinscriptions = $serieBacRepartition = [];
}

// Compter les admins actifs
try {
    $pdo = Database::getInstance();
    $adminsActifs = $pdo->query("SELECT COUNT(*) FROM admins WHERE actif = 1")->fetchColumn();
} catch (Exception $e) {
    $adminsActifs = 0;
}

require_once __DIR__ . '/includes/header-admin.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<!-- ============================================================
     STAT CARDS
     ============================================================ -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Orientations</h3>
            <div class="stat-number" data-count="<?= $orientationsTotal ?>"><?= number_format($orientationsTotal, 0, ',', ' ') ?></div>
            <div class="stat-sub"><span class="up">+<?= $orientationsMois ?></span> ce mois</div>
        </div>
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Préinscriptions</h3>
            <div class="stat-number" data-count="<?= $preinscriptionsTotal ?>"><?= number_format($preinscriptionsTotal, 0, ',', ' ') ?></div>
            <div class="stat-sub"><span class="up">+<?= $preinscriptionsMois ?></span> ce mois</div>
        </div>
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Rapports PDF</h3>
            <div class="stat-number" data-count="<?= $pdfCount ?>"><?= number_format($pdfCount, 0, ',', ' ') ?></div>
            <div class="stat-sub">générés au total</div>
        </div>
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Admins actifs</h3>
            <div class="stat-number" data-count="<?= $adminsActifs ?>"><?= $adminsActifs ?></div>
            <div class="stat-sub">comptes activés</div>
        </div>
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
    </div>

    <!-- NOUVEAU : Taux de Conversion -->
    <div class="stat-card" style="border-left: 4px solid var(--admin-primary)">
        <div class="stat-info">
            <h3>Taux de Conversion</h3>
            <div class="stat-number"><span data-count="<?= $conversionRate ?>">0</span>%</div>
            <div class="stat-sub">Orientés → Préinscrits</div>
        </div>
        <div class="stat-icon" style="background: rgba(24, 3, 145, 0.1); color: var(--admin-primary)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
        </div>
    </div>
</div>

<!-- ============================================================
     EVOLUTION (NOUVEAU GRAPHIQUE PLEINE LARGEUR)
     ============================================================ -->
<div class="charts-row" style="margin-bottom: 24px;">
    <div class="admin-card" style="width: 100%;">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Évolution sur les 30 derniers jours</h2>
        </div>
        <div class="admin-card-body">
            <div class="chart-container" style="height: 300px;">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     CHARTS
     ============================================================ -->
<div class="charts-row">
    <!-- Métiers Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Métiers les plus demandés</h2>
        </div>
        <div class="admin-card-body">
            <?php if (!empty($topMetiers)): ?>
            <div class="chart-container">
                <canvas id="metiersChart"></canvas>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <p>Aucune donnée d'orientation pour le moment.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filières Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Filières recommandées</h2>
        </div>
        <div class="admin-card-body">
            <?php if (!empty($topFilieres)): ?>
            <div class="chart-container">
                <canvas id="filieresChart"></canvas>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <p>Aucune donnée de filières pour le moment.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Séries BAC Chart (NOUVEAU) -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Profils par Série BAC</h2>
        </div>
        <div class="admin-card-body">
            <?php if (!empty($serieBacRepartition)): ?>
            <div class="chart-container">
                <canvas id="serieBacChart"></canvas>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <p>Aucune donnée de série de BAC pour le moment.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ============================================================
     RECENT TABLES
     ============================================================ -->
<div class="charts-row">
    <!-- Dernières orientations -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Dernières orientations</h2>
            <a href="<?= APP_URL ?>/admin/orientations/index.php" class="btn-admin btn-admin-outline btn-admin-sm">Voir tout</a>
        </div>
        <div class="admin-table-wrap">
            <?php if (!empty($recentOrientations)): ?>
            <table class="admin-table">
                <thead><tr><th>Nom</th><th>Métier</th><th>Date</th><th>Statut</th></tr></thead>
                <tbody>
                    <?php foreach ($recentOrientations as $o): ?>
                    <tr>
                        <td><strong><?= e($o['nom'] . ' ' . $o['prenom']) ?></strong><br><small style="color:var(--admin-text-muted)"><?= e($o['email']) ?></small></td>
                        <td><?= e(truncate($o['metier_souhaite'], 30)) ?></td>
                        <td><?= date_fr($o['created_at'], 'd/m/Y') ?></td>
                        <td><?= $o['email_envoye'] ? '<span class="badge badge-success">Envoyé</span>' : '<span class="badge badge-warning">En attente</span>' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><p>Aucune orientation enregistrée.</p></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Dernières préinscriptions -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Dernières préinscriptions</h2>
            <a href="<?= APP_URL ?>/admin/preinscriptions/index.php" class="btn-admin btn-admin-outline btn-admin-sm">Voir tout</a>
        </div>
        <div class="admin-table-wrap">
            <?php if (!empty($recentPreinscriptions)): ?>
            <table class="admin-table">
                <thead><tr><th>Nom</th><th>Filière</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach ($recentPreinscriptions as $p): ?>
                    <tr>
                        <td><strong><?= e($p['nom'] . ' ' . $p['prenom']) ?></strong></td>
                        <td><span class="badge badge-primary"><?= e($p['nom_filiere'] ?? 'N/A') ?></span></td>
                        <td><?= date_fr($p['created_at'], 'd/m/Y') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><p>Aucune préinscription enregistrée.</p></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Charts data
$metiersLabels = json_encode(array_column($topMetiers, 'label'));
$metiersData = json_encode(array_map('intval', array_column($topMetiers, 'total')));
$filieresLabels = json_encode(array_map(function($f) { return truncate($f['label'], 25); }, $topFilieres));
$filieresData = json_encode(array_map('intval', array_column($topFilieres, 'total')));

// Series BAC data
$seriesLabels = json_encode(array_column($serieBacRepartition, 'label'));
$seriesData = json_encode(array_map('intval', array_column($serieBacRepartition, 'total')));

// Evolution data processing (merging dates)
$dateMap = [];
for ($i = 29; $i >= 0; $i--) {
    $dateMap[date('Y-m-d', strtotime("-$i days"))] = ['o' => 0, 'p' => 0];
}
foreach ($evolutionOrientations as $eo) { if(isset($dateMap[$eo['date']])) $dateMap[$eo['date']]['o'] = $eo['total']; }
foreach ($evolutionPreinscriptions as $ep) { if(isset($dateMap[$ep['date']])) $dateMap[$ep['date']]['p'] = $ep['total']; }

$evoLabels = json_encode(array_map('date_fr', array_keys($dateMap)));
$evoDataO  = json_encode(array_column($dateMap, 'o'));
$evoDataP  = json_encode(array_column($dateMap, 'p'));

$inlineJS = "
    // Load charts
    var chartsScript = document.createElement('script');
    chartsScript.src = '" . APP_URL . "/admin/assets/js/charts.js';
    chartsScript.onload = function() {
        if(typeof initMetiersChart === 'function') initMetiersChart('metiersChart', $metiersLabels, $metiersData);
        if(typeof initFilieresChart === 'function') initFilieresChart('filieresChart', $filieresLabels, $filieresData);
        if(typeof initSeriesChart === 'function') initSeriesChart('serieBacChart', $seriesLabels, $seriesData);
        if(typeof initEvolutionChart === 'function') initEvolutionChart('evolutionChart', $evoLabels, $evoDataO, $evoDataP);
    };
    document.body.appendChild(chartsScript);
";

require_once __DIR__ . '/includes/footer-admin.php';
?>
