(function () {
  'use strict';

  var burger = document.getElementById('nd-burger');
  var header = document.querySelector('.nd-header');
  var nav    = document.getElementById('nd-main-nav');

  if (!burger || !header || !nav) return;

  burger.addEventListener('click', function () {
    var isOpen = header.classList.toggle('nd-header--open');
    burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    nav.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  });

  // Fermer le menu si on clique en dehors
  document.addEventListener('click', function (e) {
    if (!header.contains(e.target) && header.classList.contains('nd-header--open')) {
      header.classList.remove('nd-header--open');
      burger.setAttribute('aria-expanded', 'false');
      nav.setAttribute('aria-hidden', 'true');
    }
  });

  // Fermer le menu au resize > 768px
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768 && header.classList.contains('nd-header--open')) {
      header.classList.remove('nd-header--open');
      burger.setAttribute('aria-expanded', 'false');
      nav.setAttribute('aria-hidden', 'true');
    }
  });
})();
