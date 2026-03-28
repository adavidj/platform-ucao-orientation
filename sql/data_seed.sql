-- =================================================================
-- UCAO-ORIENTATION — Données Initiales (Seed)
-- À exécuter APRÈS ucao_orientation.sql
-- =================================================================

USE `ucao_orientation`;

-- =================================================================
-- SUPER ADMIN par défaut
-- Email: admin@ucao.bj / Mot de passe: ucao2026
-- ⚠️ CHANGER CE MOT DE PASSE EN PRODUCTION !
-- =================================================================
INSERT INTO `admins` (`nom`, `email`, `password_hash`, `role`, `actif`) VALUES
('Super Administrateur', 'admin@ucao.bj', '$2y$10$y1ZH286m2gphBaEpgawYGeF9dcDX1bNTx0dNdKlP00jhxmv8RP0aa', 'super_admin', 1),
('David Jonathan', 'davidaidasso252@gmail.com', '$2y$10$cQ4i4tWWpO.L6pq65e7oru2QaR5GTv/QXVpi1eHixaI0vvROiaB7G', 'super_admin', 1);

-- =================================================================
-- PARAMÈTRES par défaut
-- =================================================================
INSERT INTO `parametres` (`cle`, `valeur`, `description`) VALUES
('periode_nouveaux_bacheliers', '0', 'Active le champ Numéro de table dans le formulaire d\'orientation (1 = activé, 0 = désactivé)'),
('site_nom', 'UCAO Orientation', 'Nom du site affiché dans les emails et rapports'),
('site_email', 'contact@ucaobenin.org', 'Email principal de contact'),
('maintenance_mode', '0', 'Mode maintenance (1 = activé, 0 = désactivé)');

-- =================================================================
-- FILIÈRES — EGEI (École de Génie Électrique et Informatique)
-- =================================================================
INSERT INTO `filieres` (`ecole_faculte`, `nom_filiere`, `niveau`, `duree`, `description`, `debouches`, `slug`) VALUES
('EGEI', 'Électronique', 'Licence', '3 ans',
 'Formation en électronique analogique et numérique, microcontrôleurs, systèmes embarqués et instrumentation.',
 'Ingénieur en électronique, Technicien en maintenance électronique, Concepteur de circuits, Chef de projet R&D',
 'electronique'),

('EGEI', 'Génie Télécoms et TIC', 'Licence', '3 ans',
 'Formation en réseaux de télécommunications, technologies de l\'information, systèmes d\'exploitation et administration réseau.',
 'Ingénieur réseau, Administrateur systèmes, Consultant TIC, Chef de projet télécom',
 'genie-telecoms-tic'),

('EGEI', 'Informatique Industrielle et Maintenance', 'Licence', '3 ans',
 'Formation en automatisme, programmation industrielle, supervision, réseaux industriels et systèmes embarqués.',
 'Automaticien, Ingénieur en informatique industrielle, Technicien en maintenance industrielle',
 'informatique-industrielle'),

('EGEI', 'Électrotechnique', 'Licence', '3 ans',
 'Formation en génie électrique, machines électriques, réseaux électriques, énergies renouvelables et installations.',
 'Ingénieur électricien, Technicien en énergie, Responsable installations électriques',
 'electrotechnique'),

('EGEI', 'Automatique', 'Master', '2 ans',
 'Formation avancée en automatisme industriel, robotique, commande des systèmes, intelligence artificielle appliquée.',
 'Ingénieur en automatisme, Chef de projet industriel, Consultant en robotique',
 'master-automatique'),

('EGEI', 'Télécommunications', 'Master', '2 ans',
 'Formation avancée en systèmes de télécommunications avancés, 5G, fibre optique, sécurité des réseaux.',
 'Architecte réseau, Ingénieur télécom senior, Consultant en cybersécurité',
 'master-telecommunications'),

('EGEI', 'Informatique', 'Master', '2 ans',
 'Formation avancée en génie logiciel, bases de données avancées, intelligence artificielle, cloud computing.',
 'Architecte logiciel, Data scientist, DevOps Engineer, CTO',
 'master-informatique'),

-- =================================================================
-- FILIÈRES — ESMEA (École Supérieure de Management et d'Économie Appliquée)
-- =================================================================
('ESMEA', 'Banques, Finances et Assurances', 'Licence', '3 ans',
 'Formation en analyse financière, gestion bancaire, marchés financiers, assurances et gestion des risques.',
 'Analyste financier, Gestionnaire de portefeuille, Agent d\'assurance, Auditeur bancaire',
 'banques-finances-assurances'),

('ESMEA', 'Audit et Comptabilité', 'Licence', '3 ans',
 'Formation en comptabilité générale et analytique, audit interne et externe, fiscalité, contrôle de gestion.',
 'Expert-comptable, Auditeur, Contrôleur de gestion, Directeur financier',
 'audit-comptabilite'),

('ESMEA', 'Gestion des Ressources Humaines', 'Licence', '3 ans',
 'Formation en management du personnel, droit social, recrutement, formation professionnelle et gestion des carrières.',
 'DRH, Responsable recrutement, Consultant RH, Gestionnaire de paie',
 'gestion-ressources-humaines'),

('ESMEA', 'Marketing et Commerce', 'Licence', '3 ans',
 'Formation en marketing digital, stratégie commerciale, communication, études de marché et techniques de vente.',
 'Directeur marketing, Chef de produit, Community manager, Responsable commercial',
 'marketing-commerce'),

('ESMEA', 'Transport et Logistique', 'Licence', '3 ans',
 'Formation en gestion de la chaîne logistique, transport international, commerce international et douanes.',
 'Responsable logistique, Supply chain manager, Transitaire, Chef d\'exploitation transport',
 'transport-logistique'),

('ESMEA', 'Audit (Master)', 'Master', '2 ans',
 'Formation avancée en audit des organisations, normes IFRS, gouvernance d\'entreprise et gestion des risques.',
 'Directeur d\'audit, Commissaire aux comptes, Consultant senior en audit',
 'master-audit'),

('ESMEA', 'GRH (Master)', 'Master', '2 ans',
 'Formation avancée en stratégie RH, management du changement, négociations sociales et GPEC.',
 'DRH groupe, Consultant senior RH, Directeur des relations sociales',
 'master-grh'),

('ESMEA', 'Marketing (Master)', 'Master', '2 ans',
 'Formation avancée en marketing stratégique, marketing digital avancé, data marketing et brand management.',
 'Directeur marketing, Directeur communication, Chief Marketing Officer',
 'master-marketing'),

('ESMEA', 'Commerce International (Master)', 'Master', '2 ans',
 'Formation avancée en commerce international, négociation interculturelle, trade finance et géopolitique économique.',
 'Directeur commercial export, Consultant en développement international',
 'master-commerce-international'),

('ESMEA', 'Transport (Master)', 'Master', '2 ans',
 'Formation avancée en management de la supply chain, optimisation logistique et transport multimodal.',
 'Directeur supply chain, Consultant logistique senior',
 'master-transport'),

-- =================================================================
-- FILIÈRES — FSAE (Faculté des Sciences de l'Agronomie et de l'Environnement)
-- =================================================================
('FSAE', 'Agronomie', 'Licence', '3 ans',
 'Formation en sciences agronomiques, production agricole, agroécologie, gestion des exploitations et sécurité alimentaire.',
 'Ingénieur agronome, Conseiller agricole, Responsable exploitation, Chercheur en agronomie',
 'agronomie'),

('FSAE', 'Gestion de l\'Environnement', 'Licence', '3 ans',
 'Formation en gestion de l\'environnement, écologie, développement durable, études d\'impact et biodiversité.',
 'Chargé d\'études environnementales, Responsable RSE, Consultant en développement durable',
 'gestion-environnement'),

('FSAE', 'Ressources Animales', 'Licence', '3 ans',
 'Formation en zootechnie, production animale, santé animale, alimentation du bétail et gestion des élevages.',
 'Zootechnicien, Responsable d\'élevage, Technicien en production animale',
 'ressources-animales'),

('FSAE', 'Production Végétale', 'Licence', '3 ans',
 'Formation en phytotechnie, protection des cultures, amélioration variétale et technologies post-récolte.',
 'Ingénieur en production végétale, Responsable de culture, Sélectionneur végétal',
 'production-vegetale'),

('FSAE', 'Environnement (Master)', 'Master', '2 ans',
 'Formation avancée en gestion intégrée de l\'environnement, changement climatique et politiques environnementales.',
 'Expert en environnement, Directeur RSE, Consultant international en développement durable',
 'master-environnement'),

('FSAE', 'Gestion des Ressources Naturelles (Master)', 'Master', '2 ans',
 'Formation avancée en gestion des ressources naturelles, foresterie, ressources en eau et biodiversité.',
 'Gestionnaire de parc naturel, Expert en ressources naturelles, Consultant forestier',
 'master-ressources-naturelles'),

('FSAE', 'Espace Urbain (Master)', 'Master', '2 ans',
 'Formation avancée en aménagement urbain, urbanisme durable, planification territoriale et smart cities.',
 'Urbaniste, Aménageur territorial, Consultant en planification urbaine',
 'master-espace-urbain'),

-- =================================================================
-- FILIÈRES — FDE (Faculté de Droit et d'Économie)
-- =================================================================
('FDE', 'Sciences Juridiques', 'Licence', '3 ans',
 'Formation en droit civil, droit pénal, droit constitutionnel, droit commercial et méthodologie juridique.',
 'Avocat, Magistrat, Juriste d\'entreprise, Notaire, Huissier de justice',
 'sciences-juridiques'),

('FDE', 'Sciences Économiques', 'Licence', '3 ans',
 'Formation en micro et macroéconomie, économétrie, économie du développement et politiques économiques.',
 'Économiste, Analyste de politiques publiques, Chargé d\'études économiques',
 'sciences-economiques'),

('FDE', 'Droit Privé Fondamental (Master)', 'Master', '2 ans',
 'Formation avancée en droit civil approfondi, droit des affaires, droit international privé et arbitrage.',
 'Avocat d\'affaires, Juriste senior, Arbitre international, Magistrat',
 'master-droit-prive'),

('FDE', 'Droit Public Fondamental (Master)', 'Master', '2 ans',
 'Formation avancée en droit administratif, droit constitutionnel comparé, contentieux public et droit international public.',
 'Haut fonctionnaire, Conseiller juridique de l\'État, Expert en droit public international',
 'master-droit-public');

-- =================================================================
-- MÉTIERS et correspondances Métiers ↔ Filières
-- =================================================================

-- Métiers Tech / Informatique
INSERT INTO `metiers` (`nom_metier`, `slug`) VALUES
('Développeur web', 'developpeur-web'),
('Développeur mobile', 'developpeur-mobile'),
('Ingénieur logiciel', 'ingenieur-logiciel'),
('Data scientist', 'data-scientist'),
('Administrateur réseau', 'administrateur-reseau'),
('Ingénieur en cybersécurité', 'ingenieur-cybersecurite'),
('Architecte cloud', 'architecte-cloud'),
('Ingénieur en intelligence artificielle', 'ingenieur-ia'),
('Chef de projet IT', 'chef-projet-it'),
('Technicien en maintenance informatique', 'technicien-maintenance-info'),

-- Métiers Électronique / Télécom
('Ingénieur en télécommunications', 'ingenieur-telecommunications'),
('Ingénieur en électronique', 'ingenieur-electronique'),
('Automaticien', 'automaticien'),
('Ingénieur en énergie', 'ingenieur-energie'),
('Technicien en électrotechnique', 'technicien-electrotechnique'),

-- Métiers Finance / Commerce
('Analyste financier', 'analyste-financier'),
('Expert-comptable', 'expert-comptable'),
('Auditeur financier', 'auditeur-financier'),
('Banquier', 'banquier'),
('Gestionnaire de patrimoine', 'gestionnaire-patrimoine'),
('Directeur marketing', 'directeur-marketing'),
('Community manager', 'community-manager'),
('Responsable commercial', 'responsable-commercial'),
('Supply chain manager', 'supply-chain-manager'),
('Transitaire', 'transitaire'),

-- Métiers RH
('Directeur des ressources humaines', 'directeur-rh'),
('Consultant en recrutement', 'consultant-recrutement'),
('Responsable formation', 'responsable-formation'),

-- Métiers Droit
('Avocat', 'avocat'),
('Magistrat', 'magistrat'),
('Notaire', 'notaire'),
('Juriste d\'entreprise', 'juriste-entreprise'),
('Diplomate', 'diplomate'),

-- Métiers Agronomie / Environnement
('Ingénieur agronome', 'ingenieur-agronome'),
('Consultant en développement durable', 'consultant-developpement-durable'),
('Responsable RSE', 'responsable-rse'),
('Urbaniste', 'urbaniste'),
('Gestionnaire de parc naturel', 'gestionnaire-parc-naturel'),
('Vétérinaire / Zootechnicien', 'veterinaire-zootechnicien'),

-- Métiers transversaux
('Économiste', 'economiste'),
('Chercheur', 'chercheur'),
('Entrepreneur', 'entrepreneur'),
('Consultant', 'consultant'),
('Chef d\'entreprise', 'chef-entreprise');

-- =================================================================
-- CORRESPONDANCES Métiers ↔ Filières
-- (priorite : 1 = recommandation principale, 2 = alternative, 3 = possible)
-- =================================================================

-- Développeur web → Informatique, Génie Télécoms, Master Informatique
INSERT INTO `metiers_filieres` (`metier_id`, `filiere_id`, `priorite`) VALUES
(1, 7, 1), (1, 2, 2), (1, 3, 3),

-- Développeur mobile → Informatique, Master Informatique
(2, 7, 1), (2, 2, 2),

-- Ingénieur logiciel → Master Informatique, Informatique Industrielle
(3, 7, 1), (3, 3, 2),

-- Data scientist → Master Informatique
(4, 7, 1),

-- Admin réseau → Génie Télécoms, Master Telecom
(5, 2, 1), (5, 6, 2),

-- Cybersécurité → Master Telecom, Génie Télécoms
(6, 6, 1), (6, 2, 2),

-- Architecte cloud → Master Informatique, Master Telecom
(7, 7, 1), (7, 6, 2),

-- Ingénieur IA → Master Informatique
(8, 7, 1),

-- Chef projet IT → Génie Télécoms, Master Informatique
(9, 2, 1), (9, 7, 2),

-- Technicien maintenance info → Informatique Industrielle, Électronique
(10, 3, 1), (10, 1, 2),

-- Ingénieur Telecom → Master Telecom, Génie Telecoms
(11, 6, 1), (11, 2, 2),

-- Ingénieur Électronique → Électronique, Master Automatique
(12, 1, 1), (12, 5, 2),

-- Automaticien → Master Automatique, Informatique Industrielle
(13, 5, 1), (13, 3, 2),

-- Ingénieur énergie → Électrotechnique
(14, 4, 1),

-- Technicien Élec → Électrotechnique, Électronique
(15, 4, 1), (15, 1, 2),

-- Analyste financier → Banques-Finances, Master Audit
(16, 8, 1), (16, 13, 2),

-- Expert-comptable → Audit-Comptabilité, Master Audit
(17, 9, 1), (17, 13, 2),

-- Auditeur financier → Master Audit, Audit-Comptabilité
(18, 13, 1), (18, 9, 2),

-- Banquier → Banques-Finances
(19, 8, 1),

-- Gestionnaire patrimoine → Banques-Finances, Master Audit
(20, 8, 1), (20, 13, 2),

-- Directeur marketing → Master Marketing, Marketing-Commerce
(21, 15, 1), (21, 11, 2),

-- Community manager → Marketing-Commerce, Master Marketing
(22, 11, 1), (22, 15, 2),

-- Responsable commercial → Marketing-Commerce, Master Commerce International
(23, 11, 1), (23, 16, 2),

-- Supply chain manager → Master Transport, Transport-Logistique
(24, 17, 1), (24, 12, 2),

-- Transitaire → Transport-Logistique, Master Transport
(25, 12, 1), (25, 17, 2),

-- DRH → Master GRH, GRH Licence
(26, 14, 1), (26, 10, 2),

-- Consultant recrutement → GRH, Master GRH
(27, 10, 1), (27, 14, 2),

-- Responsable formation → Master GRH, GRH
(28, 14, 1), (28, 10, 2),

-- Avocat → Sciences Juridiques, Master Droit Privé
(29, 25, 1), (29, 27, 2),

-- Magistrat → Sciences Juridiques, Master Droit Public
(30, 25, 1), (30, 28, 2),

-- Notaire → Sciences Juridiques, Master Droit Privé
(31, 25, 1), (31, 27, 2),

-- Juriste d'entreprise → Master Droit Privé, Sciences Juridiques
(32, 27, 1), (32, 25, 2),

-- Diplomate → Master Droit Public, Sciences Juridiques
(33, 28, 1), (33, 25, 2),

-- Ingénieur agronome → Agronomie, Master Environnement
(34, 18, 1), (34, 23, 2),

-- Consultant dev durable → Master Environnement, Gestion Environnement
(35, 23, 1), (35, 19, 2),

-- Responsable RSE → Gestion Environnement, Master Environnement
(36, 19, 1), (36, 23, 2),

-- Urbaniste → Master Espace Urbain, Gestion Environnement
(37, 24, 1), (37, 19, 2),

-- Gestionnaire parc naturel → Master Ressources Naturelles, Gestion Environnement
(38, 24, 1), (38, 19, 2),

-- Vétérinaire → Ressources Animales
(39, 20, 1),

-- Économiste → Sciences Économiques, Master Droit Public
(40, 26, 1), (40, 28, 3),

-- Chercheur → correspondances variables selon domaine, on met les masters
(41, 7, 2), (41, 23, 2), (41, 28, 2),

-- Entrepreneur → Marketing-Commerce, Audit-Comptabilité, GRH
(42, 11, 1), (42, 9, 2), (42, 10, 3),

-- Consultant → Audit-Comptabilité, Master Audit, Marketing
(43, 9, 1), (43, 13, 2), (43, 11, 3),

-- Chef d'entreprise → Master Marketing, Master Audit, Master GRH
(44, 15, 1), (44, 13, 2), (44, 14, 3);
