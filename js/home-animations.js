/* ========================================================
   Home Page — Multi-Service SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const homeScene = document.querySelector('.home-svg-scene');
    if (!homeScene) return; // Only run on home page

    const svg = document.querySelector('.home-svg');
    if (!svg) return;

    /* ── Central Hub Glow Pulse ── */
    const hub = document.querySelector('.home-hub');
    if (hub) {
        let scale = 1;
        let direction = 1;
        setInterval(function () {
            scale += direction * 0.02;
            if (scale >= 1.25) direction = -1;
            if (scale <= 0.9) direction = 1;
            hub.setAttribute('r', 40 * scale);
        }, 50);
    }

    /* ── Photo Icon Floating ── */
    const photoIcon = document.querySelector('.home-photo');
    if (photoIcon) {
        let offsetY = 0;
        let photoDir = 1;
        setInterval(function () {
            offsetY += photoDir * 0.5;
            if (offsetY >= 10) photoDir = -1;
            if (offsetY <= -10) photoDir = 1;
            photoIcon.setAttribute('transform', `translate(120, ${90 + offsetY}) rotateZ(${Math.sin(Date.now() / 3000) * 8}deg)`);
        }, 40);
    }

    /* ── Video Icon Rotation ── */
    const videoIcon = document.querySelector('.home-video');
    if (videoIcon) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1;
            if (rotation >= 360) rotation = 0;
            videoIcon.setAttribute('transform', `translate(360, 90) rotateZ(${rotation}deg)`);
        }, 30);
    }

    /* ── 3D Icon Perspective ── */
    const threeD = document.querySelector('.home-3d');
    if (threeD) {
        let scaleX = 1;
        let direction = 1;
        setInterval(function () {
            scaleX += direction * 0.03;
            if (scaleX >= 1.15) direction = -1;
            if (scaleX <= 0.85) direction = 1;
            threeD.setAttribute('transform', `translate(100, 160) scaleX(${scaleX})`);
        }, 50);
    }

    /* ── Retouching Icon Pulse ── */
    const retouch = document.querySelector('.home-retouch');
    if (retouch) {
        let opacity = 0.8;
        let dir = 1;
        setInterval(function () {
            opacity += dir * 0.05;
            if (opacity >= 1) dir = -1;
            if (opacity <= 0.6) dir = 1;
            retouch.style.opacity = opacity;
        }, 60);
    }

    /* ── Clipping Path Icon Wave ── */
    const clipping = document.querySelector('.home-clipping');
    if (clipping) {
        let offsetX = 0;
        let waveDir = 1;
        setInterval(function () {
            offsetX += waveDir * 0.6;
            if (offsetX >= 8) waveDir = -1;
            if (offsetX <= -8) waveDir = 1;
            clipping.setAttribute('transform', `translate(${130 + offsetX}, 280)`);
        }, 40);
    }

    /* ── Color Grading Icon Spin ── */
    const colorIcon = document.querySelector('.home-color');
    if (colorIcon) {
        let rotation = 0;
        setInterval(function () {
            rotation += 0.8;
            if (rotation >= 360) rotation = 0;
            colorIcon.setAttribute('transform', `translate(370, 280) rotateZ(${rotation}deg)`);
        }, 35);
    }

    /* ── Layers Panel Slide Animation ── */
    const layersPanel = document.querySelector('.home-layers');
    if (layersPanel) {
        let offsetX = -50;
        let panelDir = 1;
        let panelVisible = false;

        setInterval(function () {
            if (!panelVisible) {
                offsetX += panelDir * 0.4;
                if (offsetX >= 0) {
                    offsetX = 0;
                    panelVisible = true;
                }
                layersPanel.setAttribute('transform', `translate(${50 + offsetX}, 320)`);
            }
        }, 50);

        // Subtle breathing after visible
        let breathe = 1;
        let breathDir = 1;
        setInterval(function () {
            if (panelVisible) {
                breathe += breathDir * 0.008;
                if (breathe >= 1.05) breathDir = -1;
                if (breathe <= 0.95) breathDir = 1;
                layersPanel.setAttribute('transform', `translate(50, 320) scale(${breathe})`);
            }
        }, 60);
    }

    /* ── Adjustments Panel Slide Animation ── */
    const adjPanel = document.querySelector('.home-adjustments');
    if (adjPanel) {
        let offsetX = 50;
        let panelDir = -1;
        let panelVisible = false;

        setInterval(function () {
            if (!panelVisible) {
                offsetX += panelDir * 0.4;
                if (offsetX <= 0) {
                    offsetX = 0;
                    panelVisible = true;
                }
                adjPanel.setAttribute('transform', `translate(${450 - offsetX}, 320)`);
            }
        }, 50);

        // Subtle breathing after visible
        let breathe = 1;
        let breathDir = 1;
        setInterval(function () {
            if (panelVisible) {
                breathe += breathDir * 0.008;
                if (breathe >= 1.05) breathDir = -1;
                if (breathe <= 0.95) breathDir = 1;
                adjPanel.setAttribute('transform', `translate(450, 320) scale(${breathe})`);
            }
        }, 60);
    }

    /* ── Monitor Glow Pulse ── */
    const monitor = document.querySelector('.home-monitor');
    if (monitor) {
        let glowOpacity = 1;
        let glowDir = 1;
        setInterval(function () {
            glowOpacity += glowDir * 0.02;
            if (glowOpacity >= 1.2) glowDir = -1;
            if (glowOpacity <= 0.8) glowDir = 1;
            monitor.style.opacity = glowOpacity;
        }, 50);
    }

    /* ── Background Glow Pulse ── */
    const bgGlow = document.querySelector('.home-pulse');
    if (bgGlow) {
        let rx = 220;
        let ry = 150;
        let direction = 1;
        setInterval(function () {
            rx += direction * 1.5;
            ry += direction * 1;
            if (rx >= 240) direction = -1;
            if (rx <= 200) direction = 1;
            bgGlow.setAttribute('rx', rx);
            bgGlow.setAttribute('ry', ry);
        }, 50);
    }

    /* ── Floating Particles ── */
    const dots = {
        dot1: [],
        dot2: [],
        dot3: []
    };

    document.querySelectorAll('.home-dot1').forEach(function (dot) {
        dots.dot1.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2,
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: Math.random() * 0.8 + 0.4
        });
    });

    document.querySelectorAll('.home-dot2').forEach(function (dot) {
        dots.dot2.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2,
            speedX: (Math.random() - 0.5) * 0.6,
            speedY: Math.random() * 0.9 + 0.5
        });
    });

    document.querySelectorAll('.home-dot3').forEach(function (dot) {
        dots.dot3.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2,
            speedX: (Math.random() - 0.5) * 0.7,
            speedY: Math.random() * 0.7 + 0.3
        });
    });

    setInterval(function () {
        const time = Date.now() / 1000;

        Object.keys(dots).forEach(function (dotType) {
            dots[dotType].forEach(function (dot) {
                const newY = dot.originalY + Math.sin(time * 1.5 + dot.offset) * 15;
                const newX = dot.originalX + Math.cos(time * 1.2 + dot.offset) * 12;
                dot.el.setAttribute('cy', newY);
                dot.el.setAttribute('cx', newX);
            });
        });
    }, 30);

});
