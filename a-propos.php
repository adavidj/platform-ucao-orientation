<?php
/**
 * Page À Propos
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "À Propos";
$page_css = "assets/css/a-propos.css";

// Team members
$team = [
    [
        'name' => 'Pr. Jean-Paul KOUADIO',
        'role' => 'Directeur de l\'Orientation',
        'description' => 'Expert en orientation académique avec plus de 20 ans d\'expérience.'
    ],
    [
        'name' => 'Dr. Marie SOSSOU',
        'role' => 'Responsable Pédagogique',
        'description' => 'Spécialiste en ingénierie de formation et développement curriculaire.'
    ],
    [
        'name' => 'M. Kodjo AMEGBO',
        'role' => 'Conseiller d\'Orientation',
        'description' => 'Accompagne les étudiants dans leurs choix de carrière depuis 10 ans.'
    ],
    [
        'name' => 'Mme. Aïcha DIALLO',
        'role' => 'Chargée des Admissions',
        'description' => 'Gère les processus d\'admission et accompagne les candidats.'
    ]
];

// Timeline / History
$history = [
    [
        'year' => '1975',
        'title' => 'Fondation de l\'UCAO',
        'description' => 'Création de l\'Université Catholique de l\'Afrique de l\'Ouest à Abidjan par la Conférence Épiscopale Régionale de l\'Afrique de l\'Ouest.'
    ],
    [
        'year' => '1995',
        'title' => 'Création de l\'UCAO-UUC',
        'description' => 'L\'Unité Universitaire de Cotonou est fondée pour répondre aux besoins de formation au Bénin.'
    ],
    [
        'year' => '2010',
        'title' => 'Expansion des filières',
        'description' => 'Ouverture de nouvelles filières technologiques et scientifiques avec la création de l\'EGEI.'
    ],
    [
        'year' => '2020',
        'title' => 'Transformation digitale',
        'description' => 'Lancement de la plateforme d\'orientation en ligne pour accompagner les futurs étudiants.'
    ],
    [
        'year' => '2024',
        'title' => 'Excellence reconnue',
        'description' => 'L\'UCAO-UUC est reconnue parmi les meilleures universités privées d\'Afrique de l\'Ouest.'
    ]
];

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero apropos-hero">
    <div class="container">
        <h1>À Propos</h1>
        <p>Découvrez l'histoire et la mission de l'UCAO et de notre plateforme d'orientation</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>À Propos</span>
        </nav>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section">
    <div class="container">
        <div class="mission-content">
            <div class="mission-text reveal">
                <h2>Notre Mission</h2>
                <p>L'Université Catholique de l'Afrique de l'Ouest (UCAO) est un établissement d'enseignement supérieur d'excellence, fondé sur les principes de Foi, Science et Action.</p>
                <p>Notre mission est de former des leaders compétents, éthiques et engagés, capables de contribuer au développement durable de l'Afrique de l'Ouest et du monde.</p>
                <p>Nous offrons une formation de qualité dans un environnement propice à l'épanouissement intellectuel, moral et spirituel de chaque étudiant.</p>
            </div>
            <div class="mission-image reveal">
                Campus UCAO-UUC
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section" style="background-color: var(--light-gray);">
    <div class="container">
        <h2 class="section-title">Nos Valeurs</h2>
        <div class="values-grid">
            <div class="value-item reveal">
                <div class="value-icon">F</div>
                <h3>Foi</h3>
                <p>Ancrée dans les valeurs évangéliques, notre université promeut le respect, la tolérance et l'ouverture à tous, quelle que soit leur croyance.</p>
            </div>
            <div class="value-item reveal">
                <div class="value-icon">S</div>
                <h3>Science</h3>
                <p>L'excellence académique et la rigueur scientifique sont au cœur de notre enseignement pour former les experts de demain.</p>
            </div>
            <div class="value-item reveal">
                <div class="value-icon">A</div>
                <h3>Action</h3>
                <p>Nous formons des acteurs du changement, engagés dans la transformation positive de leur communauté et de la société.</p>
            </div>
        </div>
    </div>
</section>

<!-- Platform Section -->
<section class="platform-section">
    <div class="container">
        <div class="platform-content">
            <h2>La Plateforme d'Orientation</h2>
            <p>Notre plateforme d'orientation a été conçue pour accompagner les futurs étudiants dans leur choix de carrière. Grâce à un système intelligent d'analyse des profils et des aspirations professionnelles, nous aidons chaque candidat à trouver la filière qui lui correspond le mieux.</p>
        </div>
        <div class="platform-features">
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <h4>Analyse Intelligente</h4>
                <p>Notre algorithme analyse votre profil pour recommander les filières adaptées à vos compétences.</p>
            </div>
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <h4>Rapport Personnalisé</h4>
                <p>Recevez un rapport PDF détaillé avec les filières recommandées et leurs débouchés.</p>
            </div>
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                </div>
                <h4>Accompagnement</h4>
                <p>Notre équipe d'orientation vous accompagne tout au long de votre processus d'inscription.</p>
            </div>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="history-section">
    <div class="container">
        <h2 class="section-title">Notre Histoire</h2>
        <div class="timeline">
            <?php foreach ($history as $event): ?>
            <div class="timeline-item reveal">
                <div class="timeline-year"><?= htmlspecialchars($event['year']) ?></div>
                <div class="timeline-content">
                    <h4><?= htmlspecialchars($event['title']) ?></h4>
                    <p><?= htmlspecialchars($event['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <h2 class="section-title">L'Équipe d'Orientation</h2>
        <div class="team-grid">
            <?php foreach ($team as $member): ?>
            <div class="team-card reveal">
                <div class="team-photo"><?= strtoupper(substr($member['name'], 4, 1)) ?></div>
                <div class="team-info">
                    <h4><?= htmlspecialchars($member['name']) ?></h4>
                    <p class="team-role"><?= htmlspecialchars($member['role']) ?></p>
                    <p><?= htmlspecialchars($member['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="apropos-cta">
    <div class="container">
        <h2>Prêt à commencer votre parcours ?</h2>
        <p>Découvrez la filière qui correspond à vos ambitions et rejoignez notre communauté d'étudiants.</p>
        <a href="orientation.php" class="btn btn-primary">Commencer mon orientation</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
