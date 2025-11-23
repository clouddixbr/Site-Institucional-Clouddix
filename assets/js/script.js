// CloudDix - Interactive JavaScript

(function() {
    'use strict';

    // ===================================
    // NAVIGATION
    // ===================================
    
    const navbar = document.getElementById('navbar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Navbar scroll effect
    function handleNavbarScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleNavbarScroll);

    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
    }

    // Close mobile menu on link click
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            if (mobileMenuToggle) {
                mobileMenuToggle.classList.remove('active');
            }
        });
    });

    // Active section highlighting
    function setActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        const scrollY = window.pageYOffset;

        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 100;
            const sectionId = section.getAttribute('id');
            const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                if (navLink) {
                    navLinks.forEach(link => link.classList.remove('active'));
                    navLink.classList.add('active');
                }
            }
        });
    }

    window.addEventListener('scroll', setActiveNavLink);

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
                // Simulate form submission (replace with actual API call)
                await new Promise(resolve => setTimeout(resolve, 1200));

                // Success message
                showNotification('Mensagem recebida! Vamos responder em breve.', 'success');
                contactForm.reset();

            } catch (error) {
                // Error message
                showNotification('Ops, algo deu errado. Tenta de novo ou manda no WhatsApp.', 'error');
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
    whatsappButton.href = 'https://api.whatsapp.com/send?phone=5511975427080&text=Oi!%20Vim%20do%20site%20e%20queria%20conversar%20sobre%20cloud';
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
