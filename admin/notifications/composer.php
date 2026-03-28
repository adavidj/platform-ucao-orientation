<?php
// =================================================================
// COMPOSER UNE NOTIFICATION
// =================================================================
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Composer une notification';

$pdo = Database::getInstance();
$filieres = $pdo->query("SELECT id, nom_filiere, ecole_faculte FROM filieres WHERE actif = 1 ORDER BY ecole_faculte, nom_filiere")->fetchAll();

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Session expirée.');
        redirect('composer.php');
    }

    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $typeCible = $_POST['type_cible'] ?? '';
    $filtreSerie = $_POST['filtre_serie'] ?? null;
    $filtreFiliere = $_POST['filtre_filiere'] ?? null;

    if (empty($sujet) || empty($message) || empty($typeCible)) {
        set_flash('error', 'Veuillez remplir tous les champs obligatoires.');
        redirect('composer.php');
    }

    $result = Notification::send($sujet, $message, $typeCible, $filtreSerie ?: null, $filtreFiliere ?: null, $currentAdmin['id']);
    set_flash($result['success'] ? 'success' : 'error', $result['message']);
    redirect('index.php');
}

require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<div style="margin-bottom:16px"><a href="index.php" class="btn-admin btn-admin-outline btn-admin-sm">← Retour à l'historique</a></div>

<div class="admin-card">
    <div class="admin-card-header"><h2 class="admin-card-title">Composer et envoyer une notification</h2></div>
    <div class="admin-card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Cible <span class="required">*</span></label>
                    <select name="type_cible" class="form-control" required id="typeCible">
                        <option value="">— Sélectionner —</option>
                        <option value="orientations">Tous les orientés</option>
                        <option value="preinscriptions">Tous les préinscrits</option>
                        <option value="tous">Tous (orientés + préinscrits)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Filtrer par série Bac</label>
                    <select name="filtre_serie" class="form-control">
                        <option value="">Toutes les séries</option>
                        <?php foreach (SERIES_BAC as $key => $label): ?>
                        <option value="<?= $key ?>"><?= e($key . ' — ' . $label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Filtrer par filière</label>
                <select name="filtre_filiere" class="form-control">
                    <option value="">Toutes les filières</option>
                    <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= e($f['ecole_faculte'] . ' — ' . $f['nom_filiere']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Sujet <span class="required">*</span></label>
                <input type="text" name="sujet" class="form-control" placeholder="Objet de la notification..." required>
            </div>
            <div class="form-group">
                <label class="form-label">Message <span class="required">*</span></label>
                <textarea name="message" class="form-control" rows="10" placeholder="Rédigez votre message ici..." required></textarea>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end">
                <a href="index.php" class="btn-admin btn-admin-outline">Annuler</a>
                <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg" onclick="return confirm('Confirmez-vous l\'envoi de cette notification ?')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Envoyer la notification
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer-admin.php'; ?>
