// Load header and footer from components folder
(function () {
    const basePath = document.currentScript.src.split('/').slice(0, -1).join('/') + '/';

    // Create a container for the page content to fade in after components load
    function setupPageContent() {
        const main = document.querySelector('main') || document.body;
        main.style.opacity = '0';
        main.style.transition = 'opacity 0.4s ease';

        setTimeout(() => {
            main.style.opacity = '1';
        }, 50);
    }

    // Load header
    fetch(basePath + 'header.html')
        .then(response => {
            if (!response.ok) throw new Error('Header load failed');
            return response.text();
        })
        .then(html => {
            const headerContainer = document.createElement('div');
            headerContainer.innerHTML = html;
            document.body.insertBefore(headerContainer, document.body.firstChild);

            // Re-initialize header functionality
            initializeHeader();
        })
        .catch(error => console.warn('Could not load header:', error));

    // Load footer
    fetch(basePath + 'footer.html')
        .then(response => {
            if (!response.ok) throw new Error('Footer load failed');
            return response.text();
        })
        .then(html => {
            const footerContainer = document.createElement('div');
            footerContainer.innerHTML = html;
            document.body.appendChild(footerContainer);

            // Re-initialize footer functionality (back-to-top button, etc.)
            initializeFooter();
        })
        .catch(error => console.warn('Could not load footer:', error));

    // Initialize header functionality (from script.js)
    function initializeHeader() {
        const header = document.getElementById('header');
        const backToTop = document.getElementById('back-to-top');
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');

        if (!header) return;

        // Header scroll effect
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            if (window.scrollY > 400) {
                if (backToTop) backToTop.classList.add('show');
            } else {
                if (backToTop) backToTop.classList.remove('show');
            }
        });

        // Back to top button
        if (backToTop) {
            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Mobile navigation toggle
        if (navToggle && navMenu) {
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
        }
    }

    // Initialize footer functionality
    function initializeFooter() {
        setupPageContent();
    }

    // Also initialize on page load in case DOM was already ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupPageContent);
    } else {
        setupPageContent();
    }
})();
