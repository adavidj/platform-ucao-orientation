<?php
/**
 * Page Contact
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "Contact";
$page_css = "assets/css/contact.css";

// Campus information
$campuses = [
    [
        'name' => 'UCAO-UUC Cotonou',
        'address' => 'Lot 246 St Jean, rue de l\'hôpital St Jean, Cotonou',
        'bp' => '04 BP 928 Cotonou - République du Bénin',
        'phone' => '+229 01 21 60 40 70',
        'mobile' => '+229 01 56 35 14 41',
        'email' => 'contact@ucaobenin.org',
        'hours' => 'Lundi - Vendredi: 8h00 - 17h00',
        'hours_saturday' => 'Samedi: 9h00 - 13h00'
    ]
];

// Subject options for contact form
$contact_subjects = [
    'info' => 'Demande d\'information générale',
    'orientation' => 'Question sur l\'orientation',
    'inscription' => 'Question sur l\'inscription',
    'formations' => 'Information sur les formations',
    'partenariat' => 'Proposition de partenariat',
    'autre' => 'Autre'
];

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero contact-hero">
    <div class="container">
        <h1>Contact</h1>
        <p>Nous sommes là pour répondre à toutes vos questions</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>Contact</span>
        </nav>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-wrapper reveal">
                <h2>Envoyez-nous un message</h2>
                <p>Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>

                <form id="contact-form" data-validate>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom <span class="required">*</span></label>
                            <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom <span class="required">*</span></label>
                            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="+229 00 00 00 00">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="sujet">Sujet <span class="required">*</span></label>
                        <select id="sujet" name="sujet" class="form-control" required>
                            <option value="">Sélectionnez un sujet</option>
                            <?php foreach ($contact_subjects as $value => $label): ?>
                            <option value="<?= $value ?>"><?= htmlspecialchars($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-control" placeholder="Votre message..." required></textarea>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">Envoyer le message</button>
                    </div>
                </form>

                <div class="success-message" id="success-message">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h3>Message envoyé !</h3>
                    <p>Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</p>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-wrapper">
                <?php foreach ($campuses as $campus): ?>
                <div class="campus-card reveal">
                    <h3><?= htmlspecialchars($campus['name']) ?></h3>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="contact-details">
                            <h4>Adresse</h4>
                            <p><?= htmlspecialchars($campus['address']) ?></p>
                            <?php if (!empty($campus['bp'])): ?>
                            <p class="bp"><?= htmlspecialchars($campus['bp']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div class="contact-details">
                            <h4>Téléphone</h4>
                            <p><a href="tel:<?= htmlspecialchars(str_replace(' ', '', $campus['phone'])) ?>"><?= htmlspecialchars($campus['phone']) ?></a></p>
                            <?php if (!empty($campus['mobile'])): ?>
                            <p><a href="tel:<?= htmlspecialchars(str_replace(' ', '', $campus['mobile'])) ?>"><?= htmlspecialchars($campus['mobile']) ?></a> (Mobile)</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div class="contact-details">
                            <h4>E-mail</h4>
                            <p><a href="mailto:<?= htmlspecialchars($campus['email']) ?>"><?= htmlspecialchars($campus['email']) ?></a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="contact-details">
                            <h4>Horaires</h4>
                            <p><?= htmlspecialchars($campus['hours']) ?></p>
                            <?php if (!empty($campus['hours_saturday'])): ?>
                            <p><?= htmlspecialchars($campus['hours_saturday']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="contact-item whatsapp-item">
                        <div class="contact-icon whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div class="contact-details">
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/22956351441" target="_blank">+229 56 35 14 41</a></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Social Links -->
                <div class="social-card reveal">
                    <h3>Suivez-nous</h3>
                    <div class="social-buttons">
                        <a href="https://facebook.com/UCAOBENIN" class="social-btn" title="Facebook" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                        <a href="https://wa.me/22956351441" class="social-btn whatsapp" title="WhatsApp" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <a href="https://instagram.com/ucaobenin" class="social-btn" title="Instagram" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                        <a href="https://tiktok.com/@ucaouuc" class="social-btn" title="TikTok" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <h2 class="section-title">Notre Localisation</h2>
        <div class="map-container">
            <!-- In production, embed Google Maps here -->
            <p>Carte Google Maps - Campus UCAO-UUC Cotonou</p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2 class="section-title">Questions Fréquentes</h2>
        <div class="faq-grid">
            <div class="faq-item reveal">
                <button class="faq-question">
                    Quels sont les documents nécessaires pour l'inscription ?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer">
                    <p>Pour votre inscription, vous aurez besoin de : relevé de notes du baccalauréat, diplôme ou attestation de réussite au bac, pièce d'identité (CNI ou passeport), 4 photos d'identité, et les frais d'inscription.</p>
                </div>
            </div>

            <div class="faq-item reveal">
                <button class="faq-question">
                    Comment fonctionne le système d'orientation ?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer">
                    <p>Notre système d'orientation analyse votre profil académique et vos aspirations professionnelles pour vous recommander les filières les plus adaptées. Vous recevez ensuite un rapport PDF personnalisé avec nos recommandations.</p>
                </div>
            </div>

            <div class="faq-item reveal">
                <button class="faq-question">
                    Quand commencent les inscriptions ?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer">
                    <p>Les inscriptions sont ouvertes tout au long de l'année. Cependant, pour les nouveaux bacheliers, nous recommandons de commencer le processus dès la publication des résultats du baccalauréat pour garantir votre place.</p>
                </div>
            </div>

            <div class="faq-item reveal">
                <button class="faq-question">
                    Y a-t-il des bourses disponibles ?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer">
                    <p>Oui, l'UCAO propose plusieurs programmes de bourses basés sur le mérite académique et les critères sociaux. Contactez le service des admissions pour plus d'informations sur les critères d'éligibilité.</p>
                </div>
            </div>

            <div class="faq-item reveal">
                <button class="faq-question">
                    Puis-je changer de filière après inscription ?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="faq-answer">
                    <p>Les changements de filière sont possibles sous certaines conditions et dans les délais impartis. Consultez le service d'orientation pour évaluer la faisabilité de votre demande.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const form = document.getElementById('contact-form');
    const successMessage = document.getElementById('success-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate form
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            field.classList.remove('error');
            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) existingError.remove();

            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
                const msg = document.createElement('span');
                msg.className = 'error-message';
                msg.textContent = 'Ce champ est obligatoire';
                field.parentElement.appendChild(msg);
            }
        });

        // Email validation
        const emailField = form.querySelector('#email');
        if (emailField.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('error');
            const existingError = emailField.parentElement.querySelector('.error-message');
            if (!existingError) {
                const msg = document.createElement('span');
                msg.className = 'error-message';
                msg.textContent = 'Adresse email invalide';
                emailField.parentElement.appendChild(msg);
            }
        }

        if (isValid) {
            form.style.display = 'none';
            successMessage.classList.add('visible');
        }
    });

    // FAQ accordion
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            // Close others
            faqItems.forEach(other => {
                if (other !== item) {
                    other.classList.remove('active');
                }
            });
            // Toggle current
            item.classList.toggle('active');
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
