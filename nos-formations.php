<?php
/**
 * Page Nos Formations
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "Nos Formations";
$page_css = "assets/css/nos-formations.css";

// Formations data - Source: ucaobenin.org
$formations = [
    'EGEI' => [
        'name' => 'EGEI - École de Génie Électrique et Informatique',
        'type' => 'École Professionnelle',
        'description' => 'Des formations concrètes pour des carrières d\'excellence',
        'licences' => [
            [
                'name' => 'Électronique',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D, E ou F',
                'careers' => 'Technicien électronique, Ingénieur de maintenance, Concepteur de circuits',
                'skills' => 'Conception de circuits, Systèmes embarqués, Électronique de puissance'
            ],
            [
                'name' => 'Génie Télécoms et TIC',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D, E ou F',
                'careers' => 'Technicien télécom, Administrateur réseau, Spécialiste fibre optique',
                'skills' => 'Réseaux mobiles, Infrastructure télécom, Technologies IP'
            ],
            [
                'name' => 'Informatique Industrielle et Maintenance',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D, E ou F',
                'careers' => 'Automaticien, Technicien de maintenance industrielle, Programmeur automates',
                'skills' => 'Automatisme, Programmation PLC, Supervision industrielle'
            ],
            [
                'name' => 'Électrotechnique',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D, E ou F',
                'careers' => 'Électricien industriel, Technicien de maintenance, Chef de projet électrique',
                'skills' => 'Machines électriques, Installations électriques, Énergies renouvelables'
            ]
        ],
        'masters' => [
            [
                'name' => 'Système Industriel',
                'specialisation' => 'Électronique, Automatique et Système de Production',
                'duration' => '2 ans',
                'entry' => 'Licence dans le domaine',
                'careers' => 'Ingénieur automaticien, Chef de projet automatisme, Consultant industrie 4.0',
                'skills' => 'Robotique, Systèmes de contrôle avancés, Intelligence artificielle industrielle'
            ],
            [
                'name' => 'Génie Télécoms et TIC',
                'specialisation' => 'Télécommunications et Réseaux Informatiques',
                'duration' => '2 ans',
                'entry' => 'Licence dans le domaine',
                'careers' => 'Ingénieur télécom, Architecte réseau, Chef de projet infrastructure',
                'skills' => 'Réseaux 5G, Transformation digitale, Sécurité des réseaux'
            ]
        ]
    ],
    'ESMEA' => [
        'name' => 'ESMEA - École de Management et Économie Appliquée',
        'type' => 'École Professionnelle',
        'description' => 'Former les managers et entrepreneurs de demain',
        'licences' => [
            [
                'name' => 'Banques Finances et Assurances',
                'options' => 'Assurances, Banque et Finance d\'Entreprise',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Conseiller bancaire, Agent d\'assurance, Analyste de crédit',
                'skills' => 'Gestion des risques, Analyse financière, Produits bancaires'
            ],
            [
                'name' => 'Finances Comptabilité Audit',
                'options' => 'Audit et Contrôle de Gestion',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Comptable, Auditeur junior, Contrôleur de gestion',
                'skills' => 'Comptabilité générale, Fiscalité, Audit financier'
            ],
            [
                'name' => 'Management des Ressources Humaines',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Assistant RH, Chargé de recrutement, Gestionnaire de paie',
                'skills' => 'Droit du travail, Gestion des talents, Relations sociales'
            ],
            [
                'name' => 'Marketing Communication et Commerce',
                'options' => 'Action Commerciale, Communication et Action Publicitaire, Commerce',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Assistant marketing, Chef de produit junior, Community manager',
                'skills' => 'Marketing digital, Études de marché, Communication'
            ],
            [
                'name' => 'Système Informatique et Logiciel',
                'options' => 'Informatique de Gestion',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Développeur, Analyste programmeur, Administrateur systèmes',
                'skills' => 'Programmation, Bases de données, Développement web'
            ],
            [
                'name' => 'Transport et Logistique',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Agent logistique, Gestionnaire de stock, Coordinateur transport',
                'skills' => 'Supply chain, Gestion des stocks, Commerce international'
            ]
        ],
        'masters' => [
            [
                'name' => 'Assurances',
                'duration' => '2 ans',
                'entry' => 'Licence en Banque/Finance/Assurance',
                'careers' => 'Directeur d\'agence, Actuaire, Souscripteur senior',
                'skills' => 'Gestion des risques, Réassurance, Droit des assurances'
            ],
            [
                'name' => 'Finances Comptabilité Audit',
                'specialisation' => 'Audit et Contrôle de Gestion',
                'duration' => '2 ans',
                'entry' => 'Licence en Gestion/Finance',
                'careers' => 'Auditeur externe, Contrôleur de gestion, DAF',
                'skills' => 'Audit stratégique, Normes IFRS, Pilotage de la performance'
            ],
            [
                'name' => 'Gestion des Ressources Humaines',
                'duration' => '2 ans',
                'entry' => 'Licence en GRH/Management',
                'careers' => 'DRH, Responsable formation, Consultant RH',
                'skills' => 'Management stratégique RH, GPEC, Négociation sociale'
            ],
            [
                'name' => 'Marketing Communication et Commerce',
                'options' => 'Marketing Communication, Commerce International',
                'duration' => '2 ans',
                'entry' => 'Licence en Marketing/Commerce',
                'careers' => 'Directeur marketing, Chef de produit, Consultant marketing',
                'skills' => 'Marketing stratégique, Big data marketing, E-commerce'
            ],
            [
                'name' => 'Transport et Logistique',
                'duration' => '2 ans',
                'entry' => 'Licence Transport/Logistique',
                'careers' => 'Directeur logistique, Supply chain manager, Consultant transport',
                'skills' => 'Supply chain management, Optimisation logistique, Green logistics'
            ]
        ]
    ],
    'FSAE' => [
        'name' => 'FSAE - Faculté des Sciences de l\'Agronomie et de l\'Environnement',
        'type' => 'Faculté Académique',
        'description' => 'Savoir fondamental et recherche avancée',
        'licences' => [
            [
                'name' => 'Gestion de l\'Environnement et Aménagement du Territoire',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D',
                'careers' => 'Technicien environnement, Agent d\'aménagement, Conseiller territorial',
                'skills' => 'Études d\'impact, Aménagement du territoire, Cartographie'
            ],
            [
                'name' => 'Production et Gestion des Ressources Animales',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D',
                'careers' => 'Technicien d\'élevage, Conseiller en nutrition animale, Agent vétérinaire',
                'skills' => 'Zootechnie, Santé animale, Alimentation animale'
            ],
            [
                'name' => 'Sciences et Techniques de Production Végétale',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D',
                'careers' => 'Technicien de production, Agent phytosanitaire, Conseiller cultures',
                'skills' => 'Phytotechnie, Protection des cultures, Semences'
            ],
            [
                'name' => 'Stockage Conservation et Conditionnement des Produits Agricoles',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D',
                'careers' => 'Responsable qualité, Technicien agroalimentaire, Gestionnaire de stocks',
                'skills' => 'Conservation des aliments, Normes qualité, Transformation'
            ],
            [
                'name' => 'Gestion des Entreprises Rurales et Agricoles',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat C, D',
                'careers' => 'Gestionnaire d\'exploitation, Conseiller agricole, Agent de développement rural',
                'skills' => 'Gestion des exploitations, Économie rurale, Entrepreneuriat agricole'
            ]
        ],
        'masters' => [
            [
                'name' => 'Gestion de l\'Environnement et Aménagement du Territoire',
                'duration' => '2 ans',
                'entry' => 'Licence Environnement/Agronomie',
                'careers' => 'Ingénieur environnement, Chef de projet aménagement, Expert territorial',
                'skills' => 'Planification territoriale, SIG avancé, Politiques environnementales'
            ],
            [
                'name' => 'Production et Gestion des Ressources Animales',
                'duration' => '2 ans',
                'entry' => 'Licence Ressources Animales',
                'careers' => 'Ingénieur zootechnicien, Consultant élevage, Chercheur',
                'skills' => 'Amélioration génétique, Systèmes d\'élevage, Nutrition avancée'
            ],
            [
                'name' => 'Sciences et Techniques de Production Végétale',
                'duration' => '2 ans',
                'entry' => 'Licence Production Végétale',
                'careers' => 'Ingénieur agronome, Chercheur, Consultant agricole',
                'skills' => 'Agronomie avancée, Biotechnologies végétales, Agriculture de précision'
            ],
            [
                'name' => 'Stockage Conservation et Conditionnement des Produits Agricoles',
                'duration' => '2 ans',
                'entry' => 'Licence dans le domaine',
                'careers' => 'Ingénieur qualité, R&D agroalimentaire, Directeur de production',
                'skills' => 'Technologies post-récolte, Innovation alimentaire, Management qualité'
            ],
            [
                'name' => 'Administration et Politique de l\'Environnement',
                'duration' => '2 ans',
                'entry' => 'Licence Environnement',
                'careers' => 'Expert politiques publiques, Consultant RSE, Cadre administration',
                'skills' => 'Politiques environnementales, Gouvernance, Droit de l\'environnement'
            ],
            [
                'name' => 'Gestion des Ressources Naturelles',
                'duration' => '2 ans',
                'entry' => 'Licence Environnement/Agronomie',
                'careers' => 'Gestionnaire de ressources, Expert forestier, Consultant biodiversité',
                'skills' => 'Conservation, Agroforesterie, Gestion durable des terres'
            ],
            [
                'name' => 'Gestion de l\'Espace Urbain',
                'duration' => '2 ans',
                'entry' => 'Licence Environnement/Géographie',
                'careers' => 'Urbaniste, Chef de projet aménagement, Consultant mobilité',
                'skills' => 'Planification urbaine, SIG, Développement territorial'
            ]
        ]
    ],
    'FDE' => [
        'name' => 'FDE - Faculté de Droit et d\'Économie',
        'type' => 'Faculté Académique',
        'description' => 'Excellence juridique et économique',
        'licences' => [
            [
                'name' => 'Sciences Juridiques / Droit',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Juriste d\'entreprise, Clerc de notaire, Assistant juridique',
                'skills' => 'Droit civil, Droit des affaires, Procédures judiciaires'
            ],
            [
                'name' => 'Sciences Économiques / Économie',
                'duration' => '3 ans',
                'entry' => 'Baccalauréat toutes séries',
                'careers' => 'Économiste, Analyste, Chargé d\'études',
                'skills' => 'Analyse économique, Statistiques, Économétrie'
            ]
        ],
        'masters' => [
            [
                'name' => 'Droit Privé Fondamental',
                'specialisations' => 'Droit des TIC, Professions Judiciaires, Fiscalité et Droit des Affaires, Juriste d\'Entreprises',
                'duration' => '2 ans',
                'entry' => 'Licence en Droit',
                'careers' => 'Avocat, Magistrat, Juriste d\'affaires senior, Fiscaliste',
                'skills' => 'Contentieux, Droit des contrats, Arbitrage, Droit du numérique'
            ],
            [
                'name' => 'Droit Public Fondamental',
                'specialisations' => 'Droit de l\'Homme et Droit Humanitaire, Droit de l\'Environnement et de l\'Urbanisme',
                'duration' => '2 ans',
                'entry' => 'Licence en Droit',
                'careers' => 'Conseiller juridique public, Fonctionnaire international, Expert droits humains',
                'skills' => 'Droit administratif, Droit constitutionnel, Contentieux public'
            ]
        ]
    ]
];

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero formations-hero" style="background-image: url('assets/images/hero/formations.jpg');">
    <div class="container">
        <h1>Nos Formations</h1>
        <p>Des programmes d'excellence pour construire votre avenir professionnel</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>Nos Formations</span>
        </nav>
    </div>
</section>

<!-- Formations Content -->
<section class="section">
    <div class="container">
        <div class="tabs-container">
            <!-- School Tabs -->
            <div class="school-tabs">
                <?php $first = true; foreach ($formations as $key => $school): ?>
                <button class="school-tab <?= $first ? 'active' : '' ?>" data-school="<?= $key ?>">
                    <?= $key ?>
                </button>
                <?php $first = false; endforeach; ?>
            </div>

            <!-- School Contents -->
            <?php $first = true; foreach ($formations as $key => $school): ?>
            <div class="school-content <?= $first ? 'active' : '' ?>" id="school-<?= $key ?>">
                <div class="school-header">
                    <h2><?= htmlspecialchars($school['name']) ?></h2>
                    <p><?= htmlspecialchars($school['description']) ?></p>
                </div>

                <!-- Licences -->
                <div class="level-section">
                    <h3>Licences</h3>
                    <div class="formations-grid">
                        <?php foreach ($school['licences'] as $formation): ?>
                        <div class="formation-card reveal">
                            <div class="formation-header">
                                <h4><?= htmlspecialchars($formation['name']) ?></h4>
                            </div>
                            <div class="formation-body">
                                <div class="formation-meta">
                                    <div class="meta-item">
                                        <span class="meta-label">Durée</span>
                                        <span class="meta-value"><?= htmlspecialchars($formation['duration']) ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Niveau d'entrée</span>
                                        <span class="meta-value"><?= htmlspecialchars($formation['entry']) ?></span>
                                    </div>
                                </div>
                                <div class="formation-details">
                                    <div class="detail-item">
                                        <strong>Débouchés</strong>
                                        <p><?= htmlspecialchars($formation['careers']) ?></p>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Compétences acquises</strong>
                                        <p><?= htmlspecialchars($formation['skills']) ?></p>
                                    </div>
                                </div>
                                <div class="formation-cta">
                                    <a href="orientation.php?filiere=<?= urlencode($formation['name']) ?>" class="btn btn-primary">
                                        Me faire orienter vers cette filière
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Masters -->
                <div class="level-section">
                    <h3>Masters</h3>
                    <div class="formations-grid">
                        <?php foreach ($school['masters'] as $formation): ?>
                        <div class="formation-card reveal">
                            <div class="formation-header">
                                <h4><?= htmlspecialchars($formation['name']) ?></h4>
                            </div>
                            <div class="formation-body">
                                <div class="formation-meta">
                                    <div class="meta-item">
                                        <span class="meta-label">Durée</span>
                                        <span class="meta-value"><?= htmlspecialchars($formation['duration']) ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Niveau d'entrée</span>
                                        <span class="meta-value"><?= htmlspecialchars($formation['entry']) ?></span>
                                    </div>
                                </div>
                                <div class="formation-details">
                                    <div class="detail-item">
                                        <strong>Débouchés</strong>
                                        <p><?= htmlspecialchars($formation['careers']) ?></p>
                                    </div>
                                    <div class="detail-item">
                                        <strong>Compétences acquises</strong>
                                        <p><?= htmlspecialchars($formation['skills']) ?></p>
                                    </div>
                                </div>
                                <div class="formation-cta">
                                    <a href="orientation.php?filiere=<?= urlencode($formation['name']) ?>" class="btn btn-primary">
                                        Me faire orienter vers cette filière
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php $first = false; endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Besoin d'aide pour choisir ?</h2>
        <p>Notre outil d'orientation intelligent vous aide à trouver la filière qui correspond le mieux à votre profil et vos aspirations professionnelles.</p>
        <a href="orientation.php" class="btn btn-primary">Commencer mon orientation</a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // School tabs switching
    const schoolTabs = document.querySelectorAll('.school-tab');
    const schoolContents = document.querySelectorAll('.school-content');

    schoolTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const school = this.getAttribute('data-school');

            // Remove active from all
            schoolTabs.forEach(t => t.classList.remove('active'));
            schoolContents.forEach(c => c.classList.remove('active'));

            // Add active to current
            this.classList.add('active');
            document.getElementById('school-' + school).classList.add('active');
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
