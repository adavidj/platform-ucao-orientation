<?php
// Export PDF liste des préinscriptions
require_once dirname(__DIR__) . '/includes/auth-check.php';
$filters = ['filiere'=>$_GET['filiere']??'','date_debut'=>$_GET['date_debut']??'','date_fin'=>$_GET['date_fin']??'','serie_bac'=>$_GET['serie_bac']??'','search'=>$_GET['search']??''];
$result = Preinscription::getAll($filters, 1, 999999);

$pdf = Rapport::generateListePDF($result['data'], 'Liste des préinscriptions — UCAO');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="preinscriptions_' . date('Y-m-d') . '.pdf"');
echo $pdf;
exit;
