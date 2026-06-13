// Load header and footer from components folder, then run footer.js
(function () {
    var scriptSrc = document.currentScript ? document.currentScript.src : '';
    var basePath = scriptSrc.split('/').slice(0, -1).join('/') + '/';

    var rootPath = basePath.replace(/components\/$/, '');

    function loadFooterJS() {
        var s = document.createElement('script');
        s.src = rootPath + 'js/footer.js';
        document.body.appendChild(s);
    }

    var headerDone = false;
    var footerDone = false;

    function checkBothDone() {
        if (headerDone && footerDone) {
            loadFooterJS();
        }
    }

    // Load header
    fetch(basePath + 'header.html')
        .then(function (response) {
            if (!response.ok) throw new Error('Header load failed');
            return response.text();
        })
        .then(function (html) {
            var headerContainer = document.createElement('div');
            headerContainer.innerHTML = html;
            document.body.insertBefore(headerContainer, document.body.firstChild);
            headerDone = true;
            checkBothDone();
        })
        .catch(function (error) { console.warn('Could not load header:', error); });

    // Load footer
    fetch(basePath + 'footer.html')
        .then(function (response) {
            if (!response.ok) throw new Error('Footer load failed');
            return response.text();
        })
        .then(function (html) {
            var footerContainer = document.createElement('div');
            footerContainer.innerHTML = html;
            document.body.appendChild(footerContainer);
            footerDone = true;
            checkBothDone();
        })
        .catch(function (error) { console.warn('Could not load footer:', error); });
})();
