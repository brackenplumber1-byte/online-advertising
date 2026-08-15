/* Tysons Plumbers Roodepoort — main.js v2 */

// ── Smooth scroll ─────────────────────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(function(a) {
  a.addEventListener('click', function(e) {
    var id = this.getAttribute('href').slice(1);
    if (!id) return;
    var el = document.getElementById(id);
    if (el) {
      e.preventDefault();
      var nav = document.querySelector('.site-nav');
      var off = nav ? nav.offsetHeight + 12 : 80;
      window.scrollTo({ top: el.getBoundingClientRect().top + window.pageYOffset - off, behavior: 'smooth' });
    }
  });
});

// ── Mobile nav with dropdown support ─────────────────────────────────────
var hamburger = document.querySelector('.hamburger');
var navMenu   = document.querySelector('.nav-menu');
if (hamburger && navMenu) {
  hamburger.addEventListener('click', function(e) {
    e.stopPropagation();
    navMenu.classList.toggle('open');
  });
  document.addEventListener('click', function(e) {
    if (!navMenu.contains(e.target) && !hamburger.contains(e.target)) {
      navMenu.classList.remove('open');
    }
  });
  // Mobile: toggle dropdown on tap
  navMenu.querySelectorAll('.nav-item > a').forEach(function(a) {
    if (a.nextElementSibling && a.nextElementSibling.classList.contains('dropdown')) {
      a.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          var item = this.closest('.nav-item');
          item.classList.toggle('open');
        }
      });
    } else {
      a.addEventListener('click', function() { navMenu.classList.remove('open'); });
    }
  });
}

// ── FAQ accordion ─────────────────────────────────────────────────────────
function toggleFaq(el) {
  var isOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-q').forEach(function(q) { q.classList.remove('open'); });
  document.querySelectorAll('.faq-a').forEach(function(a) { a.classList.remove('open'); });
  if (!isOpen) { el.classList.add('open'); el.nextElementSibling.classList.add('open'); }
}

// ── Contact/sidebar form ──────────────────────────────────────────────────
function handleForm(e) {
  e.preventDefault();
  e.target.innerHTML = '<div class="form-ok">✓ Request received — we will call you back within 30 minutes.</div>';
}

// ── Active nav on scroll + shrink/shadow on scroll ─────────────────────────
var siteNav = document.querySelector('.site-nav');
window.addEventListener('scroll', function() {
  var pos = window.pageYOffset + 140;
  document.querySelectorAll('section[id]').forEach(function(sec) {
    var link = document.querySelector('.nav-menu a[href="#' + sec.id + '"]');
    if (!link) return;
    if (pos >= sec.offsetTop && pos < sec.offsetTop + sec.offsetHeight) {
      link.style.color = 'var(--fire)';
    } else {
      link.style.color = '';
    }
  });
  if (siteNav) siteNav.classList.toggle('is-scrolled', window.pageYOffset > 40);
}, { passive: true });

// ── Scroll-reveal (progressive enhancement — see main.css .reveal rules) ──
// Content is already fully visible without this; it only ADDS the .in-view
// class that triggers the CSS transition once an element scrolls into view.
// Skipped entirely under prefers-reduced-motion, since .reveal never starts
// hidden there anyway (nothing to observe for).
if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window) {
  var revealEls = document.querySelectorAll('.reveal');
  var revealObserver = new IntersectionObserver(function(entries, obs) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });
  revealEls.forEach(function(el) { revealObserver.observe(el); });

  // ── Count-up stats (45, 24, 15 etc.) ──────────────────────────────────
  // The number in the markup is ALWAYS the real, final value (see index.php)
  // — this only animates the visual transition up to it, then leaves the
  // exact original text in place. A page that never runs this script (or
  // never scrolls the stat into view) shows the correct number regardless.
  var countEls = document.querySelectorAll('[data-count]');
  var countObserver = new IntersectionObserver(function(entries, obs) {
    entries.forEach(function(entry) {
      if (!entry.isIntersecting) return;
      var el = entry.target;
      var target = parseInt(el.getAttribute('data-count'), 10);
      obs.unobserve(el);
      if (!target) return; // nothing to animate for a target of 0
      var start = null;
      var duration = 1100;
      function step(ts) {
        if (start === null) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = target; // guarantee exact final value
      }
      requestAnimationFrame(step);
    });
  }, { threshold: 0.4 });
  countEls.forEach(function(el) { countObserver.observe(el); });
}
