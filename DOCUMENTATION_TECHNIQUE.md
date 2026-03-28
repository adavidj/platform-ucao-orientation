# 📘 Documentation Technique Complète — Administration UCAO-Orientation

> **Auteur** : Génération automatique  
> **Date** : 27 mars 2026  
> **Version** : 1.0  
> **Stack** : PHP 8.x · MySQL 8.x · Chart.js · PHPMailer · DOMPDF

---

## Table des matières

1. [Vue d'ensemble du projet](#1-vue-densemble-du-projet)
2. [Architecture des fichiers](#2-architecture-des-fichiers)
3. [Couche 1 — Base de données](#3-couche-1--base-de-données)
4. [Couche 2 — Configuration](#4-couche-2--configuration)
5. [Couche 3 — Classes PHP (Logique métier)](#5-couche-3--classes-php-logique-métier)
6. [Couche 4 — Authentification & Layout Admin](#6-couche-4--authentification--layout-admin)
7. [Couche 5 — CSS & JavaScript Admin](#7-couche-5--css--javascript-admin)
8. [Couche 6 — Modules Admin (Pages)](#8-couche-6--modules-admin-pages)
9. [Sécurité](#9-sécurité)
10. [Déploiement](#10-déploiement)

---

## 1. Vue d'ensemble du projet

### Qu'est-ce qu'on a construit ?

Un **panneau d'administration complet** (back-office) pour la plateforme UCAO-Orientation. Ce panneau permet aux administrateurs de l'université de :

- **Voir les statistiques** en temps réel (dashboard avec graphiques)
- **Gérer les orientations** effectuées par les visiteurs
- **Gérer les préinscriptions** reçues
- **Envoyer des notifications** par email (groupées ou ciblées)
- **Administrer les filières** de l'université (CRUD complet)
- **Administrer les métiers** et leurs correspondances avec les filières
- **Configurer les paramètres** du site (période nouveaux bacheliers, mode maintenance)
- **Gérer les comptes administrateurs** (ajout, modification, désactivation)

### Comment c'est organisé ?

Le projet suit une architecture **MVC simplifiée** (sans framework) :

```
Modèle (M)    → classes/       → Logique métier + accès BDD
Vue (V)       → admin/*.php    → Pages HTML/PHP affichées à l'utilisateur
Contrôleur (C)→ Intégré dans chaque page PHP (traitement POST en haut du fichier)
```

Ce choix permet de rester simple et compréhensible sans dépendre d'un framework lourd comme Laravel ou Symfony.

---

## 2. Architecture des fichiers

```
ucao-orientation/
│
├── .env                          ← Variables secrètes (BDD, SMTP) — JAMAIS sur Git
├── .env.example                  ← Modèle .env pour la production
├── .gitignore                    ← Fichiers exclus de Git
├── composer.json                 ← Dépendances PHP (PHPMailer, DOMPDF)
├── composer                      ← Exécutable Composer local
│
├── config/                       ← ⚙️ CONFIGURATION
│   ├── config.php                ← Point d'entrée central, charge tout
│   ├── database.php              ← Connexion PDO à MySQL
│   ├── constantes.php            ← Constantes métier (séries bac, niveaux...)
│   └── email.php                 ← Configuration SMTP
│
├── classes/                      ← 🧠 LOGIQUE MÉTIER
│   ├── Database.php              ← Singleton de connexion PDO
│   ├── Auth.php                  ← Authentification + gestion sessions
│   ├── Orientation.php           ← CRUD + stats orientations
│   ├── Preinscription.php        ← CRUD + stats préinscriptions
│   ├── Notification.php          ← Envoi groupé + historique
│   ├── Mailer.php                ← Wrapper PHPMailer
│   └── Rapport.php               ← Génération PDF (DOMPDF)
│
├── sql/                          ← 🗃️ BASE DE DONNÉES
│   ├── ucao_orientation.sql      ← Création des tables
│   └── data_seed.sql             ← Données initiales
│
├── admin/                        ← 🖥️ PANNEAU D'ADMINISTRATION
│   ├── login.php                 ← Page de connexion
│   ├── logout.php                ← Déconnexion
│   ├── index.php                 ← Dashboard principal
│   │
│   ├── includes/                 ← Composants réutilisables
│   │   ├── auth-check.php        ← Garde d'authentification
│   │   ├── header-admin.php      ← <head> HTML + CSS/JS
│   │   ├── sidebar.php           ← Sidebar + topbar + flash
│   │   └── footer-admin.php      ← Scripts + fermeture </html>
│   │
│   ├── assets/
│   │   ├── css/admin.css         ← Tout le design admin
│   │   └── js/
│   │       ├── admin.js          ← Interactivité globale
│   │       └── charts.js         ← Graphiques Chart.js
│   │
│   ├── orientations/             ← Module orientations
│   │   ├── index.php             ← Liste avec filtres
│   │   ├── voir.php              ← Fiche détaillée
│   │   ├── repondre.php          ← Envoi réponse email
│   │   └── export.php            ← Export CSV
│   │
│   ├── preinscriptions/          ← Module préinscriptions
│   │   ├── index.php             ← Liste avec filtres
│   │   ├── voir.php              ← Dossier complet
│   │   ├── notifier.php          ← Notification individuelle
│   │   ├── export-pdf.php        ← Export PDF liste
│   │   └── export-csv.php        ← Export CSV
│   │
│   ├── notifications/            ← Module notifications
│   │   ├── index.php             ← Historique
│   │   └── composer.php          ← Composer + envoyer
│   │
│   ├── formations/               ← Module filières (CRUD)
│   │   ├── index.php
│   │   ├── ajouter.php
│   │   ├── modifier.php
│   │   └── supprimer.php
│   │
│   ├── metiers/                  ← Module métiers (CRUD)
│   │   ├── index.php
│   │   ├── ajouter.php
│   │   ├── modifier.php
│   │   └── supprimer.php
│   │
│   ├── parametres/               ← Module paramètres
│   │   └── index.php
│   │
│   └── admins/                   ← Module gestion admins
│       ├── index.php
│       ├── ajouter.php
│       └── modifier.php
│
├── uploads/                      ← 📁 Fichiers générés/uploadés
│   ├── rapports/                 ← PDF d'orientation
│   ├── dossiers/                 ← Documents préinscrits
│   └── email_logs/               ← Emails simulés en dev
│
└── vendor/                       ← Librairies Composer (auto-généré)
```

---

## 3. Couche 1 — Base de données

### 📄 `sql/ucao_orientation.sql` — Schéma de base de données

Ce fichier crée **8 tables** qui représentent toutes les entités du système.

#### Table `admins`
```sql
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,      -- Mot de passe hashé en bcrypt
  `role` ENUM('super_admin','admin') NOT NULL DEFAULT 'admin',
  `actif` TINYINT(1) NOT NULL DEFAULT 1,      -- 1 = actif, 0 = désactivé
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` DATETIME NULL DEFAULT NULL,     -- Mis à jour à chaque connexion
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_admins_email` (`email`)       -- Un seul compte par email
) ENGINE=InnoDB;
```

**Pourquoi ?**
- `password_hash` : On ne stocke JAMAIS le mot de passe en clair. On stocke un hash bcrypt.
- `ENUM('super_admin','admin')` : Deux niveaux d'accès. Seuls les super_admin peuvent gérer les comptes.
- `actif` : Plutôt que de supprimer un admin, on le désactive. Cela préserve l'historique.
- `UNIQUE KEY` sur email : Empêche les doublons au niveau base de données.

#### Table `filieres`
```sql
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ecole_faculte` VARCHAR(100) NOT NULL,       -- EGEI, ESMEA, FSAE, FDE
  `nom_filiere` VARCHAR(200) NOT NULL,
  `niveau` VARCHAR(50) NOT NULL DEFAULT 'Licence',
  `duree` VARCHAR(20) NOT NULL DEFAULT '3 ans',
  `description` TEXT NULL,
  `debouches` TEXT NULL,                        -- Métiers possibles après cette filière
  `slug` VARCHAR(200) NOT NULL,                 -- Version URL du nom (ex: "genie-telecoms-tic")
  `actif` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_filieres_slug` (`slug`),
  KEY `idx_filieres_ecole` (`ecole_faculte`)   -- Index pour filtrer par école rapidement
) ENGINE=InnoDB;
```

**Pourquoi un `slug` ?**
Le slug est une version simplifiée du nom, utilisable dans les URLs. Par exemple :
- "Génie Télécoms et TIC" → `genie-telecoms-tic`
- Cela permet des URLs propres comme `/filieres/genie-telecoms-tic`

#### Table `metiers_filieres` — Table de liaison N:N
```sql
CREATE TABLE IF NOT EXISTS `metiers_filieres` (
  `metier_id` INT(11) NOT NULL,
  `filiere_id` INT(11) NOT NULL,
  `priorite` INT(11) NOT NULL DEFAULT 1,       -- 1 = recommandation #1, 2 = alternative...
  UNIQUE KEY `uk_metier_filiere` (`metier_id`, `filiere_id`),
  CONSTRAINT `fk_mf_metier` FOREIGN KEY (`metier_id`) REFERENCES `metiers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mf_filiere` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;
```

**Explication de la relation N:N :**
Un métier peut mener à plusieurs filières, et une filière peut correspondre à plusieurs métiers. La table `metiers_filieres` fait le lien :
- "Développeur web" (métier) → "Informatique Master" (priorité 1), "Génie Télécoms" (priorité 2)
- `ON DELETE CASCADE` : Si on supprime un métier, ses associations sont automatiquement supprimées.

#### Table `orientations`
Stocke chaque orientation effectuée par un visiteur via le formulaire du site public.

#### Table `preinscriptions`  
Stocke les préinscriptions avec une **clé étrangère** vers `filieres` :
```sql
CONSTRAINT `fk_preinsc_filiere` FOREIGN KEY (`filiere_choisie`) 
  REFERENCES `filieres` (`id`) ON DELETE RESTRICT
```
`ON DELETE RESTRICT` = on ne peut PAS supprimer une filière si des préinscrits l'ont choisie.

#### Table `notifications`
Historique des emails groupés envoyés. Le champ `destinataires` est en **JSON** (liste des emails ciblés).

#### Table `parametres`
Table clé/valeur flexible pour la configuration dynamique :
```sql
CREATE TABLE IF NOT EXISTS `parametres` (
  `cle` VARCHAR(100) NOT NULL,    -- Ex: "periode_nouveaux_bacheliers"
  `valeur` TEXT NULL,              -- Ex: "1" ou "0"
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`cle`)              -- La clé EST la clé primaire
) ENGINE=InnoDB;
```

### 📄 `sql/data_seed.sql` — Données initiales

Ce fichier insère :
1. **1 super admin** avec mot de passe hashé bcrypt (`ucao2026`)
2. **4 paramètres** par défaut
3. **28 filières** réparties dans les 4 écoles/facultés (EGEI, ESMEA, FSAE, FDE)
4. **44 métiers** couvrant tech, finance, droit, agronomie, etc.
5. **90+ associations** métier↔filière avec niveaux de priorité

---

## 4. Couche 2 — Configuration

### 📄 `config/config.php` — Le cœur du système

C'est le **premier fichier chargé** par toutes les pages. Il fait tout ça dans l'ordre :

#### 1. Chargement du `.env`
```php
function loadEnv($path) {
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (empty($line) || $line[0] === '#') continue;  // Ignorer commentaires
        list($key, $value) = explode('=', $line, 2);      // Séparer CLÉ=VALEUR
        $_ENV[$key] = trim($value, '"\'');                 // Stocker sans guillemets
        putenv("$key=$value");                             // Aussi dans l'env système
    }
}
```

**Pourquoi un `.env` ?**  
Les mots de passe de base de données, clés API, etc. ne doivent **JAMAIS** être dans le code source (et donc jamais sur Git). Le `.env` est un fichier local, listé dans `.gitignore`, qui contient ces secrets. Chaque environnement (dev, prod) a son propre `.env`.

#### 2. Définition des constantes
```php
define('APP_ROOT', dirname(__DIR__));           // Chemin absolu du projet
define('APP_URL', env('APP_URL', '...'));       // URL publique du site
define('UPLOADS_DIR', APP_ROOT . '/uploads');   // Dossier d'uploads
```

#### 3. Configuration des sessions PHP
```php
ini_set('session.cookie_httponly', 1);    // Cookie non accessible en JavaScript (anti-XSS)
ini_set('session.use_strict_mode', 1);   // Refuse les IDs de session inventés
session_set_cookie_params([
    'lifetime' => 7200,                   // Expire après 2 heures
    'httponly' => true,                    // Inaccessible par JS
    'samesite' => 'Lax'                   // Protection CSRF partielle
]);
session_start();
```

#### 4. Autoload Composer
```php
$composerAutoload = APP_ROOT . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;  // Charge PHPMailer, DOMPDF automatiquement
}
```
Composer génère un fichier `vendor/autoload.php` qui charge automatiquement toutes les classes des librairies installées. On n'a plus besoin de `require` chacune manuellement.

#### 5. Fonctions helpers (utilitaires)

```php
// Échapper les données pour l'affichage HTML (anti-XSS)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
```
**Pourquoi `e()` ?**  
Si un utilisateur entre `<script>alert('hack')</script>` dans un formulaire et qu'on affiche ça sans échapper, le script s'exécute (attaque XSS). `htmlspecialchars()` convertit les `<` et `>` en `&lt;` et `&gt;` pour qu'ils s'affichent comme du texte et non du HTML.

```php
// Protection CSRF
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // 64 caractères aléatoires
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
```
**Qu'est-ce que le CSRF ?**  
Imaginez qu'un site malveillant contienne un formulaire caché qui envoie `POST /admin/admins/supprimer.php?id=1`. Si l'admin est connecté et visite ce site, l'action se fait sans son consentement. Le token CSRF est un secret unique par session : si le formulaire ne contient pas le bon token, la requête est rejetée.

`hash_equals()` compare les chaînes de manière constante (même durée quelle que soit la différence), ce qui empêche les attaques par timing.

```php
// Messages flash (messages qui s'affichent une seule fois)
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);  // Supprimé après lecture
        return $flash;
    }
    return null;
}
```
**Cas d'usage :** Après la suppression d'une filière, on fait `set_flash('success', 'Filière supprimée.')` puis `redirect('index.php')`. Sur la page suivante, le message vert s'affiche puis disparaît.

### 📄 `config/database.php` — Connexion PDO

```php
function getDBConnection() {
    static $pdo = null;  // Variable statique = gardée en mémoire entre les appels
    
    if ($pdo === null) {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Lancer des exceptions sur erreur
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Résultats en tableau associatif
            PDO::ATTR_EMULATE_PREPARES => false,                // Vraies requêtes préparées
        ]);
    }
    return $pdo;
}
```

**Pourquoi PDO et pas `mysqli` ?**
- PDO fonctionne avec MySQL, PostgreSQL, SQLite... (portable)
- Les requêtes préparées sont plus naturelles
- `ERRMODE_EXCEPTION` permet de catcher les erreurs proprement avec try/catch
- `EMULATE_PREPARES = false` force MySQL à faire les requêtes préparées côté serveur (meilleure sécurité)

### 📄 `config/constantes.php` — Constantes métier

```php
define('SERIES_BAC', [
    'A' => 'Série A (Lettres)',
    'B' => 'Série B (Économie)',
    // ...
]);

define('MAX_LOGIN_ATTEMPTS', 5);           // Anti brute-force
define('LOGIN_LOCKOUT_TIME', 600);         // 10 minutes de blocage
```

Ces constantes sont utilisées dans les formulaires (menus déroulants) et la validation.

### 📄 `config/email.php` — Configuration SMTP

```php
function getMailerConfig() {
    return [
        // ...
        'simulate' => APP_ENV === 'dev' && empty(env('SMTP_USER', '')),
    ];
}
```
**Le mode simulation :** En développement, si aucun serveur SMTP n'est configuré, les emails ne sont pas envoyés mais **sauvegardés dans des fichiers HTML** dans `uploads/email_logs/`. Cela permet de développer et tester les notifications sans avoir besoin d'un vrai serveur mail.

---

## 5. Couche 3 — Classes PHP (Logique métier)

### 📄 `classes/Database.php` — Pattern Singleton

```php
class Database {
    private static $instance = null;  // Une seule instance

    private function __construct() { /* ... */ }  // Constructeur privé

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();  // Créée une seule fois
        }
        return self::$instance->pdo;       // Toujours la même connexion
    }

    private function __clone() {}  // Empêche le clonage
}
```

**Qu'est-ce que le Singleton ?**  
C'est un pattern qui garantit qu'une seule instance de la classe existe. Pourquoi ?  
- On n'ouvre qu'**une seule connexion** MySQL par requête HTTP (au lieu de 10-20)
- Les performances sont bien meilleures
- On appelle `Database::getInstance()` partout et c'est toujours la même connexion

**Usage dans le code :**
```php
$pdo = Database::getInstance();  // Partout dans les classes
$stmt = $pdo->prepare("SELECT * FROM orientations WHERE id = ?");
$stmt->execute([$id]);
```

### 📄 `classes/Auth.php` — Authentification complète

#### Connexion (login)
```php
public static function login($email, $password) {
    // 1. Vérifier le blocage brute-force
    if (self::isLockedOut()) {
        return ['success' => false, 'message' => 'Trop de tentatives...'];
    }

    // 2. Chercher l'admin par email
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? AND actif = 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // 3. Vérifier le mot de passe avec bcrypt
    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        self::recordFailedAttempt();  // Enregistrer la tentative ratée
        return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
    }

    // 4. Mettre à jour le dernier login
    $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?")->execute([$admin['id']]);

    // 5. Stocker en session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_login_time'] = time();  // Pour vérifier l'expiration

    // 6. Régénérer l'ID de session (anti-fixation)
    session_regenerate_id(true);

    return ['success' => true];
}
```

**Détails importants :**
- `password_verify()` : Fonction PHP qui compare un mot de passe en clair avec un hash bcrypt. Elle gère automatiquement le sel et le coût.
- `session_regenerate_id(true)` : Après un login réussi, on change l'ID de session. Cela empêche l'attaque par **fixation de session** (où un attaquant force un ID de session connu).
- **Brute-force** : On compte les tentatives ratées dans la session. Après 5 échecs en 10 minutes, le formulaire est bloqué.

#### Vérification de session
```php
public static function isLoggedIn() {
    if (!isset($_SESSION['admin_id'])) return false;
    
    // Vérifier l'expiration (2 heures)
    if (time() - $_SESSION['admin_login_time'] > 7200) {
        self::logout();
        return false;
    }
    return true;
}
```
À chaque page, on vérifie que :
1. L'admin a bien une session valide
2. La session n'a pas expiré (2 heures max)

### 📄 `classes/Orientation.php` — Requêtes avec filtres dynamiques

Le pattern de filtres dynamiques est utilisé dans toutes les classes de listing :

```php
public static function getAll($filters = [], $page = 1, $perPage = 15) {
    $where = [];    // Conditions WHERE
    $params = [];   // Paramètres pour les requêtes préparées

    // Chaque filtre ajoute une condition SI il est rempli
    if (!empty($filters['date_debut'])) {
        $where[] = "o.created_at >= ?";
        $params[] = $filters['date_debut'] . ' 00:00:00';
    }
    if (!empty($filters['serie_bac'])) {
        $where[] = "o.serie_bac = ?";
        $params[] = $filters['serie_bac'];
    }
    if (!empty($filters['search'])) {
        $where[] = "(o.nom LIKE ? OR o.prenom LIKE ? OR o.email LIKE ?)";
        $search = '%' . $filters['search'] . '%';
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
    }

    // Construction dynamique du WHERE
    $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // 1. Compter le total (pour la pagination)
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM orientations o $whereClause");
    $countStmt->execute($params);
    $total = $countStmt->fetchColumn();

    // 2. Récupérer la page courante
    $offset = ($page - 1) * $perPage;  // Page 1 → offset 0, Page 2 → offset 15...
    $stmt = $pdo->prepare("SELECT * FROM orientations o $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    $stmt->execute($params);

    return [
        'data' => $stmt->fetchAll(),
        'total' => $total,
        'totalPages' => ceil($total / $perPage),  // 47 résultats / 15 par page = 4 pages
    ];
}
```

**Comment ça marche la construction dynamique :**
- Sans filtres : `SELECT * FROM orientations ORDER BY ...`
- Avec filtre série : `SELECT * FROM orientations WHERE serie_bac = ? ORDER BY ...`
- Avec filtre série + recherche : `SELECT * FROM orientations WHERE serie_bac = ? AND (nom LIKE ? OR ...) ORDER BY ...`

Les `?` sont des **marqueurs de position** des requêtes préparées. Les vrais valeurs sont passées via `$params`. Cela empêche totalement l'injection SQL.

#### Export CSV
```php
public static function exportCSV($filters = []) {
    $result = self::getAll($filters, 1, 999999);  // Tout récupérer

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="orientations_2026-03-27.csv"');
    
    $output = fopen('php://output', 'w');  // Écrire directement dans la réponse HTTP
    
    // BOM UTF-8 pour Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // En-têtes de colonnes
    fputcsv($output, ['ID', 'Nom', 'Prénom', 'Email', ...], ';');
    
    // Données
    foreach ($data as $row) {
        fputcsv($output, [...], ';');
    }
}
```

**Le BOM UTF-8 :** `chr(0xEF).chr(0xBB).chr(0xBF)` est un marqueur invisible ajouté au début du fichier. Il indique à Excel que le fichier est en UTF-8, sinon les caractères accentués (é, è, ç) apparaissent mal.

### 📄 `classes/Mailer.php` — Envoi d'emails

```php
use PHPMailer\PHPMailer\PHPMailer;

class Mailer {
    private $simulate;  // Mode dev = log au lieu d'envoyer

    public function send($to, $subject, $htmlBody) {
        if ($this->simulate) {
            return $this->logEmail($to, $subject, $htmlBody);  // Sauvegarde en fichier
        }

        $mail = new PHPMailer(true);  // true = exceptions activées
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '...';
        $mail->Password = '...';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('noreply@ucao.bj', 'UCAO Orientation');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;         // Version HTML
        $mail->AltBody = strip_tags($htmlBody);  // Version texte (fallback)
        $mail->send();
    }

    public function sendBulk($recipients, $subject, $htmlBody) {
        foreach ($recipients as $email) {
            $this->send($email, $subject, $htmlBody);
            usleep(200000);  // 200ms de pause entre chaque envoi
        }
    }
}
```

**Pourquoi `usleep(200000)` ?**  
Les serveurs SMTP limitent le nombre d'emails par seconde/minute. Sans pause, on risque le blocage. 200ms entre chaque email = max 300 emails/minute, ce qui est raisonnable.

### 📄 `classes/Rapport.php` — Génération PDF

```php
use Dompdf\Dompdf;
use Dompdf\Options;

public static function generateOrientationPDF($orientationId) {
    // 1. Récupérer les données
    $orientation = Orientation::getById($orientationId);

    // 2. Générer le HTML du rapport (template avec CSS inline)
    $html = self::getOrientationTemplate($orientation);

    // 3. Configurer DOMPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Helvetica');

    // 4. Convertir HTML → PDF
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 5. Sauvegarder le fichier
    file_put_contents($filepath, $dompdf->output());

    // 6. Enregistrer le chemin en base
    $pdo->prepare("UPDATE orientations SET rapport_pdf_path = ? WHERE id = ?")
        ->execute([$filename, $orientationId]);
}
```

**DOMPDF** transforme du HTML/CSS en un vrai fichier PDF. On crée un template HTML avec le design UCAO (gradient violet/rouge, logo, mise en page professionnelle) et DOMPDF le convertit. C'est pour ça que le CSS est **inline** (dans l'attribut `style`) — DOMPDF ne supporte pas les fichiers CSS externes.

---

## 6. Couche 4 — Authentification & Layout Admin

### 📄 `admin/includes/auth-check.php` — Le gardien

```php
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once dirname(dirname(__DIR__)) . '/config/constantes.php';

Auth::requireLogin();  // Redirige vers login.php si non connecté

$currentAdmin = Auth::getCurrentAdmin();
```

**Chaque page admin** (sauf `login.php`) commence par inclure ce fichier. Si l'utilisateur n'est pas connecté, il est immédiatement redirigé vers la page de login. C'est le **pattern Guard** : une barrière à l'entrée.

`dirname(dirname(__DIR__))` remonte de 2 niveaux :
- `__DIR__` = `/admin/includes/`
- `dirname(__DIR__)` = `/admin/`
- `dirname(dirname(__DIR__))` = `/` (racine du projet)

### 📄 `admin/login.php` — Page de connexion

Structure du flux :
```php
// 1. Si déjà connecté → dashboard
if (Auth::isLoggedIn()) {
    redirect('index.php');
}

// 2. Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2a. Vérifier le token CSRF
    if (!verify_csrf($token)) { $error = 'Session expirée.'; }
    // 2b. Valider les champs
    elseif (empty($email) || empty($password)) { $error = 'Champs requis.'; }
    // 2c. Tenter la connexion
    else {
        $result = Auth::login($email, $password);
        if ($result['success']) redirect('index.php');
        else $error = $result['message'];
    }
}

// 3. Afficher le formulaire (avec l'erreur éventuelle)
```

**Ce pattern** (traitement POST en haut, affichage HTML en bas) est utilisé dans presque tous les fichiers. Le traitement se fait AVANT l'affichage, car si on redirige (`redirect()`), il ne faut pas avoir déjà envoyé du HTML.

### 📄 `admin/includes/sidebar.php` — Navigation

```php
$sidebarItems = [
    ['section' => 'dashboard', 'label' => 'Tableau de bord', 'url' => '...', 'icon' => '<svg>...</svg>'],
    ['section' => 'orientations', 'label' => 'Orientations', 'badge' => $totalOrientations],
    // ...
];

// Ajouter la gestion admin uniquement pour les super_admin
if (Auth::isSuperAdmin()) {
    $sidebarItems[] = ['section' => 'admins', 'label' => 'Administrateurs', ...];
}
```

**L'état actif** est déterminé dynamiquement :
```php
$currentSection = basename(dirname($_SERVER['PHP_SELF']));  // ex: "orientations"
```
Puis dans le HTML :
```php
<a class="sidebar-link<?= $currentSection === $item['section'] ? ' active' : '' ?>">
```

Les **icônes SVG inline** sont utilisées plutôt que FontAwesome pour éviter une dépendance externe (pas de requête CDN = chargement plus rapide).

---

## 7. Couche 5 — CSS & JavaScript Admin

### 📄 `admin/assets/css/admin.css` — Le design premium

#### Variables CSS (Design Tokens)
```css
:root {
    --admin-primary: #180391;       /* Violet UCAO */
    --admin-secondary: #8B0000;     /* Rouge UCAO */
    --admin-gold: #FFD700;          /* Or UCAO */
    --admin-bg: #F0F2F8;            /* Fond gris très clair */
    --admin-card-bg: #ffffff;       /* Fond des cards */
    --admin-sidebar-bg: linear-gradient(180deg, #0e0560 0%, #180391 50%, #1a0a4a 100%);
    --admin-radius: 16px;           /* Coins arrondis modernes */
    --admin-shadow: 0 4px 6px rgba(24, 3, 145, 0.04), 0 10px 20px rgba(24, 3, 145, 0.06);
    --admin-ease: cubic-bezier(0.16, 1, 0.3, 1);  /* Courbe d'animation fluide */
}
```

**Pourquoi des variables CSS ?**
Modifiez une seule variable, et toute l'interface change. Par exemple, changer `--admin-primary` de violet à bleu recolore automatiquement la sidebar, les boutons, les badges, les graphiques...

#### Layout Sidebar + Main Content
```css
.admin-sidebar {
    width: 260px;
    position: fixed;    /* Fixée à gauche, ne scrolle pas */
    top: 0;
    left: 0;
    height: 100vh;      /* Toute la hauteur de l'écran */
}

.admin-main {
    margin-left: 260px;  /* Décalé de la largeur de la sidebar */
    flex: 1;
}
```

#### Responsive (Mobile)
```css
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);  /* Cachée hors écran */
    }
    .admin-sidebar.open {
        transform: translateX(0);       /* Glisse vers la droite quand ouverte */
    }
    .admin-main {
        margin-left: 0;                /* Prend toute la largeur */
    }
    .topbar-hamburger {
        display: flex;                  /* Affiche le bouton menu burger */
    }
}
```

#### Stat Cards avec animation hover
```css
.stat-card {
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.stat-card:hover {
    transform: translateY(-4px);     /* Monte légèrement */
    box-shadow: 0 12px 24px ...;     /* Ombre plus prononcée */
}

/* Barre colorée en haut de chaque card */
.stat-card:nth-child(1)::before { background: linear-gradient(90deg, violet, ...); }
.stat-card:nth-child(2)::before { background: linear-gradient(90deg, vert, ...); }
```

### 📄 `admin/assets/js/admin.js` — Interactivité

#### Compteurs animés
```javascript
document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.getAttribute('data-count'));
    const duration = 1500;

    function updateCount(currentTime) {
        const progress = Math.min(elapsed / duration, 1);
        // Courbe ease-out exponentielle (démarre vite, ralentit à la fin)
        const eased = 1 - Math.pow(2, -10 * progress);
        el.textContent = Math.floor(target * eased).toLocaleString('fr-FR');
        if (progress < 1) requestAnimationFrame(updateCount);
    }

    // Observer : démarre l'animation quand l'élément est visible
    const observer = new IntersectionObserver((entries) => {
        if (entry.isIntersecting) {
            requestAnimationFrame(updateCount);
            observer.unobserve(entry.target);  // Une seule fois
        }
    });
    observer.observe(el);
});
```

**Comment ça marche :**
1. Le HTML contient `<span data-count="156">0</span>`
2. Quand l'élément devient visible (scrolling), l'animation démarre
3. Le nombre passe de 0 à 156 en 1.5 secondes avec une courbe fluide
4. `toLocaleString('fr-FR')` formate avec des espaces (1 234 au lieu de 1234)

#### Sidebar mobile
```javascript
sidebarToggle.addEventListener('click', () => {
    sidebar.classList.add('open');    // Ajoute la classe CSS
    overlay.classList.add('active');  // Affiche le fond sombre
    document.body.style.overflow = 'hidden';  // Empêche le scroll de la page
});
```

### 📄 `admin/assets/js/charts.js` — Graphiques

```javascript
function initMetiersChart(canvasId, labels, data) {
    new Chart(document.getElementById(canvasId), {
        type: 'bar',
        data: {
            labels: labels,           // ["Développeur web", "Avocat", ...]
            datasets: [{
                data: data,            // [45, 38, 32, ...]
                backgroundColor: [...],// Palette UCAO
                borderRadius: 8,       // Coins arrondis sur les barres
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true },    // Axe Y commence à 0
                x: { maxRotation: 45 },      // Labels en diagonale si longs
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart',      // Animation douce
            }
        }
    });
}
```

**Chart.js** est chargé via CDN dans le `header-admin.php`. Les données viennent de PHP (converties en JSON), puis passées au JS pour créer les graphiques.

---

## 8. Couche 6 — Modules Admin (Pages)

### Schéma général d'une page admin

Chaque page suit le même squelette :

```php
<?php
// 1. Authentification
require_once dirname(__DIR__) . '/includes/auth-check.php';
$pageTitle = 'Titre de la page';

// 2. Traitement POST (si formulaire soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf(...)) { /* erreur */ }
    // ... traitement ...
    set_flash('success', 'Action réussie.');
    redirect('index.php');
}

// 3. Récupération des données
$data = SomeClass::getAll(...);

// 4. Layout
require_once dirname(__DIR__) . '/includes/header-admin.php';
require_once dirname(__DIR__) . '/includes/sidebar.php';
?>

<!-- 5. Contenu HTML -->
<div class="admin-card">
    ...
</div>

<?php
// 6. Fermeture + scripts
require_once dirname(__DIR__) . '/includes/footer-admin.php';
?>
```

### Module Dashboard (`admin/index.php`)

Récupère toutes les statistiques en une seule page :
```php
$orientationsTotal = Orientation::getCount();        // Total absolu
$orientationsMois = Orientation::getCount('month');   // Ce mois seulement
$topMetiers = Orientation::getTopMetiers(8);          // Pour le graphique barres
$topFilieres = Orientation::getTopFilieres(6);        // Pour le graphique camembert
$recentOrientations = Orientation::getRecent(5);      // 5 dernières
```

Les données pour Chart.js sont passées de PHP à JavaScript :
```php
$metiersLabels = json_encode(array_column($topMetiers, 'label'));
$metiersData = json_encode(array_column($topMetiers, 'total'));
```
Puis dans le JS inline :
```javascript
initMetiersChart('metiersChart', <?= $metiersLabels ?>, <?= $metiersData ?>);
```

### Module Orientations — Pagination

```php
<!-- Pagination -->
<?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
    <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>"
       class="<?= $i === $page ? 'active' : '' ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
```

**`http_build_query()`** transforme un tableau en paramètres URL :
```php
http_build_query(['search' => 'Jean', 'page' => 3])
// Résultat : "search=Jean&page=3"
```
`array_merge($filters, ['page' => $i])` garde les filtres actifs en changeant la page.

### Module Orientations — Modal de réponse

Quand l'admin clique sur "Répondre", un popup s'ouvre avec un message pré-rempli :
```javascript
function openReplyModal(id, email, metier) {
    document.getElementById('replyEmail').value = email;
    document.getElementById('replyMessage').value = 
        'Bonjour,\n\nSuite à votre demande pour le métier « ' + metier + ' »...';
    openModal('replyModal');
}
```

Le formulaire du modal envoie un POST vers `repondre.php` qui :
1. Construit un email HTML avec le template UCAO
2. Envoie via `Mailer::send()`
3. Marque l'orientation comme "email envoyé" en base
4. Redirige vers la liste avec un message flash

### Module CRUD Filières

Le pattern **CRUD** (Create, Read, Update, Delete) est le même pour filières et métiers :

| Page | Méthode HTTP | Action |
|------|-------------|--------|
| `index.php` | GET | Lister toutes les filières |
| `ajouter.php` | GET | Afficher le formulaire vide |
| `ajouter.php` | POST | Insérer en base + redirect |
| `modifier.php?id=5` | GET | Afficher le formulaire pré-rempli |
| `modifier.php` | POST | Mettre à jour en base + redirect |
| `supprimer.php` | POST | Supprimer + redirect |

**Pourquoi la suppression est en POST et pas en GET ?**
Une action destructrice (supprimer) ne doit JAMAIS être déclenchée par un simple lien (GET). Raisons :
- Les robots des moteurs de recherche suivent les liens GET
- Le navigateur peut pré-charger les liens GET
- Un lien malveillant pourrait supprimer des données

### Module Paramètres — INSERT ON DUPLICATE KEY

```sql
INSERT INTO parametres (cle, valeur) VALUES (?, ?) ON DUPLICATE KEY UPDATE valeur = ?
```

Cette requête fait un "upsert" (update or insert) :
- Si la clé existe → met à jour la valeur
- Si la clé n'existe pas → l'insère
- En une seule requête atomique

---

## 9. Sécurité

### Récapitulatif des mesures

| Attaque | Protection | Implémentation |
|---------|-----------|----------------|
| **Injection SQL** | Requêtes préparées PDO | `$stmt->execute([$param])` partout |
| **XSS** | Échappement HTML | Fonction `e()` sur tout affichage |
| **CSRF** | Token unique par session | `csrf_field()` + `verify_csrf()` |
| **Brute-force** | Limite de tentatives | 5 max / 10 min dans `Auth.php` |
| **Mots de passe** | Hash bcrypt | `password_hash()` + `password_verify()` |
| **Session fixation** | Régénération | `session_regenerate_id(true)` après login |
| **Session hijacking** | Cookies httponly | `session.cookie_httponly = 1` |
| **Accès non autorisé** | Guard d'authentification | `auth-check.php` sur chaque page |
| **Élévation de privilèges** | Vérification de rôle | `Auth::requireSuperAdmin()` |

### Mot de passe bcrypt — Comment ça fonctionne

```php
// Création du hash (lors de l'inscription)
$hash = password_hash('ucao2026', PASSWORD_BCRYPT, ['cost' => 10]);
// Résultat : "$2y$10$tBfJNy6johlKquHDBjB3qOUUwpKpXbSFFdsvBPU9sT.OvE01FmLse"
//             ^^^^  ^^  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//             Algo  Cost                    Sel + Hash
```

- `$2y$` = algorithme bcrypt
- `10` = coût (nombre d'itérations = 2^10 = 1024)
- Le reste = sel aléatoire (22 chars) + hash (31 chars)
- Chaque hash est différent même pour le même mot de passe (grâce au sel aléatoire)
- Impossible de "dé-hasher" : on ne peut que vérifier avec `password_verify()`

---

## 10. Déploiement

### En local (développement)

1. XAMPP doit être démarré (Apache + MySQL)
2. Créer la base `ucao_orientation` dans phpMyAdmin
3. Importer `sql/ucao_orientation.sql` puis `sql/data_seed.sql`
4. Le `.env` est déjà configuré pour localhost

### En production

1. **Hébergement** : VPS ou hébergement mutualisé avec PHP ≥ 8.0 + MySQL
2. **Fichiers** : Uploader tout le projet (sauf `.env`, `vendor/` est facultatif si on fait `composer install` sur le serveur)
3. **Base de données** : Créer la base + importer les SQL via phpMyAdmin de l'hébergeur
4. **Configuration** :
   ```bash
   cp .env.example .env
   nano .env  # Remplir les vrais credentials
   ```
5. **Permissions** :
   ```bash
   chmod -R 755 uploads/
   ```
6. **Composer** (si vendor pas uploadé) :
   ```bash
   composer install --no-dev
   ```

### Variables `.env` à changer en production

| Variable | Dev | Prod |
|----------|-----|------|
| `APP_ENV` | `dev` | `prod` |
| `APP_DEBUG` | `true` | `false` |
| `APP_URL` | `http://localhost/ucao-orientation` | `https://orientation.ucao.bj` |
| `DB_USER` | `root` | `ucao_db_user` |
| `DB_PASS` | *(vide)* | `MotDePasseFort123!` |
| `SMTP_USER` | *(vide)* | `notification@ucao.bj` |
| `SMTP_PASS` | *(vide)* | `mdp_smtp_app` |

---

## Glossaire

| Terme | Explication |
|-------|-------------|
| **PDO** | PHP Data Objects — Interface PHP pour communiquer avec les bases de données |
| **Singleton** | Pattern qui garantit une seule instance d'une classe |
| **CSRF** | Cross-Site Request Forgery — Attaque forçant une action sans le consentement de l'utilisateur |
| **XSS** | Cross-Site Scripting — Injection de code JavaScript malveillant |
| **bcrypt** | Algorithme de hashage de mots de passe, lent par design (résistant au brute-force) |
| **DOMPDF** | Librairie PHP qui convertit du HTML/CSS en fichier PDF |
| **PHPMailer** | Librairie PHP pour envoyer des emails via SMTP |
| **Requête préparée** | Requête SQL où les données sont séparées de la structure (anti-injection) |
| **Session** | Mécanisme côté serveur pour conserver des données entre les requêtes HTTP |
| **Flash message** | Message affiché une seule fois après une redirection |
| **Slug** | Version URL-friendly d'un texte ("Génie Télécoms" → "genie-telecoms") |
| **CRUD** | Create, Read, Update, Delete — Les 4 opérations de base sur les données |
| **Seed** | Données initiales insérées dans une base de données vide |
| **CDN** | Content Delivery Network — Serveur distant qui fournit des fichiers JS/CSS populaires |
| **Guard** | Code qui vérifie une condition avant d'autoriser l'accès à une ressource |

---

*Fin de la documentation technique. Ce document couvre l'intégralité du code produit pour le panneau d'administration UCAO-Orientation.*
