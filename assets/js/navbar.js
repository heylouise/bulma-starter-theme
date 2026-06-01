/**
 * Bulma navbar burger toggle.
 * Toggles 'is-active' on the burger and its target menu on mobile.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var burgers = Array.prototype.slice.call(
            document.querySelectorAll('.navbar-burger'),
            0
        );

        if (burgers.length === 0) return;

        burgers.forEach(function (burger) {
            burger.addEventListener('click', function () {
                var targetId = burger.dataset.target;
                var target = targetId ? document.getElementById(targetId) : null;

                burger.classList.toggle('is-active');
                if (target) target.classList.toggle('is-active');

                var expanded = burger.classList.contains('is-active');
                burger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            });
        });
    });
})();
