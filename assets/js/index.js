/**
 * UCAO Orientation - Page d'accueil JavaScript v2.0
 * Hero slider et interactions premium
 */

(function() {
    'use strict';

    // =================================================================
    // HERO SLIDER
    // =================================================================
    const initHeroSlider = () => {
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');
        const heroPrevBtn = document.querySelector('.hero-nav.prev');
        const heroNextBtn = document.querySelector('.hero-nav.next');
        const heroProgressBar = document.querySelector('.hero-progress-bar');
        const heroSlider = document.querySelector('.hero-slider');

        if (!heroSlides.length) return;

        let currentHeroIndex = 0;
        let heroInterval;
        let progressInterval;
        const slideDuration = 6000;
        const progressStep = 50;

        function goToHeroSlide(index) {
            // Animation de sortie
            heroSlides[currentHeroIndex].classList.add('exiting');
            heroSlides[currentHeroIndex].classList.remove('active');
            heroDots[currentHeroIndex].classList.remove('active');

            currentHeroIndex = index;
            if (currentHeroIndex < 0) currentHeroIndex = heroSlides.length - 1;
            if (currentHeroIndex >= heroSlides.length) currentHeroIndex = 0;

            // Animation d'entrée
            heroSlides[currentHeroIndex].classList.add('active');
            heroDots[currentHeroIndex].classList.add('active');

            // Nettoyer la classe exiting après transition
            setTimeout(() => {
                heroSlides.forEach(slide => slide.classList.remove('exiting'));
            }, 1000);

            resetProgress();
        }

        function nextHeroSlide() {
            goToHeroSlide(currentHeroIndex + 1);
        }

        function prevHeroSlide() {
            goToHeroSlide(currentHeroIndex - 1);
        }

        function resetProgress() {
            heroProgressBar.style.transition = 'none';
            heroProgressBar.style.width = '0%';

            // Forcer le reflow
            heroProgressBar.offsetWidth;

            heroProgressBar.style.transition = `width ${slideDuration}ms linear`;
            heroProgressBar.style.width = '100%';
        }

        function startHeroAutoPlay() {
            resetProgress();
            heroInterval = setInterval(nextHeroSlide, slideDuration);
        }

        function pauseHeroAutoPlay() {
            clearInterval(heroInterval);
            // Pause progress bar
            const currentWidth = heroProgressBar.offsetWidth;
            const parentWidth = heroProgressBar.parentElement.offsetWidth;
            const percentage = (currentWidth / parentWidth) * 100;
            heroProgressBar.style.transition = 'none';
            heroProgressBar.style.width = percentage + '%';
        }

        // Event listeners
        if (heroNextBtn) {
            heroNextBtn.addEventListener('click', () => {
                pauseHeroAutoPlay();
                nextHeroSlide();
                startHeroAutoPlay();
            });
        }

        if (heroPrevBtn) {
            heroPrevBtn.addEventListener('click', () => {
                pauseHeroAutoPlay();
                prevHeroSlide();
                startHeroAutoPlay();
            });
        }

        heroDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                pauseHeroAutoPlay();
                goToHeroSlide(index);
                startHeroAutoPlay();
            });
        });

        // Pause on hover
        if (heroSlider) {
            heroSlider.addEventListener('mouseenter', pauseHeroAutoPlay);
            heroSlider.addEventListener('mouseleave', startHeroAutoPlay);
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            // Ne pas interférer si un champ de formulaire est focusé
            if (document.activeElement.tagName === 'INPUT' ||
                document.activeElement.tagName === 'TEXTAREA') return;

            if (e.key === 'ArrowLeft') {
                pauseHeroAutoPlay();
                prevHeroSlide();
                startHeroAutoPlay();
            } else if (e.key === 'ArrowRight') {
                pauseHeroAutoPlay();
                nextHeroSlide();
                startHeroAutoPlay();
            }
        });

        // Touch/Swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        if (heroSlider) {
            heroSlider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                pauseHeroAutoPlay();
            }, { passive: true });

            heroSlider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextHeroSlide();
                    } else {
                        prevHeroSlide();
                    }
                }
                startHeroAutoPlay();
            }, { passive: true });
        }

        // Start auto-play
        startHeroAutoPlay();
    };

    // =================================================================
    // SCROLL INDICATOR ANIMATION
    // =================================================================
    const initScrollIndicator = () => {
        const scrollIndicator = document.querySelector('.scroll-indicator');
        if (!scrollIndicator) return;

        // Hide on scroll
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;

            if (currentScroll > 100) {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.pointerEvents = 'none';
            } else {
                scrollIndicator.style.opacity = '1';
                scrollIndicator.style.pointerEvents = 'auto';
            }

            lastScroll = currentScroll;
        }, { passive: true });
    };

    // =================================================================
    // HERO CONTENT PARALLAX
    // =================================================================
    const initHeroParallax = () => {
        const heroContent = document.querySelectorAll('.hero-slide-content');
        if (!heroContent.length) return;

        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            const heroHeight = window.innerHeight;

            if (scrollY < heroHeight) {
                const progress = scrollY / heroHeight;
                const translateY = scrollY * 0.4;
                const opacity = 1 - (progress * 0.8);

                heroContent.forEach(content => {
                    content.style.transform = `translateY(${translateY}px)`;
                    content.style.opacity = opacity;
                });
            }
        }, { passive: true });
    };

    // =================================================================
    // WHY CARDS STAGGER ANIMATION
    // =================================================================
    const initWhyCardsAnimation = () => {
        const whyCards = document.querySelectorAll('.why-card');
        if (!whyCards.length) return;

        whyCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.15}s`;
        });
    };

    // =================================================================
    // PROCESS TIMELINE ANIMATION
    // =================================================================
    const initProcessAnimation = () => {
        const processItems = document.querySelectorAll('.process-item');
        if (!processItems.length) return;

        processItems.forEach((item, index) => {
            item.style.transitionDelay = `${index * 0.2}s`;
        });
    };

    // =================================================================
    // FIGURE ITEMS HOVER EFFECT
    // =================================================================
    const initFigureHover = () => {
        const figureItems = document.querySelectorAll('.figure-item');
        if (!figureItems.length) return;

        figureItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-12px) scale(1.02)';
            });

            item.addEventListener('mouseleave', () => {
                item.style.transform = '';
            });
        });
    };

    // =================================================================
    // TESTIMONIALS SLIDER
    // =================================================================
    const initTestimonialsSlider = () => {
        const wrapper = document.getElementById('testimonials-wrapper');
        const prevBtn = document.querySelector('.testimonials-prev');
        const nextBtn = document.querySelector('.testimonials-next');
        const cards = wrapper ? wrapper.querySelectorAll('.testimonial-card') : [];

        if (!wrapper || !prevBtn || !nextBtn || !cards.length) return;

        let currentIndex = 0;
        let autoSlideInterval;
        const autoSlideDelay = 5000;

        // Calculate visible cards based on viewport
        const getVisibleCards = () => {
            if (window.innerWidth < 768) return 1;
            if (window.innerWidth < 992) return 2;
            return 3;
        };

        // Calculate scroll amount
        const getScrollAmount = () => {
            const card = cards[0];
            if (card) {
                const style = getComputedStyle(wrapper);
                const gap = parseInt(style.gap) || 20;
                return card.offsetWidth + gap;
            }
            return 350;
        };

        // Scroll to specific index
        const scrollToIndex = (index) => {
            const maxIndex = Math.max(0, cards.length - getVisibleCards());
            currentIndex = Math.max(0, Math.min(index, maxIndex));
            const scrollAmount = currentIndex * getScrollAmount();
            wrapper.scrollTo({ left: scrollAmount, behavior: 'smooth' });
        };

        // Navigate
        const slideNext = () => {
            const maxIndex = Math.max(0, cards.length - getVisibleCards());
            if (currentIndex >= maxIndex) {
                scrollToIndex(0);
            } else {
                scrollToIndex(currentIndex + 1);
            }
        };

        const slidePrev = () => {
            if (currentIndex <= 0) {
                scrollToIndex(cards.length - getVisibleCards());
            } else {
                scrollToIndex(currentIndex - 1);
            }
        };

        // Update button states
        const updateButtons = () => {
            const scrollLeft = wrapper.scrollLeft;
            const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;

            prevBtn.style.opacity = scrollLeft <= 5 ? '0.4' : '1';
            nextBtn.style.opacity = scrollLeft >= maxScroll - 5 ? '0.4' : '1';
        };

        // Auto slide
        const startAutoSlide = () => {
            stopAutoSlide();
            autoSlideInterval = setInterval(slideNext, autoSlideDelay);
        };

        const stopAutoSlide = () => {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
            }
        };

        // Event listeners
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            slideNext();
            startAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            slidePrev();
            startAutoSlide();
        });

        wrapper.addEventListener('scroll', () => {
            updateButtons();
            // Update currentIndex based on scroll position
            currentIndex = Math.round(wrapper.scrollLeft / getScrollAmount());
        }, { passive: true });

        // Pause on hover
        wrapper.addEventListener('mouseenter', stopAutoSlide);
        wrapper.addEventListener('mouseleave', startAutoSlide);

        // Touch swipe support
        let touchStartX = 0;
        let touchStartScrollLeft = 0;

        wrapper.addEventListener('touchstart', (e) => {
            stopAutoSlide();
            touchStartX = e.changedTouches[0].screenX;
            touchStartScrollLeft = wrapper.scrollLeft;
        }, { passive: true });

        wrapper.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    slideNext();
                } else {
                    slidePrev();
                }
            }
            startAutoSlide();
        }, { passive: true });

        // Initialize
        updateButtons();
        startAutoSlide();
    };

    // =================================================================
    // SPLASH SCREEN
    // =================================================================
    const initSplashScreen = () => {
        const splashScreen = document.getElementById('splash-screen');
        if (!splashScreen) return;

        // Hide splash screen after 3 seconds
        setTimeout(() => {
            splashScreen.classList.add('hidden');
            // Remove from DOM after transition
            setTimeout(() => {
                splashScreen.remove();
            }, 600);
        }, 3000);
    };

    // =================================================================
    // INITIALIZE ALL
    // =================================================================
    const init = () => {
        initSplashScreen();
        initHeroSlider();
        initScrollIndicator();
        initHeroParallax();
        initWhyCardsAnimation();
        initProcessAnimation();
        initFigureHover();
        initTestimonialsSlider();
    };

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
