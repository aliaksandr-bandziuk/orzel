//#region src/js/custom/headerScroll.js
function initStickyHeader() {
	const header = document.getElementById("siteHeader");
	const preheader = document.getElementById("sitePreheader");
	const headerWrapper = document.getElementById("headerWrapper");
	const placeholder = document.getElementById("headerPlaceholder");
	if (!header || !preheader || !headerWrapper || !placeholder) return;
	const desktopMedia = window.matchMedia("(min-width: 980px)");
	const updateHeader = () => {
		const preheaderHeight = desktopMedia.matches ? preheader.offsetHeight : 0;
		const headerHeight = headerWrapper.offsetHeight;
		placeholder.style.height = `${headerHeight}px`;
		if (window.scrollY > preheaderHeight) header.classList.add("is-scrolled");
		else header.classList.remove("is-scrolled");
	};
	updateHeader();
	window.addEventListener("scroll", updateHeader, { passive: true });
	window.addEventListener("resize", updateHeader);
}
window.addEventListener("DOMContentLoaded", initStickyHeader);
//#endregion
