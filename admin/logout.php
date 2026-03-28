<?php
// =================================================================
// DÉCONNEXION ADMIN
// =================================================================
require_once dirname(__DIR__) . '/config/config.php';

Auth::logout();
redirect('login.php');
