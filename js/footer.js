/* ========================================================
   footer.js — Header, Navigation & Footer Interactions
   Loaded automatically by load-components.js after both
   components are injected into the DOM.
   ======================================================== */

(function () {

    /* ── Header scroll effect ── */
    var header   = document.getElementById('header');
    var backToTop = document.getElementById('back-to-top');

    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            if (backToTop) {
                if (window.scrollY > 400) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            }
        });
    }

    /* ── Back-to-top button ── */
    if (backToTop) {
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ── Mobile navigation toggle ── */
    var navToggle = document.getElementById('nav-toggle');
    var navMenu   = document.getElementById('nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function () {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        document.querySelectorAll('.nav-link, .nav-cta, .dropdown-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    /* ── Highlight active nav link ── */
    var currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-link').forEach(function (link) {
        var href = link.getAttribute('href');
        if (href && href === currentPage) {
            link.classList.add('active');
        }
    });

    /* ── Free Trial Modal (triggered by href="#free-trial" links) ── */
    var overlay = document.getElementById('trialModalOverlay');
    var closeBtn = document.getElementById('trialModalClose');

    if (overlay && closeBtn) {
        function openModal(e) {
            e.preventDefault();
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Intercept all links pointing to #free-trial
        document.querySelectorAll('a[href="#free-trial"]').forEach(function (el) {
            el.addEventListener('click', openModal);
        });

        closeBtn.addEventListener('click', closeModal);

        // Close on backdrop click
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        // File input label update
        var modalFile = document.getElementById('modal-file-input');
        if (modalFile) {
            modalFile.addEventListener('change', function () {
                var label = modalFile.parentElement.querySelector('.file-name');
                if (label) label.textContent = modalFile.files[0] ? modalFile.files[0].name : 'No file chosen';
            });
        }
    }

})();
