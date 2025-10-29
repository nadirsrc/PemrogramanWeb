// JavaScript Document
/*
TemplateMo 597 Neural Glass
https://templatemo.com/tm-597-neural-glass
*/
document.addEventListener('DOMContentLoaded', () => {

    // Mobile menu functionality
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');

    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenuToggle.classList.toggle('active');
            mobileNav.classList.toggle('active');
        });

        // Close mobile menu when clicking on links
        document.querySelectorAll('.mobile-nav a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuToggle.classList.remove('active');
                mobileNav.classList.remove('active');
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (mobileMenuToggle && mobileNav && !mobileMenuToggle.contains(e.target) && !mobileNav.contains(e.target)) {
                mobileMenuToggle.classList.remove('active');
                mobileNav.classList.remove('active');
            }
        });
    }

    // Enhanced smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            
            // Skip if href is just "#"
            if (targetId === '#') return;
            
            try {
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            } catch (error) {
                console.warn('Smooth scroll target not found:', targetId);
            }
        });
    });

    // Enhanced header functionality
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (!header) return;
        const scrolled = window.pageYOffset;
        
        if (scrolled > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Active menu item highlighting
    function updateActiveMenuItem() {
        try {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-links a, .mobile-nav a');
            
            let currentSection = 'home'; // Default ke home
            const scrollPos = window.pageYOffset + 150; // Offset agar lebih akurat
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                
                if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                    currentSection = section.getAttribute('id');
                }
            });

            // Jika di paling bawah, aktifkan link terakhir
            if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight - 50) {
                const lastSection = sections[sections.length - 1];
                if(lastSection) currentSection = lastSection.getAttribute('id');
            }
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active');
                }
            });
        } catch (error) {
            console.error('Error updating active menu item:', error);
        }
    }

    window.addEventListener('scroll', updateActiveMenuItem);
    window.addEventListener('load', updateActiveMenuItem);

    // Parallax effect for geometric shapes (SESUAI PERMINTAAN)
    window.addEventListener('scroll', () => {
        const shapes = document.querySelectorAll('.shape');
        const scrolled = window.pageYOffset;
        
        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.1; // Kecepatan dikurangi agar tidak terlalu liar
            shape.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.05}deg)`;
        });
    });

    // Neural lines pulse effect (SESUAI PERMINTAAN)
    const neuralLines = document.querySelectorAll('.neural-line');
    if (neuralLines.length > 0) {
        setInterval(() => {
            neuralLines.forEach((line, index) => {
                setTimeout(() => {
                    line.style.opacity = '1';
                    line.style.transform = 'scaleX(1.2)';
                    setTimeout(() => {
                        line.style.opacity = '0.2';
                        line.style.transform = 'scaleX(0.5)';
                    }, 200);
                }, index * 300);
            });
        }, 2000);
    }

    // Enhanced particle generation (SESUAI PERMINTAAN)
    function createQuantumParticle() {
        try {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.width = Math.random() * 4 + 1 + 'px';
            particle.style.height = particle.style.width;
            particle.style.background = ['#00ffff', '#ff0080', '#8000ff'][Math.floor(Math.random() * 3)];
            particle.style.borderRadius = '50%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = '100vh';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '-1';
            particle.style.boxShadow = `0 0 10px ${particle.style.background}`;
            
            document.body.appendChild(particle);
            
            const duration = Math.random() * 3000 + 2000;
            const drift = (Math.random() - 0.5) * 200;
            
            particle.animate([
                { transform: 'translateY(0px) translateX(0px)', opacity: 0 },
                { transform: `translateY(-100vh) translateX(${drift}px)`, opacity: 1 }
            ], {
                duration: duration,
                easing: 'ease-out'
            }).onfinish = () => particle.remove();
        } catch (error) {
            // Jangan spam console jika ada error
        }
    }

    // Generate quantum particles
    setInterval(createQuantumParticle, 1500);

    // Intersection Observer for animations
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) rotateY(0) rotateX(0)';
                    observer.unobserve(entry.target); // Hanya animasikan sekali
                }
            });
        }, observerOptions);

        // Observe timeline items dan elemen baru
        document.querySelectorAll('.timeline-content, .hexagon, .issue-content, .details-grid, .details-full-width-card, .article-card').forEach(el => {
            el.style.opacity = '0';
            // Memberi efek 3D yang lebih halus
            if (el.classList.contains('timeline-content') && el.parentElement.matches(':nth-child(odd)')) {
                el.style.transform = 'translateY(50px) rotateY(-10deg)';
            } else if (el.classList.contains('timeline-content')) {
                 el.style.transform = 'translateY(50px) rotateY(10deg)';
            } else {
                el.style.transform = 'translateY(50px)';
            }
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });
    } else {
        // Fallback untuk browser lama
        document.querySelectorAll('.timeline-content, .hexagon, .issue-content, .details-grid, .details-full-width-card, .article-card').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
    }

    // Form submission effect (DIHAPUS)

}); // End of DOMContentLoaded