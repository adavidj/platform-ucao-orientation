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
('David Jonathan', 'davidaidasso252@gmail.com', '$2y$10$cQ4i4tWWpO.L6pq65e7oru2QaR5GTv/QXVpi1eHixaI0vvROiaB7G', 'super_admin', 1),
('ZANNOU Rhetice', 'rheticezannou@gmail.com', '$2y$10$wQw6Qw6Qw6Qw6Qw6Qw6QwOQw6Qw6Qw6Qw6Qw6Qw6Qw6Qw6Qw6Q', 'admin', 1); -- Mot de passe: ucao2026

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
-- IDs filières : 1 à 8
-- =================================================================
INSERT INTO `filieres` (`ecole_faculte`, `nom_filiere`, `niveau`, `duree`, `description`, `debouches`, `slug`) VALUES

-- ID 1
('EGEI', 'Électronique', 'Licence', '3 ans',
 'Formation d\'ingénieurs capables de concevoir des circuits, des cartes électroniques et des systèmes embarqués. Couvre l\'électronique analogique et numérique, les microcontrôleurs, l\'instrumentation et la compatibilité électromagnétique (CEM). Secteurs : aéronautique, spatial, automobile, électronique grand public, défense, santé.',
 'Ingénieur en conception électronique, Ingénieur en systèmes embarqués, Ingénieur en circuits intégrés (ASIC/FPGA), Ingénieur en instrumentation et mesure, Responsable de projets électroniques, Ingénieur en CEM',
 'electronique'),

-- ID 2
('EGEI', 'Génie Télécoms et TIC', 'Licence', '3 ans',
 'Spécialisée dans les réseaux, les télécommunications et les technologies de l\'information et de la communication. Secteurs : opérateurs télécoms, entreprises du numérique, banques, administration, industries de haute technologie.',
 'Ingénieur réseaux et télécoms, Ingénieur en cybersécurité, Architecte des systèmes d\'information, Ingénieur en infrastructure cloud et virtualisation, Administrateur de bases de données et réseaux, Consultant en transformation numérique',
 'genie-telecoms-tic'),

-- ID 3
('EGEI', 'Informatique Industrielle et Maintenance', 'Licence', '3 ans',
 'Combine l\'informatique appliquée aux processus industriels et la gestion de la maintenance. Couvre l\'automatisme, la supervision SCADA, les réseaux industriels et la fiabilité des systèmes. Secteurs : industrie manufacturière, production, énergie, automatismes, usines intelligentes.',
 'Ingénieur en automatisme et supervision, Ingénieur de maintenance industrielle, Ingénieur en informatique industrielle, Responsable GMAO, Ingénieur en supervision (SCADA), Ingénieur en fiabilité et sûreté de fonctionnement',
 'informatique-industrielle'),

-- ID 4
('EGEI', 'Système Industriel', 'Licence', '3 ans',
 'Filière orientée vers l\'optimisation, la gestion et l\'intégration des systèmes de production industrielle. Secteurs : agroalimentaire, automobile, logistique, chimie, pharmacie, conseil en organisation industrielle.',
 'Ingénieur en organisation et gestion de production, Ingénieur en logistique et supply chain, Ingénieur en amélioration continue (Lean Six Sigma), Responsable d\'unité industrielle, Ingénieur en pilotage de systèmes industriels, Chef de projet industriel',
 'systeme-industriel'),

-- ID 5
('EGEI', 'Électrotechnique', 'Licence', '3 ans',
 'Filière centrée sur l\'énergie électrique : production, transport, distribution, conversion et maîtrise de l\'énergie. Secteurs : énergie (électricité, renouvelables), transport ferroviaire, bâtiment, grandes industries, services publics.',
 'Ingénieur en conception et exploitation des réseaux électriques, Ingénieur en énergies renouvelables (solaire, éolien, hydrogène), Chargé d\'affaires en génie électrique, Ingénieur en maintenance des équipements électriques, Ingénieur en efficacité énergétique, Chef de projet électrique',
 'electrotechnique'),

-- ID 6
('EGEI', 'Système Industriel', 'Master', '2 ans',
 'Formation avancée en optimisation des systèmes de production, logistique, gestion industrielle et intégration de l\'industrie 4.0. Secteurs : industrie manufacturière, agroalimentaire, automobile, aéronautique, logistique, conseil en organisation industrielle.',
 'Ingénieur en organisation et gestion de production, Responsable supply chain / logistique, Ingénieur en amélioration continue (Lean, Six Sigma), Responsable de flux industriels, Consultant en performance industrielle, Chef de projet industriel, Responsable de planning et ordonnancement',
 'master-systeme-industriel'),

-- ID 7
('EGEI', 'Électronique, Automatique et Système de Production', 'Master', '2 ans',
 'Formation avancée en conception de systèmes électroniques embarqués, automatismes industriels, supervision et robotique. Secteurs : automobile, aéronautique, robotique, production industrielle, énergie, usines intelligentes.',
 'Ingénieur en systèmes embarqués, Ingénieur en automatique et supervision (SCADA), Ingénieur en robotique industrielle, Concepteur de cartes électroniques et FPGA, Ingénieur en instrumentation et contrôle-commande, Responsable de projet en automatisation, Architecte de systèmes de production connectés',
 'master-electronique-automatique'),

-- ID 8
('EGEI', 'Génie Télécoms et TIC', 'Master', '2 ans',
 'Formation avancée en conception, déploiement et sécurisation des infrastructures réseaux et télécoms, virtualisation, cloud et cybersécurité. Secteurs : opérateurs télécoms, ESN, banques, administrations, industries critiques (énergie, transport).',
 'Ingénieur réseaux et télécommunications, Architecte réseau (LAN/WAN, SD-WAN, 5G), Ingénieur en cybersécurité, Ingénieur en infrastructure cloud (AWS, Azure, OpenStack), Administrateur systèmes et réseaux, Consultant en transformation numérique, Responsable de projets télécoms, Ingénieur radiofréquences (RF) et réseaux mobiles',
 'master-genie-telecoms-tic'),

-- =================================================================
-- FILIÈRES — ESMEA (École Supérieure de Management et d'Économie Appliquée)
-- IDs filières : 9 à 18
-- =================================================================

-- ID 9
('ESMEA', 'Banques, Finances et Assurances', 'Licence', '3 ans',
 'Formation couvrant deux spécialités : Assurances (compagnies d\'assurances, mutuelles, courtiers, bancassurance) et Banque et Finance d\'Entreprise (banques de détail, banques d\'investissement, sociétés de financement, trésoreries d\'entreprise).',
 'Gestionnaire sinistres, Souscripteur en assurances, Chargé de clientèle en assurances, Expert en évaluation des risques, Analyste financier, Gestionnaire de patrimoine, Chargé de financement d\'entreprises, Trésorier d\'entreprise, Analyste crédit',
 'banques-finances-assurances'),

-- ID 10
('ESMEA', 'Finances, Comptabilité, Audit', 'Licence', '3 ans',
 'Formation en audit et contrôle de gestion. Secteurs : cabinets d\'audit (Big Four, cabinets nationaux), directions financières d\'entreprises, administrations publiques.',
 'Auditeur interne / externe, Contrôleur de gestion, Analyste financier, Directeur administratif et financier (DAF), Expert-comptable, Consultant en management financier, Responsable de la conformité (contrôle interne)',
 'finances-comptabilite-audit'),

-- ID 11
('ESMEA', 'Gestion des Ressources Humaines', 'Licence', '3 ans',
 'Formation en management RH couvrant tous secteurs : industrie, services, administrations, cabinets de recrutement, cabinets conseil RH.',
 'Chargé de recrutement, Responsable paie et administration du personnel, Gestionnaire de carrières, Responsable formation, Chargé des relations sociales, Responsable développement RH, Consultant RH, Responsable de la diversité et QVT',
 'gestion-ressources-humaines'),

-- ID 12
('ESMEA', 'Marketing, Communication et Commerce', 'Licence', '3 ans',
 'Formation couvrant trois spécialités : Action Commerciale et Force de Vente, Communication et Action Publicitaire, et Commerce. Secteurs : grandes surfaces, agences de communication, négoce, import-export, e-commerce.',
 'Chargé d\'affaires, Responsable de secteur, Chef des ventes, Directeur commercial, Chef de projet en communication, Community manager, Concepteur rédacteur, Acheteur / Approvisionneur, Responsable e-commerce, Responsable export',
 'marketing-communication-commerce'),

-- ID 13
('ESMEA', 'Système Informatique et Logiciel', 'Licence', '3 ans',
 'Spécialité Informatique de Gestion. Formation destinée aux entreprises privées, administrations, ESN (sociétés de services numériques), cabinets de conseil.',
 'Analyste fonctionnel, Chef de projet informatique, Administrateur de bases de données, Responsable ERP (SAP, Oracle), Consultant en systèmes d\'information, Directeur des systèmes d\'information (DSI), Développeur d\'applications de gestion',
 'systeme-informatique-logiciel'),

-- ID 14
('ESMEA', 'Transport et Logistique', 'Licence', '3 ans',
 'Formation en gestion des flux logistiques et de transport. Secteurs : entreprises de transport (routier, maritime, aérien, ferroviaire), prestataires logistiques (3PL, 4PL), supply chain des industries et du commerce, e-commerce.',
 'Responsable logistique, Gestionnaire de transport, Coordinateur supply chain, Responsable entrepôt / plateforme, Planificateur de flux, Chef de projet logistique, Consultant en optimisation de la chaîne logistique, Gestionnaire de douane et transit',
 'transport-logistique'),

-- ID 15
('ESMEA', 'Assurances', 'Master', '2 ans',
 'Formation avancée pour maîtriser les techniques d\'assurance, la gestion des risques, la souscription, l\'indemnisation et la réglementation. Secteurs : compagnies d\'assurances, mutuelles, courtiers, bancassurance, cabinets de conseil en risques.',
 'Responsable sinistres, Souscripteur senior, Chargé de clientèle professionnelle, Inspecteur d\'assurances, Responsable de portefeuille, Expert en gestion des risques, Chef de produit en assurance, Directeur d\'agence d\'assurances, Conseiller en épargne et prévoyance',
 'master-assurances'),

-- ID 16
('ESMEA', 'Finances, Comptabilité, Audit', 'Master', '2 ans',
 'Spécialité Audit et Contrôle de Gestion. Formation avancée en audit financier, contrôle interne, reporting, pilotage de la performance et conseil. Secteurs : cabinets d\'audit (Big Four), directions financières, banques, administrations.',
 'Auditeur interne / externe, Contrôleur de gestion, Directeur administratif et financier (DAF), Responsable de la conformité (contrôle interne), Consultant en gestion financière, Analyste financier, Chef de mission d\'audit, Responsable du reporting consolidé',
 'master-finances-comptabilite-audit'),

-- ID 17
('ESMEA', 'Gestion des Ressources Humaines', 'Master', '2 ans',
 'Formation avancée en stratégie RH, recrutement, formation, gestion des carrières, relations sociales, droit du travail et transformation organisationnelle. Secteurs : industrie, services, banque, santé, administrations, cabinets de conseil RH.',
 'Responsable des ressources humaines (RRH), Chargé de recrutement / responsable talent acquisition, Responsable formation et développement, Responsable paie et administration du personnel, Consultant RH, Directeur des ressources humaines (DRH), Chargé de la GPEC',
 'master-grh'),

-- ID 18
('ESMEA', 'Marketing, Communication et Commerce', 'Master', '2 ans',
 'Deux spécialités : Marketing Communication (stratégies marketing et communication intégrées, médias sociaux, publicité) et Commerce International (opérations d\'export-import, logistique internationale, aspects juridiques et douaniers).',
 'Chef de produit / responsable marketing, Responsable communication, Directeur marketing et communication, Chef de projet digital, Social media manager, Responsable export / import, Chef de zone internationale, Acheteur international, Consultant en développement international',
 'master-marketing-communication-commerce'),

-- ID 19
('ESMEA', 'Transport et Logistique', 'Master', '2 ans',
 'Formation avancée pour optimiser les chaînes logistiques, gérer les flux physiques et informationnels, piloter la performance des transports multimodaux. Secteurs : transport, prestataires logistiques, supply chain, e-commerce, conseil.',
 'Directeur logistique / supply chain, Responsable transport, Responsable entrepôt / plateforme, Coordinateur de flux, Chef de projet logistique, Consultant en optimisation logistique, Responsable supply chain planning, Directeur des opérations logistiques',
 'master-transport-logistique'),

-- =================================================================
-- FILIÈRES — FSAE (Faculté des Sciences de l'Agronomie et de l'Environnement)
-- IDs filières : 20 à 24
-- =================================================================

-- ID 20
('FSAE', 'Gestion de l\'Environnement et Aménagement du Territoire', 'Licence', '3 ans',
 'Formation en gestion de l\'environnement et aménagement du territoire. Secteurs : administrations publiques (ministères de l\'environnement, collectivités territoriales), bureaux d\'études, ONG environnementales, aménagement urbain et rural, projets de développement durable.',
 'Chargé d\'études environnementales, Responsable en aménagement du territoire, Consultant en évaluation environnementale, Gestionnaire de ressources naturelles, Chargé de projet en développement durable, Responsable de protection de l\'environnement, Géomaticien (SIG)',
 'gestion-environnement-amenagement'),

-- ID 21
('FSAE', 'Production et Gestion des Ressources Animales', 'Licence', '3 ans',
 'Formation en zootechnie et gestion des ressources animales. Secteurs : élevage, industries agroalimentaires (viande, lait, œufs), services vétérinaires, projets de développement rural, organisations professionnelles agricoles, recherche agronomique.',
 'Ingénieur zootechnicien, Conseiller en élevage, Responsable d\'exploitation d\'élevage, Contrôleur de qualité des produits animaux, Technicien en insémination artificielle, Gestionnaire de programmes de santé animale, Chargé de projet en filières animales',
 'production-ressources-animales'),

-- ID 22
('FSAE', 'Sciences et Techniques de Production Végétale', 'Licence', '3 ans',
 'Formation en production végétale. Secteurs : agriculture (grandes cultures, maraîchage, arboriculture), semenciers, industries agroalimentaires, recherche agronomique, vulgarisation agricole, projets de développement rural.',
 'Ingénieur agronome, Chef de culture / responsable d\'exploitation agricole, Conseiller agricole / agent de vulgarisation, Technicien en production végétale, Responsable de pépinière, Chargé d\'expérimentation agricole, Gestionnaire de filières végétales',
 'production-vegetale'),

-- ID 23
('FSAE', 'Conservation et Conditionnement des Produits Agricoles', 'Licence', '3 ans',
 'Formation en conservation post-récolte et conditionnement. Secteurs : industries agroalimentaires, unités de transformation, entreprises de stockage et de logistique, laboratoires de contrôle qualité, services de normalisation, exportation de produits agricoles.',
 'Responsable qualité en agroalimentaire, Technicien en conservation post-récolte, Responsable de conditionnement et emballage, Contrôleur de conformité des produits agricoles, Gestionnaire de chaîne du froid, Consultant en sécurité sanitaire des aliments, Coordinateur logistique dans les filières agricoles',
 'conservation-conditionnement-agricole'),

-- ID 24
('FSAE', 'Gestion des Entreprises Rurales et Agricoles', 'Licence', '3 ans',
 'Formation en gestion des exploitations agricoles et des entreprises rurales. Secteurs : exploitations agricoles, coopératives, agro-industries, institutions de microfinance rurale, projets de développement, cabinets de conseil en gestion agricole.',
 'Gestionnaire d\'exploitation agricole, Responsable administratif et financier de coopérative, Conseiller en gestion d\'entreprise rurale, Chargé de projet en développement rural, Analyste de filières agricoles, Entrepreneur agricole, Responsable de crédit rural / microfinance agricole',
 'gestion-entreprises-rurales'),

-- =================================================================
-- FILIÈRES — FDE (Faculté de Droit et d'Économie)
-- IDs filières : 25 à 34
-- =================================================================

-- ID 25
('FDE', 'Droit', 'Licence', '3 ans',
 'Formation en droit couvrant : magistrature, barreau, administrations publiques, collectivités territoriales, entreprises privées, cabinets d\'avocats, institutions internationales, ONG, notariat, enseignement et recherche.',
 'Magistrat, Avocat, Notaire, Juriste d\'entreprise / conseiller juridique, Greffier, Officier de police judiciaire (cadre), Administrateur civil, Chargé d\'affaires juridiques, Responsable conformité réglementaire, Expert en droit de l\'environnement ou droit des affaires, Enseignant-chercheur en droit',
 'droit'),

-- ID 26
('FDE', 'Économie', 'Licence', '3 ans',
 'Formation en sciences économiques. Secteurs : administrations publiques (ministères des finances, de la planification), banques centrales, institutions financières, organisations internationales (Banque mondiale, FMI, PNUD), bureaux d\'études économiques, entreprises privées, cabinets de conseil.',
 'Économiste de banque centrale (BCEAO), Analyste économique / conjoncturiste, Chargé d\'études économiques, Économiste de la santé / de l\'environnement / du développement, Responsable de projets de développement, Consultant en politiques économiques, Statisticien-économiste (INSAE), Expert en commerce international',
 'economie'),

-- ID 27
('FDE', 'Droit des Technologies de l\'Information et de la Communication', 'Master', '2 ans',
 'Spécialité Droit Privé Fondamental. Secteurs : cabinets d\'avocats spécialisés, directions juridiques d\'entreprises (tech, télécoms), autorités de régulation (CIP, ARCEP), start-ups, ESN, institutions européennes.',
 'Juriste en droit du numérique / DPO, Avocat spécialisé en technologies, Responsable conformité (RGPD, cybersécurité), Consultant en droit des TIC, Juriste en propriété intellectuelle',
 'master-droit-tic'),

-- ID 28
('FDE', 'Professions Judiciaires', 'Master', '2 ans',
 'Spécialité Droit Privé Fondamental. Secteurs : magistrature, greffes, ministère de la Justice, écoles professionnelles.',
 'Magistrat, Greffier en chef / greffier, Directeur des services de greffe judiciaire, Juriste assistant de magistrat',
 'master-professions-judiciaires'),

-- ID 29
('FDE', 'Fiscalité et Droit des Affaires', 'Master', '2 ans',
 'Spécialité Droit Privé Fondamental. Secteurs : cabinets d\'avocats d\'affaires, directions fiscales et juridiques, cabinets d\'expertise comptable, administrations fiscales, conseil en patrimoine.',
 'Avocat fiscaliste / en droit des affaires, Juriste fiscal d\'entreprise, Inspecteur des impôts (cadre), Consultant en fiscalité, Conseiller en gestion de patrimoine',
 'master-fiscalite-droit-affaires'),

-- ID 30
('FDE', 'Juriste d\'Entreprises et d\'Affaires', 'Master', '2 ans',
 'Spécialité Droit Privé Fondamental. Secteurs : directions juridiques d\'entreprises (industrielles, commerciales, financières), cabinets d\'avocats, cabinets de conseil, organismes de régulation.',
 'Juriste d\'entreprise / juriste d\'affaires, Responsable juridique, Chargé des contrats / compliance officer, Avocat en droit des affaires, Secrétaire général de société',
 'master-juriste-entreprises'),

-- ID 31
('FDE', 'Droit de l\'Homme et Droit Humanitaire', 'Master', '2 ans',
 'Spécialité Droit Public Fondamental. Secteurs : organisations internationales (ONU, UA, CEDEAO), ONG de défense des droits humains, administrations publiques, institutions nationales des droits de l\'homme, barreaux, enseignement.',
 'Juriste en droits humains, Chargé de plaidoyer (advocacy), Consultant en droit humanitaire, Collaborateur d\'institutions internationales, Avocat spécialisé en contentieux des droits fondamentaux',
 'master-droit-homme-humanitaire'),

-- ID 32
('FDE', 'Droit de l\'Environnement et de l\'Urbanisme', 'Master', '2 ans',
 'Spécialité Droit Public Fondamental. Secteurs : ministères (Environnement, Urbanisme), collectivités territoriales, agences d\'urbanisme, bureaux d\'études, entreprises BTP et énergies, cabinets d\'avocats spécialisés.',
 'Juriste en droit de l\'environnement, Responsable affaires réglementaires (développement durable), Consultant en droit de l\'urbanisme, Chargé des études d\'impact environnemental, Avocat en droit public / droit de l\'environnement',
 'master-droit-environnement-urbanisme');


-- =================================================================
-- MÉTIERS
-- Ordre d'insertion et IDs séquentiels (auto_increment depuis 1)
-- =================================================================

-- ---------------------------------------------------------------
-- EGEI — IDs 1 à 37
-- ---------------------------------------------------------------
INSERT INTO `metiers` (`nom_metier`, `slug`) VALUES
-- Électronique (Licence) — IDs 1 à 6
('Ingénieur en conception électronique', 'ingenieur-conception-electronique'),           -- 1
('Ingénieur en systèmes embarqués', 'ingenieur-systemes-embarques'),                     -- 2
('Ingénieur en circuits intégrés (ASIC/FPGA)', 'ingenieur-circuits-integres'),           -- 3
('Ingénieur en instrumentation et mesure', 'ingenieur-instrumentation-mesure'),          -- 4
('Responsable de projets électroniques', 'responsable-projets-electroniques'),           -- 5
('Ingénieur en CEM', 'ingenieur-cem'),                                                   -- 6

-- Génie Télécoms et TIC (Licence & Master) — IDs 7 à 14
('Ingénieur réseaux et télécoms', 'ingenieur-reseaux-telecoms'),                         -- 7
('Ingénieur en cybersécurité', 'ingenieur-cybersecurite'),                               -- 8
('Architecte des systèmes d\'information', 'architecte-systemes-information'),           -- 9
('Ingénieur en infrastructure cloud et virtualisation', 'ingenieur-cloud-virtualisation'), -- 10
('Administrateur de bases de données et réseaux', 'administrateur-bdd-reseaux'),         -- 11
('Consultant en transformation numérique', 'consultant-transformation-numerique'),       -- 12
('Architecte réseau (LAN/WAN, SD-WAN, 5G)', 'architecte-reseau'),                        -- 13
('Ingénieur radiofréquences (RF) et réseaux mobiles', 'ingenieur-rf-reseaux-mobiles'),  -- 14

-- Informatique Industrielle et Maintenance (Licence) — IDs 15 à 20
('Ingénieur en automatisme et supervision', 'ingenieur-automatisme-supervision'),        -- 15
('Ingénieur de maintenance industrielle', 'ingenieur-maintenance-industrielle'),         -- 16
('Ingénieur en informatique industrielle', 'ingenieur-informatique-industrielle'),       -- 17
('Responsable GMAO', 'responsable-gmao'),                                                -- 18
('Ingénieur en supervision SCADA', 'ingenieur-scada'),                                   -- 19
('Ingénieur en fiabilité et sûreté de fonctionnement', 'ingenieur-fiabilite'),           -- 20

-- Système Industriel (Licence & Master) — IDs 21 à 27
('Ingénieur en organisation et gestion de production', 'ingenieur-gestion-production'), -- 21
('Ingénieur en logistique et supply chain', 'ingenieur-logistique-supply-chain'),        -- 22
('Ingénieur en amélioration continue (Lean Six Sigma)', 'ingenieur-lean-six-sigma'),     -- 23
('Responsable d\'unité industrielle', 'responsable-unite-industrielle'),                 -- 24
('Ingénieur en pilotage de systèmes industriels', 'ingenieur-pilotage-systemes'),        -- 25
('Chef de projet industriel', 'chef-projet-industriel'),                                 -- 26
('Responsable de planning et ordonnancement', 'responsable-planning-ordonnancement'),   -- 27

-- Électrotechnique (Licence) — IDs 28 à 33
('Ingénieur en conception et exploitation des réseaux électriques', 'ingenieur-reseaux-electriques'), -- 28
('Ingénieur en énergies renouvelables', 'ingenieur-energies-renouvelables'),             -- 29
('Chargé d\'affaires en génie électrique', 'charge-affaires-genie-electrique'),          -- 30
('Ingénieur en maintenance des équipements électriques', 'ingenieur-maintenance-electrique'), -- 31
('Ingénieur en efficacité énergétique', 'ingenieur-efficacite-energetique'),             -- 32
('Chef de projet électrique', 'chef-projet-electrique'),                                 -- 33

-- Master Électronique, Automatique et Système de Production — IDs 34 à 37
('Ingénieur en robotique industrielle', 'ingenieur-robotique-industrielle'),             -- 34
('Concepteur de cartes électroniques et FPGA', 'concepteur-cartes-fpga'),                -- 35
('Ingénieur en contrôle-commande', 'ingenieur-controle-commande'),                       -- 36
('Architecte de systèmes de production connectés', 'architecte-systemes-production'),   -- 37

-- ---------------------------------------------------------------
-- ESMEA — IDs 38 à 82
-- ---------------------------------------------------------------

-- Banques, Finances et Assurances (Licence) — IDs 38 à 46
('Gestionnaire sinistres', 'gestionnaire-sinistres'),                                    -- 38
('Souscripteur en assurances', 'souscripteur-assurances'),                               -- 39
('Chargé de clientèle en assurances', 'charge-clientele-assurances'),                   -- 40
('Inspecteur d\'assurances', 'inspecteur-assurances'),                                   -- 41
('Expert en évaluation des risques', 'expert-evaluation-risques'),                       -- 42
('Conseiller en prévoyance et épargne', 'conseiller-prevoyance-epargne'),               -- 43
('Chargé de clientèle banque', 'charge-clientele-banque'),                               -- 44
('Trésorier d\'entreprise', 'tresorier-entreprise'),                                     -- 45
('Analyste crédit', 'analyste-credit'),                                                  -- 46

-- Finances, Comptabilité, Audit (Licence & Master) — IDs 47 à 54
('Auditeur interne / externe', 'auditeur-interne-externe'),                              -- 47
('Contrôleur de gestion', 'controleur-gestion'),                                         -- 48
('Analyste financier', 'analyste-financier'),                                            -- 49
('Directeur administratif et financier (DAF)', 'directeur-administratif-financier'),    -- 50
('Expert-comptable', 'expert-comptable'),                                                -- 51
('Consultant en management financier', 'consultant-management-financier'),               -- 52
('Responsable de la conformité (contrôle interne)', 'responsable-conformite'),          -- 53
('Chef de mission d\'audit', 'chef-mission-audit'),                                      -- 54

-- Gestion des Ressources Humaines (Licence & Master) — IDs 55 à 63
('Chargé de recrutement', 'charge-recrutement'),                                         -- 55
('Responsable paie et administration du personnel', 'responsable-paie'),                -- 56
('Gestionnaire de carrières', 'gestionnaire-carrieres'),                                 -- 57
('Responsable formation', 'responsable-formation'),                                      -- 58
('Chargé des relations sociales', 'charge-relations-sociales'),                          -- 59
('Responsable développement RH', 'responsable-developpement-rh'),                       -- 60
('Consultant RH', 'consultant-rh'),                                                      -- 61
('Directeur des ressources humaines (DRH)', 'directeur-rh'),                             -- 62
('Chargé de la GPEC', 'charge-gpec'),                                                    -- 63

-- Marketing, Communication et Commerce (Licence & Master) — IDs 64 à 76
('Chargé d\'affaires', 'charge-affaires'),                                               -- 64
('Chef des ventes', 'chef-ventes'),                                                      -- 65
('Directeur commercial', 'directeur-commercial'),                                        -- 66
('Responsable développement commercial', 'responsable-developpement-commercial'),       -- 67
('Chef de projet en communication', 'chef-projet-communication'),                        -- 68
('Responsable communication', 'responsable-communication'),                              -- 69
('Community manager / Social media manager', 'community-manager'),                       -- 70
('Concepteur rédacteur', 'concepteur-redacteur'),                                        -- 71
('Directeur artistique', 'directeur-artistique'),                                        -- 72
('Chargé des relations presse', 'charge-relations-presse'),                              -- 73
('Acheteur / Approvisionneur', 'acheteur-approvisionneur'),                              -- 74
('Responsable e-commerce', 'responsable-e-commerce'),                                   -- 75
('Responsable export', 'responsable-export'),                                            -- 76

-- Système Informatique et Logiciel (Licence) — IDs 77 à 83
('Analyste fonctionnel', 'analyste-fonctionnel'),                                        -- 77
('Chef de projet informatique', 'chef-projet-informatique'),                             -- 78
('Administrateur de bases de données', 'administrateur-bdd'),                            -- 79
('Responsable ERP (SAP, Oracle)', 'responsable-erp'),                                    -- 80
('Consultant en systèmes d\'information', 'consultant-si'),                              -- 81
('Directeur des systèmes d\'information (DSI)', 'directeur-si'),                         -- 82
('Développeur d\'applications de gestion', 'developpeur-applications-gestion'),         -- 83

-- Transport et Logistique (Licence & Master) — IDs 84 à 91
('Responsable logistique', 'responsable-logistique'),                                    -- 84
('Gestionnaire de transport', 'gestionnaire-transport'),                                 -- 85
('Coordinateur supply chain', 'coordinateur-supply-chain'),                              -- 86
('Responsable entrepôt / plateforme', 'responsable-entrepot'),                          -- 87
('Planificateur de flux', 'planificateur-flux'),                                         -- 88
('Chef de projet logistique', 'chef-projet-logistique'),                                 -- 89
('Gestionnaire de douane et transit', 'gestionnaire-douane-transit'),                   -- 90
('Directeur logistique / supply chain', 'directeur-logistique'),                         -- 91

-- Master Assurances (spécifique) — IDs 92 à 94
('Souscripteur senior', 'souscripteur-senior'),                                          -- 92
('Chef de produit en assurance', 'chef-produit-assurance'),                              -- 93
('Directeur d\'agence d\'assurances', 'directeur-agence-assurances'),                   -- 94

-- Master Marketing/Communication — IDs 95 à 97
('Chef de produit / responsable marketing', 'chef-produit-marketing'),                  -- 95
('Planneur stratégique', 'planneur-strategique'),                                        -- 96
('Chef de zone internationale', 'chef-zone-internationale'),                             -- 97

-- ---------------------------------------------------------------
-- FSAE — IDs 98 à 119
-- ---------------------------------------------------------------

-- Gestion Environnement et Aménagement (Licence) — IDs 98 à 104
('Chargé d\'études environnementales', 'charge-etudes-environnementales'),               -- 98
('Responsable en aménagement du territoire', 'responsable-amenagement-territoire'),     -- 99
('Consultant en évaluation environnementale', 'consultant-evaluation-environnementale'), -- 100
('Gestionnaire de ressources naturelles', 'gestionnaire-ressources-naturelles'),         -- 101
('Chargé de projet en développement durable', 'charge-projet-developpement-durable'),  -- 102
('Responsable de protection de l\'environnement', 'responsable-protection-environnement'), -- 103
('Géomaticien (SIG)', 'geomaticien-sig'),                                                -- 104

-- Production et Gestion des Ressources Animales (Licence) — IDs 105 à 111
('Ingénieur zootechnicien', 'ingenieur-zootechnicien'),                                  -- 105
('Conseiller en élevage', 'conseiller-elevage'),                                         -- 106
('Responsable d\'exploitation d\'élevage', 'responsable-exploitation-elevage'),         -- 107
('Contrôleur de qualité des produits animaux', 'controleur-qualite-animaux'),           -- 108
('Technicien en insémination artificielle', 'technicien-insemination-artificielle'),    -- 109
('Gestionnaire de programmes de santé animale', 'gestionnaire-sante-animale'),          -- 110
('Chargé de projet en filières animales', 'charge-projet-filieres-animales'),           -- 111

-- Sciences et Techniques de Production Végétale (Licence) — IDs 112 à 118
('Ingénieur agronome', 'ingenieur-agronome'),                                            -- 112
('Chef de culture / responsable d\'exploitation agricole', 'chef-culture-exploitation'), -- 113
('Conseiller agricole / agent de vulgarisation', 'conseiller-agricole'),                -- 114
('Technicien en production végétale', 'technicien-production-vegetale'),                -- 115
('Responsable de pépinière', 'responsable-pepiniere'),                                  -- 116
('Chargé d\'expérimentation agricole', 'charge-experimentation-agricole'),              -- 117
('Gestionnaire de filières végétales', 'gestionnaire-filieres-vegetales'),              -- 118

-- Conservation et Conditionnement (Licence) — IDs 119 à 125
('Responsable qualité en agroalimentaire', 'responsable-qualite-agroalimentaire'),      -- 119
('Technicien en conservation post-récolte', 'technicien-conservation-post-recolte'),   -- 120
('Responsable de conditionnement et emballage', 'responsable-conditionnement'),         -- 121
('Contrôleur de conformité des produits agricoles', 'controleur-conformite-agricole'), -- 122
('Gestionnaire de chaîne du froid', 'gestionnaire-chaine-froid'),                       -- 123
('Consultant en sécurité sanitaire des aliments', 'consultant-securite-sanitaire'),     -- 124
('Coordinateur logistique dans les filières agricoles', 'coordinateur-logistique-agricole'), -- 125

-- Gestion des Entreprises Rurales et Agricoles (Licence) — IDs 126 à 132
('Gestionnaire d\'exploitation agricole', 'gestionnaire-exploitation-agricole'),        -- 126
('Responsable administratif et financier de coopérative', 'responsable-af-cooperative'), -- 127
('Conseiller en gestion d\'entreprise rurale', 'conseiller-gestion-rurale'),            -- 128
('Chargé de projet en développement rural', 'charge-projet-developpement-rural'),      -- 129
('Analyste de filières agricoles', 'analyste-filieres-agricoles'),                      -- 130
('Entrepreneur agricole', 'entrepreneur-agricole'),                                      -- 131
('Responsable de crédit rural / microfinance agricole', 'responsable-credit-rural'),    -- 132

-- ---------------------------------------------------------------
-- FDE — IDs 133 à 162
-- ---------------------------------------------------------------

-- Droit (Licence) — IDs 133 à 143
('Magistrat', 'magistrat'),                                                              -- 133
('Avocat', 'avocat'),                                                                    -- 134
('Notaire', 'notaire'),                                                                  -- 135
('Juriste d\'entreprise / conseiller juridique', 'juriste-entreprise'),                 -- 136
('Greffier', 'greffier'),                                                                -- 137
('Officier de police judiciaire (cadre)', 'officier-police-judiciaire'),                -- 138
('Administrateur civil', 'administrateur-civil'),                                        -- 139
('Chargé d\'affaires juridiques', 'charge-affaires-juridiques'),                        -- 140
('Responsable conformité réglementaire', 'responsable-conformite-reglementaire'),       -- 141
('Expert en droit des affaires', 'expert-droit-affaires'),                              -- 142
('Enseignant-chercheur en droit', 'enseignant-chercheur-droit'),                        -- 143

-- Économie (Licence) — IDs 144 à 151
('Économiste de banque centrale', 'economiste-banque-centrale'),                         -- 144
('Analyste économique / conjoncturiste', 'analyste-economique'),                         -- 145
('Chargé d\'études économiques', 'charge-etudes-economiques'),                          -- 146
('Économiste du développement', 'economiste-developpement'),                             -- 147
('Responsable de projets de développement', 'responsable-projets-developpement'),       -- 148
('Consultant en politiques économiques', 'consultant-politiques-economiques'),           -- 149
('Statisticien-économiste', 'statisticien-economiste'),                                  -- 150
('Expert en commerce international', 'expert-commerce-international'),                  -- 151

-- Master Droit des TIC — IDs 152 à 154
('Juriste en droit du numérique / DPO', 'juriste-droit-numerique-dpo'),                 -- 152
('Avocat spécialisé en technologies', 'avocat-technologies'),                            -- 153
('Juriste en propriété intellectuelle', 'juriste-propriete-intellectuelle'),             -- 154

-- Master Professions Judiciaires — IDs 155 à 157
('Greffier en chef', 'greffier-en-chef'),                                                -- 155
('Directeur des services de greffe judiciaire', 'directeur-services-greffe'),           -- 156
('Juriste assistant de magistrat', 'juriste-assistant-magistrat'),                       -- 157

-- Master Fiscalité et Droit des Affaires — IDs 158 à 160
('Avocat fiscaliste / en droit des affaires', 'avocat-fiscaliste'),                      -- 158
('Juriste fiscal d\'entreprise', 'juriste-fiscal'),                                      -- 159
('Consultant en fiscalité', 'consultant-fiscalite'),                                     -- 160

-- Master Juriste d'Entreprises et d'Affaires — IDs 161 à 163
('Compliance officer / chargé des contrats', 'compliance-officer'),                     -- 161
('Secrétaire général de société', 'secretaire-general-societe'),                        -- 162
('Responsable juridique', 'responsable-juridique'),                                      -- 163

-- Master Droit de l'Homme et Humanitaire — IDs 164 à 166
('Juriste en droits humains', 'juriste-droits-humains'),                                 -- 164
('Chargé de plaidoyer (advocacy)', 'charge-plaidoyer'),                                  -- 165
('Consultant en droit humanitaire', 'consultant-droit-humanitaire'),                     -- 166

-- Master Droit de l'Environnement et de l'Urbanisme — IDs 167 à 170
('Juriste en droit de l\'environnement', 'juriste-droit-environnement'),                -- 167
('Responsable affaires réglementaires (développement durable)', 'responsable-affaires-reglementaires'), -- 168
('Consultant en droit de l\'urbanisme', 'consultant-droit-urbanisme'),                  -- 169
('Chargé des études d\'impact environnemental', 'charge-etude-impact-environnemental'), -- 170

-- ---------------------------------------------------------------
-- MÉTIERS GÉNÉRIQUES / TRANSVERSAUX — IDs 171 à 182
-- ---------------------------------------------------------------
('Entrepreneur', 'entrepreneur'),                                                        -- 171
('Chercheur / Enseignant-chercheur', 'chercheur-enseignant'),                            -- 172
('Consultant en développement durable', 'consultant-developpement-durable'),             -- 173
('Chef de projet (générique)', 'chef-projet-generique'),                                 -- 174
('Chargé de projet développement international', 'charge-projet-developpement-international'), -- 175
('Responsable RSE', 'responsable-rse'),                                                  -- 176
('Gestionnaire de patrimoine', 'gestionnaire-patrimoine'),                               -- 177
('Directeur général / CEO', 'directeur-general'),                                        -- 178
('Chargé de mission ONG / organisation internationale', 'charge-mission-ong'),          -- 179
('Coordinateur de projets de développement rural', 'coordinateur-projets-ruraux'),      -- 180
('Inspecteur d\'assurances', 'inspecteur-assurances-generique'),                        -- 181
('Responsable de portefeuille', 'responsable-portefeuille'),                             -- 182
('Ingénieur de données', 'ingenieur-donnees');                               -- 183


-- =================================================================
-- CORRESPONDANCES Métiers ↔ Filières
-- Rappel des IDs filières :
--  EGEI  : 1=Électronique(L), 2=TélécomsL, 3=InfoIndus(L), 4=SysIndus(L), 5=Électrotech(L)
--           6=MasterSysIndus, 7=MasterEASP, 8=MasterTélécoms
--  ESMEA : 9=BFA(L), 10=FCA(L), 11=GRH(L), 12=MCC(L), 13=SIL(L), 14=Transport(L)
--           15=MasterAssur, 16=MasterFCA, 17=MasterGRH, 18=MasterMCC, 19=MasterTransport
--  FSAE  : 20=EnvAménagt(L), 21=RessAnim(L), 22=ProdVégét(L), 23=ConservAgri(L), 24=EntRurales(L)
--  FDE   : 25=Droit(L), 26=Économie(L), 27=MasterDroitTIC, 28=MasterProfJudic,
--           29=MasterFiscalité, 30=MasterJuristeAffaires, 31=MasterDroitHomme, 32=MasterDroitEnvUrba
-- (priorite : 1 = recommandation principale, 2 = alternative, 3 = possible)
-- =================================================================

INSERT INTO `metiers_filieres` (`metier_id`, `filiere_id`, `priorite`) VALUES

-- ---------------------------------------------------------------
-- EGEI
-- ---------------------------------------------------------------
-- 1 Ingénieur en conception électronique
(1, 1, 1), (1, 7, 2),
-- 2 Ingénieur en systèmes embarqués
(2, 1, 1), (2, 7, 2),
-- 3 Ingénieur en circuits intégrés (ASIC/FPGA)
(3, 1, 1), (3, 7, 2),
-- 4 Ingénieur en instrumentation et mesure
(4, 1, 1), (4, 3, 2),
-- 5 Responsable de projets électroniques
(5, 1, 1), (5, 7, 2),
-- 6 Ingénieur en CEM
(6, 1, 1),
-- 7 Ingénieur réseaux et télécoms
(7, 2, 1), (7, 8, 2),
-- 8 Ingénieur en cybersécurité
(8, 8, 1), (8, 2, 2),
-- 9 Architecte des systèmes d'information
(9, 8, 1), (9, 2, 2),
-- 10 Ingénieur en infrastructure cloud et virtualisation
(10, 8, 1), (10, 2, 2),
-- 11 Administrateur de bases de données et réseaux
(11, 2, 1), (11, 8, 2),
-- 12 Consultant en transformation numérique
(12, 8, 1), (12, 2, 2),
-- 13 Architecte réseau
(13, 8, 1),
-- 14 Ingénieur radiofréquences (RF)
(14, 8, 1),
-- 15 Ingénieur en automatisme et supervision
(15, 3, 1), (15, 7, 2),
-- 16 Ingénieur de maintenance industrielle
(16, 3, 1),
-- 17 Ingénieur en informatique industrielle
(17, 3, 1), (17, 7, 2),
-- 18 Responsable GMAO
(18, 3, 1), (18, 4, 2),
-- 19 Ingénieur en supervision SCADA
(19, 3, 1), (19, 7, 2),
-- 20 Ingénieur en fiabilité et sûreté
(20, 3, 1), (20, 4, 2),
-- 21 Ingénieur en organisation et gestion de production
(21, 4, 1), (21, 6, 2),
-- 22 Ingénieur en logistique et supply chain
(22, 4, 1), (22, 6, 2),
-- 23 Ingénieur en amélioration continue (Lean Six Sigma)
(23, 6, 1), (23, 4, 2),
-- 24 Responsable d'unité industrielle
(24, 6, 1), (24, 4, 2),
-- 25 Ingénieur en pilotage de systèmes industriels
(25, 4, 1), (25, 6, 2),
-- 26 Chef de projet industriel
(26, 6, 1), (26, 4, 2), (26, 7, 3),
-- 27 Responsable de planning et ordonnancement
(27, 6, 1),
-- 28 Ingénieur en conception et exploitation des réseaux électriques
(28, 5, 1),
-- 29 Ingénieur en énergies renouvelables
(29, 5, 1),
-- 30 Chargé d'affaires en génie électrique
(30, 5, 1),
-- 31 Ingénieur en maintenance des équipements électriques
(31, 5, 1), (31, 3, 2),
-- 32 Ingénieur en efficacité énergétique
(32, 5, 1),
-- 33 Chef de projet électrique
(33, 5, 1),
-- 34 Ingénieur en robotique industrielle
(34, 7, 1), (34, 3, 2),
-- 35 Concepteur de cartes électroniques et FPGA
(35, 7, 1), (35, 1, 2),
-- 36 Ingénieur en contrôle-commande
(36, 7, 1), (36, 3, 2),
-- 37 Architecte de systèmes de production connectés
(37, 7, 1), (37, 6, 2),

-- ---------------------------------------------------------------
-- ESMEA
-- ---------------------------------------------------------------
-- 38 Gestionnaire sinistres
(38, 9, 1), (38, 15, 2),
-- 39 Souscripteur en assurances
(39, 9, 1), (39, 15, 2),
-- 40 Chargé de clientèle en assurances
(40, 9, 1),
-- 41 Inspecteur d'assurances
(41, 9, 1), (41, 15, 2),
-- 42 Expert en évaluation des risques
(42, 15, 1), (42, 9, 2),
-- 43 Conseiller en prévoyance et épargne
(43, 9, 1), (43, 15, 2),
-- 44 Chargé de clientèle banque
(44, 9, 1),
-- 45 Trésorier d'entreprise
(45, 9, 1), (45, 10, 2),
-- 46 Analyste crédit
(46, 9, 1), (46, 10, 2),
-- 47 Auditeur interne / externe
(47, 10, 1), (47, 16, 2),
-- 48 Contrôleur de gestion
(48, 10, 1), (48, 16, 2),
-- 49 Analyste financier
(49, 10, 1), (49, 9, 2),
-- 50 Directeur administratif et financier (DAF)
(50, 16, 1), (50, 10, 2),
-- 51 Expert-comptable
(51, 10, 1), (51, 16, 2),
-- 52 Consultant en management financier
(52, 16, 1), (52, 10, 2),
-- 53 Responsable de la conformité (contrôle interne)
(53, 16, 1), (53, 10, 2),
-- 54 Chef de mission d'audit
(54, 16, 1),
-- 55 Chargé de recrutement
(55, 11, 1), (55, 17, 2),
-- 56 Responsable paie et administration du personnel
(56, 11, 1), (56, 17, 2),
-- 57 Gestionnaire de carrières
(57, 11, 1), (57, 17, 2),
-- 58 Responsable formation
(58, 17, 1), (58, 11, 2),
-- 59 Chargé des relations sociales
(59, 11, 1), (59, 17, 2),
-- 60 Responsable développement RH
(60, 17, 1), (60, 11, 2),
-- 61 Consultant RH
(61, 17, 1), (61, 11, 2),
-- 62 Directeur des ressources humaines (DRH)
(62, 17, 1), (62, 11, 2),
-- 63 Chargé de la GPEC
(63, 17, 1),
-- 64 Chargé d'affaires
(64, 12, 1),
-- 65 Chef des ventes
(65, 12, 1), (65, 18, 2),
-- 66 Directeur commercial
(66, 18, 1), (66, 12, 2),
-- 67 Responsable développement commercial
(67, 12, 1), (67, 18, 2),
-- 68 Chef de projet en communication
(68, 12, 1), (68, 18, 2),
-- 69 Responsable communication
(69, 18, 1), (69, 12, 2),
-- 70 Community manager / Social media manager
(70, 12, 1), (70, 18, 2),
-- 71 Concepteur rédacteur
(71, 12, 1),
-- 72 Directeur artistique
(72, 12, 1),
-- 73 Chargé des relations presse
(73, 12, 1), (73, 18, 2),
-- 74 Acheteur / Approvisionneur
(74, 12, 1), (74, 19, 2),
-- 75 Responsable e-commerce
(75, 12, 1), (75, 18, 2),
-- 76 Responsable export
(76, 18, 1), (76, 19, 2),
-- 77 Analyste fonctionnel
(77, 13, 1),
-- 78 Chef de projet informatique
(78, 13, 1),
-- 79 Administrateur de bases de données
(79, 13, 1),
-- 80 Responsable ERP (SAP, Oracle)
(80, 13, 1),
-- 81 Consultant en systèmes d'information
(81, 13, 1),
-- 82 Directeur des systèmes d'information (DSI)
(82, 13, 1),
-- 83 Développeur d'applications de gestion
(83, 13, 1),
-- 84 Responsable logistique
(84, 14, 1), (84, 19, 2),
-- 85 Gestionnaire de transport
(85, 14, 1), (85, 19, 2),
-- 86 Coordinateur supply chain
(86, 14, 1), (86, 19, 2),
-- 87 Responsable entrepôt / plateforme
(87, 14, 1), (87, 19, 2),
-- 88 Planificateur de flux
(88, 14, 1), (88, 19, 2),
-- 89 Chef de projet logistique
(89, 19, 1), (89, 14, 2),
-- 90 Gestionnaire de douane et transit
(90, 14, 1),
-- 91 Directeur logistique / supply chain
(91, 19, 1), (91, 14, 2),
-- 92 Souscripteur senior
(92, 15, 1),
-- 93 Chef de produit en assurance
(93, 15, 1),
-- 94 Directeur d'agence d'assurances
(94, 15, 1),
-- 95 Chef de produit / responsable marketing
(95, 18, 1), (95, 12, 2),
-- 96 Planneur stratégique
(96, 18, 1), (96, 12, 2),
-- 97 Chef de zone internationale
(97, 18, 1),

-- ---------------------------------------------------------------
-- FSAE
-- ---------------------------------------------------------------
-- 98 Chargé d'études environnementales
(98, 20, 1),
-- 99 Responsable en aménagement du territoire
(99, 20, 1),
-- 100 Consultant en évaluation environnementale
(100, 20, 1),
-- 101 Gestionnaire de ressources naturelles
(101, 20, 1),
-- 102 Chargé de projet en développement durable
(102, 20, 1), (102, 24, 2),
-- 103 Responsable de protection de l'environnement
(103, 20, 1),
-- 104 Géomaticien (SIG)
(104, 20, 1),
-- 105 Ingénieur zootechnicien
(105, 21, 1),
-- 106 Conseiller en élevage
(106, 21, 1),
-- 107 Responsable d'exploitation d'élevage
(107, 21, 1),
-- 108 Contrôleur de qualité des produits animaux
(108, 21, 1), (108, 23, 2),
-- 109 Technicien en insémination artificielle
(109, 21, 1),
-- 110 Gestionnaire de programmes de santé animale
(110, 21, 1),
-- 111 Chargé de projet en filières animales
(111, 21, 1), (111, 24, 2),
-- 112 Ingénieur agronome
(112, 22, 1), (112, 24, 2),
-- 113 Chef de culture / responsable d'exploitation agricole
(113, 22, 1), (113, 24, 2),
-- 114 Conseiller agricole / agent de vulgarisation
(114, 22, 1),
-- 115 Technicien en production végétale
(115, 22, 1),
-- 116 Responsable de pépinière
(116, 22, 1),
-- 117 Chargé d'expérimentation agricole
(117, 22, 1),
-- 118 Gestionnaire de filières végétales
(118, 22, 1), (118, 24, 2),
-- 119 Responsable qualité en agroalimentaire
(119, 23, 1),
-- 120 Technicien en conservation post-récolte
(120, 23, 1),
-- 121 Responsable de conditionnement et emballage
(121, 23, 1),
-- 122 Contrôleur de conformité des produits agricoles
(122, 23, 1),
-- 123 Gestionnaire de chaîne du froid
(123, 23, 1),
-- 124 Consultant en sécurité sanitaire des aliments
(124, 23, 1),
-- 125 Coordinateur logistique dans les filières agricoles
(125, 23, 1), (125, 24, 2),
-- 126 Gestionnaire d'exploitation agricole
(126, 24, 1),
-- 127 Responsable administratif et financier de coopérative
(127, 24, 1),
-- 128 Conseiller en gestion d'entreprise rurale
(128, 24, 1),
-- 129 Chargé de projet en développement rural
(129, 24, 1), (129, 20, 2),
-- 130 Analyste de filières agricoles
(130, 24, 1), (130, 22, 2),
-- 131 Entrepreneur agricole
(131, 24, 1),
-- 132 Responsable de crédit rural / microfinance agricole
(132, 24, 1),

-- ---------------------------------------------------------------
-- FDE
-- ---------------------------------------------------------------
-- 133 Magistrat
(133, 25, 1), (133, 28, 2),
-- 134 Avocat
(134, 25, 1), (134, 30, 2),
-- 135 Notaire
(135, 25, 1), (135, 29, 2),
-- 136 Juriste d'entreprise / conseiller juridique
(136, 30, 1), (136, 25, 2),
-- 137 Greffier
(137, 25, 1), (137, 28, 2),
-- 138 Officier de police judiciaire (cadre)
(138, 25, 1),
-- 139 Administrateur civil
(139, 25, 1),
-- 140 Chargé d'affaires juridiques
(140, 25, 1), (140, 30, 2),
-- 141 Responsable conformité réglementaire
(141, 30, 1), (141, 27, 2),
-- 142 Expert en droit des affaires
(142, 29, 1), (142, 30, 2),
-- 143 Enseignant-chercheur en droit
(143, 25, 1),
-- 144 Économiste de banque centrale
(144, 26, 1),
-- 145 Analyste économique / conjoncturiste
(145, 26, 1),
-- 146 Chargé d'études économiques
(146, 26, 1),
-- 147 Économiste du développement
(147, 26, 1),
-- 148 Responsable de projets de développement
(148, 26, 1), (148, 24, 2),
-- 149 Consultant en politiques économiques
(149, 26, 1),
-- 150 Statisticien-économiste
(150, 26, 1),
-- 151 Expert en commerce international
(151, 26, 1), (151, 18, 2),
-- 152 Juriste en droit du numérique / DPO
(152, 27, 1), (152, 25, 2),
-- 153 Avocat spécialisé en technologies
(153, 27, 1),
-- 154 Juriste en propriété intellectuelle
(154, 27, 1),
-- 155 Greffier en chef
(155, 28, 1),
-- 156 Directeur des services de greffe judiciaire
(156, 28, 1),
-- 157 Juriste assistant de magistrat
(157, 28, 1), (157, 25, 2),
-- 158 Avocat fiscaliste / en droit des affaires
(158, 29, 1),
-- 159 Juriste fiscal d'entreprise
(159, 29, 1),
-- 160 Consultant en fiscalité
(160, 29, 1),
-- 161 Compliance officer / chargé des contrats
(161, 30, 1), (161, 27, 2),
-- 162 Secrétaire général de société
(162, 30, 1),
-- 163 Responsable juridique
(163, 30, 1), (163, 25, 2),
-- 164 Juriste en droits humains
(164, 31, 1),
-- 165 Chargé de plaidoyer (advocacy)
(165, 31, 1),
-- 166 Consultant en droit humanitaire
(166, 31, 1),
-- 167 Juriste en droit de l'environnement
(167, 32, 1), (167, 20, 2),
-- 168 Responsable affaires réglementaires (développement durable)
(168, 32, 1), (168, 20, 2),
-- 169 Consultant en droit de l'urbanisme
(169, 32, 1),
-- 170 Chargé des études d'impact environnemental
(170, 32, 1), (170, 20, 2),

-- ---------------------------------------------------------------
-- MÉTIERS GÉNÉRIQUES / TRANSVERSAUX
-- ---------------------------------------------------------------
-- 171 Entrepreneur
(171, 12, 1), (171, 24, 2), (171, 10, 3),
-- 172 Chercheur / Enseignant-chercheur
(172, 26, 1), (172, 25, 2), (172, 22, 3),
-- 173 Consultant en développement durable
(173, 20, 1), (173, 32, 2),
-- 174 Chef de projet (générique)
(174, 6, 1), (174, 19, 2), (174, 17, 3),
-- 175 Chargé de projet développement international
(175, 18, 1), (175, 26, 2), (175, 31, 3),
-- 176 Responsable RSE
(176, 20, 1), (176, 32, 2), (176, 11, 3),
-- 177 Gestionnaire de patrimoine
(177, 9, 1), (177, 16, 2),
-- 178 Directeur général / CEO
(178, 18, 1), (178, 17, 2), (178, 16, 3),
-- 179 Chargé de mission ONG / organisation internationale
(179, 31, 1), (179, 20, 2), (179, 26, 3),
-- 180 Coordinateur de projets de développement rural
(180, 24, 1), (180, 20, 2),
-- 181 Inspecteur d'assurances
(181, 15, 1), (181, 9, 2),
-- 182 Responsable de portefeuille
(182, 15, 1), (182, 9, 2),
-- 183 Ingénieur de données
(183, 8, 1), (183, 13, 2), (183, 2, 3);