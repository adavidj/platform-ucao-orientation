<?php
/**
 * Page Découvrir UCAO
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "Découvrir l'UCAO";
$page_css = "assets/css/decouvrir.css";

// Campus activities
$campus_activities = [
    [
        'title' => 'Football',
        'description' => 'Équipes masculines et féminines, tournois inter-facultés',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10"></path></svg>'
    ],
    [
        'title' => 'Basketball',
        'description' => 'Courts modernes, entrainements hebdomadaires',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M5 12h14"></path></svg>'
    ],
    [
        'title' => 'Arts Martiaux',
        'description' => 'Karaté, Taekwondo, self-défense',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path></svg>'
    ],
    [
        'title' => 'Athlétisme',
        'description' => 'Piste d\'athlétisme, compétitions régionales',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="2"></circle><path d="M4 21l5-8 4 4 7-10"></path></svg>'
    ]
];

// Clubs & associations
$clubs = [
    ['name' => 'Club Informatique', 'description' => 'Développement, hackathons, ateliers tech'],
    ['name' => 'Club Débat', 'description' => 'Éloquence, compétitions oratoires'],
    ['name' => 'Club Entrepreneuriat', 'description' => 'Pitch, business plan, accompagnement startups'],
    ['name' => 'Troupe Théâtrale', 'description' => 'Représentations, festivals culturels'],
    ['name' => 'Club Photo/Vidéo', 'description' => 'Création audiovisuelle, couverture événements'],
    ['name' => 'Association Caritative', 'description' => 'Actions sociales, aide humanitaire']
];

// University services
$services = [
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
        'title' => 'Hébergement',
        'description' => 'Résidences universitaires sécurisées, chambres équipées, Wi-Fi.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>'
    ],
    [
        'title' => 'Service Médical',
        'description' => 'Infirmerie sur site, consultations médicales, accompagnement psychologique.',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>'
    ]
];

// Partners
$partners = [
    'Université de Bordeaux, France',
    'Université Catholique de Louvain, Belgique',
    'Pontificia Universidad Católica, Chile',
    'University of Notre Dame, USA',
    'Università Cattolica del Sacro Cuore, Italie',
    'University of Ghana, Accra'
];

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero decouvrir">
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
                <div class="gallery-placeholder">Campus UCAO</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">Bibliothèque</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">Amphithéâtre</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">Terrain de Sport</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">Événement</div>
            </div>
        </div>
    </div>
</section>

<!-- Activities Section -->
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
                <h4><?= htmlspecialchars($club['name']) ?></h4>
                <p><?= htmlspecialchars($club['description']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section section">
    <div class="container">
        <h2 class="section-title">Œuvres Universitaires</h2>
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

<!-- Partners Section -->
<section class="partners-section">
    <div class="container">
        <h2 class="section-title">Partenariats Internationaux</h2>
        <div class="partners-list">
            <?php foreach ($partners as $partner): ?>
            <div class="partner-item reveal"><?= htmlspecialchars($partner) ?></div>
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
