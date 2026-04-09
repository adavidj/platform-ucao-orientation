<?php
/**
 * Page Orientation
 * Formulaire d'orientation intelligent
 */

// Include configuration
require_once 'config/config.php';
require_once 'config/app.php';
// Connexion PDO
require_once 'config/database.php';
$pdo = getDBConnection();

// Page settings
$page_title = "Orientation";
$page_css = "assets/css/orientation.css";

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

// Suggestions métiers : tous les nom_metier de la table metiers
$job_suggestions = [];
$sql = "SELECT nom_metier FROM metiers ORDER BY nom_metier ASC";
$result = $pdo->query($sql);
if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $nom = trim($row['nom_metier']);
        if ($nom && !in_array($nom, $job_suggestions, true)) {
            $job_suggestions[] = $nom;
        }
    }
}

// Admin parameter - période nouveaux bacheliers (normally from database)
$is_bac_period = true; // Would be retrieved from admin settings

// Include header
include 'includes/header.php';
?>


<!-- Page Hero -->
<section class="page-hero orientation-hero" style="background-image: url('assets/images/hero/orientation.jpeg');">
    <div class="container">
        <h1>Orientation</h1>
        <p>Découvrez la filière qui correspond à votre profil et vos aspirations</p>
        <nav class="breadcrumb">
            <a href="index.php">Accueil</a>
            <span>/</span>
            <span>Orientation</span>
        </nav>
    </div>
</section>

<!-- Orientation Form -->
<section class="section">
    <div class="container">
        <div class="orientation-container">
            <div class="form-card">
                <div class="form-header">
                    <h2>Formulaire d'orientation</h2>
                    <p>Remplissez ce formulaire pour recevoir un rapport d'orientation personnalisé</p>
                </div>

                <form id="orientation-form" action="handlers/orientation-handler.php" method="POST" data-validate>
                    <?= csrf_field() ?>
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
                            <label for="email">Adresse e-mail <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="votre.email@exemple.com" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Numéro de téléphone <span class="required">*</span></label>
                            <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="+229 00 00 00 00" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="serie_bac">Série du baccalauréat <span class="required">*</span></label>
                            <select id="serie_bac" name="serie_bac" class="form-control" required>
                                <option value="">Sélectionnez votre série</option>
                                <?php foreach ($bac_series as $code => $label): ?>
                                <option value="<?= $code ?>"><?= htmlspecialchars($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <?php if ($is_bac_period): ?>
                        <div class="form-group conditional-field visible" id="numero-table-group">
                            <label for="numero_table">Numéro de table (Bac) <span class="required">*</span></label>
                            <input type="text" id="numero_table" name="numero_table" class="form-control" placeholder="Ex: 12345">
                            <small style="color: #666; font-size: 0.85rem;">Champ activé durant la période des nouveaux bacheliers</small>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group full-width">
                        <label for="metier_souhaite">Métier souhaité <span class="required">*</span></label>
                        <div class="autocomplete-wrapper">
                            <input type="text" id="metier_souhaite" name="metier_souhaite" class="form-control" placeholder="Tapez le métier qui vous intéresse..." required autocomplete="off">
                            <div class="autocomplete-suggestions" id="job-suggestions"></div>
                        </div>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">
                            <span>Obtenir mon orientation</span>
                        </button>
                    </div>

                    <p class="privacy-notice">
                        En soumettant ce formulaire, vous acceptez notre <a href="#">politique de confidentialité</a>.
                        Vos données sont traitées de manière sécurisée.
                    </p>
                </form>

                <!-- Result Section (shown after successful submission) -->
                <div class="result-section" id="result-section">
                    <div class="result-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2 class="result-title">Rapport d'orientation!</h2>
                    <p class="result-message">
                        Votre rapport d'orientation personnalisé a été généré et envoyé à votre adresse e-mail.
                        Vous pouvez également le télécharger directement.
                    </p>
                    <div class="result-actions">
                        <a href="#" class="btn btn-primary" id="download-report">Télécharger votre rapport</a>
                        <a href="preinscription.php" class="btn btn-outline">Continuer vers la pré-inscription</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="how-it-works">
    <div class="container">
        <h2 class="section-title">Comment ça fonctionne ?</h2>
        <div class="steps-grid">
            <div class="step-item reveal">
                <div class="step-number">1</div>
                <h4>Remplissez le formulaire</h4>
                <p>Indiquez vos informations et le métier qui vous intéresse</p>
            </div>
            <div class="step-item reveal">
                <div class="step-number">2</div>
                <h4>Analyse intelligente</h4>
                <p>Notre système analyse votre profil et le métier visé</p>
            </div>
            <div class="step-item reveal">
                <div class="step-number">3</div>
                <h4>Rapport personnalisé</h4>
                <p>Recevez un rapport PDF avec les filières recommandées</p>
            </div>
            <div class="step-item reveal">
                <div class="step-number">4</div>
                <h4>Pré-inscription</h4>
                <p>Postulez directement à la filière de votre choix</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Job suggestions data
    const jobSuggestions = <?= json_encode($job_suggestions) ?>;

    // Autocomplete functionality
    const metierInput = document.getElementById('metier_souhaite');
    const suggestionsContainer = document.getElementById('job-suggestions');

    metierInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();

        if (query.length < 2) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        const matches = jobSuggestions.filter(job =>
            job.toLowerCase().includes(query)
        );

        if (matches.length > 0) {
            suggestionsContainer.innerHTML = matches.map(job =>
                `<div class="autocomplete-item">${job}</div>`
            ).join('');
            suggestionsContainer.classList.add('active');

            // Click on suggestion
            suggestionsContainer.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', function() {
                    metierInput.value = this.textContent;
                    suggestionsContainer.classList.remove('active');
                });
            });
        } else {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!metierInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Form submission handling (demo)
    const form = document.getElementById('orientation-form');
    const resultSection = document.getElementById('result-section');

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
            const msg = document.createElement('span');
            msg.className = 'error-message';
            msg.textContent = 'Adresse email invalide';
            emailField.parentElement.appendChild(msg);
        }

        if (isValid) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Génération en cours...</span>';
            submitBtn.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.style.display = 'none';
                    resultSection.classList.add('visible');
                    document.getElementById('download-report').href = data.download_url;
                } else {
                    alert('Erreur: ' + data.message);
                    submitBtn.innerHTML = originalBtnHtml;
                    submitBtn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Une erreur est survenue lors de la génération du rapport.');
                submitBtn.innerHTML = originalBtnHtml;
                submitBtn.disabled = false;
            });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>