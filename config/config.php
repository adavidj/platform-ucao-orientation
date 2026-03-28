<?php
// =================================================================
// CONFIGURATION PRINCIPALE DE L'APPLICATION
// =================================================================

// Empêcher l'accès direct
if (!defined('APP_LOADED')) {
    define('APP_LOADED', true);
}

// Charger les variables d'environnement depuis .env
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] === '#') continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // Retirer les guillemets
        $value = trim($value, '"\'');
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Charger .env
$envPath = dirname(__DIR__) . '/.env';
loadEnv($envPath);

// Fonction helper pour lire les variables d'environnement
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) {
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
    return $value;
}

// =================================================================
// CONSTANTES APPLICATION
// =================================================================
define('APP_ROOT', dirname(__DIR__));
define('APP_URL', env('APP_URL', 'http://localhost/ucao-orientation'));
define('APP_ENV', env('APP_ENV', 'dev'));
define('APP_DEBUG', env('APP_DEBUG', 'true') === 'true');
define('APP_TIMEZONE', env('APP_TIMEZONE', 'Africa/Porto-Novo'));
define('UPLOADS_DIR', APP_ROOT . '/uploads');
define('RAPPORTS_DIR', UPLOADS_DIR . '/rapports');
define('DOSSIERS_DIR', UPLOADS_DIR . '/dossiers');

// Timezone
date_default_timezone_set(APP_TIMEZONE);

// Affichage des erreurs selon l'environnement
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// =================================================================
// CONFIGURATION SESSION
// =================================================================
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    session_set_cookie_params([
        'lifetime' => 7200, // 2 heures
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// =================================================================
// AUTOLOAD COMPOSER (si disponible)
// =================================================================
$composerAutoload = APP_ROOT . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// =================================================================
// CHARGER LES CLASSES
// =================================================================
require_once APP_ROOT . '/classes/Database.php';
require_once APP_ROOT . '/classes/Auth.php';
require_once APP_ROOT . '/classes/Orientation.php';
require_once APP_ROOT . '/classes/Preinscription.php';
require_once APP_ROOT . '/classes/Notification.php';
require_once APP_ROOT . '/classes/Mailer.php';
require_once APP_ROOT . '/classes/Rapport.php';

// =================================================================
// FONCTIONS HELPERS
// =================================================================

/**
 * Redirection sécurisée
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Échapper les données pour l'affichage HTML
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Générer un token CSRF
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Champ hidden CSRF pour les formulaires
 */
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Vérifier le token CSRF
 */
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Message flash (session)
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Générer un slug à partir d'une chaîne
 */
function slugify($string) {
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    $slug = preg_replace('/[^a-zA-Z0-9\s-]/', '', $slug);
    $slug = strtolower(trim($slug));
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return $slug;
}

/**
 * Formater une date en français
 */
function date_fr($date, $format = 'd/m/Y à H:i') {
    if (empty($date)) return '—';
    return date($format, strtotime($date));
}

/**
 * Tronquer un texte
 */
function truncate($text, $length = 100) {
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '…';
}
