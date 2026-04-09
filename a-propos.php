<?php
/**
 * Page À Propos
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "À Propos";
$page_css = "assets/css/a-propos.css";

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero apropos-hero" style="background-image: url('assets/images/ucaouuc-siege.jpeg');">
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
                <p class="text-justify">L'Université Catholique de l'Afrique de l'Ouest (UCAO) est un établissement d'enseignement supérieur d'excellence, fondé sur les principes de Foi, Science et Action.</p>
                <p class="text-justify">Notre mission est de former des leaders compétents, éthiques et engagés, capables de contribuer au développement durable de l'Afrique de l'Ouest et du monde.</p>
                <p class="text-justify">Nous offrons une formation de qualité dans un environnement propice à l'épanouissement intellectuel, moral et spirituel de chaque étudiant.</p>
            </div>
            <div class="mission-image reveal">
                <img src="assets/images/ucaouuc-siege.jpeg" alt="Campus UCAO-UUC">
            </div>
        </div>
    </div>
</section>

<!-- Platform Section -->
<section class="platform-section">
    <div class="container">
        <div class="platform-content">
            <h2>La Plateforme d'Orientation</h2>
            <p class="text-justify">Notre plateforme d'orientation a été conçue pour accompagner les futurs étudiants dans leur choix de carrière. Grâce à un système intelligent d'analyse des profils et des aspirations professionnelles, nous aidons chaque candidat à trouver la filière qui lui correspond le mieux.</p>
        </div>
        <div class="platform-features">
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <h4>Analyse Intelligente</h4>
                <p class="text-justify">Notre algorithme analyse votre profil pour recommander les filières adaptées à vos compétences.</p>
            </div>
           
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <h4>Rapport Personnalisé</h4>
                <p class="text-justify">Recevez un rapport PDF détaillé avec les filières recommandées et leurs débouchés.</p>
            </div>
            <div class="platform-feature reveal">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                </div>
                <h4>Accompagnement</h4>
                <p class="text-justify">Notre équipe d'orientation vous accompagne tout au long de votre processus d'inscription.</p>
            </div>
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
