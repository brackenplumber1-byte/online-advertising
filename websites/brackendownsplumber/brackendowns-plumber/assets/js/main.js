/* 247 Plumbers GP — Main JS v1 */

// ── MOBILE HAMBURGER ──────────────────────────────────────────────────────────
var hamburger = document.querySelector('.hamburger');
var navLinks  = document.querySelector('.nav-links');
if (hamburger && navLinks) {
  hamburger.addEventListener('click', function(e) {
    e.stopPropagation();
    navLinks.classList.toggle('open');
  });
  // Close when clicking outside
  document.addEventListener('click', function(e) {
    if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
      navLinks.classList.remove('open');
    }
  });
  // Close when a link is clicked
  navLinks.querySelectorAll('a').forEach(function(a) {
    a.addEventListener('click', function() {
      navLinks.classList.remove('open');
    });
  });
}

// ── SMOOTH SCROLL ─────────────────────────────────────────────────────────────
// Works for: #services  OR  https://site.co.za/#services  OR  /#services
function scrollToSection(id) {
  var el = document.getElementById(id);
  if (!el) return false;
  var navEl  = document.querySelector('#site-nav');
  var offset = navEl ? navEl.offsetHeight + 16 : 80;
  var top    = el.getBoundingClientRect().top + window.pageYOffset - offset;
  window.scrollTo({ top: top, behavior: 'smooth' });
  return true;
}

document.querySelectorAll('a[href]').forEach(function(link) {
  link.addEventListener('click', function(e) {
    var href = this.getAttribute('href') || '';

    // Pure hash link: #services
    if (href.charAt(0) === '#') {
      var id = href.slice(1);
      if (id && scrollToSection(id)) e.preventDefault();
      return;
    }

    // URL ending in #hash — same page or homepage
    var hashIdx = href.indexOf('#');
    if (hashIdx === -1) return; // no hash, normal link

    var hash    = href.slice(hashIdx + 1);
    var urlPart = href.slice(0, hashIdx);

    // Check if the URL part points to the current page or homepage
    var currentUrl = window.location.href.replace(/\/$/, '').replace(/#.*$/, '');
    var homeUrl    = (window.gp_home || '').replace(/\/$/, '');
    var linkUrl    = urlPart.replace(/\/$/, '');

    var isCurrentPage = (linkUrl === '' || linkUrl === currentUrl || linkUrl === homeUrl);

    if (isCurrentPage) {
      if (hash && scrollToSection(hash)) {
        e.preventDefault();
      }
    }
    // Otherwise let the browser navigate normally (goes to homepage then scrolls)
  });
});

// ── FAQ ACCORDION ─────────────────────────────────────────────────────────────
function toggleFaq(el) {
  var isOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-q').forEach(function(q) { q.classList.remove('open'); });
  document.querySelectorAll('.faq-a').forEach(function(a) { a.classList.remove('open'); });
  if (!isOpen) {
    el.classList.add('open');
    var ans = el.nextElementSibling;
    if (ans) ans.classList.add('open');
  }
}

// ── FORM SUBMIT ───────────────────────────────────────────────────────────────
function submitForm(e, target) {
  e.preventDefault();
  var el = target || e.target;
  el.innerHTML = '<div class="form-success-msg">✓ Request received! We\'ll call you back within 15 minutes.</div>';
}

// ── SCROLL REVEAL (progressive enhancement, no-op if unsupported) ──────────────
if ('IntersectionObserver' in window) {
  document.querySelectorAll('.section, .svc-card, .rev-card, .mini-review').forEach(function(el) {
    el.classList.add('reveal');
  });
  var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach(function(el) { revealObserver.observe(el); });
}

// ── ACTIVE NAV HIGHLIGHT ──────────────────────────────────────────────────────
window.addEventListener('scroll', function() {
  var pos = window.pageYOffset + 140;
  document.querySelectorAll('section[id]').forEach(function(sec) {
    if (pos >= sec.offsetTop && pos < sec.offsetTop + sec.offsetHeight) {
      document.querySelectorAll('.nav-links a').forEach(function(a) {
        var h = (a.getAttribute('href') || '');
        var id = h.slice(h.indexOf('#') + 1);
        a.style.color = (id === sec.id) ? 'var(--red)' : '';
      });
    }
  });
});
