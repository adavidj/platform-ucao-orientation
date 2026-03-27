/**
 * UCAO Orientation - Premium Shared JavaScript v2.0
 * Modern interactions with smooth animations & micro-interactions
 */

(function() {
    'use strict';

    // =================================================================
    // CONFIGURATION
    // =================================================================
    const CONFIG = {
        scrollThreshold: 50,
        revealThreshold: 0.15,
        revealRootMargin: '0px 0px -80px 0px',
        counterDuration: 2000,
        debounceDelay: 100,
        mobileBreakpoint: 992
    };

    // =================================================================
    // UTILITY FUNCTIONS
    // =================================================================
    const debounce = (fn, delay) => {
        let timeoutId;
        return (...args) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => fn.apply(this, args), delay);
        };
    };

    const throttle = (fn, limit) => {
        let inThrottle;
        return (...args) => {
            if (!inThrottle) {
                fn.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    const lerp = (start, end, factor) => start + (end - start) * factor;

    const easeOutExpo = (t) => t === 1 ? 1 : 1 - Math.pow(2, -10 * t);

    const getElement = (selector) => document.querySelector(selector);
    const getElements = (selector) => document.querySelectorAll(selector);

    // =================================================================
    // MOBILE MENU
    // =================================================================
    const initMobileMenu = () => {
        const hamburgerBtn = getElement('#hamburger-btn');
        const mobileMenu = getElement('#mobile-menu');
        const mobileOverlay = getElement('#mobile-overlay');
        const mobileCloseBtn = getElement('#mobile-close-btn');

        if (!hamburgerBtn || !mobileMenu || !mobileOverlay) return;

        let isOpen = false;

        const openMenu = () => {
            if (isOpen) return;
            isOpen = true;

            hamburgerBtn.classList.add('active');
            hamburgerBtn.setAttribute('aria-expanded', 'true');
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Focus trap
            const focusableElements = mobileMenu.querySelectorAll(
                'a[href], button:not([disabled]), input:not([disabled])'
            );
            if (focusableElements.length > 0) {
                setTimeout(() => focusableElements[0].focus(), 100);
            }
        };

        const closeMenu = () => {
            if (!isOpen) return;
            isOpen = false;

            hamburgerBtn.classList.remove('active');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';

            hamburgerBtn.focus();
        };

        const toggleMenu = () => isOpen ? closeMenu() : openMenu();

        // Event listeners
        hamburgerBtn.addEventListener('click', toggleMenu);
        mobileOverlay.addEventListener('click', closeMenu);

        if (mobileCloseBtn) {
            mobileCloseBtn.addEventListener('click', closeMenu);
        }

        // Close menu when clicking on a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                setTimeout(closeMenu, 150);
            });
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen) {
                closeMenu();
            }
        });

        // Close menu on resize to desktop
        const handleResize = debounce(() => {
            if (window.innerWidth > CONFIG.mobileBreakpoint && isOpen) {
                closeMenu();
            }
        }, CONFIG.debounceDelay);

        window.addEventListener('resize', handleResize);
    };

    // =================================================================
    // NAVBAR SCROLL EFFECT
    // =================================================================
    const initNavbarScroll = () => {
        const header = getElement('#main-header');
        if (!header) return;

        let lastScroll = 0;
        let ticking = false;

        const updateHeader = () => {
            const currentScroll = window.scrollY;

            if (currentScroll > CONFIG.scrollThreshold) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });

        // Initial check
        updateHeader();
    };

    // =================================================================
    // SCROLL REVEAL ANIMATIONS (IntersectionObserver)
    // =================================================================
    const initScrollReveal = () => {
        const revealElements = getElements('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-rotate');
        if (revealElements.length === 0) return;

        const observerOptions = {
            threshold: CONFIG.revealThreshold,
            rootMargin: CONFIG.revealRootMargin
        };

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add a small delay based on element index for stagger effect
                    const delay = entry.target.dataset.delay || 0;

                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, delay);

                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        revealElements.forEach((el, index) => {
            // Add stagger delay for elements in same parent
            if (!el.dataset.delay && el.parentElement) {
                const siblings = el.parentElement.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-rotate');
                const siblingIndex = Array.from(siblings).indexOf(el);
                if (siblingIndex > 0) {
                    el.style.transitionDelay = `${siblingIndex * 0.1}s`;
                }
            }
            revealObserver.observe(el);
        });
    };

    // =================================================================
    // ANIMATED COUNTERS
    // =================================================================
    const initCounters = () => {
        const counters = getElements('.number[data-target]');
        if (counters.length === 0) return;

        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'), 10);
            const suffix = counter.dataset.suffix || '';
            const duration = CONFIG.counterDuration;
            const startTime = performance.now();

            const updateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutExpo(progress);
                const current = Math.floor(target * easedProgress);

                counter.textContent = current.toLocaleString('fr-FR') + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString('fr-FR') + suffix;
                }
            };

            requestAnimationFrame(updateCounter);
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counter.textContent = '0';
            counterObserver.observe(counter);
        });
    };

    // =================================================================
    // TABS FUNCTIONALITY
    // =================================================================
    const initTabs = () => {
        const tabContainers = getElements('.tabs-container');

        tabContainers.forEach(container => {
            const tabBtns = container.querySelectorAll('.tab-btn');
            const tabContents = container.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.getAttribute('data-tab');

                    // Remove active from all
                    tabBtns.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Add active to clicked
                    btn.classList.add('active');
                    btn.setAttribute('aria-selected', 'true');

                    const targetContent = getElement(`#${tabId}`);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });

                // Keyboard navigation
                btn.addEventListener('keydown', (e) => {
                    const tabs = Array.from(tabBtns);
                    const currentIndex = tabs.indexOf(btn);

                    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % tabs.length;
                        tabs[nextIndex].focus();
                        tabs[nextIndex].click();
                    } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = (currentIndex - 1 + tabs.length) % tabs.length;
                        tabs[prevIndex].focus();
                        tabs[prevIndex].click();
                    }
                });
            });
        });
    };

    // =================================================================
    // ACCORDION FUNCTIONALITY
    // =================================================================
    const initAccordion = () => {
        const accordionHeaders = getElements('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const accordion = item.closest('.accordion');
                const isActive = item.classList.contains('active');

                // Close all accordions in the same group
                if (accordion) {
                    accordion.querySelectorAll('.accordion-item').forEach(i => {
                        i.classList.remove('active');
                        i.querySelector('.accordion-header').setAttribute('aria-expanded', 'false');
                    });
                }

                // Toggle current
                if (!isActive) {
                    item.classList.add('active');
                    header.setAttribute('aria-expanded', 'true');
                }
            });

            // Keyboard support
            header.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    header.click();
                }
            });
        });
    };

    // =================================================================
    // FORM VALIDATION
    // =================================================================
    const initFormValidation = () => {
        const forms = getElements('form[data-validate]');

        forms.forEach(form => {
            const inputs = form.querySelectorAll('.form-control');

            // Real-time validation on blur
            inputs.forEach(input => {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', () => {
                    if (input.classList.contains('error')) {
                        validateField(input);
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!validateField(field)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        });

        function validateField(field) {
            // Remove previous error
            field.classList.remove('error', 'success');
            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) existingError.remove();

            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            // Required check
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Ce champ est obligatoire';
            }

            // Email validation
            if (isValid && field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Adresse email invalide';
                }
            }

            // Phone validation
            if (isValid && field.type === 'tel' && value) {
                const phoneRegex = /^[\d\s\+\-\(\)]{8,}$/;
                if (!phoneRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Numéro de téléphone invalide';
                }
            }

            // Min length
            if (isValid && field.minLength && value.length < field.minLength) {
                isValid = false;
                errorMessage = `Minimum ${field.minLength} caractères requis`;
            }

            if (!isValid) {
                showError(field, errorMessage);
            } else if (value) {
                field.classList.add('success');
            }

            return isValid;
        }

        function showError(field, message) {
            field.classList.add('error');
            const msg = document.createElement('span');
            msg.className = 'error-message';
            msg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>${message}`;
            field.parentElement.appendChild(msg);
        }
    };

    // =================================================================
    // FILE UPLOAD
    // =================================================================
    const initFileUpload = () => {
        const fileUploads = getElements('.file-upload');

        fileUploads.forEach(upload => {
            const input = upload.querySelector('input[type="file"]');
            const textEl = upload.querySelector('.file-upload-text');
            if (!input || !textEl) return;

            const originalText = textEl.textContent;

            upload.addEventListener('click', (e) => {
                if (e.target !== input) {
                    input.click();
                }
            });

            input.addEventListener('change', () => {
                if (input.files.length > 0) {
                    const fileName = input.files[0].name;
                    const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
                    textEl.textContent = `${fileName} (${fileSize} MB)`;
                    upload.classList.add('has-file');
                } else {
                    textEl.textContent = originalText;
                    upload.classList.remove('has-file');
                }
            });

            // Drag and drop
            const preventDefaults = (e) => {
                e.preventDefault();
                e.stopPropagation();
            };

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                upload.addEventListener(eventName, preventDefaults);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                upload.addEventListener(eventName, () => upload.classList.add('dragover'));
            });

            ['dragleave', 'drop'].forEach(eventName => {
                upload.addEventListener(eventName, () => upload.classList.remove('dragover'));
            });

            upload.addEventListener('drop', (e) => {
                if (e.dataTransfer.files.length > 0) {
                    input.files = e.dataTransfer.files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });
    };

    // =================================================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // =================================================================
    const initSmoothScroll = () => {
        getElements('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '#!' || targetId === '#top') {
                    if (targetId === '#top') {
                        e.preventDefault();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    return;
                }

                const target = getElement(targetId);
                if (target) {
                    e.preventDefault();
                    const header = getElement('#main-header');
                    const headerHeight = header ? header.offsetHeight : 0;
                    const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jumping
                    history.pushState(null, '', targetId);
                }
            });
        });
    };

    // =================================================================
    // BUTTON RIPPLE EFFECT
    // =================================================================
    const initRippleEffect = () => {
        // Add ripple animation styles
        if (!getElement('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                .btn-ripple {
                    position: absolute;
                    width: 0;
                    height: 0;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: translate(-50%, -50%);
                    pointer-events: none;
                    animation: rippleEffect 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }
                @keyframes rippleEffect {
                    to {
                        width: 300px;
                        height: 300px;
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn');
            if (!btn) return;

            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.className = 'btn-ripple';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;

            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    };

    // =================================================================
    // LAZY LOAD IMAGES
    // =================================================================
    const initLazyLoad = () => {
        const lazyImages = getElements('img[data-src]');
        if (lazyImages.length === 0) return;

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;

                    // Create a new image to preload
                    const tempImage = new Image();
                    tempImage.onload = () => {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.add('loaded');
                    };
                    tempImage.src = img.dataset.src;

                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '100px' });

        lazyImages.forEach(img => {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });

        // Add lazy load styles
        if (!getElement('#lazy-style')) {
            const style = document.createElement('style');
            style.id = 'lazy-style';
            style.textContent = `
                img.lazy {
                    opacity: 0;
                    transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                }
                img.lazy.loaded {
                    opacity: 1;
                }
            `;
            document.head.appendChild(style);
        }
    };

    // =================================================================
    // CARD HOVER EFFECTS (3D Tilt)
    // =================================================================
    const initCardHover = () => {
        const cards = getElements('.card[data-tilt], .card-tilt');

        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    };

    // =================================================================
    // ALERT DISMISS
    // =================================================================
    const initAlertDismiss = () => {
        getElements('.alert-close').forEach(btn => {
            btn.addEventListener('click', () => {
                const alert = btn.closest('.alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        });
    };

    // =================================================================
    // MODAL FUNCTIONALITY
    // =================================================================
    const initModal = () => {
        // Open modal
        getElements('[data-modal-open]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal-open');
                const modal = getElement(`#${modalId}`);
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';

                    // Focus first focusable element
                    const focusable = modal.querySelector('button, [href], input, select, textarea');
                    if (focusable) focusable.focus();
                }
            });
        });

        // Close modal
        getElements('.modal-close, .modal-overlay').forEach(el => {
            el.addEventListener('click', (e) => {
                if (e.target === el) {
                    const modal = el.closest('.modal-overlay');
                    if (modal) {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            });
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const activeModal = getElement('.modal-overlay.active');
                if (activeModal) {
                    activeModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        });
    };

    // =================================================================
    // BACK TO TOP BUTTON
    // =================================================================
    const initBackToTop = () => {
        const backToTop = getElement('#back-to-top');
        if (!backToTop) return;

        const toggleButton = () => {
            if (window.scrollY > 400) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        };

        window.addEventListener('scroll', throttle(toggleButton, 100), { passive: true });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    };

    // =================================================================
    // PARALLAX EFFECT
    // =================================================================
    const initParallax = () => {
        const parallaxElements = getElements('[data-parallax]');
        if (parallaxElements.length === 0) return;

        const updateParallax = () => {
            const scrollY = window.scrollY;

            parallaxElements.forEach(el => {
                const speed = parseFloat(el.dataset.parallax) || 0.5;
                const rect = el.getBoundingClientRect();
                const elementTop = rect.top + scrollY;
                const offset = (scrollY - elementTop) * speed;

                el.style.transform = `translateY(${offset}px)`;
            });
        };

        window.addEventListener('scroll', throttle(updateParallax, 16), { passive: true });
    };

    // =================================================================
    // COPY TO CLIPBOARD
    // =================================================================
    const initCopyToClipboard = () => {
        getElements('[data-copy]').forEach(btn => {
            btn.addEventListener('click', async () => {
                const text = btn.getAttribute('data-copy');

                try {
                    await navigator.clipboard.writeText(text);

                    // Show success feedback
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Copié !';
                    btn.classList.add('copied');

                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('copied');
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                }
            });
        });
    };

    // =================================================================
    // PRINT FUNCTIONALITY
    // =================================================================
    const initPrint = () => {
        getElements('[data-print]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.print();
            });
        });
    };

    // =================================================================
    // TESTIMONIALS SLIDER
    // =================================================================
    const initTestimonialsSlider = () => {
        const wrapper = getElement('#testimonials-wrapper');
        const prevBtn = getElement('.testimonials-prev');
        const nextBtn = getElement('.testimonials-next');

        if (!wrapper || !prevBtn || !nextBtn) return;

        const scrollAmount = 350;

        prevBtn.addEventListener('click', () => {
            wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    };

    // =================================================================
    // CURRENT YEAR
    // =================================================================
    const initCurrentYear = () => {
        getElements('[data-year]').forEach(el => {
            el.textContent = new Date().getFullYear();
        });
    };

    // =================================================================
    // FOCUS VISIBLE POLYFILL
    // =================================================================
    const initFocusVisible = () => {
        let hadKeyboardEvent = false;

        document.addEventListener('keydown', () => {
            hadKeyboardEvent = true;
        });

        document.addEventListener('mousedown', () => {
            hadKeyboardEvent = false;
        });

        document.addEventListener('focusin', (e) => {
            if (hadKeyboardEvent) {
                e.target.classList.add('focus-visible');
            }
        });

        document.addEventListener('focusout', (e) => {
            e.target.classList.remove('focus-visible');
        });
    };

    // =================================================================
    // PAGE TRANSITION
    // =================================================================
    const initPageTransition = () => {
        // Add fade-in on page load
        document.body.classList.add('page-loaded');

        // Add page transition styles
        if (!getElement('#page-transition-style')) {
            const style = document.createElement('style');
            style.id = 'page-transition-style';
            style.textContent = `
                body {
                    opacity: 0;
                    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                }
                body.page-loaded {
                    opacity: 1;
                }
            `;
            document.head.appendChild(style);
        }
    };

    // =================================================================
    // INITIALIZE ALL
    // =================================================================
    const init = () => {
        initPageTransition();
        initMobileMenu();
        initNavbarScroll();
        initScrollReveal();
        initCounters();
        initTabs();
        initAccordion();
        initFormValidation();
        initFileUpload();
        initSmoothScroll();
        initRippleEffect();
        initLazyLoad();
        initCardHover();
        initAlertDismiss();
        initModal();
        initBackToTop();
        initParallax();
        initCopyToClipboard();
        initPrint();
        initTestimonialsSlider();
        initCurrentYear();
        initFocusVisible();
    };

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose utility functions for external use
    window.UCAO = {
        debounce,
        throttle,
        getElement,
        getElements
    };

})();
