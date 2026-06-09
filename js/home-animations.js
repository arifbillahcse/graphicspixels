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

    /* ── Orbiting Service Icons (around monitor) ── */
    const orbitingIcons = {
        'home-orbit-1': { angle: 0, radius: 140, speed: 0.7 },
        'home-orbit-2': { angle: 45, radius: 150, speed: 0.8 },
        'home-orbit-3': { angle: 90, radius: 145, speed: 0.75 },
        'home-orbit-4': { angle: 135, radius: 135, speed: 0.85 },
        'home-orbit-5': { angle: 180, radius: 140, speed: 0.9 },
        'home-orbit-6': { angle: 225, radius: 150, speed: 0.72 },
        'home-orbit-7': { angle: 270, radius: 135, speed: 0.88 },
        'home-orbit-8': { angle: 315, radius: 145, speed: 0.82 },
        'home-orbit-9': { angle: 30, radius: 130, speed: 0.78 },
        'home-orbit-10': { angle: 150, radius: 140, speed: 0.86 }
    };

    const monitorCenter = { x: 260, y: 160 };

    Object.keys(orbitingIcons).forEach(function (className) {
        const icon = document.querySelector('.' + className);
        if (icon) {
            const config = orbitingIcons[className];
            setInterval(function () {
                const time = Date.now() / 1000;
                const angle = (config.angle + time * config.speed * 18) * Math.PI / 180;
                const x = monitorCenter.x + Math.cos(angle) * config.radius;
                const y = monitorCenter.y + Math.sin(angle) * config.radius;
                icon.setAttribute('transform', `translate(${x}, ${y})`);
            }, 30);
        }
    });

    /* ── Sparkle Twinkling (home page) ── */
    document.querySelectorAll('.home-sparkle').forEach(function (sparkle, index) {
        const initialOpacity = parseFloat(sparkle.getAttribute('opacity')) || 0.7;
        let opacity = initialOpacity;
        let direction = 1;
        const speed = 0.05 + (index * 0.01);
        const delayStart = Math.random() * 1200;

        setTimeout(function () {
            setInterval(function () {
                opacity += direction * speed;
                if (opacity >= initialOpacity * 1.3) direction = -1;
                if (opacity <= initialOpacity * 0.2) direction = 1;
                sparkle.setAttribute('opacity', opacity);
            }, 60 + (index * 20));
        }, delayStart);
    });

    /* ── Graphics Pixels Logo Animation (sidebar) ── */
    const logoIcon = document.querySelector('.home-logo-icon');
    const logoText1 = document.querySelector('.home-logo-text-1');
    const logoText2 = document.querySelector('.home-logo-text-2');
    if (logoIcon) {
        let glowOpacity = 1;
        let glowDir = 1;

        // Glow pulse
        setInterval(function () {
            glowOpacity += glowDir * 0.035;
            if (glowOpacity >= 1.4) glowDir = -1;
            if (glowOpacity <= 0.6) glowDir = 1;
            const circle = logoIcon.querySelector('circle');
            if (circle) {
                circle.setAttribute('stroke-width', 3 * (glowOpacity / 1));
                circle.setAttribute('opacity', (0.5 + glowOpacity * 0.25));
            }
        }, 60);

        // Text pulsing animations
        if (logoText1) {
            let text1Opacity = 0.8;
            let text1Dir = 1;
            setInterval(function () {
                text1Opacity += text1Dir * 0.04;
                if (text1Opacity >= 1) text1Dir = -1;
                if (text1Opacity <= 0.6) text1Dir = 1;
                logoText1.setAttribute('opacity', text1Opacity);
            }, 80);
        }

        if (logoText2) {
            let text2Opacity = 0.8;
            let text2Dir = 1;
            setInterval(function () {
                text2Opacity += text2Dir * 0.04;
                if (text2Opacity >= 1) text2Dir = -1;
                if (text2Opacity <= 0.6) text2Dir = 1;
                logoText2.setAttribute('opacity', text2Opacity);
            }, 90);
        }
    }

    /* ── Central Logo Animation (monitor center) ── */
    const centerLogo = document.querySelector('.home-center-logo');
    const centerLogoImg = document.querySelector('.home-center-logo-img');
    if (centerLogo) {
        let glowOpacity = 1;
        let glowDir = 1;
        let logoRot = 0;

        // Glow pulse
        setInterval(function () {
            glowOpacity += glowDir * 0.04;
            if (glowOpacity >= 1.5) glowDir = -1;
            if (glowOpacity <= 0.7) glowDir = 1;
            const centerCircle = centerLogo.querySelector('circle');
            if (centerCircle) {
                centerCircle.setAttribute('stroke-width', 2.5 * (glowOpacity / 1));
                centerCircle.setAttribute('opacity', (0.6 + glowOpacity * 0.2));
            }
        }, 50);

        // Logo image rotation
        if (centerLogoImg) {
            setInterval(function () {
                logoRot += 2.5;
                if (logoRot >= 360) logoRot = 0;
                centerLogoImg.setAttribute('transform', `rotate(${logoRot})`);
            }, 40);
        }
    }

    /* ── Diamond Shape Rotation ── */
    const diamond = document.querySelector('.home-center-diamond');
    if (diamond) {
        let diamondRotation = 0;
        setInterval(function () {
            diamondRotation += 1.8;
            if (diamondRotation >= 360) diamondRotation = 0;
            diamond.setAttribute('transform', `translate(260, 160) rotate(${diamondRotation})`);
        }, 40);
    }

    /* ── Red Circle Pulse ── */
    const redCircle = document.querySelector('.home-center-red-circle');
    if (redCircle) {
        let circleRadius = 48;
        let circleDir = 1;
        setInterval(function () {
            circleRadius += circleDir * 0.6;
            if (circleRadius >= 58) circleDir = -1;
            if (circleRadius <= 42) circleDir = 1;
            redCircle.setAttribute('r', circleRadius);
        }, 40);
    }

});
