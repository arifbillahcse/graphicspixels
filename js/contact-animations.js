/* ========================================================
   Contact Page — Main SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const contactScene = document.querySelector('.contact-svg-main');
    if (!contactScene) return;

    /* ── Main Frame Glow Pulse ── */
    const frame = document.querySelector('.contact-frame');
    if (frame) {
        let glowOpacity = 0.8;
        let glowDir = 1;
        setInterval(function () {
            glowOpacity += glowDir * 0.03;
            if (glowOpacity >= 1.2) glowDir = -1;
            if (glowOpacity <= 0.6) glowDir = 1;
            frame.setAttribute('stroke-width', 3 * (glowOpacity / 0.9));
            frame.setAttribute('opacity', glowOpacity);
        }, 50);
    }

    /* ── Center Spiral Rotation ── */
    const spiral1 = document.querySelector('.contact-spiral-1');
    const spiral2 = document.querySelector('.contact-spiral-2');
    const spiral3 = document.querySelector('.contact-spiral-3');

    if (spiral1 || spiral2 || spiral3) {
        let rotation = 0;
        setInterval(function () {
            rotation += 0.8;
            if (rotation >= 360) rotation = 0;
            if (spiral1) spiral1.setAttribute('transform', `rotate(${rotation} 250 170)`);
            if (spiral2) spiral2.setAttribute('transform', `rotate(${-rotation * 1.3} 250 170)`);
            if (spiral3) spiral3.setAttribute('transform', `rotate(${rotation * 1.5} 250 170)`);
        }, 35);
    }

    /* ── Left Large Circle Pulsing ── */
    const leftCircle = document.querySelector('.contact-left-circle');
    if (leftCircle) {
        let radius = 25;
        let direction = 1;
        setInterval(function () {
            radius += direction * 0.5;
            if (radius >= 30) direction = -1;
            if (radius <= 20) direction = 1;
            leftCircle.setAttribute('r', radius);
        }, 40);
    }

    /* ── Icons Pulsing ── */
    const icons = [
        '.contact-icon-1', '.contact-icon-2', '.contact-icon-3', '.contact-icon-4',
        '.contact-icon-5', '.contact-icon-6', '.contact-icon-7', '.contact-icon-8', '.contact-icon-9'
    ];

    icons.forEach(function (selector, index) {
        const icon = document.querySelector(selector);
        if (icon) {
            let opacity = 0.6;
            let direction = 1;
            const speed = 0.04 + (index * 0.01);
            const delay = Math.random() * 500;

            setTimeout(function () {
                setInterval(function () {
                    opacity += direction * speed;
                    if (opacity >= 1) direction = -1;
                    if (opacity <= 0.3) direction = 1;
                    icon.setAttribute('opacity', opacity);
                }, 60 + (index * 15));
            }, delay);
        }
    });

    /* ── Top Center Element Animation ── */
    const topDot = document.querySelector('.contact-top-dot');
    if (topDot) {
        let scale = 1;
        let direction = 1;
        setInterval(function () {
            scale += direction * 0.04;
            if (scale >= 1.4) direction = -1;
            if (scale <= 0.8) direction = 1;
            topDot.setAttribute('r', 10 * scale);
        }, 50);
    }

    /* ── Dashed Box Rotation ── */
    const dashedBox = document.querySelector('.contact-dashed-box');
    if (dashedBox) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1;
            if (rotation >= 360) rotation = 0;
            dashedBox.setAttribute('transform', `rotate(${rotation} 400 320)`);
        }, 40);
    }

    /* ── Floating Dots ── */
    const floatDots = document.querySelectorAll('[class^="contact-float-dot-"]');
    floatDots.forEach(function (dot, index) {
        const originalX = parseFloat(dot.getAttribute('cx'));
        const originalY = parseFloat(dot.getAttribute('cy'));
        const speed = 0.6 + (index * 0.15);
        const offset = Math.random() * Math.PI * 2;

        setInterval(function () {
            const time = Date.now() / 1000;
            const newX = originalX + Math.sin(time * speed + offset) * 15;
            const newY = originalY + Math.cos(time * (speed - 0.2) + offset) * 15;
            dot.setAttribute('cx', newX);
            dot.setAttribute('cy', newY);
        }, 30);
    });

    /* ── Center Logo Animation ── */
    const logoImg = document.querySelector('.contact-logo-img');
    const logoBg = document.querySelector('.contact-logo-bg');
    const logoRing = document.querySelector('.contact-logo-ring');

    if (logoImg) {
        let logoRotation = 0;
        setInterval(function () {
            logoRotation += 1.5;
            if (logoRotation >= 360) logoRotation = 0;
            logoImg.setAttribute('transform', `rotate(${logoRotation} 250 170)`);
        }, 40);
    }

    if (logoBg) {
        let glowOpacity = 0.9;
        let glowDir = 1;
        setInterval(function () {
            glowOpacity += glowDir * 0.03;
            if (glowOpacity >= 1) glowDir = -1;
            if (glowOpacity <= 0.6) glowDir = 1;
            logoBg.setAttribute('stroke-width', 2 + glowOpacity * 1.5);
            logoBg.setAttribute('opacity', glowOpacity);
        }, 60);
    }

    if (logoRing) {
        let ringRotation = 0;
        setInterval(function () {
            ringRotation -= 0.5;
            if (ringRotation <= -360) ringRotation = 0;
            logoRing.setAttribute('transform', `rotate(${ringRotation} 250 170)`);
        }, 50);
    }

    /* ── Company Name Text Pulse ── */
    const textGraphics = document.querySelector('.contact-text-graphics');
    const textPixels = document.querySelector('.contact-text-pixels');

    if (textGraphics) {
        let opacity = 0.8;
        let dir = 1;
        setInterval(function () {
            opacity += dir * 0.04;
            if (opacity >= 1) dir = -1;
            if (opacity <= 0.5) dir = 1;
            textGraphics.setAttribute('opacity', opacity);
        }, 80);
    }

    if (textPixels) {
        let opacity = 0.7;
        let dir = -1;
        setInterval(function () {
            opacity += dir * 0.04;
            if (opacity >= 1) dir = -1;
            if (opacity <= 0.5) dir = 1;
            textPixels.setAttribute('opacity', opacity);
        }, 80);
    }

    /* ── Right Circles Pulsing ── */
    const rightCircles = ['.contact-icon-5', '.contact-icon-6', '.contact-icon-7', '.contact-icon-8'];
    rightCircles.forEach(function (selector, index) {
        const circle = document.querySelector(selector);
        if (circle) {
            let radius = parseFloat(circle.getAttribute('r'));
            const baseRadius = radius;
            let direction = 1;
            const speed = 0.15 + (index * 0.08);

            setInterval(function () {
                radius += direction * speed;
                if (radius >= baseRadius * 1.4) direction = -1;
                if (radius <= baseRadius * 0.7) direction = 1;
                circle.setAttribute('r', radius);
            }, 45 + (index * 20));
        }
    });

});

