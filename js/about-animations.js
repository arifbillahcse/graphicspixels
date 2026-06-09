/* ========================================================
   About Us Page — SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const aboutScene = document.querySelector('.about-svg-main');
    if (!aboutScene) return;

    /* ── Main Frame Glow Pulse ── */
    const frame = document.querySelector('.about-frame');
    if (frame) {
        let opacity = 0.8;
        let dir = 1;
        setInterval(function () {
            opacity += dir * 0.03;
            if (opacity >= 1.2) dir = -1;
            if (opacity <= 0.6) dir = 1;
            frame.setAttribute('stroke-width', 3 * (opacity / 0.9));
            frame.setAttribute('opacity', opacity);
        }, 50);
    }

    /* ── Center Spirals Rotation ── */
    const spiral1 = document.querySelector('.about-spiral-1');
    const spiral2 = document.querySelector('.about-spiral-2');
    const spiral3 = document.querySelector('.about-spiral-3');

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

    /* ── Logo Rotation ── */
    const logoImg = document.querySelector('.about-logo-img');
    if (logoImg) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1.5;
            if (rotation >= 360) rotation = 0;
            logoImg.setAttribute('transform', `rotate(${rotation} 250 170)`);
        }, 40);
    }

    /* ── Logo Background Glow ── */
    const logoBg = document.querySelector('.about-logo-bg');
    if (logoBg) {
        let opacity = 0.9;
        let dir = 1;
        setInterval(function () {
            opacity += dir * 0.03;
            if (opacity >= 1) dir = -1;
            if (opacity <= 0.6) dir = 1;
            logoBg.setAttribute('stroke-width', 2 + opacity * 1.5);
            logoBg.setAttribute('opacity', opacity);
        }, 60);
    }

    /* ── Logo Ring Counter-Rotation ── */
    const logoRing = document.querySelector('.about-logo-ring');
    if (logoRing) {
        let rotation = 0;
        setInterval(function () {
            rotation -= 0.5;
            if (rotation <= -360) rotation = 0;
            logoRing.setAttribute('transform', `rotate(${rotation} 250 170)`);
        }, 50);
    }

    /* ── Company Name Text Pulse ── */
    const textGraphics = document.querySelector('.about-text-graphics');
    const textPixels = document.querySelector('.about-text-pixels');

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

    /* ── Orbiting Team Member Icons ── */
    const orbitConfig = {
        'about-orbit-1': { angle: 0,   radius: 95, speed: 0.7  },
        'about-orbit-2': { angle: 72,  radius: 100, speed: 0.85 },
        'about-orbit-3': { angle: 144, radius: 90,  speed: 0.75 },
        'about-orbit-4': { angle: 216, radius: 100, speed: 0.9  },
        'about-orbit-5': { angle: 288, radius: 95,  speed: 0.8  }
    };

    const center = { x: 250, y: 170 };

    Object.keys(orbitConfig).forEach(function (cls) {
        const el = document.querySelector('.' + cls);
        if (el) {
            const cfg = orbitConfig[cls];
            setInterval(function () {
                const time = Date.now() / 1000;
                const angle = (cfg.angle + time * cfg.speed * 20) * Math.PI / 180;
                const x = center.x + Math.cos(angle) * cfg.radius;
                const y = center.y + Math.sin(angle) * cfg.radius;
                el.setAttribute('transform', `translate(${x}, ${y})`);
            }, 30);
        }
    });

    /* ── Left Circle Pulse ── */
    const leftCircle = document.querySelector('.about-left-circle');
    if (leftCircle) {
        let radius = 25;
        let dir = 1;
        setInterval(function () {
            radius += dir * 0.5;
            if (radius >= 30) dir = -1;
            if (radius <= 20) dir = 1;
            leftCircle.setAttribute('r', radius);
        }, 40);
    }

    /* ── Top Dot Pulse ── */
    const topDot = document.querySelector('.about-top-dot');
    if (topDot) {
        let r = 10;
        let dir = 1;
        setInterval(function () {
            r += dir * 0.06;
            if (r >= 14) dir = -1;
            if (r <= 7) dir = 1;
            topDot.setAttribute('r', r);
        }, 50);
    }

    /* ── Side Icons Pulse ── */
    ['.about-icon-1','.about-icon-2','.about-icon-3','.about-icon-4',
     '.about-icon-5','.about-icon-6','.about-icon-7','.about-icon-8','.about-icon-9'].forEach(function (sel, i) {
        const el = document.querySelector(sel);
        if (!el) return;
        let opacity = 0.6;
        let dir = 1;
        setTimeout(function () {
            setInterval(function () {
                opacity += dir * (0.04 + i * 0.005);
                if (opacity >= 1) dir = -1;
                if (opacity <= 0.3) dir = 1;
                el.setAttribute('opacity', opacity);
            }, 65 + i * 15);
        }, Math.random() * 600);
    });

    /* ── Dashed Box Rotation ── */
    const dashedBox = document.querySelector('.about-dashed-box');
    if (dashedBox) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1;
            if (rotation >= 360) rotation = 0;
            dashedBox.setAttribute('transform', `rotate(${rotation} 400 320)`);
        }, 40);
    }

    /* ── Floating Dots ── */
    document.querySelectorAll('[class^="about-float-dot-"]').forEach(function (dot, i) {
        const ox = parseFloat(dot.getAttribute('cx'));
        const oy = parseFloat(dot.getAttribute('cy'));
        const speed = 0.6 + i * 0.15;
        const offset = Math.random() * Math.PI * 2;
        setInterval(function () {
            const t = Date.now() / 1000;
            dot.setAttribute('cx', ox + Math.sin(t * speed + offset) * 15);
            dot.setAttribute('cy', oy + Math.cos(t * (speed - 0.2) + offset) * 15);
        }, 30);
    });

});
