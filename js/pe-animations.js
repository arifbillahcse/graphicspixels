/* ========================================================
   Photo Editing Page — Vibrant SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const peScene = document.querySelector('.pe-svg-scene');
    if (!peScene) return; // Only run on photo-editing page

    const svg = document.querySelector('.pe-svg');
    if (!svg) return;

    /* ── Canvas Glow Frame Animation ── */
    const canvasGlow = document.querySelector('.pe-canvas-glow');
    if (canvasGlow) {
        let strokeWidth = 2;
        let direction = 1;
        setInterval(function () {
            strokeWidth += direction * 0.05;
            if (strokeWidth >= 4) direction = -1;
            if (strokeWidth <= 1) direction = 1;
            canvasGlow.setAttribute('stroke-width', strokeWidth);
        }, 40);
    }

    /* ── Brightness Slider Movement ── */
    const brightnessSlider = document.querySelector('.pe-brightness-slider');
    if (brightnessSlider) {
        let sliderY = 100;
        let direction = 1;
        setInterval(function () {
            sliderY += direction * 0.8;
            if (sliderY >= 130) direction = -1;
            if (sliderY <= 80) direction = 1;
            brightnessSlider.setAttribute('cy', sliderY);
        }, 35);
    }

    /* ── Saturation Slider Movement ── */
    const saturationSlider = document.querySelector('.pe-saturation-slider');
    if (saturationSlider) {
        let sliderY = 120;
        let direction = 1;
        setInterval(function () {
            sliderY += direction * 0.7;
            if (sliderY >= 150) direction = -1;
            if (sliderY <= 90) direction = 1;
            saturationSlider.setAttribute('cy', sliderY);
        }, 40);
    }

    /* ── Hue Wheel Rotation ── */
    const hueWheel = document.querySelector('.pe-hue-wheel');
    if (hueWheel) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1;
            if (rotation >= 360) rotation = 0;
            hueWheel.setAttribute('transform', `translate(60, 280) rotateZ(${rotation}deg)`);
        }, 30);
    }

    /* ── Hue Dot Pulsing ── */
    const hueDot = document.querySelector('.pe-hue-dot');
    if (hueDot) {
        let radius = 4;
        let direction = 1;
        setInterval(function () {
            radius += direction * 0.08;
            if (radius >= 7) direction = -1;
            if (radius <= 3) direction = 1;
            hueDot.setAttribute('r', radius);
        }, 50);
    }

    /* ── Crop Tool Pulsing ── */
    const cropTool = document.querySelector('.pe-crop');
    if (cropTool) {
        let opacity = 0.7;
        let direction = 1;
        setInterval(function () {
            opacity += direction * 0.06;
            if (opacity >= 1) direction = -1;
            if (opacity <= 0.4) direction = 1;
            cropTool.setAttribute('opacity', opacity);
        }, 60);
    }

    /* ── Transform Tools Rotation ── */
    const transforms = document.querySelector('.pe-transforms');
    if (transforms) {
        let rotation = 0;
        const rotateButton = transforms.querySelector('path');
        if (rotateButton) {
            setInterval(function () {
                rotation += 1.2;
                if (rotation >= 360) rotation = 0;
                rotateButton.setAttribute('transform', `rotate(${rotation} 30 200)`);
            }, 40);
        }
    }

    /* ── Vibrance Dial Rotation ── */
    const vibranceHand = document.querySelector('.pe-vibrance-hand');
    if (vibranceHand) {
        let rotation = 0;
        setInterval(function () {
            rotation = (Math.sin(Date.now() / 2000) * 45);
            vibranceHand.setAttribute('transform', `rotate(${rotation} 440 200)`);
        }, 30);
    }

    /* ── Clarity Dial Rotation ── */
    const clarityHand = document.querySelector('.pe-clarity-hand');
    if (clarityHand) {
        let rotation = 0;
        setInterval(function () {
            rotation = (Math.cos(Date.now() / 2500) * 40) - 20;
            clarityHand.setAttribute('transform', `rotate(${rotation} 440 235)`);
        }, 30);
    }

    /* ── Floating Particles with Smooth Motion ── */
    const dots = {
        dot1: [],
        dot2: [],
        dot3: []
    };

    document.querySelectorAll('.pe-dot1').forEach(function (dot) {
        dots.dot1.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2
        });
    });

    document.querySelectorAll('.pe-dot2').forEach(function (dot) {
        dots.dot2.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2
        });
    });

    document.querySelectorAll('.pe-dot3').forEach(function (dot) {
        dots.dot3.push({
            el: dot,
            originalY: parseFloat(dot.getAttribute('cy')),
            originalX: parseFloat(dot.getAttribute('cx')),
            offset: Math.random() * Math.PI * 2
        });
    });

    setInterval(function () {
        const time = Date.now() / 1000;

        Object.keys(dots).forEach(function (dotType) {
            dots[dotType].forEach(function (dot, index) {
                const speed = dotType === 'dot1' ? 1.3 : dotType === 'dot2' ? 0.9 : 1.1;
                const newY = dot.originalY + Math.sin(time * speed + dot.offset) * 16;
                const newX = dot.originalX + Math.cos(time * (speed - 0.3) + dot.offset) * 12;
                dot.el.setAttribute('cy', newY);
                dot.el.setAttribute('cx', newX);
            });
        });
    }, 30);

    /* ── Light Rays Pulsing ── */
    const rays = document.querySelector('.pe-rays');
    if (rays) {
        let opacity = 0.4;
        let direction = 1;
        setInterval(function () {
            opacity += direction * 0.04;
            if (opacity >= 0.8) direction = -1;
            if (opacity <= 0.2) direction = 1;
            rays.setAttribute('opacity', opacity);
        }, 70);
    }

    /* ── Orbiting Tool Icons (around canvas) ── */
    const orbitingTools = {
        'pe-orbit-1': { angle: 0, radius: 120, speed: 0.8 },
        'pe-orbit-2': { angle: 45, radius: 130, speed: 0.9 },
        'pe-orbit-3': { angle: 90, radius: 125, speed: 0.7 },
        'pe-orbit-4': { angle: 135, radius: 115, speed: 0.85 },
        'pe-orbit-5': { angle: 180, radius: 120, speed: 0.95 },
        'pe-orbit-6': { angle: 225, radius: 130, speed: 0.75 },
        'pe-orbit-7': { angle: 270, radius: 115, speed: 0.88 },
        'pe-orbit-8': { angle: 315, radius: 125, speed: 0.82 },
        'pe-orbit-9': { angle: 30, radius: 110, speed: 0.92 },
        'pe-orbit-10': { angle: 150, radius: 120, speed: 0.86 },
        'pe-orbit-11': { angle: 240, radius: 130, speed: 0.79 }
    };

    const canvasCenter = { x: 240, y: 160 };

    Object.keys(orbitingTools).forEach(function (className) {
        const tool = document.querySelector('.' + className);
        if (tool) {
            const config = orbitingTools[className];
            setInterval(function () {
                const time = Date.now() / 1000;
                const angle = (config.angle + time * config.speed * 20) * Math.PI / 180;
                const x = canvasCenter.x + Math.cos(angle) * config.radius;
                const y = canvasCenter.y + Math.sin(angle) * config.radius;
                tool.setAttribute('transform', `translate(${x}, ${y})`);
            }, 30);
        }
    });

    /* ── Graphics Pixels Logo Animation ── */
    const logoIcon = document.querySelector('.pe-logo-icon');
    const logoImg = document.querySelector('.pe-logo-img');
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

    /* ── Sparkle Twinkling ── */
    document.querySelectorAll('.pe-sparkle').forEach(function (sparkle, index) {
        const initialOpacity = parseFloat(sparkle.getAttribute('opacity')) || 0.7;
        let opacity = initialOpacity;
        let direction = 1;
        const speed = 0.04 + (index * 0.01); // Vary speed per sparkle
        const delayStart = Math.random() * 1000; // Randomize start

        setTimeout(function () {
            setInterval(function () {
                opacity += direction * speed;
                if (opacity >= initialOpacity * 1.2) direction = -1;
                if (opacity <= initialOpacity * 0.3) direction = 1;
                sparkle.setAttribute('opacity', opacity);
            }, 50 + (index * 20));
        }, delayStart);
    });

});
