/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

/**
 * Main theme JavaScript file
 *
 * Contains functionality for the mobile menu toggle and other interactive elements
 */

// Import parallax effect
import './parallax.js';

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function () {
	const mobileMenuButton = document.getElementById('mobile-menu-button');
	const mobileMenu = document.getElementById('mobile-menu');

	if (mobileMenuButton && mobileMenu) {
		mobileMenuButton.addEventListener('click', function () {
			mobileMenu.classList.toggle('hidden');
			const isExpanded =
				mobileMenuButton.getAttribute('aria-expanded') === 'true';
			mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
		});
	}

	// Close mobile menu on window resize to desktop size
	window.addEventListener('resize', function () {
		if (
			window.innerWidth >= 768 &&
			mobileMenu &&
			!mobileMenu.classList.contains('hidden')
		) {
			mobileMenu.classList.add('hidden');
			if (mobileMenuButton) {
				mobileMenuButton.setAttribute('aria-expanded', 'false');
			}
		}
	});
});
