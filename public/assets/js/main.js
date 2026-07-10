/* ============================================================
   AmsazBeauty — Main JavaScript
   ============================================================ */

'use strict';

/* ── Toast Notifications ───────────────────────────────────── */
function showToast(message, type) {
  type = type || 'success';
  var container = document.getElementById('toast-container');
  if (!container) return;

  var colors = {
    success: { bg: '#f0fdf4', border: '#86efac', text: '#15803d', icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' },
    error:   { bg: '#fef2f2', border: '#fca5a5', text: '#b91c1c', icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>' },
    info:    { bg: '#eff6ff', border: '#93c5fd', text: '#1d4ed8', icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' },
  };
  var c = colors[type] || colors.success;

  var toast = document.createElement('div');
  toast.style.cssText = [
    'display:flex;align-items:center;gap:.7rem',
    'background:' + c.bg,
    'border:1.5px solid ' + c.border,
    'color:' + c.text,
    'padding:.8rem 1.1rem',
    'border-radius:12px',
    'box-shadow:0 4px 20px rgba(0,0,0,.1)',
    'font-size:.875rem',
    'font-weight:600',
    'min-width:280px',
    'max-width:360px',
    'pointer-events:all',
    'opacity:0',
    'transform:translateX(30px)',
    'transition:opacity .25s ease,transform .25s ease',
  ].join(';');

  toast.innerHTML =
    '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="' + c.text + '" stroke-width="2" style="flex-shrink:0;">' + c.icon + '</svg>' +
    '<span style="flex:1;line-height:1.4;">' + message + '</span>' +
    '<button onclick="this.parentNode.remove()" style="background:none;border:none;cursor:pointer;color:' + c.text + ';opacity:.5;padding:0;line-height:1;font-size:1.1rem;">✕</button>';

  container.appendChild(toast);

  // Animate in
  requestAnimationFrame(function() {
    requestAnimationFrame(function() {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(0)';
    });
  });

  // Auto-dismiss after 4s
  setTimeout(function() {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(30px)';
    setTimeout(function() { if (toast.parentNode) toast.remove(); }, 300);
  }, 4000);
}

/* ── DOM Ready ─────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  initHamburger();
  initStickyHeader();
  initCountdown();
  initProductGallery();
  initWishlist();
  initCartQty();
  initSliders();
  initLazyLoad();
  initDropdowns();
  initSearchToggle();
  initMobileFilters();
  initTabSystem();
  initStoreLocator();
  initToast();
});

/* ── Hamburger / Mobile Menu ───────────────────────────────── */
function initHamburger() {
  const btn  = document.getElementById('hamburger-btn');
  const menu = document.getElementById('mobile-menu');
  const closeBtn = document.getElementById('mobile-menu-close');
  if (!btn || !menu) return;

  const open = () => {
    btn.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
    menu.style.display = 'flex';
    requestAnimationFrame(() => menu.classList.add('open'));
    document.body.style.overflow = 'hidden';
  };

  const close = () => {
    btn.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
    menu.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { if (!menu.classList.contains('open')) menu.style.display = ''; }, 400);
  };

  btn.addEventListener('click', () => btn.classList.contains('open') ? close() : open());
  if (closeBtn) closeBtn.addEventListener('click', close);

  menu.addEventListener('click', e => {
    if (e.target === menu) close();
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && menu.classList.contains('open')) close();
  });
}

/* ── Sticky Header ─────────────────────────────────────────── */
function initStickyHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const toggle = () => header.classList.toggle('scrolled', window.scrollY > 10);
  window.addEventListener('scroll', toggle, { passive: true });
  toggle();
}

/* ── Countdown Timer ───────────────────────────────────────── */
function initCountdown() {
  const els = {
    hh: document.getElementById('countdown-hh'),
    mm: document.getElementById('countdown-mm'),
    ss: document.getElementById('countdown-ss'),
  };
  if (!els.ss) return;

  // Target: 12h 48m 32s from now
  const target = Date.now() + (12 * 3600 + 48 * 60 + 32) * 1000;

  const pad = n => String(n).padStart(2, '0');

  const tick = () => {
    const diff = Math.max(0, target - Date.now());
    const totalSec = Math.floor(diff / 1000);
    els.hh.textContent = pad(Math.floor(totalSec / 3600));
    els.mm.textContent = pad(Math.floor((totalSec % 3600) / 60));
    els.ss.textContent = pad(totalSec % 60);
  };

  tick();
  setInterval(tick, 1000);
}

/* ── Product Image Gallery ─────────────────────────────────── */
function initProductGallery() {
  // Original flat selector
  const mainImg   = document.getElementById('gallery-main-img');
  const thumbBtns = document.querySelectorAll('.gallery-thumb');
  if (mainImg && thumbBtns.length) {
    thumbBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const src = btn.dataset.src;
        if (!src) return;
        mainImg.src = src;
        mainImg.alt = btn.dataset.alt || '';
        thumbBtns.forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
      });
    });
  }

  // BEM selector (pd-gallery__thumb) – swaps background-image on main
  const pdMain  = document.getElementById('pdMainImg');
  const pdThumbs = document.querySelectorAll('.pd-gallery__thumb');
  if (pdMain && pdThumbs.length) {
    pdThumbs.forEach(btn => {
      btn.addEventListener('click', () => {
        const bg = btn.dataset.imgBg || btn.dataset.imgUrl;
        if (bg) {
          // bg may be a URL string or a css url() value
          pdMain.style.backgroundImage = bg.startsWith('url(') ? bg : `url('${bg}')`;
        }
        pdThumbs.forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
      });
    });
  }
}

/* ── Wishlist Toggle (AJAX, session-persisted) ─────────────── */
function initWishlist() {
  var csrf = document.querySelector('meta[name="csrf-token"]');

  function updateBadge(count) {
    document.querySelectorAll('[data-wishlist-count]').forEach(function(el) {
      el.textContent = count;
      el.style.display = count > 0 ? 'flex' : 'none';
    });
  }

  function setButtonState(btn, active) {
    btn.classList.toggle('active', active);
    var icon = btn.querySelector('svg');
    if (icon) {
      icon.style.fill   = active ? 'var(--color-accent)' : 'none';
      icon.style.stroke = active ? 'var(--color-accent)' : 'currentColor';
    }
  }

  // Restore state on page load for any pre-wishlisted items
  document.querySelectorAll('[data-wishlist-btn]').forEach(function(btn) {
    if (btn.dataset.active === 'true') setButtonState(btn, true);
  });

  document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-wishlist-btn]');
    if (!btn) return;
    var productId = btn.dataset.product;
    if (!productId || !csrf) return;

    btn.disabled = true;
    fetch('/wishlist/toggle', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf.content,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ product_id: productId }),
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      setButtonState(btn, data.in_wishlist);
      updateBadge(data.count);
      showToast(data.message, data.in_wishlist ? 'success' : 'info');
    })
    .catch(function() { showToast('Something went wrong', 'error'); })
    .finally(function() { btn.disabled = false; });
  });
}

/* ── Cart Quantity Selector ────────────────────────────────── */
function initCartQty() {
  document.addEventListener('click', e => {
    const btn = e.target.closest('[data-qty-action]');
    if (!btn) return;
    const wrap = btn.closest('.qty-selector');
    const val  = wrap ? wrap.querySelector('.qty-val') : null;
    if (!val) return;
    let n = parseInt(val.value || val.textContent, 10) || 1;
    if (btn.dataset.qtyAction === 'inc') n = Math.min(n + 1, 99);
    if (btn.dataset.qtyAction === 'dec') n = Math.max(n - 1, 1);
    if (val.tagName === 'INPUT') val.value = n; else val.textContent = n;
  });
}

/* ── Hero Slider ───────────────────────────────────────────── */
function initSliders() {
  // Hero dots navigation
  const dots = document.querySelectorAll('.hero-dot');
  if (!dots.length) return;

  let current = 0;
  const slides = [
    { title: 'Your Beauty, Our Craft', accent: 'Our Craft', desc: 'Discover Pakistan\'s most curated luxury beauty destination.' },
    { title: 'New Arrivals', accent: 'New Arrivals', desc: 'Be first to explore the latest drops in skincare & makeup.' },
    { title: 'Flash Sale', accent: 'Flash Sale', desc: 'Exclusive deals on your favorites. Ending soon!' },
  ];

  const activate = (i) => {
    dots.forEach((d, idx) => d.classList.toggle('active', idx === i));
    current = i;
  };

  dots.forEach((dot, i) => dot.addEventListener('click', () => activate(i)));

  // Auto-advance
  setInterval(() => activate((current + 1) % dots.length), 5000);
}

/* ── Lazy Loading ──────────────────────────────────────────── */
function initLazyLoad() {
  if (!('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        if (img.dataset.src) {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
        }
        observer.unobserve(img);
      }
    });
  }, { rootMargin: '200px' });

  document.querySelectorAll('img[data-src]').forEach(img => observer.observe(img));
}

/* ── Dropdown Menus ────────────────────────────────────────── */
function initDropdowns() {
  document.querySelectorAll('[data-dropdown-toggle]').forEach(trigger => {
    const target = document.getElementById(trigger.dataset.dropdownToggle);
    if (!target) return;

    trigger.addEventListener('click', e => {
      e.stopPropagation();
      const isOpen = target.classList.contains('open');
      document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
      if (!isOpen) target.classList.add('open');
    });
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
  });
}

/* ── Search Toggle ─────────────────────────────────────────── */
function initSearchToggle() {
  const searchBtn = document.getElementById('search-toggle-btn');
  const searchBar = document.getElementById('mobile-search-bar');
  if (!searchBtn || !searchBar) return;

  searchBtn.addEventListener('click', () => {
    const isOpen = searchBar.classList.toggle('open');
    if (isOpen) searchBar.querySelector('input')?.focus();
  });
}

/* ── Mobile Filters Sidebar ────────────────────────────────── */
function initMobileFilters() {
  const openBtn  = document.getElementById('open-filters-btn');
  const overlay  = document.getElementById('filters-overlay');
  const closeBtn = document.getElementById('close-filters-btn');
  if (!openBtn || !overlay) return;

  openBtn.addEventListener('click', () => {
    overlay.style.display = 'flex';
    requestAnimationFrame(() => overlay.classList.add('open'));
    document.body.style.overflow = 'hidden';
  });

  const close = () => {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { overlay.style.display = ''; }, 300);
  };

  if (closeBtn) closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
}

/* ── Tab System ────────────────────────────────────────────── */
function initTabSystem() {
  document.querySelectorAll('[data-tab-list]').forEach(list => {
    const tabs    = list.querySelectorAll('[data-tab]');
    const panels  = document.querySelectorAll('[data-tab-panel]');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const target = tab.dataset.tab;
        panels.forEach(p => {
          p.hidden = p.dataset.tabPanel !== target;
        });
      });
    });
  });
}

/* ── Store Locator ─────────────────────────────────────────── */
function initStoreLocator() {
  const items = document.querySelectorAll('.store-list-item');
  if (!items.length) return;

  items.forEach(item => {
    item.addEventListener('click', () => {
      items.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });
}

/* ── Toast Notification ────────────────────────────────────── */
let toastTimeout;
function showToast(message, type = 'success') {
  let toast = document.getElementById('toast-notification');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast-notification';
    toast.style.cssText = `
      position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(100px);
      background: var(--color-primary); color: #fff; padding: 12px 24px;
      border-radius: var(--radius-full); font-size: 0.875rem; font-weight: 600;
      z-index: 9999; transition: transform 0.3s ease; box-shadow: var(--shadow-lg);
      white-space: nowrap;
    `;
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.style.background = type === 'error' ? 'var(--color-sale)' : 'var(--color-primary)';
  clearTimeout(toastTimeout);
  requestAnimationFrame(() => {
    toast.style.transform = 'translateX(-50%) translateY(0)';
    toastTimeout = setTimeout(() => {
      toast.style.transform = 'translateX(-50%) translateY(100px)';
    }, 2500);
  });
}

/* ── Add to Bag Buttons ────────────────────────────────────── */
document.addEventListener('click', e => {
  const btn = e.target.closest('.btn-add-to-bag, .btn-add-bag-lg, [data-add-to-bag]');
  if (!btn) return;
  const productName = btn.closest('.product-card, .combo-card, .editor-card')
    ?.querySelector('.product-name, .combo-title, .editor-product-name')?.textContent;
  showToast(`Added ${productName ? '"' + productName.trim().substring(0, 30) + '…"' : 'item'} to bag ✓`);

  // Update cart badge
  const badge = document.querySelector('.cart-badge');
  if (badge) {
    badge.textContent = parseInt(badge.textContent || 0) + 1;
  }
});

/* ── Accordion ─────────────────────────────────────────────── */
document.addEventListener('click', e => {
  const trigger = e.target.closest('[data-accordion-trigger]');
  if (!trigger) return;
  const content = document.getElementById(trigger.dataset.accordionTrigger);
  if (!content) return;
  const isOpen = content.style.display === 'block';
  content.style.display = isOpen ? 'none' : 'block';
  trigger.setAttribute('aria-expanded', !isOpen);
  const icon = trigger.querySelector('.accordion-icon');
  if (icon) icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
});

/* ── Product Options ───────────────────────────────────────── */
document.addEventListener('click', e => {
  const btn = e.target.closest('.option-btn');
  if (!btn) return;
  const group = btn.closest('.option-buttons');
  if (!group) return;
  group.querySelectorAll('.option-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
});

/* ── Filter Toggles (Desktop) ──────────────────────────────── */
document.querySelectorAll('.filter-toggle-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const panel = btn.closest('.filter-panel');
    const body  = panel?.querySelector('.filter-panel-body');
    if (!body) return;
    const isHidden = body.style.display === 'none';
    body.style.display = isHidden ? '' : 'none';
    btn.textContent = isHidden ? 'Hide' : 'Show';
  });
});

/* ── Smooth anchor scrolling ───────────────────────────────── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (!target) return;
    e.preventDefault();
    const offset = (document.querySelector('.site-header')?.offsetHeight || 0) + 16;
    window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
  });
});
