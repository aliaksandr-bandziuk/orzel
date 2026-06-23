function initStickyHeader() {
  const header = document.getElementById('siteHeader');
  const headerWrapper = document.getElementById('headerWrapper');
  const placeholder = document.getElementById('headerPlaceholder');

  if (!header || !headerWrapper || !placeholder) return;

  const updateHeader = () => {
    placeholder.style.height = `${headerWrapper.offsetHeight}px`;

    if (window.scrollY > 0) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  };

  updateHeader();

  window.addEventListener('scroll', updateHeader, { passive: true });
  window.addEventListener('resize', updateHeader);
}

window.addEventListener('DOMContentLoaded', initStickyHeader);
