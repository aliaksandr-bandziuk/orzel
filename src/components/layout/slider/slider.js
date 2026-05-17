/*
Документація по роботі у шаблоні: 
Документація слайдера: https://swiperjs.com/
Сніппет(HTML): swiper
*/

// Підключаємо слайдер Swiper з node_modules
// При необхідності підключаємо додаткові модулі слайдера, вказуючи їх у {} через кому
// Приклад: { Navigation, Autoplay }
import Swiper from 'swiper';
import { Navigation, Pagination, Thumbs } from 'swiper/modules';
/*
Основні модулі слайдера:
Navigation, Pagination, Autoplay, 
EffectFade, Lazy, Manipulation
Детальніше дивись https://swiperjs.com/
*/

// Стилі Swiper
// Підключення базових стилів
import "./slider.scss";
// Повний набір стилів з node_modules
// import 'swiper/css/bundle';

function initReviewMedia(sliderBlock, swiperInstance) {
	const mediaWrap = document.querySelector('.reviews__media');
	if (!mediaWrap || !swiperInstance) return;

	const reviewSlides = sliderBlock.querySelectorAll('.reviews__slide');
	const mediaGalleries = mediaWrap.querySelectorAll('.reviews__media-gallery');

	if (!reviewSlides.length || !mediaGalleries.length) return;

	const mediaSwipers = new Map();

	mediaGalleries.forEach((gallery) => {
		const sliderEl = gallery.querySelector('.reviews__media-slider');
		const paginationEl = gallery.querySelector('.reviews__media-pagination');
		const slides = gallery.querySelectorAll('.swiper-slide');

		if (!sliderEl) return;
		if (sliderEl.classList.contains('swiper-initialized')) return;

		const mediaSwiper = new Swiper(sliderEl, {
			modules: [Pagination],
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 600,
			resistanceRatio: 0,
			pagination: {
				el: paginationEl,
				clickable: true,
			},
		});

		if (slides.length <= 1 && paginationEl) {
			paginationEl.style.display = 'none';
		}

		mediaSwipers.set(gallery.dataset.reviewGalleryId, mediaSwiper);
	});

	let currentGalleryId = reviewSlides[swiperInstance.realIndex]?.dataset.reviewGalleryId || '0';

	const switchGallery = (newGalleryId) => {
		if (!newGalleryId || newGalleryId === currentGalleryId) return;

		const currentGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${currentGalleryId}"]`);
		const nextGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${newGalleryId}"]`);

		if (!nextGallery) return;

		mediaWrap.classList.add('is-changing');

		setTimeout(() => {
			if (currentGallery) currentGallery.classList.remove('is-active');
			nextGallery.classList.add('is-active');

			const nextSwiper = mediaSwipers.get(newGalleryId);
			if (nextSwiper) {
				nextSwiper.update();
				nextSwiper.pagination.update();
			}

			currentGalleryId = newGalleryId;
			mediaWrap.classList.remove('is-changing');
		}, 180);
	};

	const initialGallery = mediaWrap.querySelector(`.reviews__media-gallery[data-review-gallery-id="${currentGalleryId}"]`);
	if (initialGallery) {
		mediaGalleries.forEach((gallery) => gallery.classList.remove('is-active'));
		initialGallery.classList.add('is-active');
	}

	swiperInstance.on('slideChange', () => {
		const activeSlide = reviewSlides[swiperInstance.realIndex];
		if (!activeSlide) return;

		const newGalleryId = activeSlide.dataset.reviewGalleryId;
		switchGallery(newGalleryId);
	});
}

function syncSliderFullBlockHeight(block) {
	const mainEl = block.querySelector('.slider-full-block__main');
	const thumbsWrap = block.querySelector('.slider-full-block__thumbs-wrap');
	const prevBtn = block.querySelector('.slider-full-block__nav--prev');
	const nextBtn = block.querySelector('.slider-full-block__nav--next');

	if (!mainEl || !thumbsWrap) return;

	if (window.innerWidth < 768) {
		block.style.removeProperty('--slider-full-thumbs-height');
		return;
	}

	const mainHeight = mainEl.offsetHeight;
	const prevHeight = prevBtn ? prevBtn.offsetHeight : 0;
	const nextHeight = nextBtn ? nextBtn.offsetHeight : 0;

	const thumbsHeight = mainHeight - prevHeight - nextHeight;

	if (thumbsHeight > 0) {
		block.style.setProperty('--slider-full-thumbs-height', `${thumbsHeight}px`);
	}
}

function initSingleSliderFullBlock(block) {
	if (!block) return;
	if (block.dataset.sliderFullReady === 'true') return;

	const mainEl = block.querySelector('.slider-full-block__main');
	const thumbsEl = block.querySelector('.slider-full-block__thumbs');
	const prevBtn = block.querySelector('.slider-full-block__nav--prev');
	const nextBtn = block.querySelector('.slider-full-block__nav--next');

	if (!mainEl || !thumbsEl) return;
	if (mainEl.classList.contains('swiper-initialized')) return;

	const thumbsSwiper = new Swiper(thumbsEl, {
		modules: [Thumbs, Navigation],
		observer: true,
		observeParents: true,
		watchOverflow: true,
		freeMode: true,
		watchSlidesProgress: true,
		spaceBetween: 10,
		slidesPerView: 3.3,
		direction: 'horizontal',
		navigation: {
			prevEl: prevBtn,
			nextEl: nextBtn,
		},
		breakpoints: {
			768: {
				direction: 'vertical',
				slidesPerView: 3.4,
				spaceBetween: 10,
			},
			900: {
				direction: 'vertical',
				slidesPerView: 4.4,
				spaceBetween: 10,
			},
			980: {
				direction: 'vertical',
				slidesPerView: 5.4,
				spaceBetween: 20,
			},
			1200: {
				direction: 'vertical',
				slidesPerView: 6.4,
				spaceBetween: 20,
			},
		},
	});

	const mainSwiper = new Swiper(mainEl, {
		modules: [Thumbs, Navigation],
		observer: true,
		observeParents: true,
		watchOverflow: true,
		slidesPerView: 1,
		spaceBetween: 20,
		direction: 'horizontal',
		grabCursor: true,
		navigation: {
			prevEl: prevBtn,
			nextEl: nextBtn,
		},
		thumbs: {
			swiper: thumbsSwiper,
		},
		breakpoints: {
			768: {
				direction: 'vertical',
			},
		},
		on: {
			init: () => {
				syncSliderFullBlockHeight(block);
			},
			resize: () => {
				syncSliderFullBlockHeight(block);
			},
		},
	});

	syncSliderFullBlockHeight(block);

	let resizeRaf = null;

	const handleResize = () => {
		if (resizeRaf) cancelAnimationFrame(resizeRaf);

		resizeRaf = requestAnimationFrame(() => {
			syncSliderFullBlockHeight(block);
			mainSwiper.update();
			thumbsSwiper.update();
		});
	};

	window.addEventListener('resize', handleResize, { passive: true });

	block.dataset.sliderFullReady = 'true';
}

function initSingleSlider(sliderBlock) {
	if (!sliderBlock) return;
	if (sliderBlock.dataset.sliderReady === 'true') return;

	const sliderEl = sliderBlock.querySelector('.swiper');
	const prevBtn = sliderBlock.querySelector('.slider-block__button--prev');
	const nextBtn = sliderBlock.querySelector('.slider-block__button--next');
	const paginationEl = sliderBlock.querySelector('.slider-block__pagination');
	const sliderType = sliderBlock.dataset.sliderType || 'default';

	if (!sliderEl) return;
	if (sliderEl.classList.contains('swiper-initialized')) return;

	let options = {
		modules: [Navigation, Pagination],
		observer: true,
		observeParents: true,
		speed: 800,
		watchOverflow: true,
		slidesPerView: 1,
		spaceBetween: 16,
	};

	if (prevBtn && nextBtn) {
		options.navigation = {
			prevEl: prevBtn,
			nextEl: nextBtn,
		};
	}

	if (paginationEl) {
		options.pagination = {
			el: paginationEl,
			clickable: true,
		};
	}

	if (sliderType === 'services') {
		options = {
			...options,
			loop: true,
			slidesPerView: 1.2,
			spaceBetween: 16,
			breakpoints: {
				576: {
					slidesPerView: 2,
					spaceBetween: 16,
				},
				768: {
					slidesPerView: 2.2,
					spaceBetween: 20,
				},
				992: {
					slidesPerView: 3,
					spaceBetween: 24,
				},
			},
		};
	}

	if (sliderType === 'reviews') {
		options = {
			...options,
			loop: true,
			slidesPerView: 1,
			spaceBetween: 0,
			navigation: {
				prevEl: sliderBlock.querySelector('.reviews__button--prev'),
				nextEl: sliderBlock.querySelector('.reviews__button--next'),
			},
		};
	}

	const swiper = new Swiper(sliderEl, options);

	if (sliderType === 'reviews') {
		initReviewMedia(sliderBlock, swiper);
	}

	sliderBlock.dataset.sliderReady = 'true';
}

function observeDeferredSliders() {
	const sliderBlocks = document.querySelectorAll('[data-fls-slider]');
	const fullBlocks = document.querySelectorAll('[data-slider-full-block]');

	if (!sliderBlocks.length && !fullBlocks.length) return;

	const observer = new IntersectionObserver((entries, obs) => {
		entries.forEach((entry) => {
			if (!entry.isIntersecting) return;

			const element = entry.target;

			if (element.hasAttribute('data-fls-slider')) {
				initSingleSlider(element);
			}

			if (element.hasAttribute('data-slider-full-block')) {
				initSingleSliderFullBlock(element);
			}

			obs.unobserve(element);
		});
	}, {
		rootMargin: '300px 0px',
		threshold: 0.01,
	});

	sliderBlocks.forEach((block) => observer.observe(block));
	fullBlocks.forEach((block) => observer.observe(block));
}

window.addEventListener('load', () => {
	observeDeferredSliders();
});