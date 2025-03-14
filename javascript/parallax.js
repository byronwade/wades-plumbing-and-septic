/**
 * Parallax effect and full-width handling for the hero section
 */
document.addEventListener('DOMContentLoaded', function () {
	// Handle parallax effect
	const parallaxElements = document.querySelectorAll(
		'.is-style-wades-parallax-hero'
	);

	function handleParallax() {
		parallaxElements.forEach((element) => {
			if (window.innerWidth > 768) {
				// Only apply parallax on larger screens
				const scrollPosition = window.pageYOffset;
				// Adjust the background position for a subtle parallax effect
				element.style.backgroundPositionY = `calc(50% + ${scrollPosition * 0.4}px)`;
			} else {
				// Reset for mobile devices
				element.style.backgroundPositionY = '50%';
			}
		});
	}

	// Handle full-width layout issues
	function ensureFullWidth() {
		const fullWidthElements = document.querySelectorAll(
			'.alignfull, [data-align="full"], .wp-block-cover.alignfull'
		);

		fullWidthElements.forEach((element) => {
			// Reset any potential inherited max-width constraints
			element.style.width = '100vw';
			element.style.maxWidth = '100vw';
			element.style.marginLeft = 'calc(50% - 50vw)';
			element.style.marginRight = 'calc(50% - 50vw)';

			// Force layout recalculation
			element.offsetHeight;
		});
	}

	// Initial setup
	window.addEventListener('scroll', handleParallax);
	window.addEventListener('resize', function () {
		handleParallax();
		ensureFullWidth();
	});

	// Run immediately
	handleParallax();
	ensureFullWidth();

	// Run again after a slight delay to handle post-load layout adjustments
	setTimeout(ensureFullWidth, 500);
});
