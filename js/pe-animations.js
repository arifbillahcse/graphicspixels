/* ========================================================
   Photo Editing Page — SVG Scene Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const peScene = document.querySelector('.pe-svg-scene');
    if (!peScene) return; // Only run on photo-editing page

    const svg = document.querySelector('.pe-svg');
    if (!svg) return;

    /* ── Layer Panel Active Animation ── */
    const layerActive = document.querySelector('.pe-layer-active');
    if (layerActive) {
        let opacity = 0.8;
        let increasing = false;
        setInterval(function () {
            if (increasing) {
                opacity += 0.03;
                if (opacity >= 1) increasing = false;
            } else {
                opacity -= 0.03;
                if (opacity <= 0.5) increasing = true;
            }
            layerActive.setAttribute('opacity', opacity);
        }, 50);
    }

    /* ── Color Primary Glow Pulse ── */
    const colorPrimary = document.querySelector('.pe-color-primary');
    if (colorPrimary) {
        let scale = 1;
        let direction = 1;
        setInterval(function () {
            scale += direction * 0.015;
            if (scale >= 1.2) direction = -1;
            if (scale <= 0.95) direction = 1;
            colorPrimary.setAttribute('transform', `scale(${scale})`);
            colorPrimary.setAttribute('transform-origin', '50% 50%');
        }, 40);
    }

    /* ── Opacity Slider Movement ── */
    const opacitySlider = document.querySelector('.pe-opacity-slider');
    if (opacitySlider) {
        let sliderPos = 125;
        let sliderDir = 1;
        setInterval(function () {
            sliderPos += sliderDir * 0.8;
            if (sliderPos >= 145) sliderDir = -1;
            if (sliderPos <= 35) sliderDir = 1;
            opacitySlider.setAttribute('cx', sliderPos);
        }, 30);
    }

    /* ── Histogram Bars Animation (shimmer) ── */
    const histoBars = document.querySelectorAll('.pe-bars rect');
    if (histoBars.length) {
        histoBars.forEach(function (bar, index) {
            const originalHeight = bar.getAttribute('height');
            const originalY = bar.getAttribute('y');
            setInterval(function () {
                const variance = Math.sin((Date.now() / 500) + (index * 0.3)) * 4;
                const newHeight = parseFloat(originalHeight) + variance;
                const newY = parseFloat(originalY) - (variance / 2);
                bar.setAttribute('height', newHeight);
                bar.setAttribute('y', newY);
            }, 30);
        });
    }

    /* ── Selection Tool Rotation ── */
    const selectionTool = document.querySelector('.pe-tool');
    if (selectionTool) {
        let rotation = 0;
        setInterval(function () {
            rotation += 1.5;
            if (rotation >= 360) rotation = 0;
            selectionTool.setAttribute('transform', `translate(370,100) rotate(${rotation} 0 0)`);
        }, 40);
    }

    /* ── Floating Particles (bobbing) ── */
    const dots = {
        dot1: [],
        dot2: [],
        dot3: []
    };

    document.querySelectorAll('.pe-dot1').forEach(function (dot) {
        dots.dot1.push({ el: dot, originalY: parseFloat(dot.getAttribute('cy')), offset: Math.random() * Math.PI * 2 });
    });
    document.querySelectorAll('.pe-dot2').forEach(function (dot) {
        dots.dot2.push({ el: dot, originalY: parseFloat(dot.getAttribute('cy')), offset: Math.random() * Math.PI * 2 });
    });
    document.querySelectorAll('.pe-dot3').forEach(function (dot) {
        dots.dot3.push({ el: dot, originalY: parseFloat(dot.getAttribute('cy')), offset: Math.random() * Math.PI * 2 });
    });

    setInterval(function () {
        const time = Date.now() / 1000;
        Object.keys(dots).forEach(function (dotType) {
            dots[dotType].forEach(function (dot) {
                const newY = dot.originalY + Math.sin(time * 1.2 + dot.offset) * 12;
                dot.el.setAttribute('cy', newY);
            });
        });
    }, 30);

    /* ── Background Glow Pulse ── */
    const bgGlow = document.querySelector('.pe-pulse');
    if (bgGlow) {
        let rx = 190;
        let ry = 130;
        let direction = 1;
        setInterval(function () {
            rx += direction * 2;
            ry += direction * 1.5;
            if (rx >= 210) direction = -1;
            if (rx <= 170) direction = 1;
            bgGlow.setAttribute('rx', rx);
            bgGlow.setAttribute('ry', ry);
        }, 50);
    }

    /* ── Layers Panel Slide In (reveal animation) ── */
    const layersGroup = document.querySelector('.pe-layers');
    if (layersGroup) {
        let xOffset = -140;
        let slideDirection = 1;
        let inActive = false;

        const slideInterval = setInterval(function () {
            if (!inActive) {
                xOffset += slideDirection * 0.8;
                if (xOffset >= 0) {
                    xOffset = 0;
                    inActive = true;
                }
                layersGroup.setAttribute('transform', `translateX(${xOffset})`);
            }
        }, 40);

        // Subtle continuous breathing effect once visible
        let breathScale = 1;
        let breathDir = 1;
        setInterval(function () {
            if (inActive) {
                breathScale += breathDir * 0.008;
                if (breathScale >= 1.04) breathDir = -1;
                if (breathScale <= 0.98) breathDir = 1;
                layersGroup.setAttribute('transform', `translateX(0) scale(${breathScale})`);
                layersGroup.setAttribute('transform-origin', '80px 180px');
            }
        }, 50);
    }

});
