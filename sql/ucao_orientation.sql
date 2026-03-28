-- =================================================================
-- UCAO-ORIENTATION — Schéma de Base de Données
-- Version 1.1 — Mars 2026
-- =================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+01:00";

-- Création de la base si elle n'existe pas
CREATE DATABASE IF NOT EXISTS `ucao_orientation`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `ucao_orientation`;

-- =================================================================
-- TABLE : admins
-- Comptes administrateurs du back-office
-- =================================================================
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin','admin') NOT NULL DEFAULT 'admin',
  `actif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : filieres
-- Toutes les filières proposées par l'UCAO
-- =================================================================
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ecole_faculte` VARCHAR(100) NOT NULL,
  `nom_filiere` VARCHAR(200) NOT NULL,
  `niveau` VARCHAR(50) NOT NULL DEFAULT 'Licence',
  `duree` VARCHAR(20) NOT NULL DEFAULT '3 ans',
  `description` TEXT NULL,
  `debouches` TEXT NULL,
  `slug` VARCHAR(200) NOT NULL,
  `actif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_filieres_slug` (`slug`),
  KEY `idx_filieres_ecole` (`ecole_faculte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : metiers
-- Métiers proposés dans l'autocomplete du formulaire d'orientation
-- =================================================================
CREATE TABLE IF NOT EXISTS `metiers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_metier` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL,
  `actif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_metiers_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : metiers_filieres
-- Correspondance Métiers ↔ Filières (N:N avec priorité)
-- =================================================================
CREATE TABLE IF NOT EXISTS `metiers_filieres` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `metier_id` INT(11) NOT NULL,
  `filiere_id` INT(11) NOT NULL,
  `priorite` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_metier_filiere` (`metier_id`, `filiere_id`),
  KEY `idx_mf_metier` (`metier_id`),
  KEY `idx_mf_filiere` (`filiere_id`),
  CONSTRAINT `fk_mf_metier` FOREIGN KEY (`metier_id`) REFERENCES `metiers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mf_filiere` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : orientations
-- Toutes les orientations effectuées via le formulaire visiteur
-- =================================================================
CREATE TABLE IF NOT EXISTS `orientations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `serie_bac` VARCHAR(10) NOT NULL,
  `numero_table` VARCHAR(30) NULL DEFAULT NULL,
  `metier_souhaite` VARCHAR(200) NOT NULL,
  `filieres_recommandees` TEXT NULL,
  `rapport_pdf_path` VARCHAR(255) NULL DEFAULT NULL,
  `email_envoye` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_orientations_email` (`email`),
  KEY `idx_orientations_date` (`created_at`),
  KEY `idx_orientations_serie` (`serie_bac`),
  KEY `idx_orientations_metier` (`metier_souhaite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : preinscriptions
-- Préinscriptions reçues via le formulaire
-- =================================================================
CREATE TABLE IF NOT EXISTS `preinscriptions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `date_naissance` DATE NOT NULL,
  `nationalite` VARCHAR(80) NOT NULL DEFAULT 'Béninoise',
  `serie_bac` VARCHAR(10) NOT NULL,
  `annee_bac` YEAR NOT NULL,
  `etablissement_origine` VARCHAR(200) NOT NULL,
  `filiere_choisie` INT(11) NOT NULL,
  `niveau_entree` VARCHAR(20) NOT NULL DEFAULT 'Licence 1',
  `email` VARCHAR(150) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `doc_releve` VARCHAR(255) NULL DEFAULT NULL,
  `doc_bac` VARCHAR(255) NULL DEFAULT NULL,
  `doc_identite` VARCHAR(255) NULL DEFAULT NULL,
  `orientation_id` INT(11) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_preinscriptions_email` (`email`),
  KEY `idx_preinscriptions_date` (`created_at`),
  KEY `idx_preinscriptions_filiere` (`filiere_choisie`),
  KEY `idx_preinscriptions_serie` (`serie_bac`),
  CONSTRAINT `fk_preinsc_filiere` FOREIGN KEY (`filiere_choisie`) REFERENCES `filieres` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_preinsc_orientation` FOREIGN KEY (`orientation_id`) REFERENCES `orientations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : notifications
-- Historique des notifications e-mail envoyées par les admins
-- =================================================================
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sujet` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `destinataires` TEXT NOT NULL COMMENT 'JSON: liste des emails ciblés',
  `nb_destinataires` INT(11) NOT NULL DEFAULT 0,
  `type_cible` VARCHAR(50) NOT NULL COMMENT 'orientations, preinscriptions, tous',
  `filtre_serie` VARCHAR(10) NULL DEFAULT NULL,
  `filtre_filiere` INT(11) NULL DEFAULT NULL,
  `envoye_le` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_date` (`envoye_le`),
  KEY `idx_notifications_admin` (`admin_id`),
  CONSTRAINT `fk_notif_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABLE : parametres
-- Configuration dynamique de l'application
-- =================================================================
CREATE TABLE IF NOT EXISTS `parametres` (
  `cle` VARCHAR(100) NOT NULL,
  `valeur` TEXT NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
