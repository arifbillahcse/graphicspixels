/* ========================================================
   Contact Page — Small SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const contactScene = document.querySelector('.contact-svg-small');
    if (!contactScene) return;

    /* ── Center Circle Glow Pulse ── */
    const centerCircle = document.querySelector('.contact-small-center');
    if (centerCircle) {
        let glowOpacity = 1;
        let glowDir = 1;
        setInterval(function () {
            glowOpacity += glowDir * 0.04;
            if (glowOpacity >= 1.3) glowDir = -1;
            if (glowOpacity <= 0.7) glowDir = 1;
            centerCircle.setAttribute('stroke-width', 2.5 * (glowOpacity / 1));
            centerCircle.setAttribute('opacity', (0.6 + glowOpacity * 0.2));
        }, 60);
    }

    /* ── Rings Rotation ── */
    const outerRing = document.querySelector('.contact-outer-ring');
    const middleRing = document.querySelector('.contact-middle-ring');

    if (outerRing || middleRing) {
        let rotation = 0;
        setInterval(function () {
            rotation += 0.6;
            if (rotation >= 360) rotation = 0;
            if (outerRing) {
                outerRing.setAttribute('transform', `rotate(${rotation} 150 150)`);
            }
            if (middleRing) {
                middleRing.setAttribute('transform', `rotate(${-rotation * 1.2} 150 150)`);
            }
        }, 40);
    }

    /* ── Floating Dots ── */
    const dots = document.querySelectorAll('[class^="contact-small-dot-"]');
    dots.forEach(function (dot, index) {
        const originalX = parseFloat(dot.getAttribute('cx'));
        const originalY = parseFloat(dot.getAttribute('cy'));
        const speed = 0.7 + (index * 0.12);
        const offset = Math.random() * Math.PI * 2;

        setInterval(function () {
            const time = Date.now() / 1000;
            const newX = originalX + Math.sin(time * speed + offset) * 12;
            const newY = originalY + Math.cos(time * (speed - 0.2) + offset) * 12;
            dot.setAttribute('cx', newX);
            dot.setAttribute('cy', newY);
        }, 30);
    });

});

