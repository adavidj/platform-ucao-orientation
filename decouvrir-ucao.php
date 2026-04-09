<?php
/**
 * Page Découvrir UCAO
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "Découvrir l'UCAO";
$page_css = "assets/css/decouvrir.css";

// ACASTU Statistics
$acastu_stats = [
    ['value' => '20+', 'label' => 'Clubs actifs'],
    ['value' => '4', 'label' => 'Catégories'],
    ['value' => '10+', 'label' => 'Événements/an'],
    ['value' => '500+', 'label' => 'Étudiants engagés']
];

// University services (Services aux étudiants)
$services = [
    [
        'title' => 'Aumônerie',
        'description' => 'Accompagnement spirituel, célébrations, retraites et activités pastorales pour tous.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20M12 2a3 3 0 0 1 3 3v4a3 3 0 0 1-6 0V5a3 3 0 0 1 3-3z"></path></svg>'
    ],
    [
        'title' => 'Restauration',
        'description' => 'Cantine universitaire proposant des repas équilibrés à prix abordables.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path><path d="M7 2v20"></path><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path></svg>'
    ],
    [
        'title' => 'Bibliothèque',
        'description' => 'Plus de 50 000 ouvrages, espaces de lecture, ressources numériques.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>'
    ],
    [
        'title' => 'Service Médical',
        'description' => 'Infirmerie sur site, consultations médicales, accompagnement psychologique.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>'
    ]
];

// Campus activities (Sports)
$campus_activities = [
    [
        'title' => 'Football',
        'description' => 'Entraînements 3x/semaine, tournois inter-universitaires',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10"></path></svg>'
    ],
    [
        'title' => 'Basketball',
        'description' => 'Techniques, tactiques, équipes mixtes',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M5 12h14"></path></svg>'
    ],
    [
        'title' => 'Volleyball',
        'description' => 'Service, passe, smash, beach volley',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v20"></path></svg>'
    ],
    [
        'title' => 'Handball',
        'description' => 'Contre-attaques, défense en zone',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle></svg>'
    ],
    [
        'title' => 'Arts Martiaux',
        'description' => 'Karaté, Taekwondo, Judo, self-défense',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path></svg>'
    ]
];

// Clubs & associations (ACASTU)
$clubs = [
    ['name' => 'Club d\'Anglais', 'category' => 'Culturel', 'description' => 'Conversations, débats, préparation TOEFL/IELTS, cinéma en VO'],
    ['name' => 'Art Oratoire', 'category' => 'Artistique', 'description' => 'Prise de parole, débats, rhétorique, éloquence'],
    ['name' => 'Théâtre', 'category' => 'Artistique', 'description' => 'Improvisation, jeu d\'acteur, productions scéniques'],
    ['name' => 'Danse', 'category' => 'Artistique', 'description' => 'Moderne, hip-hop, danses africaines, salsa'],
    ['name' => 'Musique & Chorale', 'category' => 'Artistique', 'description' => 'Instruments, composition, gospel, célébrations'],
    ['name' => 'Art de l\'Image', 'category' => 'Artistique', 'description' => 'Photographie, vidéographie, production visuelle'],
    ['name' => 'Tech-Bot', 'category' => 'Technologique', 'description' => 'Robotique, IA, Arduino, Python, IoT'],
    ['name' => 'Digital Pro', 'category' => 'Technologique', 'description' => 'Développement web/mobile, marketing digital, startups'],
    ['name' => 'Design Club', 'category' => 'Technologique', 'description' => 'UI/UX, Figma, motion design, branding'],
    ['name' => 'Gaming', 'category' => 'Technologique', 'description' => 'Esport, développement de jeux, tournois']
];

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero decouvrir" style="background-image: url('assets/images/hero/oeuvre-ucao.jpg'); background-position: center center;">
    <div class="container">
        <h1>Découvrir l'UCAO</h1>
        <p>Une université d'excellence au service de l'Afrique, fondée sur les valeurs de Foi, Science et Action</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>Découvrir l'UCAO</span>
        </nav>
    </div>
</section>

<!-- Values Section -->
<section class="values-section section">
    <div class="container">
        <h2 class="section-title">Nos Valeurs Fondamentales</h2>
        <div class="values-grid">
            <div class="value-card reveal">
                <div class="value-icon">F</div>
                <h3>Foi</h3>
                <p>Enracinée dans les valeurs chrétiennes, l'UCAO forme des leaders éthiques et responsables, respectueux de toutes les croyances.</p>
            </div>
            <div class="value-card reveal">
                <div class="value-icon">S</div>
                <h3>Science</h3>
                <p>L'excellence académique et la rigueur scientifique sont au cœur de notre enseignement pour préparer les défis de demain.</p>
            </div>
            <div class="value-card reveal">
                <div class="value-icon">A</div>
                <h3>Action</h3>
                <p>Former des acteurs du changement capables de transformer positivement leur communauté et la société africaine.</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <h2 class="section-title">La Vie sur le Campus</h2>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="assets/images/ucaouuc-siege.jpeg" alt="Campus UCAO">
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">Bibliothèque</div>
            </div>
            <div class="gallery-item">
                <img src="assets/images/slides/slide2.jpg" alt="Amphithéâtre">
            </div>
            <div class="gallery-item">
                <img src="assets/images/slides/terrain-sport.webp" alt="Terrain de Sport">
            </div>
            <div class="gallery-item">
                <img src="assets/images/slides/oeuvre-universitaire.png" alt="Événement">
            </div>
        </div>
    </div>
</section>

<!-- Services aux Étudiants Section -->
<section class="services-section section">
    <div class="container">
        <h2 class="section-title">Services aux Étudiants</h2>
        <p class="section-description">L'ACASTU (Activité Culturelle Artistique Sportive et Technologique Universitaire) est le cœur battant de la vie étudiante à l'UCAO-UUC. Une vision de formation intégrale où l'excellence académique se nourrit de l'épanouissement personnel.</p>

        <!-- ACASTU Stats -->
        <div class="acastu-stats">
            <?php foreach ($acastu_stats as $stat): ?>
            <div class="stat-item reveal">
                <span class="stat-value"><?= $stat['value'] ?></span>
                <span class="stat-label"><?= $stat['label'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card reveal">
                <div class="service-icon"><?= $service['icon'] ?></div>
                <h3><?= htmlspecialchars($service['title']) ?></h3>
                <p><?= htmlspecialchars($service['description']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Activités Sportives Section -->
<section class="activities-section section">
    <div class="container">
        <h2 class="section-title">Activités Sportives</h2>
        <div class="activities-grid">
            <?php foreach ($campus_activities as $activity): ?>
            <div class="activity-card reveal">
                <div class="activity-icon"><?= $activity['icon'] ?></div>
                <h3><?= htmlspecialchars($activity['title']) ?></h3>
                <p><?= htmlspecialchars($activity['description']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Clubs Section -->
<section class="clubs-section">
    <div class="container">
        <h2 class="section-title">Clubs & Associations</h2>
        <div class="clubs-grid">
            <?php foreach ($clubs as $club): ?>
            <div class="club-item reveal">
                <span class="club-category"><?= htmlspecialchars($club['category']) ?></span>
                <h4><?= htmlspecialchars($club['name']) ?></h4>
                <p><?= htmlspecialchars($club['description']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="discover-cta">
    <div class="container">
        <h2>Prêt à rejoindre notre communauté ?</h2>
        <p>Découvrez la filière qui correspond à vos ambitions et commencez votre parcours à l'UCAO.</p>
        <a href="orientation.php" class="btn btn-primary">Je m'oriente</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
