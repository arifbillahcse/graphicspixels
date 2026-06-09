/* ========================================================
   Contact Page — SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const contactScene = document.querySelector('.contact-svg');
    if (!contactScene) return;

    /* ── Center Circle Glow Pulse ── */
    const centerCircle = document.querySelector('.contact-center-circle');
    if (centerCircle) {
        let glowOpacity = 1;
        let glowDir = 1;
        setInterval(function () {
            glowOpacity += glowDir * 0.04;
            if (glowOpacity >= 1.3) glowDir = -1;
            if (glowOpacity <= 0.7) glowDir = 1;
            centerCircle.setAttribute('stroke-width', 3 * (glowOpacity / 1));
            centerCircle.setAttribute('opacity', (0.6 + glowOpacity * 0.2));
        }, 60);
    }

    /* ── Ring Rotation ── */
    const ring1 = document.querySelector('.contact-ring-1');
    const ring2 = document.querySelector('.contact-ring-2');

    if (ring1 || ring2) {
        let rotation = 0;
        const svg = contactScene.closest('svg');
        setInterval(function () {
            rotation += 0.5;
            if (rotation >= 360) rotation = 0;
            if (ring1) {
                ring1.setAttribute('transform', `rotate(${rotation} 200 200)`);
            }
            if (ring2) {
                ring2.setAttribute('transform', `rotate(${-rotation * 1.5} 200 200)`);
            }
        }, 40);
    }

    /* ── Floating Dots ── */
    const dots = document.querySelectorAll('[class^="contact-dot-"]');
    dots.forEach(function (dot, index) {
        const originalX = parseFloat(dot.getAttribute('cx'));
        const originalY = parseFloat(dot.getAttribute('cy'));
        const speed = 0.8 + (index * 0.15);
        const offset = Math.random() * Math.PI * 2;

        setInterval(function () {
            const time = Date.now() / 1000;
            const newX = originalX + Math.sin(time * speed + offset) * 15;
            const newY = originalY + Math.cos(time * (speed - 0.2) + offset) * 15;
            dot.setAttribute('cx', newX);
            dot.setAttribute('cy', newY);
        }, 30);
    });

    /* ── Background Pulse ── */
    const pulse = document.querySelector('.contact-pulse');
    if (pulse) {
        let rx = 180;
        let ry = 150;
        let direction = 1;
        setInterval(function () {
            rx += direction * 1;
            ry += direction * 0.8;
            if (rx >= 200) direction = -1;
            if (rx <= 160) direction = 1;
            pulse.setAttribute('rx', rx);
            pulse.setAttribute('ry', ry);
        }, 50);
    }

});
