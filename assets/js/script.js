// CloudDix - Interactive JavaScript

(function() {
    'use strict';

    // ===================================
    // NAVIGATION
    // ===================================
    
    const navbar = document.getElementById('navbar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navLinks = document.getElementById('navLinks');

    // Mobile menu toggle
    if (mobileMenuToggle && navLinks) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Close menu when clicking on a link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navbar.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    }

    // Navbar scroll effect
    function handleNavbarScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleNavbarScroll);

    // ===================================
    // SERVICES CAROUSEL AUTO-SCROLL
    // ===================================
    
    const servicesGrid = document.querySelector('.services-grid');
    const dotsContainer = document.getElementById('servicesDots');
    
    if (servicesGrid && dotsContainer) {
        const cards = servicesGrid.querySelectorAll('.service-card');
        const totalCards = cards.length;
        
        // Create dots
        for (let i = 0; i < totalCards; i++) {
            const dot = document.createElement('div');
            dot.classList.add('carousel-dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => scrollToCard(i));
            dotsContainer.appendChild(dot);
        }
        
        const dots = dotsContainer.querySelectorAll('.carousel-dot');
        
        let autoScrollInterval;
        let isUserScrolling = false;
        let scrollTimeout;
        let currentIndex = 0;
        
        function updateDots(index) {
            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[index]) {
                dots[index].classList.add('active');
            }
        }
        
        function scrollToCard(index) {
            const cardWidth = cards[0].offsetWidth;
            const gap = 32; // spacing-xl
            const scrollAmount = (cardWidth + gap) * index;
            
            servicesGrid.scrollTo({ left: scrollAmount, behavior: 'smooth' });
            currentIndex = index;
            updateDots(index);
            
            // Reset auto-scroll timer
            isUserScrolling = true;
            clearInterval(autoScrollInterval);
            clearTimeout(scrollTimeout);
            
            scrollTimeout = setTimeout(() => {
                isUserScrolling = false;
                autoScrollInterval = setInterval(autoScrollServices, 4000);
            }, 3000);
        }
        
        function autoScrollServices() {
            if (isUserScrolling) return;
            
            const cardWidth = cards[0].offsetWidth;
            const gap = 32; // spacing-xl
            const scrollAmount = cardWidth + gap;
            
            // Check if at the end
            if (servicesGrid.scrollLeft + servicesGrid.clientWidth >= servicesGrid.scrollWidth - 10) {
                // Reset to beginning
                servicesGrid.scrollTo({ left: 0, behavior: 'smooth' });
                currentIndex = 0;
            } else {
                // Scroll to next card
                servicesGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                currentIndex++;
                if (currentIndex >= totalCards) currentIndex = 0;
            }
            
            updateDots(currentIndex);
        }
        
        // Update dots based on scroll position
        servicesGrid.addEventListener('scroll', () => {
            const cardWidth = cards[0].offsetWidth;
            const gap = 32;
            const scrollPos = servicesGrid.scrollLeft;
            const newIndex = Math.round(scrollPos / (cardWidth + gap));
            
            if (newIndex !== currentIndex) {
                currentIndex = newIndex;
                updateDots(currentIndex);
            }
            
            isUserScrolling = true;
            clearTimeout(scrollTimeout);
            clearInterval(autoScrollInterval);
            
            // Resume after 3 seconds of no interaction
            scrollTimeout = setTimeout(() => {
                isUserScrolling = false;
                autoScrollInterval = setInterval(autoScrollServices, 4000);
            }, 3000);
        });
        
        // Start auto-scroll
        autoScrollInterval = setInterval(autoScrollServices, 4000);
        
        // Pause on hover
        servicesGrid.addEventListener('mouseenter', () => {
            clearInterval(autoScrollInterval);
        });
        
        // Resume on mouse leave
        servicesGrid.addEventListener('mouseleave', () => {
            if (!isUserScrolling) {
                autoScrollInterval = setInterval(autoScrollServices, 4000);
            }
        });
    }

    // ===================================
    // SMOOTH SCROLL
    // ===================================
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#' || href === '#!') {
                e.preventDefault();
                return;
            }

            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                const offsetTop = target.offsetTop - 80;
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===================================
    // CONTACT FORM
    // ===================================
    
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;

            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span>Enviando...</span>';

            try {
                // Envia o formulário para o backend PHP
                const response = await fetch('send-email.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Success message
                    showNotification(result.message, 'success');
                    contactForm.reset();
                } else {
                    // Error message from server
                    showNotification(result.message, 'error');
                }

            } catch (error) {
                // Network or parsing error
                showNotification('Erro ao enviar mensagem. Tente novamente ou entre em contato via WhatsApp.', 'error');
                console.error('Erro:', error);
            } finally {
                // Reset button
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    // ===================================
    // NOTIFICATION SYSTEM
    // ===================================
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${type === 'success' ? '✓' : '✕'}</span>
                <span class="notification-message">${message}</span>
            </div>
        `;

        // Add styles if not already present
        if (!document.getElementById('notification-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-styles';
            style.textContent = `
                .notification {
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    z-index: 10000;
                    background: white;
                    border-radius: 12px;
                    padding: 1rem 1.5rem;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                    animation: slideInRight 0.3s ease-out;
                    max-width: 400px;
                }
                .notification-success {
                    border-left: 4px solid #10b981;
                }
                .notification-error {
                    border-left: 4px solid #ef4444;
                }
                .notification-content {
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                }
                .notification-icon {
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    flex-shrink: 0;
                }
                .notification-success .notification-icon {
                    background: #d1fae5;
                    color: #10b981;
                }
                .notification-error .notification-icon {
                    background: #fee2e2;
                    color: #ef4444;
                }
                .notification-message {
                    color: #1e293b;
                    font-size: 0.9375rem;
                    line-height: 1.5;
                }
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOutRight {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        document.body.appendChild(notification);

        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // ===================================
    // SCROLL REVEAL ANIMATION
    // ===================================
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.service-card, .case-card, .feature-box').forEach(el => {
        observer.observe(el);
    });

    // ===================================
    // COUNTER ANIMATION
    // ===================================
    
    function animateCounter(element) {
        const target = parseInt(element.textContent.replace(/\D/g, ''));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        const suffix = element.textContent.replace(/[0-9]/g, '');

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target + suffix;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
        }, 16);
    }

    // Animate stats when they come into view
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target.querySelector('.stat-number');
                if (statNumber && !statNumber.classList.contains('animated')) {
                    statNumber.classList.add('animated');
                    animateCounter(statNumber);
                }
                statsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-item').forEach(el => {
        statsObserver.observe(el);
    });

    // ===================================
    // PARALLAX EFFECT
    // ===================================
    
    function handleParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-card');

        parallaxElements.forEach((el, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrolled * speed);
            el.style.transform = `translateY(${yPos}px)`;
        });
    }

    window.addEventListener('scroll', handleParallax);

    // ===================================
    // FORM VALIDATION
    // ===================================
    
    const formInputs = document.querySelectorAll('.contact-form input, .contact-form textarea');

    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                validateInput(this);
            }
        });
    });

    function validateInput(input) {
        const value = input.value.trim();
        let isValid = true;

        if (input.hasAttribute('required') && value === '') {
            isValid = false;
        }

        if (input.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
        }

        if (isValid) {
            input.classList.remove('invalid');
            input.classList.add('valid');
        } else {
            input.classList.add('invalid');
            input.classList.remove('valid');
        }

        return isValid;
    }

    // ===================================
    // WHATSAPP INTEGRATION
    // ===================================
    
    // Create floating WhatsApp button
    const whatsappButton = document.createElement('a');
    whatsappButton.href = 'https://wa.me/5511941731330?text=Ol%C3%A1%20Eduardo!%20Vim%20do%20site%20CloudDix%20e%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es.';
    whatsappButton.target = '_blank';
    whatsappButton.rel = 'noopener noreferrer';
    whatsappButton.className = 'whatsapp-float';
    whatsappButton.innerHTML = `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="white">
            <path d="M16 0C7.163 0 0 7.163 0 16c0 2.83.741 5.491 2.037 7.796L.071 31.929l8.337-2.186A15.917 15.917 0 0016 32c8.837 0 16-7.163 16-16S24.837 0 16 0zm8.289 22.617c-.365 1.024-1.806 1.879-2.953 2.134-.784.17-1.81.307-5.257-1.129-4.415-1.838-7.258-6.298-7.478-6.591-.215-.293-1.762-2.347-1.762-4.478s1.114-3.178 1.508-3.611c.394-.433.861-.541 1.148-.541.288 0 .575.003.827.015.265.014.621-.101.971.741.359.865 1.229 3.001 1.334 3.218.106.217.177.47.036.755-.141.285-.212.463-.424.713-.212.25-.446.557-.636.748-.212.212-.433.441-.186.867.247.426 1.1 1.816 2.362 2.942 1.624 1.449 2.993 1.899 3.419 2.112.426.212.675.177.923-.107.247-.285 1.061-1.236 1.345-1.661.285-.426.57-.355.961-.213.391.142 2.483 1.171 2.909 1.384.426.213.71.32.813.497.103.178.103 1.025-.262 2.018z"/>
        </svg>
    `;

    // Add WhatsApp button styles
    const whatsappStyle = document.createElement('style');
    whatsappStyle.textContent = `
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            animation: whatsapp-pulse 2s infinite;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(37, 211, 102, 0.6);
        }
        @keyframes whatsapp-pulse {
            0%, 100% {
                box-shadow: 0 10px 30px rgba(37, 211, 102, 0.4);
            }
            50% {
                box-shadow: 0 10px 30px rgba(37, 211, 102, 0.6), 0 0 0 15px rgba(37, 211, 102, 0.1);
            }
        }
        @media (max-width: 768px) {
            .whatsapp-float {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
            .whatsapp-float svg {
                width: 26px;
                height: 26px;
            }
        }
    `;
    document.head.appendChild(whatsappStyle);
    document.body.appendChild(whatsappButton);

    // ===================================
    // PERFORMANCE MONITORING
    // ===================================
    
    // Log page load time
    window.addEventListener('load', () => {
        const loadTime = performance.timing.domContentLoadedEventEnd - performance.timing.navigationStart;
        console.log(`Page loaded in ${loadTime}ms`);
    });

    // ===================================
    // INITIALIZE
    // ===================================
    
    console.log('Site carregado!');

})();
