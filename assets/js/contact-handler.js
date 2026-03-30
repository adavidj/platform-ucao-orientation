/**
 * Contact Form Handler
 * Gère la soumission du formulaire de contact via AJAX
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contact-form');
        if (!contactForm) return;

        const endpoint = contactForm.dataset.endpoint || 'handlers/contact-handler.php';
        const successMessage = document.getElementById('success-message');
        const errorBox = document.getElementById('error-message-box');
        const errorContent = document.getElementById('error-message-content');

        const clearInlineErrors = function() {
            const errorMessages = contactForm.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());

            const fields = contactForm.querySelectorAll('.form-control, input[type="checkbox"]');
            fields.forEach(field => field.classList.remove('error'));
        };

        const showServerError = function(message) {
            if (!errorBox || !errorContent) {
                alert(message);
                return;
            }

            errorContent.textContent = message;
            errorBox.style.display = 'block';
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        };

        const hideServerError = function() {
            if (!errorBox) return;
            errorBox.style.display = 'none';
            if (errorContent) {
                errorContent.textContent = '';
            }
        };

        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            clearInlineErrors();
            hideServerError();

            // Valider tous les champs requis
            const requiredFields = contactForm.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                const value = field.type === 'checkbox' ? (field.checked ? '1' : '') : field.value.trim();
                if (!value) {
                    isValid = false;
                    field.classList.add('error');

                    const errorHost = field.closest('.form-group') || field.parentElement;
                    if (errorHost && !errorHost.querySelector('.error-message')) {
                        const msg = document.createElement('span');
                        msg.className = 'error-message';
                        msg.textContent = 'Ce champ est obligatoire';
                        errorHost.appendChild(msg);
                    }
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                showServerError('Veuillez corriger les champs obligatoires.');
                return;
            }

            // Préparer les données
            const formData = new FormData(contactForm);

            // Afficher un indicateur de chargement
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Envoi en cours...';

            // Envoyer via AJAX
            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                const contentType = response.headers.get('content-type') || '';
                if (!contentType.includes('application/json')) {
                    const text = await response.text();
                    throw new Error('Réponse invalide du serveur: ' + text.slice(0, 120));
                }

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Une erreur est survenue sur le serveur.');
                }

                return data;
            })
            .then(data => {
                if (data.success) {
                    // Afficher le message de succès
                    if (successMessage) {
                        successMessage.classList.add('visible');
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    // Réinitialiser le formulaire
                    contactForm.reset();
                    contactForm.style.display = 'none';
                } else {
                    // Afficher les erreurs
                    if (data.errors && Array.isArray(data.errors)) {
                        showServerError(data.errors.join(' '));
                    } else {
                        showServerError(data.message || 'Une erreur est survenue. Veuillez réessayer.');
                    }
                }
            })
            .catch(error => {
                console.error('Erreur réseau :', error);
                showServerError(error.message || 'Erreur réseau. Veuillez vérifier votre connexion et réessayer.');
            })
            .finally(() => {
                // Restaurer le bouton
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    });
})();
