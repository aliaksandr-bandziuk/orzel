//#region \0rolldown/runtime.js
var __defProp = Object.defineProperty;
var __exportAll = (all, no_symbols) => {
	let target = {};
	for (var name in all) __defProp(target, name, {
		get: all[name],
		enumerable: true
	});
	if (!no_symbols) __defProp(target, Symbol.toStringTag, { value: "Module" });
	return target;
};
//#endregion
//#region src/js/custom/gigitsCounter.js
var gigitsCounter_exports = /* @__PURE__ */ __exportAll({ initDigitsCounter: () => initDigitsCounter });
function initDigitsCounter() {
	const counters = document.querySelectorAll(".counter__value");
	if (!counters.length) return;
	const animateCounter = (counter) => {
		const rawValue = counter.textContent.trim().replace(",", ".");
		const targetValue = parseFloat(rawValue);
		if (Number.isNaN(targetValue)) return;
		const hasDecimals = !Number.isInteger(targetValue);
		const totalFrames = Math.round(2e3 / (1e3 / 60));
		let frame = 0;
		const easeOut = (t) => 1 - Math.pow(1 - t, 4);
		const updateCounter = () => {
			frame++;
			const currentValue = targetValue * easeOut(frame / totalFrames);
			counter.textContent = hasDecimals ? currentValue.toFixed(1) : Math.round(currentValue);
			if (frame < totalFrames) requestAnimationFrame(updateCounter);
			else counter.textContent = hasDecimals ? targetValue.toFixed(1) : targetValue;
		};
		requestAnimationFrame(updateCounter);
	};
	const observer = new IntersectionObserver((entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				animateCounter(entry.target);
				observer.unobserve(entry.target);
			}
		});
	}, {
		root: null,
		threshold: .25
	});
	counters.forEach((counter) => observer.observe(counter));
}
//#endregion
export { gigitsCounter_exports as t };
