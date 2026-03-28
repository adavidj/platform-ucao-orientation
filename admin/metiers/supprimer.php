<?php
// Supprimer un métier (cascade les associations)
require_once dirname(__DIR__) . '/includes/auth-check.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
if (!verify_csrf($_POST['csrf_token'] ?? '')) { set_flash('error', 'Session expirée.'); redirect('index.php'); }
$id = intval($_POST['id'] ?? 0);
if (!$id) { set_flash('error', 'Métier introuvable.'); redirect('index.php'); }
$pdo = Database::getInstance();
$pdo->prepare("DELETE FROM metiers WHERE id = ?")->execute([$id]);
set_flash('success', 'Métier supprimé avec succès.');
redirect('index.php');
