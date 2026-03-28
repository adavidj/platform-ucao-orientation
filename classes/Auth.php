<?php
// =================================================================
// CLASSE Auth — Authentification Admin
// =================================================================

class Auth {

    /**
     * Tenter une connexion admin
     */
    public static function login($email, $password) {
        // Vérifier le verrouillage brute-force
        if (self::isLockedOut()) {
            return ['success' => false, 'message' => 'Trop de tentatives. Réessayez dans 10 minutes.'];
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? AND actif = 1 LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            self::recordFailedAttempt();
            return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
        }

        // Connexion réussie
        self::clearLoginAttempts();
        
        // Mettre à jour last_login
        $stmt = $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$admin['id']]);

        // Stocker en session
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_role'] = $admin['role'];
        $_SESSION['admin_login_time'] = time();

        // Régénérer l'ID de session pour éviter le fixation
        session_regenerate_id(true);

        return ['success' => true, 'message' => 'Connexion réussie.'];
    }

    /**
     * Déconnecter l'admin
     */
    public static function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Vérifier si un admin est connecté
     */
    public static function isLoggedIn() {
        if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_login_time'])) {
            return false;
        }
        // Vérifier l'expiration (2 heures)
        if (time() - $_SESSION['admin_login_time'] > 7200) {
            self::logout();
            return false;
        }
        return true;
    }

    /**
     * Vérifier si l'admin est Super Admin
     */
    public static function isSuperAdmin() {
        return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'super_admin';
    }

    /**
     * Obtenir les infos de l'admin courant
     */
    public static function getCurrentAdmin() {
        if (!self::isLoggedIn()) return null;
        return [
            'id' => $_SESSION['admin_id'],
            'nom' => $_SESSION['admin_nom'],
            'email' => $_SESSION['admin_email'],
            'role' => $_SESSION['admin_role'],
        ];
    }

    /**
     * Exiger la connexion (redirect si non connecté)
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            set_flash('error', 'Veuillez vous connecter pour accéder à cette page.');
            redirect('login.php');
        }
    }

    /**
     * Exiger le rôle Super Admin
     */
    public static function requireSuperAdmin() {
        self::requireLogin();
        if (!self::isSuperAdmin()) {
            set_flash('error', 'Accès réservé aux super administrateurs.');
            redirect('index.php');
        }
    }

    // =================================================================
    // PROTECTION BRUTE-FORCE
    // =================================================================

    private static function recordFailedAttempt() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        $_SESSION['login_attempts'][] = time();
        // Garder uniquement les tentatives des 10 dernières minutes
        $_SESSION['login_attempts'] = array_filter(
            $_SESSION['login_attempts'],
            function($timestamp) {
                return (time() - $timestamp) < LOGIN_LOCKOUT_TIME;
            }
        );
    }

    private static function isLockedOut() {
        if (!isset($_SESSION['login_attempts'])) return false;
        // Nettoyer les anciennes tentatives
        $_SESSION['login_attempts'] = array_filter(
            $_SESSION['login_attempts'],
            function($timestamp) {
                return (time() - $timestamp) < LOGIN_LOCKOUT_TIME;
            }
        );
        return count($_SESSION['login_attempts']) >= MAX_LOGIN_ATTEMPTS;
    }

    private static function clearLoginAttempts() {
        unset($_SESSION['login_attempts']);
    }

    // =================================================================
    // GESTION DES ADMINS (CRUD)
    // =================================================================

    /**
     * Lister tous les admins
     */
    public static function getAllAdmins() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, nom, email, role, actif, created_at, last_login FROM admins ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Obtenir un admin par ID
     */
    public static function getAdminById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT id, nom, email, role, actif, created_at, last_login FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Créer un admin
     */
    public static function createAdmin($nom, $email, $password, $role = 'admin') {
        $pdo = Database::getInstance();
        
        // Vérifier l'unicité de l'email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Cet email est déjà utilisé.'];
        }

        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $stmt = $pdo->prepare("INSERT INTO admins (nom, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $hash, $role]);

        return ['success' => true, 'message' => 'Admin créé avec succès.', 'id' => $pdo->lastInsertId()];
    }

    /**
     * Modifier un admin
     */
    public static function updateAdmin($id, $nom, $email, $role, $actif, $newPassword = null) {
        $pdo = Database::getInstance();

        // Vérifier l'unicité de l'email (hors admin courant)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Cet email est déjà utilisé par un autre compte.'];
        }

        if ($newPassword) {
            $hash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
            $stmt = $pdo->prepare("UPDATE admins SET nom = ?, email = ?, password_hash = ?, role = ?, actif = ? WHERE id = ?");
            $stmt->execute([$nom, $email, $hash, $role, $actif, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE admins SET nom = ?, email = ?, role = ?, actif = ? WHERE id = ?");
            $stmt->execute([$nom, $email, $role, $actif, $id]);
        }

        return ['success' => true, 'message' => 'Admin modifié avec succès.'];
    }
}
