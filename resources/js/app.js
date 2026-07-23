import './bootstrap';
import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'lazysizes';

// ── Make Swiper available globally so inline blade scripts can use it ──
window.Swiper = Swiper;

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize GSAP
gsap.registerPlugin(ScrollTrigger);

// Animate on scroll
document.addEventListener('DOMContentLoaded', () => {
    // Hero animations
    gsap.from('.hero-content', {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: 'power3.out'
    });

    // Section animations
    gsap.utils.toArray('.animate-on-scroll').forEach(element => {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element,
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 50,
            duration: 0.8,
            ease: 'power3.out'
        });
    });

    // Counter animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        gsap.to(counter, {
            scrollTrigger: {
                trigger: counter,
                start: 'top 80%',
            },
            textContent: target,
            duration: 2,
            ease: 'power1.out',
            snap: { textContent: 1 },
            onUpdate: function() {
                counter.textContent = Math.ceil(counter.textContent);
            }
        });
    });

    // Initialize Swiper Sliders
    // Hero Slider
    if (document.querySelector('.hero-slider')) {
        new Swiper('.hero-slider', {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            effect: 'fade',
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.hero-slider .swiper-pagination', clickable: true },
            navigation: { nextEl: '.hero-slider .swiper-button-next', prevEl: '.hero-slider .swiper-button-prev' },
        });
    }

    // Product Slider
    if (document.querySelector('.product-slider')) {
        new Swiper('.product-slider', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: '.product-slider .swiper-pagination', clickable: true },
            navigation: { nextEl: '.product-slider .swiper-button-next', prevEl: '.product-slider .swiper-button-prev' },
            breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } },
        });
    }

    // Testimonials Slider (legacy .testimonials-slider — kept for backwards compat)
    if (document.querySelector('.testimonials-slider')) {
        new Swiper('.testimonials-slider', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.testimonials-slider .swiper-pagination', clickable: true },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        });
    }

    // NEW Testimonials Swiper (home page & about page)
    if (document.querySelector('.testimonials-swiper')) {
        new Swiper('.testimonials-swiper', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
            pagination: { el: '.testimonials-dots', clickable: true },
            navigation: { nextEl: '.t-next', prevEl: '.t-prev' },
            breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        });
    }

    // About Us testimonials swiper
    if (document.querySelector('.about-testimonials-swiper')) {
        new Swiper('.about-testimonials-swiper', {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
            pagination: { el: '.about-t-dots', clickable: true },
            navigation: { nextEl: '.at-next', prevEl: '.at-prev' },
            breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        });
    }

    // Clients Logo Slider
    if (document.querySelector('.clients-slider')) {
        new Swiper('.clients-slider', {
            modules: [Autoplay],
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            autoplay: { delay: 2000, disableOnInteraction: false },
            breakpoints: { 640: { slidesPerView: 3 }, 768: { slidesPerView: 4 }, 1024: { slidesPerView: 6 } },
        });
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('#mobile-menu-btn');
    const mobileMenu = document.querySelector('#mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Sticky Header
    const header = document.querySelector('header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.classList.add('sticky', 'shadow-md');
            } else {
                header.classList.remove('sticky', 'shadow-md');
            }

            lastScroll = currentScroll;
        });
    }

    // Newsletter Form
    const newsletterForm = document.querySelector('#newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(newsletterForm);
            
            try {
                const response = await fetch(newsletterForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Successfully subscribed to newsletter!');
                    newsletterForm.reset();
                } else {
                    alert(data.message || 'Something went wrong!');
                }
            } catch (error) {
                alert('Network error. Please try again.');
            }
        });
    }

    // Contact Form
    const contactForm = document.querySelector('#contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(contactForm);
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Message sent successfully! We will contact you soon.');
                    contactForm.reset();
                } else {
                    alert(data.message || 'Something went wrong!');
                }
            } catch (error) {
                alert('Network error. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    // Back to Top Button
    const backToTop = document.querySelector('#back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('hidden');
            } else {
                backToTop.classList.add('hidden');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Image Lightbox
    const galleryImages = document.querySelectorAll('.gallery-image');
    galleryImages.forEach(image => {
        image.addEventListener('click', () => {
            const lightbox = document.createElement('div');
            lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
            lightbox.innerHTML = `
                <img src="${image.src}" class="max-w-full max-h-full object-contain" alt="${image.alt}">
                <button class="absolute top-4 right-4 text-white text-4xl">&times;</button>
            `;
            document.body.appendChild(lightbox);
            
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox || e.target.tagName === 'BUTTON') {
                    lightbox.remove();
                }
            });
        });
    });
});

// Performance: Preload critical resources
const preloadResources = () => {
    const links = [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: true },
    ];

    links.forEach(link => {
        const linkElement = document.createElement('link');
        Object.entries(link).forEach(([key, value]) => {
            linkElement.setAttribute(key, value);
        });
        document.head.appendChild(linkElement);
    });
};

preloadResources();
