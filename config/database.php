<?php
// =================================================================
// CONNEXION À LA BASE DE DONNÉES (PDO)
// =================================================================

// Ce fichier est inclus via config.php qui charge déjà le .env
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        $host = env('DB_HOST', 'localhost');
        $port = env('DB_PORT', '3306');
        $dbname = env('DB_NAME', 'ucao_orientation');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $charset = env('DB_CHARSET', 'utf8mb4');

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}"
            ]);
        } catch (PDOException $e) {
            if (APP_DEBUG) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            } else {
                die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
            }
        }
    }

    return $pdo;
}
