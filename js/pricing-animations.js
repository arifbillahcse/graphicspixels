/* ========================================================
   Pricing Page — Hero SVG Animations
   ======================================================== */

document.addEventListener('DOMContentLoaded', function () {
    if (!document.querySelector('.pr-svg-main')) return;

    /* ── Frame Glow ── */
    var frame = document.querySelector('.pr-frame');
    if (frame) {
        var fOp = 0.8, fDir = 1;
        setInterval(function () {
            fOp += fDir * 0.03;
            if (fOp >= 1.2) fDir = -1;
            if (fOp <= 0.6) fDir = 1;
            frame.setAttribute('stroke-width', String(3 * (fOp / 0.9)));
            frame.setAttribute('opacity', String(fOp));
        }, 50);
    }

    /* ── Center Spirals ── */
    var s1 = document.querySelector('.pr-spiral-1');
    var s2 = document.querySelector('.pr-spiral-2');
    var s3 = document.querySelector('.pr-spiral-3');
    if (s1 || s2 || s3) {
        var sRot = 0;
        setInterval(function () {
            sRot += 0.8;
            if (sRot >= 360) sRot = 0;
            if (s1) s1.setAttribute('transform', 'rotate(' + sRot + ' 250 170)');
            if (s2) s2.setAttribute('transform', 'rotate(' + (-sRot * 1.3) + ' 250 170)');
            if (s3) s3.setAttribute('transform', 'rotate(' + (sRot * 1.5) + ' 250 170)');
        }, 35);
    }

    /* ── Logo Rotation ── */
    var logoImg = document.querySelector('.pr-logo-img');
    if (logoImg) {
        var lRot = 0;
        setInterval(function () {
            lRot += 1.5;
            if (lRot >= 360) lRot = 0;
            logoImg.setAttribute('transform', 'rotate(' + lRot + ' 250 170)');
        }, 40);
    }

    /* ── Logo Background Glow ── */
    var logoBg = document.querySelector('.pr-logo-bg');
    if (logoBg) {
        var bgOp = 0.9, bgDir = 1;
        setInterval(function () {
            bgOp += bgDir * 0.03;
            if (bgOp >= 1) bgDir = -1;
            if (bgOp <= 0.6) bgDir = 1;
            logoBg.setAttribute('stroke-width', String(2 + bgOp * 1.5));
            logoBg.setAttribute('opacity', String(bgOp));
        }, 60);
    }

    /* ── Logo Ring Counter-Rotate ── */
    var logoRing = document.querySelector('.pr-logo-ring');
    if (logoRing) {
        var rRot = 0;
        setInterval(function () {
            rRot -= 0.5;
            if (rRot <= -360) rRot = 0;
            logoRing.setAttribute('transform', 'rotate(' + rRot + ' 250 170)');
        }, 50);
    }

    /* ── Text Pulse ── */
    var tg = document.querySelector('.pr-text-g');
    var tp = document.querySelector('.pr-text-p');
    if (tg) {
        var tgOp = 0.8, tgDir = 1;
        setInterval(function () {
            tgOp += tgDir * 0.04;
            if (tgOp >= 1) tgDir = -1;
            if (tgOp <= 0.5) tgDir = 1;
            tg.setAttribute('opacity', String(tgOp));
        }, 80);
    }
    if (tp) {
        var tpOp = 0.5, tpDir = 1;
        setInterval(function () {
            tpOp += tpDir * 0.04;
            if (tpOp >= 1) tpDir = -1;
            if (tpOp <= 0.5) tpDir = 1;
            tp.setAttribute('opacity', String(tpOp));
        }, 80);
    }

    /* ── Orbiting Currency Symbols ── */
    var orbits = [
        { cls: 'pr-orbit-1', angle: 0,   r: 95,  spd: 0.7  },
        { cls: 'pr-orbit-2', angle: 72,  r: 100, spd: 0.85 },
        { cls: 'pr-orbit-3', angle: 144, r: 90,  spd: 0.75 },
        { cls: 'pr-orbit-4', angle: 216, r: 100, spd: 0.9  },
        { cls: 'pr-orbit-5', angle: 288, r: 95,  spd: 0.8  }
    ];
    orbits.forEach(function (cfg) {
        var el = document.querySelector('.' + cfg.cls);
        if (!el) return;
        setInterval(function () {
            var t = Date.now() / 1000;
            var a = (cfg.angle + t * cfg.spd * 20) * Math.PI / 180;
            var x = 250 + Math.cos(a) * cfg.r;
            var y = 170 + Math.sin(a) * cfg.r;
            el.setAttribute('transform', 'translate(' + x + ',' + y + ')');
        }, 30);
    });

    /* ── Left Circle Pulse ── */
    var lc = document.querySelector('.pr-left-circle');
    if (lc) {
        var lcR = 25, lcDir = 1;
        setInterval(function () {
            lcR += lcDir * 0.5;
            if (lcR >= 30) lcDir = -1;
            if (lcR <= 20) lcDir = 1;
            lc.setAttribute('r', String(lcR));
        }, 40);
    }

    /* ── Top Dot Pulse ── */
    var td = document.querySelector('.pr-top-dot');
    if (td) {
        var tdR = 10, tdDir = 1;
        setInterval(function () {
            tdR += tdDir * 0.07;
            if (tdR >= 14) tdDir = -1;
            if (tdR <= 7) tdDir = 1;
            td.setAttribute('r', String(tdR));
        }, 50);
    }

    /* ── Icons Fade ── */
    document.querySelectorAll('.pr-icon').forEach(function (el, i) {
        var op = 0.6 + Math.random() * 0.3, dir = 1;
        setTimeout(function () {
            setInterval(function () {
                op += dir * 0.04;
                if (op >= 1)   dir = -1;
                if (op <= 0.3) dir = 1;
                el.setAttribute('opacity', String(op));
            }, 70 + i * 12);
        }, i * 80);
    });

    /* ── Dashed Box Spin ── */
    var db = document.querySelector('.pr-dashed-box');
    if (db) {
        var dbRot = 0;
        setInterval(function () {
            dbRot += 1;
            if (dbRot >= 360) dbRot = 0;
            db.setAttribute('transform', 'rotate(' + dbRot + ' 400 320)');
        }, 40);
    }

    /* ── Floating Dots ── */
    document.querySelectorAll('.pr-fdot').forEach(function (dot, i) {
        var ox = parseFloat(dot.getAttribute('cx'));
        var oy = parseFloat(dot.getAttribute('cy'));
        var spd = 0.6 + i * 0.15;
        var off = Math.random() * Math.PI * 2;
        setInterval(function () {
            var t = Date.now() / 1000;
            dot.setAttribute('cx', String(ox + Math.sin(t * spd + off) * 15));
            dot.setAttribute('cy', String(oy + Math.cos(t * (spd - 0.2) + off) * 15));
        }, 30);
    });

});
