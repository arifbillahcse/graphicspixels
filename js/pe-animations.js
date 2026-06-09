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

});
