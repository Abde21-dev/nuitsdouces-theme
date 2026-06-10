/**
 * Nuits Douces — toc.js
 * Génère automatiquement la table des matières à partir des H2/H3 de l'article.
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var tocContainers = document.querySelectorAll('.nd-toc');
        if (!tocContainers.length) return;

        // Zone de contenu de l'article (GeneratePress)
        var articleContent = document.querySelector('.entry-content');
        if (!articleContent) return;

        tocContainers.forEach(function (tocEl) {
            buildToc(tocEl, articleContent);
            wireToggle(tocEl);
        });
    });

    /**
     * Construit la liste de navigation à partir des titres H2/H3.
     */
    function buildToc(tocEl, content) {
        var nav = tocEl.querySelector('.nd-toc__nav');
        if (!nav) return;

        var headings = content.querySelectorAll('h2, h3');
        if (!headings.length) {
            nav.innerHTML = '<p class="nd-toc__loading">Aucun titre trouvé dans cet article.</p>';
            return;
        }

        var ol = document.createElement('ol');
        var currentH2Li = null;
        var currentSubOl = null;
        var headingCount = 0;

        headings.forEach(function (heading) {
            // Ignorer les titres vides
            if (!heading.textContent.trim()) return;

            // Créer un ID ancre si absent
            if (!heading.id) {
                heading.id = slugify(heading.textContent);
            }

            // S'assurer que l'ID est unique
            ensureUniqueId(heading);

            headingCount++;

            var li = document.createElement('li');
            var a = document.createElement('a');
            a.href = '#' + heading.id;
            a.textContent = heading.textContent.trim();

            // Scroll fluide au clic
            a.addEventListener('click', function (e) {
                e.preventDefault();
                var target = document.getElementById(heading.id);
                if (target) {
                    var offset = 80; // compensation header fixe éventuel
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                    // Mettre à jour l'URL sans recharger
                    history.pushState(null, null, '#' + heading.id);
                }
            });

            li.appendChild(a);

            if (heading.tagName === 'H2') {
                currentH2Li = li;
                currentSubOl = null;
                ol.appendChild(li);
            } else if (heading.tagName === 'H3') {
                if (!currentH2Li) {
                    // H3 orphelin sans H2 parent : on l'ajoute à la racine
                    ol.appendChild(li);
                } else {
                    if (!currentSubOl) {
                        currentSubOl = document.createElement('ol');
                        currentH2Li.appendChild(currentSubOl);
                    }
                    currentSubOl.appendChild(li);
                }
            }
        });

        if (headingCount === 0) {
            nav.innerHTML = '<p class="nd-toc__loading">Aucun titre trouvé dans cet article.</p>';
            return;
        }

        // Remplacer le message de chargement par la liste
        nav.innerHTML = '';
        nav.appendChild(ol);
    }

    /**
     * Gère le bouton toggle (afficher/masquer le sommaire).
     */
    function wireToggle(tocEl) {
        var header = tocEl.querySelector('.nd-toc__header');
        var toggle = tocEl.querySelector('.nd-toc__toggle');
        if (!toggle || !header) return;

        function doToggle() {
            var isCollapsed = tocEl.classList.contains('nd-toc--collapsed');
            if (isCollapsed) {
                tocEl.classList.remove('nd-toc--collapsed');
                toggle.setAttribute('aria-expanded', 'true');
            } else {
                tocEl.classList.add('nd-toc--collapsed');
                toggle.setAttribute('aria-expanded', 'false');
            }
        }

        header.addEventListener('click', doToggle);

        // Éviter le double déclenchement si on clique directement sur le bouton
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            doToggle();
        });
    }

    /**
     * Convertit un texte en slug utilisable comme ID HTML.
     */
    function slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .normalize('NFD')
            .replace(/[̀-ͯ]/g, '') // retire les accents
            .replace(/[^a-z0-9\s-]/g, '')    // retire les caractères spéciaux
            .replace(/\s+/g, '-')             // espaces → tirets
            .replace(/-+/g, '-')              // tirets multiples → un seul
            .replace(/^-|-$/g, '');           // retire tirets en début/fin
    }

    /**
     * Garantit l'unicité des IDs dans la page (ajoute un suffixe numérique si doublon).
     */
    var usedIds = {};

    function ensureUniqueId(heading) {
        var baseId = heading.id;
        if (!usedIds[baseId]) {
            usedIds[baseId] = 1;
        } else {
            usedIds[baseId]++;
            heading.id = baseId + '-' + usedIds[baseId];
        }
    }

})();
