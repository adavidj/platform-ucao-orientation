<?php
/**
 * Page Pré-inscription
 */

// Include configuration
require_once 'config/app.php';

// Page settings
$page_title = "Pré-inscription";
$page_css = "assets/css/preinscription.css";

// Nationalities
$nationalities = [
    'BJ' => 'Béninoise',
    'TG' => 'Togolaise',
    'NE' => 'Nigérienne',
    'BF' => 'Burkinabè',
    'CI' => 'Ivoirienne',
    'SN' => 'Sénégalaise',
    'ML' => 'Malienne',
    'GH' => 'Ghanéenne',
    'NG' => 'Nigériane',
    'CM' => 'Camerounaise',
    'GA' => 'Gabonaise',
    'CG' => 'Congolaise',
    'OTHER' => 'Autre'
];

// Baccalauréat series
$bac_series = [
    'A1' => 'A1 - Lettres et Langues',
    'A2' => 'A2 - Lettres et Philosophie',
    'B' => 'B - Sciences Économiques et Sociales',
    'C' => 'C - Mathématiques et Sciences Physiques',
    'D' => 'D - Sciences de la Vie et de la Terre',
    'E' => 'E - Mathématiques et Technique',
    'F1' => 'F1 - Construction Mécanique',
    'F2' => 'F2 - Électronique',
    'F3' => 'F3 - Électrotechnique',
    'F4' => 'F4 - Génie Civil',
    'G1' => 'G1 - Techniques Administratives',
    'G2' => 'G2 - Techniques Quantitatives de Gestion',
    'G3' => 'G3 - Techniques Commerciales'
];

// Available formations (would be from database)
$formations = [
    'EGEI' => [
        'Licence Électronique',
        'Licence Génie Télécoms et TIC',
        'Licence Informatique Industrielle',
        'Licence Électrotechnique',
        'Master Automatique',
        'Master Télécommunications',
        'Master Informatique'
    ],
    'ESMEA' => [
        'Licence Banques-Finances-Assurances',
        'Licence Audit-Comptabilité',
        'Licence Ressources Humaines',
        'Licence Marketing',
        'Licence Transport-Logistique',
        'Master Audit et Contrôle de Gestion',
        'Master GRH',
        'Master Marketing',
        'Master Commerce International',
        'Master Transport et Logistique'
    ],
    'FSAE' => [
        'Licence Agronomie',
        'Licence Gestion de l\'Environnement',
        'Licence Ressources Animales',
        'Licence Production Végétale',
        'Master Environnement',
        'Master Gestion des Ressources Naturelles',
        'Master Aménagement Espace Urbain'
    ],
    'FDE' => [
        'Licence Sciences Juridiques',
        'Licence Sciences Économiques',
        'Master Droit Privé Fondamental',
        'Master Droit Public Fondamental'
    ]
];

// Entry levels
$entry_levels = [
    'L1' => 'Licence 1',
    'L2' => 'Licence 2',
    'L3' => 'Licence 3',
    'M1' => 'Master 1',
    'M2' => 'Master 2'
];

// Years
$current_year = date('Y');
$years = range($current_year, $current_year - 10);

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero preinscription-hero">
    <div class="container">
        <h1>Pré-inscription</h1>
        <p>Commencez votre parcours à l'UCAO en soumettant votre dossier de pré-inscription</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>Pré-inscription</span>
        </nav>
    </div>
</section>

<!-- Preinscription Form -->
<section class="section">
    <div class="container">
        <div class="preinscription-container">
            <div class="form-card">
                <div class="form-header">
                    <h2>Formulaire de pré-inscription</h2>
                    <p>Tous les champs marqués d'un astérisque (*) sont obligatoires</p>
                </div>

                <div class="info-box">
                    <h4>Information importante</h4>
                    <p>Après soumission de votre dossier, vous recevrez un e-mail de confirmation. Notre équipe d'orientation prendra contact avec vous pour la suite des démarches.</p>
                </div>

                <form id="preinscription-form" action="handlers/preinscription-handler.php" method="POST" data-validate>

                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </span>
                            Informations personnelles
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nom">Nom <span class="required">*</span></label>
                                <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom de famille" required>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom <span class="required">*</span></label>
                                <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prénom" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="date_naissance">Date de naissance <span class="required">*</span></label>
                                <input type="date" id="date_naissance" name="date_naissance" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="nationalite">Nationalité <span class="required">*</span></label>
                                <select id="nationalite" name="nationalite" class="form-control" required>
                                    <option value="">Sélectionnez votre nationalité</option>
                                    <?php foreach ($nationalities as $code => $label): ?>
                                    <option value="<?= $code ?>"><?= htmlspecialchars($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            </span>
                            Parcours académique
                        </h3>

                        <div class="form-row three-cols">
                            <div class="form-group">
                                <label for="serie_bac">Série du baccalauréat <span class="required">*</span></label>
                                <select id="serie_bac" name="serie_bac" class="form-control" required>
                                    <option value="">Sélectionnez</option>
                                    <?php foreach ($bac_series as $code => $label): ?>
                                    <option value="<?= $code ?>"><?= htmlspecialchars($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="annee_bac">Année d'obtention <span class="required">*</span></label>
                                <select id="annee_bac" name="annee_bac" class="form-control" required>
                                    <option value="">Sélectionnez</option>
                                    <?php foreach ($years as $year): ?>
                                    <option value="<?= $year ?>"><?= $year ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="etablissement">Établissement d'origine <span class="required">*</span></label>
                                <input type="text" id="etablissement" name="etablissement" class="form-control" placeholder="Nom de votre lycée" required>
                            </div>
                        </div>
                    </div>

                    <!-- Program Selection -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </span>
                            Choix de formation
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="ecole">École / Faculté <span class="required">*</span></label>
                                <select id="ecole" name="ecole" class="form-control" required>
                                    <option value="">Sélectionnez une école</option>
                                    <?php foreach ($formations as $key => $programs): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($key) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filiere">Filière choisie <span class="required">*</span></label>
                                <select id="filiere" name="filiere" class="form-control" required disabled>
                                    <option value="">Sélectionnez d'abord une école</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="niveau_entree">Niveau d'entrée souhaité <span class="required">*</span></label>
                                <select id="niveau_entree" name="niveau_entree" class="form-control" required>
                                    <option value="">Sélectionnez</option>
                                    <?php foreach ($entry_levels as $code => $label): ?>
                                    <option value="<?= $code ?>"><?= htmlspecialchars($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            Coordonnées
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Adresse e-mail <span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required>
                            </div>
                            <div class="form-group">
                                <label for="telephone">Numéro de téléphone <span class="required">*</span></label>
                                <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="+229 00 00 00 00" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">
                            <span>Soumettre ma pré-inscription</span>
                        </button>
                    </div>

                    <p class="privacy-notice">
                        En soumettant ce formulaire, vous acceptez notre <a href="#">politique de confidentialité</a>
                        et consentez au traitement de vos données personnelles dans le cadre de votre candidature.
                    </p>
                </form>

                <!-- Success Section -->
                <div class="success-section" id="success-section">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2 class="success-title">Pré-inscription envoyée !</h2>
                    <p class="success-message">
                        Votre dossier de pré-inscription a été reçu avec succès.
                        Un e-mail de confirmation a été envoyé à votre adresse.
                        Notre équipe d'orientation vous contactera prochainement.
                    </p>
                    <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formations data
    const formations = <?= json_encode($formations) ?>;

    // Dynamic filière loading
    const ecoleSelect = document.getElementById('ecole');
    const filiereSelect = document.getElementById('filiere');

    ecoleSelect.addEventListener('change', function() {
        const ecole = this.value;
        filiereSelect.innerHTML = '<option value="">Sélectionnez une filière</option>';

        if (ecole && formations[ecole]) {
            filiereSelect.disabled = false;
            formations[ecole].forEach(filiere => {
                const option = document.createElement('option');
                option.value = filiere;
                option.textContent = filiere;
                filiereSelect.appendChild(option);
            });
        } else {
            filiereSelect.disabled = true;
        }
    });

    // File upload zones
    const fileZones = document.querySelectorAll('.file-upload-zone');
    fileZones.forEach(zone => {
        const input = zone.querySelector('input[type="file"]');
        const textEl = zone.querySelector('.file-upload-text');

        zone.addEventListener('click', (e) => {
            if (e.target !== input) {
                input.click();
            }
        });

        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                textEl.textContent = this.files[0].name;
                zone.classList.add('has-file');
            } else {
                textEl.textContent = zone.querySelector('.file-upload-hint').previousElementSibling.textContent;
                zone.classList.remove('has-file');
            }
        });

        // Drag and drop
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('dragover');
        });

        zone.addEventListener('dragleave', () => {
            zone.classList.remove('dragover');
        });

        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                textEl.textContent = e.dataTransfer.files[0].name;
                zone.classList.add('has-file');
            }
        });
    });

    // Form submission
    const form = document.getElementById('preinscription-form');
    const successSection = document.getElementById('success-section');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate form
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            field.classList.remove('error');
            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) existingError.remove();

            if (!field.value.trim() && field.type !== 'file') {
                isValid = false;
                field.classList.add('error');
                const msg = document.createElement('span');
                msg.className = 'error-message';
                msg.textContent = 'Ce champ est obligatoire';
                field.parentElement.appendChild(msg);
            }

            // File validation
            if (field.type === 'file' && field.files.length === 0) {
                isValid = false;
                const zone = field.closest('.file-upload-zone');
                zone.style.borderColor = '#e74c3c';
            }
        });

        // Email validation
        const emailField = form.querySelector('#email');
        if (emailField.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('error');
            const msg = document.createElement('span');
            msg.className = 'error-message';
            msg.textContent = 'Adresse email invalide';
            emailField.parentElement.appendChild(msg);
        }

        if (isValid) {
            form.style.display = 'none';
            document.querySelector('.info-box').style.display = 'none';
            document.querySelector('.form-header').style.display = 'none';
            successSection.classList.add('visible');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
