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

    /* ---------- Video Testimonial Slider ---------- */
    (function () {
        const slides   = document.querySelectorAll('.vt-slide');
        const avatars  = document.querySelectorAll('.vt-avatar');
        const prevBtn  = document.getElementById('vtPrev');
        const nextBtn  = document.getElementById('vtNext');
        const currEl   = document.getElementById('vtCurrent');
        const totalEl  = document.getElementById('vtTotal');
        const playBtns = document.querySelectorAll('.vt-play');
        const modal    = document.getElementById('vtModal');
        const backdrop = document.getElementById('vtBackdrop');
        const closeBtn = document.getElementById('vtClose');
        const iframe   = document.getElementById('vtIframe');

        if (!slides.length) return;

        let current = 0;
        const total = slides.length;
        let autoTimer = null;
        let touchStartX = 0;

        if (totalEl) totalEl.textContent = total;

        function goTo(idx) {
            if (idx < 0) idx = total - 1;
            if (idx >= total) idx = 0;
            slides.forEach(function (s) { s.classList.remove('active'); });
            avatars.forEach(function (a) { a.classList.remove('active'); });
            slides[idx].classList.add('active');
            if (avatars[idx]) avatars[idx].classList.add('active');
            current = idx;
            if (currEl) currEl.textContent = current + 1;
        }

        function startAuto() { autoTimer = setInterval(function () { goTo(current + 1); }, 4000); }
        function stopAuto()  { clearInterval(autoTimer); }
        function resetAuto() { stopAuto(); startAuto(); }

        if (prevBtn) prevBtn.addEventListener('click', function () { resetAuto(); goTo(current - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { resetAuto(); goTo(current + 1); });

        avatars.forEach(function (av, i) {
            av.addEventListener('click', function () { resetAuto(); goTo(i); });
        });

        const leftCol = document.querySelector('.vt-left');
        if (leftCol) {
            leftCol.addEventListener('mouseenter', stopAuto);
            leftCol.addEventListener('mouseleave', startAuto);
        }

        // Touch swipe
        const track = document.getElementById('vtTrack');
        if (track) {
            track.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
            track.addEventListener('touchend', function (e) {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) >= 50) { resetAuto(); goTo(diff > 0 ? current + 1 : current - 1); }
            }, { passive: true });
        }

        // Modal open
        function openModal(videoId) {
            if (!videoId || !iframe || !modal) return;
            iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1&color=white';
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            if (!modal || !iframe) return;
            modal.classList.remove('open');
            iframe.src = '';
            document.body.style.overflow = '';
        }

        playBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const slide = btn.closest('.vt-slide');
                const videoId = slide ? slide.getAttribute('data-video-id') : null;
                if (videoId) { stopAuto(); openModal(videoId); }
            });
        });

        if (backdrop) backdrop.addEventListener('click', function () { closeModal(); startAuto(); });
        if (closeBtn) closeBtn.addEventListener('click', function () { closeModal(); startAuto(); });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && modal.classList.contains('open')) { closeModal(); startAuto(); }
            if (!modal || !modal.classList.contains('open')) {
                if (e.key === 'ArrowLeft')  { resetAuto(); goTo(current - 1); }
                if (e.key === 'ArrowRight') { resetAuto(); goTo(current + 1); }
            }
        });

        goTo(0);
        startAuto();
    }());

    /* ---------- Service Image Lightbox ---------- */
    (function () {
        const serviceImages = document.querySelectorAll('.service-image');
        const lightbox = document.getElementById('serviceLightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxTitle = document.getElementById('lightboxTitle');
        const lightboxBackdrop = document.getElementById('lightboxBackdrop');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');

        if (!serviceImages.length || !lightbox) return;

        const galleryData = Array.from(serviceImages).map(function (img) {
            return {
                src: img.getAttribute('data-image'),
                title: img.getAttribute('data-title')
            };
        });

        let currentIndex = 0;

        function openLightbox(index) {
            if (index < 0) index = galleryData.length - 1;
            if (index >= galleryData.length) index = 0;
            currentIndex = index;

            lightboxImage.src = galleryData[currentIndex].src;
            lightboxTitle.textContent = galleryData[currentIndex].title;
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('open');
            document.body.style.overflow = '';
        }

        // Click on service image to open
        serviceImages.forEach(function (img, index) {
            img.addEventListener('click', function () {
                openLightbox(index);
            });
        });

        // Navigation
        if (lightboxPrev) lightboxPrev.addEventListener('click', function () { openLightbox(currentIndex - 1); });
        if (lightboxNext) lightboxNext.addEventListener('click', function () { openLightbox(currentIndex + 1); });

        // Close
        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);

        // Keyboard
        document.addEventListener('keydown', function (e) {
            if (!lightbox.classList.contains('open')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') openLightbox(currentIndex - 1);
            if (e.key === 'ArrowRight') openLightbox(currentIndex + 1);
        });
    }());

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
