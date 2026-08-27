/* ========================================================
   wp-forms.js — submits the Free Trial and Contact forms
   to WordPress (admin-ajax) where they are stored as
   entries and optionally forwarded to the app.
   ======================================================== */
(function () {
    'use strict';

    if (typeof gpForms === 'undefined') return;

    /* Derive a field key for inputs that have no name attribute
       (the original static markup relied on placeholders only). */
    function fieldKey(el) {
        if (el.name === 'phone_cc' || el.name === 'phone_number') return el.name;
        if (el.name) return el.name;
        var ph = (el.placeholder || '').toLowerCase();
        if (el.tagName === 'SELECT')   return 'service';
        if (el.tagName === 'TEXTAREA') return 'message';
        switch (el.type) {
            case 'email': return 'email';
            case 'tel':   return 'phone';
            case 'file':  return 'attachment';
            case 'text':
            case 'url':
                if (ph.indexOf('link') !== -1)    return 'file_link';
                if (ph.indexOf('website') !== -1) return 'website';
                return 'name';
        }
        return '';
    }

    function serialize(form, action) {
        var data = new FormData();
        data.append('action', action);
        data.append('nonce', gpForms.nonce);
        Array.prototype.forEach.call(form.elements, function (el) {
            var key = fieldKey(el);
            if (!key || el.type === 'submit' || el.type === 'checkbox') return;
            if (el.type === 'file') {
                if (el.files && el.files.length) data.append(key, el.files[0]);
            } else if (!data.has(key) || el.value) {
                data.append(key, el.value);
            }
        });

        /* Country-code select + number input -> single "phone" value */
        var cc = data.get('phone_cc'), num = data.get('phone_number');
        if (cc !== null || num !== null) {
            data.delete('phone_cc');
            data.delete('phone_number');
            var digits = (num || '').replace(/[^0-9]/g, '');
            data.append('phone', digits ? (cc || '') + digits : '');
        }

        return data;
    }

    function showNotice(form, message, ok) {
        var note = form.querySelector('.gp-form-notice');
        if (!note) {
            note = document.createElement('p');
            note.className = 'gp-form-notice';
            note.style.cssText = 'margin-top:12px;padding:12px 16px;border-radius:8px;font-size:14px;';
            form.appendChild(note);
        }
        note.style.background = ok ? '#e7f7ee' : '#fdecec';
        note.style.color = ok ? '#1a7f4e' : '#c0392b';
        note.textContent = message;
    }

    function bind(form, action) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var btn = form.querySelector('[type="submit"]');
            var original = btn ? btn.textContent : '';
            if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

            fetch(gpForms.ajaxUrl, { method: 'POST', body: serialize(form, action) })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {
                        showNotice(form, res.data.message, true);
                        form.reset();
                        var fileName = form.querySelector('.file-name');
                        if (fileName) fileName.textContent = 'No file chosen';
                    } else {
                        showNotice(form, (res.data && res.data.message) || 'Something went wrong. Please try again.', false);
                    }
                })
                .catch(function () {
                    showNotice(form, 'Network error. Please try again or email us directly.', false);
                })
                .finally(function () {
                    if (btn) { btn.disabled = false; btn.textContent = original; }
                });
        });
    }

    document.querySelectorAll('form.free-trial-form').forEach(function (form) {
        bind(form, 'gp_submit_trial');
    });

    var contactForm = document.getElementById('contactForm');
    if (contactForm) bind(contactForm, 'gp_submit_contact');
})();
