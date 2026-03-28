<?php
// =================================================================
// CLASSE Database — Singleton PDO
// =================================================================

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        require_once dirname(__DIR__) . '/config/database.php';
        $this->pdo = getDBConnection();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    // Empêcher le clonage et la désérialisation
    private function __clone() {}
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}
