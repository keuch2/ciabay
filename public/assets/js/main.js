/**
 * CIABAY - Main JavaScript
 * Handles all interactive functionality
 */

(function() {
    'use strict';

    // ============================================
    // DOM Elements
    // ============================================
    const elements = {
        searchBtn: document.getElementById('searchBtn'),
        searchOverlay: document.getElementById('searchOverlay'),
        searchClose: document.getElementById('searchClose'),
        searchInput: document.querySelector('.search-input'),
        mobileMenuToggle: document.getElementById('mobileMenuToggle'),
        mainNav: document.getElementById('mainNav'),
        navLinks: document.querySelectorAll('.nav-link'),
        body: document.body,
        carouselSlides: document.querySelectorAll('.carousel-slide'),
        carouselPrev: document.querySelector('.carousel-arrow-prev'),
        carouselNext: document.querySelector('.carousel-arrow-next'),
        carouselIndicators: document.querySelectorAll('.carousel-indicator'),
        redCaseSlides: document.querySelectorAll('.red-case-slide'),
        redCasePrev: document.querySelector('.red-case-arrow-prev'),
        redCaseNext: document.querySelector('.red-case-arrow-next'),
        redCaseIndicators: document.querySelectorAll('.red-case-indicator')
    };

    // ============================================
    // Search Overlay Functions
    // ============================================
    const searchOverlay = {
        open: function() {
            elements.searchOverlay.classList.add('active');
            elements.body.style.overflow = 'hidden';
            // Focus on input after animation
            setTimeout(() => {
                elements.searchInput.focus();
            }, 300);
        },

        close: function() {
            elements.searchOverlay.classList.remove('active');
            elements.body.style.overflow = '';
            elements.searchInput.value = '';
        },

        toggle: function() {
            if (elements.searchOverlay.classList.contains('active')) {
                this.close();
            } else {
                this.open();
            }
        }
    };

    // ============================================
    // Mobile Menu Functions
    // ============================================
    const mobileMenu = {
        open: function() {
            elements.mainNav.classList.add('active');
            elements.mobileMenuToggle.classList.add('active');
            elements.body.style.overflow = 'hidden';
        },

        close: function() {
            elements.mainNav.classList.remove('active');
            elements.mobileMenuToggle.classList.remove('active');
            elements.body.style.overflow = '';
            // Close all submenus when closing mobile menu
            document.querySelectorAll('.has-submenu').forEach(item => {
                item.classList.remove('active');
            });
        },

        toggle: function() {
            if (elements.mainNav.classList.contains('active')) {
                this.close();
            } else {
                this.open();
            }
        },

        toggleSubmenu: function(submenuItem) {
            // Close other submenus
            document.querySelectorAll('.has-submenu').forEach(item => {
                if (item !== submenuItem) {
                    item.classList.remove('active');
                }
            });
            // Toggle current submenu
            submenuItem.classList.toggle('active');
        }
    };

    // ============================================
    // Hero Carousel Functions
    // ============================================
    const heroCarousel = {
        currentSlide: 0,
        totalSlides: elements.carouselSlides.length,
        autoplayInterval: null,
        autoplayDelay: 5000,

        init: function() {
            if (this.totalSlides === 0) return;
            
            this.showSlide(0);
            this.startAutoplay();
        },

        showSlide: function(index) {
            // Remove active class from all slides and indicators
            elements.carouselSlides.forEach(slide => {
                slide.classList.remove('active');
            });
            
            elements.carouselIndicators.forEach(indicator => {
                indicator.classList.remove('active');
            });

            // Add active class to current slide and indicator
            if (elements.carouselSlides[index]) {
                elements.carouselSlides[index].classList.add('active');
            }
            
            if (elements.carouselIndicators[index]) {
                elements.carouselIndicators[index].classList.add('active');
            }

            this.currentSlide = index;
        },

        nextSlide: function() {
            let next = (this.currentSlide + 1) % this.totalSlides;
            this.showSlide(next);
            this.resetAutoplay();
        },

        prevSlide: function() {
            let prev = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.showSlide(prev);
            this.resetAutoplay();
        },

        goToSlide: function(index) {
            this.showSlide(index);
            this.resetAutoplay();
        },

        startAutoplay: function() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoplayDelay);
        },

        stopAutoplay: function() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },

        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    };

    // ============================================
    // Red Case Carousel Functions
    // ============================================
    const redCaseCarousel = {
        currentSlide: 0,
        totalSlides: elements.redCaseSlides.length,
        autoplayInterval: null,
        autoplayDelay: 5000,

        init: function() {
            if (this.totalSlides === 0) return;
            
            this.showSlide(0);
            this.startAutoplay();
        },

        showSlide: function(index) {
            // Remove active class from all slides and indicators
            elements.redCaseSlides.forEach(slide => {
                slide.classList.remove('active');
            });
            
            elements.redCaseIndicators.forEach(indicator => {
                indicator.classList.remove('active');
            });

            // Add active class to current slide and indicator
            if (elements.redCaseSlides[index]) {
                elements.redCaseSlides[index].classList.add('active');
            }
            
            if (elements.redCaseIndicators[index]) {
                elements.redCaseIndicators[index].classList.add('active');
            }

            this.currentSlide = index;
        },

        nextSlide: function() {
            let next = (this.currentSlide + 1) % this.totalSlides;
            this.showSlide(next);
            this.resetAutoplay();
        },

        prevSlide: function() {
            let prev = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.showSlide(prev);
            this.resetAutoplay();
        },

        goToSlide: function(index) {
            this.showSlide(index);
            this.resetAutoplay();
        },

        startAutoplay: function() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoplayDelay);
        },

        stopAutoplay: function() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },

        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    };

    // ============================================
    // Active Navigation Link
    // ============================================
    const setActiveNavLink = function() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;

        elements.navLinks.forEach(link => {
            link.classList.remove('active');
            
            const linkHref = link.getAttribute('href');
            
            // Check if it's a hash link
            if (linkHref.startsWith('#') && currentHash === linkHref) {
                link.classList.add('active');
            }
            // Check if it's a page link
            else if (!linkHref.startsWith('#') && currentPath.includes(linkHref)) {
                link.classList.add('active');
            }
        });
    };

    // ============================================
    // Smooth Scroll for Anchor Links
    // ============================================
    const smoothScroll = function(target) {
        const element = document.querySelector(target);
        if (element) {
            const headerOffset = 80; // Height of sticky header
            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    };

    // ============================================
    // Event Listeners
    // ============================================
    const initEventListeners = function() {
        // Search button click
        if (elements.searchBtn) {
            elements.searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                searchOverlay.open();
            });
        }

        // Search close button
        if (elements.searchClose) {
            elements.searchClose.addEventListener('click', function(e) {
                e.preventDefault();
                searchOverlay.close();
            });
        }

        // Close search overlay on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && elements.searchOverlay.classList.contains('active')) {
                searchOverlay.close();
            }
        });

        // Close search overlay on background click
        if (elements.searchOverlay) {
            elements.searchOverlay.addEventListener('click', function(e) {
                if (e.target === elements.searchOverlay) {
                    searchOverlay.close();
                }
            });
        }

        // Mobile menu toggle
        if (elements.mobileMenuToggle) {
            elements.mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileMenu.toggle();
            });
        }

        // Handle mobile submenu toggles
        document.querySelectorAll('.has-submenu > .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Only prevent default and toggle submenu on mobile
                if (window.innerWidth <= 768) {
                    const href = this.getAttribute('href');
                    // If it's a hash link (submenu trigger), prevent default and toggle
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        e.stopPropagation();
                        const parentItem = this.closest('.has-submenu');
                        mobileMenu.toggleSubmenu(parentItem);
                    }
                }
            });
        });

        // Close mobile menu when clicking nav links (non-submenu)
        elements.navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const isSubmenuParent = this.closest('.has-submenu') && this.parentElement.classList.contains('has-submenu');
                
                // Skip if it's a submenu parent on mobile
                if (isSubmenuParent && window.innerWidth <= 768 && href.startsWith('#')) {
                    return;
                }
                
                // If it's a hash link
                if (href.startsWith('#')) {
                    e.preventDefault();
                    smoothScroll(href);
                    mobileMenu.close();
                    
                    // Update URL hash
                    history.pushState(null, null, href);
                    setActiveNavLink();
                } else {
                    // For page links, just close the menu
                    mobileMenu.close();
                }
            });
        });

        // Handle hash changes
        window.addEventListener('hashchange', setActiveNavLink);

        // Carousel navigation arrows
        if (elements.carouselPrev) {
            elements.carouselPrev.addEventListener('click', function(e) {
                e.preventDefault();
                heroCarousel.prevSlide();
            });
        }

        if (elements.carouselNext) {
            elements.carouselNext.addEventListener('click', function(e) {
                e.preventDefault();
                heroCarousel.nextSlide();
            });
        }

        // Carousel indicators
        elements.carouselIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function(e) {
                e.preventDefault();
                heroCarousel.goToSlide(index);
            });
        });

        // Pause carousel on hover
        const carouselContainer = document.querySelector('.carousel-container');
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', function() {
                heroCarousel.stopAutoplay();
            });

            carouselContainer.addEventListener('mouseleave', function() {
                heroCarousel.startAutoplay();
            });
        }

        // Keyboard navigation for carousel
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                heroCarousel.prevSlide();
            } else if (e.key === 'ArrowRight') {
                heroCarousel.nextSlide();
            }
        });

        // Red Case carousel navigation arrows
        if (elements.redCasePrev) {
            elements.redCasePrev.addEventListener('click', function(e) {
                e.preventDefault();
                redCaseCarousel.prevSlide();
            });
        }

        if (elements.redCaseNext) {
            elements.redCaseNext.addEventListener('click', function(e) {
                e.preventDefault();
                redCaseCarousel.nextSlide();
            });
        }

        // Red Case carousel indicators
        elements.redCaseIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function(e) {
                e.preventDefault();
                redCaseCarousel.goToSlide(index);
            });
        });

        // Pause Red Case carousel on hover
        const redCaseContainer = document.querySelector('.red-case-carousel-container');
        if (redCaseContainer) {
            redCaseContainer.addEventListener('mouseenter', function() {
                redCaseCarousel.stopAutoplay();
            });

            redCaseContainer.addEventListener('mouseleave', function() {
                redCaseCarousel.startAutoplay();
            });
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Close mobile menu if window is resized to desktop
                if (window.innerWidth > 768) {
                    mobileMenu.close();
                }
            }, 250);
        });

        // Prevent search form submission (for now)
        const searchForm = document.querySelector('.search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchValue = elements.searchInput.value.trim();
                if (searchValue) {
                    console.log('Searching for:', searchValue);
                    // TODO: Implement actual search functionality
                    // For now, just close the overlay
                    searchOverlay.close();
                }
            });
        }
    };

    // ============================================
    // Header Scroll Effect (Optional)
    // ============================================
    const handleHeaderScroll = function() {
        const header = document.querySelector('.main-header');
        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            // Add shadow on scroll
            if (currentScroll > 10) {
                header.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }

            lastScroll = currentScroll;
        });
    };

    // ============================================
    // Brands Carousel
    // ============================================
    const brandsCarousel = {
        track: null,
        container: null,
        slides: null,
        prevBtn: null,
        nextBtn: null,
        currentPosition: 0,
        slideWidth: 0,
        visibleCount: 1,
        totalSlides: 0,
        autoplayInterval: null,

        init: function() {
            const self = this;
            this.track = document.querySelector('.brands-carousel-track');
            this.container = document.querySelector('.brands-carousel-track-container');
            this.slides = document.querySelectorAll('.brands-carousel-slide');
            this.prevBtn = document.querySelector('.brands-carousel-prev');
            this.nextBtn = document.querySelector('.brands-carousel-next');

            if (!this.track || this.slides.length === 0) return;

            this.totalSlides = this.slides.length;
            this.measure();

            if (this.prevBtn) {
                this.prevBtn.onclick = function(e) {
                    e.preventDefault();
                    self.prev();
                    self.resetAutoplay();
                };
            }
            if (this.nextBtn) {
                this.nextBtn.onclick = function(e) {
                    e.preventDefault();
                    self.next();
                    self.resetAutoplay();
                };
            }

            // Re-measure on resize so wrap-around stays correct
            window.addEventListener('resize', function () {
                self.measure();
                self.clampPosition();
                self.updatePosition();
            });

            this.startAutoplay();
        },

        measure: function () {
            if (this.slides.length < 2) {
                this.slideWidth = this.slides[0] ? this.slides[0].getBoundingClientRect().width : 0;
            } else {
                // Distance between two consecutive slides = slide width + gap
                const a = this.slides[0].getBoundingClientRect();
                const b = this.slides[1].getBoundingClientRect();
                this.slideWidth = b.left - a.left;
            }
            const containerWidth = this.container ? this.container.clientWidth : 0;
            this.visibleCount = this.slideWidth > 0
                ? Math.max(1, Math.floor((containerWidth + 1) / this.slideWidth))
                : 1;
        },

        maxPosition: function () {
            return Math.max(0, this.totalSlides - this.visibleCount);
        },

        clampPosition: function () {
            if (this.currentPosition > this.maxPosition()) this.currentPosition = this.maxPosition();
            if (this.currentPosition < 0) this.currentPosition = 0;
        },

        next: function() {
            if (this.currentPosition < this.maxPosition()) {
                this.currentPosition++;
            } else {
                this.currentPosition = 0;
            }
            this.updatePosition();
        },

        prev: function() {
            if (this.currentPosition > 0) {
                this.currentPosition--;
            } else {
                this.currentPosition = this.maxPosition();
            }
            this.updatePosition();
        },

        updatePosition: function() {
            const translateX = -this.currentPosition * this.slideWidth;
            this.track.style.transform = 'translateX(' + translateX + 'px)';
        },

        startAutoplay: function() {
            const self = this;
            this.stopAutoplay();
            this.autoplayInterval = setInterval(function() {
                self.next();
            }, 3000);
        },

        stopAutoplay: function() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },

        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    };

    // ============================================
    // Parallax Effect for Historia Hero (Disabled)
    // ============================================
    const parallaxEffect = {
        init: function() {
            // Parallax effect disabled - image is now displayed as full-width element
            return;
        }
    };

    // ============================================
    // Stats Counter Animation
    // ============================================
    const statsAnimation = {
        init: function() {
            const statCards = document.querySelectorAll('.stat-card');
            
            if (statCards.length === 0) return;
            
            const observerOptions = {
                threshold: 0.3,
                rootMargin: '0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const index = Array.from(statCards).indexOf(card);
                        
                        // Staggered slide-up animation
                        setTimeout(() => {
                            card.classList.add('animate-in');
                        }, index * 150);
                        
                        // Counter animation
                        const numberElement = card.querySelector('.stat-number');
                        if (numberElement) {
                            this.animateCounter(numberElement);
                        }
                        
                        observer.unobserve(card);
                    }
                });
            }, observerOptions);
            
            statCards.forEach((card) => {
                observer.observe(card);
            });
        },
        
        animateCounter: function(element) {
            const text = element.textContent;
            const hasPlus = text.includes('+');
            const number = parseInt(text.replace(/\D/g, ''));
            
            if (isNaN(number)) return;
            
            const duration = 2000;
            const steps = 60;
            const increment = number / steps;
            const stepDuration = duration / steps;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= number) {
                    element.textContent = (hasPlus ? '+' : '') + number;
                    clearInterval(timer);
                } else {
                    element.textContent = (hasPlus ? '+' : '') + Math.floor(current);
                }
            }, stepDuration);
        }
    };

    // ============================================
    // Timeline Animation
    // ============================================
    const timelineAnimation = {
        init: function() {
            const timelineItems = document.querySelectorAll('.timeline-item');
            
            if (timelineItems.length === 0) return;
            
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -100px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animate-in');
                        }, index * 150);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            timelineItems.forEach((item) => {
                observer.observe(item);
            });
        }
    };

    // ============================================
    // Initialize
    // ============================================
    const init = function() {
        // Check if DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initEventListeners();
                setActiveNavLink();
                handleHeaderScroll();
                heroCarousel.init();
                redCaseCarousel.init();
                brandsCarousel.init();
                parallaxEffect.init();
                statsAnimation.init();
                timelineAnimation.init();
            });
        } else {
            initEventListeners();
            setActiveNavLink();
            handleHeaderScroll();
            heroCarousel.init();
            redCaseCarousel.init();
            brandsCarousel.init();
            parallaxEffect.init();
            statsAnimation.init();
            timelineAnimation.init();
        }

        // Log initialization
        console.log('Ciabay website initialized successfully');
    };

    // Start the application
    init();

})();
