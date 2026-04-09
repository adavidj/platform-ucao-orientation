<?php
require_once __DIR__ . '/config/app.php';
// =================================================================
// CONFIGURATION & DATA (Simulation)
// =================================================================

// Global Site Variables
$site_logo_path = 'assets/images/logo-ucao.png';
$site_name = "UCAO - Orientation";
$site_lang = "fr";
$site_charset = "UTF-8";
$primary_font = "'Poppins', sans-serif";
$secondary_font = "'Open Sans', sans-serif";

// Color Palette
$colors = [
    'couleur_primaire' => '#180391',
    'couleur_secondaire' => '#8B0000',
    'couleur_primaire_light' => '#2a15b3',
    'couleur_primaire_dark' => '#0e0560',
    'couleur_secondaire_light' => '#b30000',
    'couleur_secondaire_dark' => '#5c0000',
    'gold' => '#FFD700',
    'white' => '#FFFFFF',
    'light_gray' => '#F8F9FC',
    'medium_gray' => '#E5E8EF',
    'dark_gray' => '#2D3436',
    'text_light' => '#F0F0F0',
    'text_dark' => '#1a1a2e'
];

// Navigation Menu Items
$nav_items = [
    ['name' => 'Découvrir l\'UCAO', 'url' => 'decouvrir-ucao.php'],
    ['name' => 'Nos Formations', 'url' => 'nos-formations.php'],
    ['name' => 'Orientation', 'url' => 'orientation.php'],
    ['name' => 'Pré-inscription', 'url' => 'preinscription.php'],
    ['name' => 'À Propos', 'url' => 'a-propos.php'],
    ['name' => 'Contact', 'url' => 'contact.php']
];

// Hero Slides
$hero_slides = [
    [
        'title' => 'Bienvenue à l\'UCAO',
        'subtitle' => 'L\'excellence académique au service de votre avenir. Découvrez une université prestigieuse.',
        'button1_text' => 'En savoir plus',
        'button1_url' => 'decouvrir-ucao.php',
        'button2_text' => 'Nos Formations',
        'button2_url' => 'nos-formations.php',
        'bg_image' => 'assets/images/hero/ucao.jpg'
    ],
    [
        'title' => 'UCAO-UUC',
        'subtitle' => 'Unité Universitaire de Cotonou : former les leaders de demain dans un environnement d\'excellence, par la foi, la science et l\'action.',
        'button1_text' => 'Découvrir l\'UCAO-UUC',
        'button1_url' => 'decouvrir-ucao.php',
        'button2_text' => '',
        'button2_url' => '',
        'bg_image' => 'assets/images/slides/ucaouuc.png'
    ],
    [
        'title' => 'Œuvres universitaires',
        'subtitle' => 'Un cadre de vie épanouissant favorisant la réussite de chaque étudiant (logement, restauration, sport).',
        'button1_text' => 'Vie étudiante',
        'button1_url' => '#',
        'button2_text' => '',
        'button2_url' => '',
        'bg_image' => 'assets/images/slides/oeuvre-universitaire.png'
    ],
    [
        'title' => 'UCAO-TECH',
        'subtitle' => 'L\'innovation technologique au cœur de notre enseignement de pointe.',
        'button1_text' => 'Découvrir UCAO-Tech',
        'button1_url' => '#',
        'button2_text' => '',
        'button2_url' => '',
        'bg_image' => 'assets/images/slides/slides4.jpeg'
    ],
    [
        'title' => 'Prêt à nous rejoindre ?',
        'subtitle' => 'N\'attendez plus, commencez votre parcours universitaire avec nous dès aujourd\'hui.',
        'button1_text' => 'Je m\'oriente',
        'button1_url' => 'orientation.php',
        'button2_text' => 'Pré-inscription',
        'button2_url' => 'preinscription.php',
        'bg_image' => 'assets/images/slides/slides6.jpeg'
    ]
];

// Key Figures
$key_figures = [
    ['value' => 12000, 'label' => 'Étudiants', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'],
    ['value' => 45, 'label' => 'Formations', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>'],
    ['value' => 7, 'label' => 'Unités Universitaires', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>'],
    ['value' => 95, 'label' => '% d\'insertion pro', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>']
];

// "Why UCAO" Points
$why_ucao = [
    ['title' => 'Excellence Académique', 'description' => 'Des programmes rigoureux et reconnus à l\'international pour former les leaders de demain.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>'],
    ['title' => 'Vie Étudiante Riche', 'description' => 'Un campus dynamique avec des activités culturelles, sportives et associatives pour un épanouissement complet.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'],
    ['title' => 'Réseau Sous-Régional', 'description' => 'Profitez de partenariats avec des universités prestigieuses à travers les régions pour des opportunités uniques.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>']
];

// Orientation Process Steps
$process_steps = [
    ['step' => '1', 'title' => 'Explorez', 'description' => 'Découvrez nos filières et les débouchés professionnels.'],
    ['step' => '2', 'title' => 'Orientez-vous', 'description' => 'Remplissez notre formulaire intelligent pour trouver votre voie.'],
    ['step' => '3', 'title' => 'Pré-inscrivez-vous', 'description' => 'Soumettez votre dossier en ligne en quelques clics.'],
    ['step' => '4', 'title' => 'Rejoignez-nous', 'description' => 'Finalisez votre inscription et commencez votre parcours à l\'UCAO.']
];

// Testimonials
$testimonials = [
    ['quote' => 'La formation en Génie Telecoms à l\'EGEI m\'a permis de maîtriser les technologies de télécommunications et les réseaux informatiques de dernière génération. Ce cursus pratique m\'a vraiment préparé pour le marché du travail.', 'author' => 'David Jonathan AÏDASSO', 'program' => '2e année de licence Génie Telecoms - TIC - EGEI'],
    ['quote' => 'Le programme IIM offre une excellente balance entre théorie et pratique. Les projets concrets nous permettent d\'appliquer immédiatement ce qu\'on apprend et de développer une véritable expertise en ingénierie informatique.', 'author' => 'Gabriel MAHUVI', 'program' => '2e année de licence IIM - EGEI'],
    ['quote' => 'Grâce au laboratoire informatique très bien équipé de l\'UCAO, j\'ai acquis des compétences très pratiques en réseaux et télécommunications.', 'author' => 'Mamadou Bah', 'program' => 'Master Génie Télécoms et TIC — Télécommunications et Réseaux Informatiques - EGEI'],
    ['quote' => 'La rigueur des cours et l\'accompagnement des professeurs m\'ont permis de développer une véritable expertise en gestion informatique.', 'author' => 'Aïssatou Ndiaye', 'program' => 'Licence Informatique de Gestion - ESMEA'],
    ['quote' => 'J\'ai pu maîtriser les techniques de contrôle de gestion et d\'audit financier tout en validant ma Licence.', 'author' => 'Mariama Sylla', 'program' => 'Licence Audit et Contrôle de Gestion - ESMEA'],
    ['quote' => 'Les formations pratiques de l\'UCAO nous permettent d\'expérimenter et de maîtriser les systèmes industriels complexes en conditions réelles.', 'author' => 'Boubacar Diallo', 'program' => 'Master Système Industriel — Électronique, Automatique et Système de Production - EGEI'],
    ['quote' => 'La formation en Transport et Logistique m\'a donné les compétences pour gérer efficacement les chaînes d\'approvisionnement et les opérations logistiques.', 'author' => 'Fatoumata Diallo', 'program' => 'Licence Transport et Logistique - ESMEA'],
    ['quote' => 'Grâce aux cours pratiques en gestion environnementale, j\'ai pu contribuer à des projets de développement durable et de préservation écologique.', 'author' => 'Kofi Mensah', 'program' => 'Licence Gestion de l\'Environnement et Aménagement du Territoire - FSAE'],
    ['quote' => 'Le programme en production agricole m\'a équipé de techniques modernes pour améliorer les rendements et la durabilité des cultures.', 'author' => 'Aboubakar Traoré', 'program' => 'Licence Sciences et Techniques de Production Végétale - FSAE'],
    ['quote' => 'Les cours en ressources humaines m\'ont permis de développer une vision holistique de la gestion des talents et du développement organisationnel.', 'author' => 'Nadia Traore', 'program' => 'Master Gestion des Ressources Humaines - ESMEA']
];

// Footer Links
$footer_links = [
    'Menu' => [
        ['name' => 'Découvrir l\'UCAO', 'url' => 'decouvrir-ucao.php'],
        ['name' => 'Formations', 'url' => 'nos-formations.php'],
        ['name' => 'Orientation', 'url' => 'orientation.php'],
        ['name' => 'Pré-inscription', 'url' => 'preinscription.php']
    ],
    'Liens rapide' => [
        ['name' => 'Site UCAO-UUC', 'url' => 'https://ucaobenin.org/'],
        ['name' => 'Site UCAO-TECH', 'url' => 'https://ucaotech.ucaobenin.org/'],
        ['name' => 'Site ACATSU', 'url' => 'https://oeuvreuniversitaire.ucaobenin.org/'],
        ['name' => 'UCAO Média', 'url' => 'https://ucaomedia.ucaobenin.org']
    ]
];

// Social Media Links
$social_links = [
    'Facebook' => ['url' => '#', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>'],
    'Twitter' => ['url' => '#', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>'],
    'LinkedIn' => ['url' => '#', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>']
];

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($site_lang) ?>">
<head>
    <meta charset="<?= htmlspecialchars($site_charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <?php if (file_exists(__DIR__ . '/assets/vendor/bootstrap/css/bootstrap.min.css')): ?>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <?php endif; ?>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

    <!-- =================================================================
       HEADER / NAVBAR
       ================================================================= -->
    <header class="main-header" id="main-header">
        <div class="container">
            <a href="index.php" class="logo">
                <?php if (file_exists(__DIR__ . '/' . $site_logo_path)): ?>
                    <img src="<?= htmlspecialchars($site_logo_path) ?>" alt="<?= htmlspecialchars($site_name) ?>" class="logo-img">
                <?php else: ?>
                    <?= htmlspecialchars(explode(' ', $site_name)[0]) ?><span>.</span>
                <?php endif; ?>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="active">Accueil</a></li>
                    <?php foreach ($nav_items as $item): ?>
                        <li><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <div class="nav-cta">
                <a href="orientation.php" class="btn btn-primary">Je m'oriente</a>
            </div>
            <button class="hamburger" id="hamburger-btn" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-overlay"></div>

    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobile-menu" aria-label="Menu mobile">
        <div class="mobile-menu-header">
            <a href="index.php" class="logo">
                <?php if (file_exists(__DIR__ . '/' . $site_logo_path)): ?>
                    <img src="<?= htmlspecialchars($site_logo_path) ?>" alt="<?= htmlspecialchars($site_name) ?>" class="logo-img">
                <?php else: ?>
                    <?= htmlspecialchars(explode(' ', $site_name)[0]) ?><span>.</span>
                <?php endif; ?>
            </a>
            <button class="mobile-menu-close" id="mobile-close-btn" aria-label="Fermer le menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="mobile-menu-content">
            <ul>
                <li><a href="index.php" class="active">Accueil</a></li>
                <?php foreach ($nav_items as $item): ?>
                    <li><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="mobile-cta">
                <a href="orientation.php" class="btn btn-primary">Je m'oriente</a>
            </div>
        </div>
    </nav>

    <main>
        <!-- =================================================================
           HERO SLIDER SECTION
           ================================================================= -->
        <section class="hero-slider" id="hero">
            <!-- Slides Container -->
            <div class="hero-slides-container">
                <?php foreach ($hero_slides as $index => $slide): ?>
                <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>" data-slide="<?= $index + 1 ?>" style="background-image: linear-gradient(135deg, rgba(24, 3, 145, 0.78) 0%, rgba(92, 0, 0, 0.72) 100%), url('<?= htmlspecialchars($slide['bg_image']) ?>');">
                    <div class="container">
                        <div class="hero-slide-content">
                            <h1><?= htmlspecialchars($slide['title']) ?></h1>
                            <p><?= htmlspecialchars($slide['subtitle']) ?></p>
                            <div class="hero-ctas">
                                <?php if (!empty($slide['button1_text'])): ?>
                                <a href="<?= htmlspecialchars($slide['button1_url']) ?>" class="btn btn-primary"><?= htmlspecialchars($slide['button1_text']) ?></a>
                                <?php endif; ?>
                                <?php if (!empty($slide['button2_text'])): ?>
                                <a href="<?= htmlspecialchars($slide['button2_url']) ?>" class="btn btn-secondary"><?= htmlspecialchars($slide['button2_text']) ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigation Arrows -->
            <button class="hero-nav prev" aria-label="Slide précédent">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="hero-nav next" aria-label="Slide suivant">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <!-- Dots Indicator -->
            <div class="hero-dots">
                <?php foreach ($hero_slides as $index => $slide): ?>
                <button class="hero-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" aria-label="Aller au slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Progress Bar -->
            <div class="hero-progress">
                <div class="hero-progress-bar"></div>
            </div>

            <!-- Scroll Indicator -->
            <a href="#key-figures" class="scroll-indicator">
                <span>Défiler</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </a>
        </section>

        <!-- =================================================================
           KEY FIGURES SECTION
           ================================================================= -->
        <section class="key-figures-section section" id="key-figures">
            <div class="container">
                <div class="key-figures-grid">
                    <?php foreach ($key_figures as $figure): ?>
                    <div class="figure-item reveal">
                        <div class="icon"><?= $figure['icon'] ?></div>
                        <div class="number" data-target="<?= $figure['value'] ?>">0</div>
                        <div class="label"><?= htmlspecialchars($figure['label']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- =================================================================
           WHY UCAO SECTION
           ================================================================= -->
        <section class="why-ucao-section section">
            <div class="container">
                <h2 class="section-title">Pourquoi choisir l'UCAO ?</h2>
                <div class="why-ucao-grid">
                    <?php foreach ($why_ucao as $reason): ?>
                    <div class="why-card reveal">
                        <div class="icon"><?= $reason['icon'] ?></div>
                        <h3><?= htmlspecialchars($reason['title']) ?></h3>
                        <p><?= htmlspecialchars($reason['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- =================================================================
           PROCESS SECTION
           ================================================================= -->
        <section class="process-section section">
            <div class="container">
                <h2 class="section-title">Votre parcours vers la réussite</h2>
                <div class="process-timeline">
                    <?php foreach ($process_steps as $index => $step): ?>
                    <div class="process-item <?= ($index % 2 == 0) ? 'left' : 'right' ?> reveal">
                        <div class="process-content">
                            <span class="step-number"><?= htmlspecialchars($step['step']) ?></span>
                            <h3><?= htmlspecialchars($step['title']) ?></h3>
                            <p><?= htmlspecialchars($step['description']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- =================================================================
           TESTIMONIALS SECTION
           ================================================================= -->
        <section class="testimonials-section section">
            <div class="container">
                <h2 class="section-title">Paroles d'étudiants</h2>
                <div class="testimonials-container">
                    <div class="testimonials-wrapper" id="testimonials-wrapper">
                        <?php foreach ($testimonials as $testimonial): ?>
                        <div class="testimonial-card reveal">
                            <p class="quote"><?= htmlspecialchars($testimonial['quote']) ?></p>
                            <p class="testimonial-author"><?= htmlspecialchars($testimonial['author']) ?></p>
                            <p class="testimonial-program"><?= htmlspecialchars($testimonial['program']) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="testimonials-nav">
                        <button class="testimonials-prev" aria-label="Témoignages précédents">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="testimonials-next" aria-label="Témoignages suivants">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================
           FINAL CTA SECTION
           ================================================================= -->
        <section class="final-cta-section section">
            <div class="container reveal">
                <h2>Prêt à construire votre avenir ?</h2>
                <p>N'attendez plus. Faites le premier pas vers une carrière brillante en découvrant la formation qui vous est destinée.</p>
                <a href="orientation.php" class="btn btn-primary">Commencer mon orientation</a>
            </div>
        </section>

    </main>

    <?php
    // Inclure le footer réutilisable
    include __DIR__ . '/includes/footer.php';
    ?>
    <script src="assets/js/index.js"></script>

</body>
</html>
