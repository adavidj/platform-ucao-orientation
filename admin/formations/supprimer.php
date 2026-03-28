<?php
// Supprimer une filière
require_once dirname(__DIR__) . '/includes/auth-check.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('index.php'); }
$id = intval($_POST['id'] ?? 0);
if (!$id) { set_flash('error', 'Filière introuvable.'); redirect('index.php'); }
$pdo = Database::getInstance();
try {
    $pdo->prepare("DELETE FROM filieres WHERE id = ?")->execute([$id]);
    set_flash('success', 'Filière supprimée.');
} catch (PDOException $e) {
    set_flash('error', 'Impossible de supprimer cette filière (elle est peut-être utilisée par des préinscriptions).');
}
redirect('index.php');
