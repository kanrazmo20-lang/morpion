(function () {
  // 1) Ne plus remonter en haut de page apres un clic
  if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
  var KEY = 'morpion:scroll';
  try {
    var saved = JSON.parse(sessionStorage.getItem(KEY) || 'null');
    if (saved && saved.path === location.pathname) window.scrollTo(0, saved.y);
    sessionStorage.removeItem(KEY);
  } catch (e) {}

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (f) {
      f.addEventListener('submit', function () {
        try { sessionStorage.setItem(KEY, JSON.stringify({ path: location.pathname, y: window.scrollY })); } catch (e) {}
      });
    });

    // 2) Colorer les symboles, animer SEULEMENT celui qui vient d'etre pose
    var cells = Array.prototype.slice.call(document.querySelectorAll('.plateau .case'));
    if (!cells.length) return;
    var now = cells.map(function (el) {
      var t = el.textContent.trim();
      return (t === 'X' || t === 'O') ? t : '-';
    });
    var kb = 'morpion:plateau:' + location.pathname;
    var prev = null;
    try { prev = sessionStorage.getItem(kb); } catch (e) {}
    cells.forEach(function (el, i) {
      if (now[i] === '-') return;
      el.classList.add('symbole-' + now[i]);
      if (prev && prev.length === 9 && prev[i] === '-') el.classList.add('nouveau');
    });
    try { sessionStorage.setItem(kb, now.join('')); } catch (e) {}

    // 3) Message de fin de partie en surbrillance
    document.querySelectorAll('h1,h2,p').forEach(function (el) {
      if (/gagn|nul/i.test(el.textContent) && !/Au tour/i.test(el.textContent)) el.classList.add('resultat');
    });
  });
})();
