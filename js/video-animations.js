/* ========================================================
   Video Editing Page — SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const veScene = document.querySelector('.ve-svg-scene');
    if (!veScene) return; // Only run on video-editing page

    const svg = document.querySelector('.ve-svg');
    if (!svg) return;

    /* ── Graphics Pixels Logo Animation ── */
    const logoIcon = document.querySelector('.ve-logo-icon');
    const logoImg = document.querySelector('.ve-logo-img');
    if (logoIcon) {
        let glowOpacity = 1;
        let glowDir = 1;
        let logoRotation = 0;

        // Glow pulse
        setInterval(function () {
            glowOpacity += glowDir * 0.03;
            if (glowOpacity >= 1.3) glowDir = -1;
            if (glowOpacity <= 0.7) glowDir = 1;
            const circle = logoIcon.querySelector('circle');
            if (circle) {
                circle.setAttribute('stroke-width', 2.5 * (glowOpacity / 1));
                circle.setAttribute('opacity', (0.6 + glowOpacity * 0.2));
            }
        }, 60);

        // Logo image rotation
        if (logoImg) {
            setInterval(function () {
                logoRotation += 1.5;
                if (logoRotation >= 360) logoRotation = 0;
                logoImg.setAttribute('transform', `rotate(${logoRotation})`);
            }, 40);
        }
    }

});
