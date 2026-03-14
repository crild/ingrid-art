/* ══════════════════════════════════════
   Bilingual System (NO/EN)
   ══════════════════════════════════════ */

const I18n = (() => {
  const STORAGE_KEY = 'pf-lang';
  const DEFAULT_LANG = 'no';
  const cache = {};

  function getCurrentLang() {
    return localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
  }

  function setLang(lang) {
    localStorage.setItem(STORAGE_KEY, lang);
  }

  async function loadTranslations(lang) {
    if (cache[lang]) return cache[lang];

    // Determine base path — works from root or subdir
    const basePath = document.querySelector('meta[name="base-path"]')?.content || '.';
    const url = `${basePath}/content/translations/${lang}.json`;

    try {
      const res = await fetch(url);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      cache[lang] = await res.json();
      return cache[lang];
    } catch (err) {
      console.warn(`Failed to load translations for "${lang}":`, err);
      return {};
    }
  }

  function applyTranslations(translations) {
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (translations[key] !== undefined) {
        // Use innerHTML for keys that contain HTML (links, etc.)
        if (translations[key].includes('<a ') || translations[key].includes('<br') || translations[key].includes('<strong')) {
          el.innerHTML = translations[key];
        } else {
          el.textContent = translations[key];
        }
      }
    });

    // Update placeholder attributes
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
      const key = el.getAttribute('data-i18n-placeholder');
      if (translations[key] !== undefined) {
        el.placeholder = translations[key];
      }
    });

    // Update the html lang attribute
    document.documentElement.lang = I18n.getCurrentLang() === 'no' ? 'nb' : 'en';
  }

  function updateButtons() {
    const lang = getCurrentLang();
    document.querySelectorAll('.lang-btn').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.lang === lang);
    });
  }

  async function switchTo(lang) {
    setLang(lang);
    const translations = await loadTranslations(lang);
    applyTranslations(translations);
    updateButtons();
  }

  async function init() {
    const lang = getCurrentLang();
    updateButtons();
    const translations = await loadTranslations(lang);
    applyTranslations(translations);

    // Bind click handlers
    document.querySelectorAll('.lang-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        switchTo(btn.dataset.lang);
      });
    });
  }

  return { init, switchTo, getCurrentLang, loadTranslations };
})();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', I18n.init);
