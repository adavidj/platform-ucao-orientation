<?php
// =================================================================
// CONSTANTES DE L'APPLICATION
// =================================================================

// Séries de Baccalauréat
define('SERIES_BAC', [
    'A' => 'Série A (Lettres)',
    'B' => 'Série B (Économie)',
    'C' => 'Série C (Mathématiques)',
    'D' => 'Série D (Sciences Naturelles)',
    'E' => 'Série E (Sciences et Technologies)',
    'F' => 'Série F (Technique)',
    'G' => 'Série G (Gestion)',
]);

// Niveaux d'entrée
define('NIVEAUX_ENTREE', [
    'Licence 1' => 'Licence 1 (1ère année)',
    'Licence 2' => 'Licence 2 (2ème année)',
    'Licence 3' => 'Licence 3 (3ème année)',
    'Master 1' => 'Master 1 (4ème année)',
    'Master 2' => 'Master 2 (5ème année)',
]);

// Types de fichiers autorisés pour l'upload
define('UPLOAD_ALLOWED_TYPES', [
    'application/pdf',
    'image/jpeg',
    'image/png',
    'image/jpg',
]);

// Extensions autorisées
define('UPLOAD_ALLOWED_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png']);

// Taille max upload (5 Mo en octets)
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024);

// Pagination par défaut
define('ITEMS_PER_PAGE', 15);

// Écoles et Facultés
define('ECOLES_FACULTES', [
    'EGEI' => 'École de Génie Électrique et Informatique',
    'ESMEA' => 'École Supérieure de Management et d\'Économie Appliquée',
    'FSAE' => 'Faculté des Sciences de l\'Agronomie et de l\'Environnement',
    'FDE' => 'Faculté de Droit et d\'Économie',
]);

// Rôles administrateurs
define('ADMIN_ROLES', [
    'super_admin' => 'Super Administrateur',
    'admin' => 'Administrateur',
]);

// Tentatives de connexion max (anti brute-force)
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 600); // 10 minutes en secondes
