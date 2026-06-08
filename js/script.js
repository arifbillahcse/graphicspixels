/* =========================================================
   Graphics Pixels — Home Page Interactions & Animations
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* ---------- Header scroll effect ---------- */
    const header = document.getElementById('header');
    const backToTop = document.getElementById('back-to-top');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        if (window.scrollY > 400) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });

    backToTop.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    /* ---------- Mobile navigation toggle ---------- */
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');

    navToggle.addEventListener('click', function () {
        navToggle.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Close mobile menu when a link is clicked
    document.querySelectorAll('.nav-link, .nav-cta, .dropdown-menu a').forEach(function (link) {
        link.addEventListener('click', function () {
            navToggle.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    /* ---------- Scroll reveal animations (Intersection Observer) ---------- */
    const revealElements = document.querySelectorAll('.reveal');

    const revealObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(function () {
                    entry.target.classList.add('visible');
                }, delay);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

    revealElements.forEach(function (el) { revealObserver.observe(el); });

    /* ---------- Animated counters for stats ---------- */
    const counters = document.querySelectorAll('.stat-number');
    let countersStarted = false;

    const counterObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting && !countersStarted) {
                countersStarted = true;
                counters.forEach(function (counter) {
                    animateCounter(counter);
                });
            }
        });
    }, { threshold: 0.4 });

    if (counters.length) {
        counterObserver.observe(document.querySelector('.stats'));
    }

    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-count'), 10);
        const suffix = el.getAttribute('data-suffix') || '';
        const duration = 2000;
        const startTime = performance.now();

        function update(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            // ease-out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.floor(eased * target);
            el.textContent = value.toLocaleString() + suffix;
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = target.toLocaleString() + suffix;
            }
        }
        requestAnimationFrame(update);
    }

    /* ---------- Testimonial slider ---------- */
    const cards = document.querySelectorAll('.testimonial-card');
    const dotsContainer = document.getElementById('slider-dots');
    let current = 0;
    let autoplay;

    if (cards.length && dotsContainer) {
        // Build dots
        cards.forEach(function (_, i) {
            const dot = document.createElement('button');
            dot.setAttribute('aria-label', 'Go to testimonial ' + (i + 1));
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', function () { goToSlide(i); });
            dotsContainer.appendChild(dot);
        });

        const dots = dotsContainer.querySelectorAll('button');

        function goToSlide(index) {
            cards[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = index;
            cards[current].classList.add('active');
            dots[current].classList.add('active');
        }

        function nextSlide() {
            goToSlide((current + 1) % cards.length);
        }

        function startAutoplay() {
            autoplay = setInterval(nextSlide, 5000);
        }
        function stopAutoplay() { clearInterval(autoplay); }

        startAutoplay();

        const slider = document.querySelector('.testimonial-slider');
        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);
    }

    /* ---------- File upload filename display ---------- */
    const fileInput = document.getElementById('file-input');
    const fileName = document.querySelector('.file-name');
    if (fileInput) {
        fileInput.addEventListener('change', function () {
            fileName.textContent = fileInput.files.length ? fileInput.files[0].name : 'No file chosen';
        });
    }

    /* ---------- Free trial form (demo handler) ---------- */
    const trialForm = document.getElementById('trial-form');
    if (trialForm) {
        trialForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = trialForm.querySelector('button[type="submit"]');
            const original = btn.textContent;
            btn.textContent = 'Sending...';
            btn.disabled = true;
            setTimeout(function () {
                btn.textContent = '✓ Message Sent!';
                trialForm.reset();
                if (fileName) fileName.textContent = 'No file chosen';
                setTimeout(function () {
                    btn.textContent = original;
                    btn.disabled = false;
                }, 2500);
            }, 1200);
        });
    }

});
