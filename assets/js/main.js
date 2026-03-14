/* ══════════════════════════════════════
   Main JS — Nav, Scroll, Lightbox
   ══════════════════════════════════════ */

// ── Scroll nav background ──
const nav = document.getElementById('navbar');
if (nav) {
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  });
  // Apply on load in case page is already scrolled
  nav.classList.toggle('scrolled', window.scrollY > 60);
}

// ── Active nav link ──
(function setActiveNav() {
  const path = window.location.pathname;
  document.querySelectorAll('.nav-links a').forEach(a => {
    const href = a.getAttribute('href');
    if (href === '/' || href === '/index.html' || href === 'index.html') {
      a.classList.toggle('active', path === '/' || path.endsWith('/index.html') || path.endsWith('/ingrid-art/'));
    } else if (path.includes(href.replace('.html', '').replace('./', ''))) {
      a.classList.add('active');
    }
  });
})();

// ── Mobile menu ──
const menuBtn = document.getElementById('menu-btn');
const navLinks = document.getElementById('nav-links');
if (menuBtn && navLinks) {
  menuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('mobile-open');
  });
  // Close on link click
  navLinks.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      navLinks.classList.remove('mobile-open');
    });
  });
}

// ── Fade-in on scroll ──
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

// ── Lightbox ──
function openLightbox(item) {
  const img = item.querySelector('img');
  const info = item.querySelector('.gallery-info');
  if (!img || !info) return;

  document.getElementById('lightbox-img').src = img.src.replace('w=600', 'w=1200');
  document.getElementById('lightbox-title').textContent = info.querySelector('h3').textContent;
  document.getElementById('lightbox-desc').textContent = info.querySelector('p:not(.price)').textContent;

  const priceEl = info.querySelector('.price');
  document.getElementById('lightbox-price').textContent = priceEl ? priceEl.textContent : '';

  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeLightbox();
});

function inquireAboutPiece() {
  const title = document.getElementById('lightbox-title').textContent;
  const price = document.getElementById('lightbox-price').textContent;
  const subject = encodeURIComponent('Inquiry about: ' + title);
  const body = encodeURIComponent(
    'Hi Ingrid,\n\nI am interested in your piece "' + title + '"' +
    (price ? ' (' + price + ')' : '') +
    '.\n\nCould you please share more details?\n\nBest regards'
  );
  window.location.href = 'mailto:ingrid@paintandfun.no?subject=' + subject + '&body=' + body;
}

// ── Gallery filtering ──
function initGalleryFilters() {
  const buttons = document.querySelectorAll('.filter-btn[data-filter]');
  const items = document.querySelectorAll('.gallery-item[data-category]');

  if (!buttons.length || !items.length) return;

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;

      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      items.forEach(item => {
        if (filter === 'all' || item.dataset.category === filter) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });
}

document.addEventListener('DOMContentLoaded', initGalleryFilters);
