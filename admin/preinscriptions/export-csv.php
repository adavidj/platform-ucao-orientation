<?php
// Export CSV des préinscriptions
require_once dirname(__DIR__) . '/includes/auth-check.php';
$filters = ['filiere'=>$_GET['filiere']??'','date_debut'=>$_GET['date_debut']??'','date_fin'=>$_GET['date_fin']??'','serie_bac'=>$_GET['serie_bac']??'','search'=>$_GET['search']??''];
Preinscription::exportCSV($filters);
