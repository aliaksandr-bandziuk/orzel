export function initDigitsCounter() {
  const counters = document.querySelectorAll(".counter__value");

  if (!counters.length) return;

  const animateCounter = (counter) => {
    const rawValue = counter.textContent.trim().replace(",", ".");
    const targetValue = parseFloat(rawValue);

    if (Number.isNaN(targetValue)) return;

    const hasDecimals = !Number.isInteger(targetValue);
    const duration = 2000;
    const frameRate = 60;
    const totalFrames = Math.round(duration / (1000 / frameRate));

    let frame = 0;

    const easeOut = (t) => 1 - Math.pow(1 - t, 4);

    const updateCounter = () => {
      frame++;

      const progress = easeOut(frame / totalFrames);
      const currentValue = targetValue * progress;

      counter.textContent = hasDecimals
        ? currentValue.toFixed(1)
        : Math.round(currentValue);

      if (frame < totalFrames) {
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = hasDecimals
          ? targetValue.toFixed(1)
          : targetValue;
      }
    };

    requestAnimationFrame(updateCounter);
  };

  const observerOptions = {
    root: null,
    threshold: 0.25,
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  counters.forEach((counter) => observer.observe(counter));
}