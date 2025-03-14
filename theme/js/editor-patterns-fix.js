/**
 * JavaScript to fix pattern rendering in the Gutenberg editor
 *
 * Uses IIFE pattern with global context
 */
(function (global) {
	// Safe reference to jQuery
	var $ = global.jQuery;
	if (!$) return;

	// Safe access to document
	var doc = global.document;
	if (!doc) return;

	// Wait for document ready
	$(doc).ready(function () {
		// Fix for hero pattern in the editor
		function fixHeroPatternDisplay() {
			// Wait for Gutenberg to be fully loaded
			var wp = global.wp;
			if (typeof wp === 'undefined' || typeof wp.data === 'undefined') {
				global.setTimeout(fixHeroPatternDisplay, 500);
				return;
			}

			// Store brand colors for consistent application
			var brandColors = {
				DEFAULT: '#bc6f30',
				900: '#71431d',
				800: '#844e22',
				700: '#965926',
				600: '#a9642b',
				500: '#bc6f30',
				400: '#c37d45',
				300: '#c98c59',
				200: '#d09a6e',
				100: '#d7a983',
				50: '#f0f9ff',
			};

			// Function to fix the hero pattern
			function refreshHeroPattern() {
				// Target the hero pattern cover blocks
				$('.editor-styles-wrapper .is-style-wades-parallax-hero').each(
					function () {
						var $hero = $(this);

						// Fix overflow issues
						$hero.css({
							width: '100%',
							'max-width': '100%',
							'margin-left': '0',
							'margin-right': '0',
							overflow: 'hidden',
						});

						// Fix parent overflow for both admin and front-end
						$hero
							.parents('.wp-block-post-content')
							.css('overflow-x', 'hidden');
						$('.editor-styles-wrapper').css('overflow-x', 'hidden');

						// Ensure proper z-index stacking
						$hero
							.find('.wp-block-cover__background')
							.css('z-index', 1);
						$hero
							.find('.wp-block-cover__inner-container')
							.css('z-index', 2);

						// Fix responsive issues with the plumber mascot
						$hero.find('.hidden.md\\:block').css({
							display: 'block',
							position: 'absolute',
							bottom: '0',
							right: '2.5rem',
						});

						// Fix backdrop blur if present
						$hero.find('.backdrop-blur-sm').css({
							'backdrop-filter': 'blur(4px)',
							'background-color': 'rgba(255, 255, 255, 0.1)',
						});

						// Fix brand colors
						$hero
							.find('.bg-brand')
							.css('background-color', brandColors.DEFAULT);
						$hero
							.find('.text-brand')
							.css('color', brandColors.DEFAULT);
						$hero
							.find('.border-brand')
							.css('border-color', brandColors.DEFAULT);

						// Brand color variants for backgrounds
						for (var shade in brandColors) {
							if (shade !== 'DEFAULT') {
								$hero
									.find('.bg-brand-' + shade)
									.css(
										'background-color',
										brandColors[shade]
									);
								$hero
									.find('.text-brand-' + shade)
									.css('color', brandColors[shade]);
								$hero
									.find('.border-brand-' + shade)
									.css('border-color', brandColors[shade]);
							}
						}

						// Fix alignfull class in the hero to prevent overflow
						$hero.find('.alignfull').css({
							'margin-left': '0',
							'margin-right': '0',
							width: '100%',
							'max-width': '100%',
						});
					}
				);
			}

			// Initial fix
			refreshHeroPattern();

			// React to changes in the editor content
			var MutationObserver = global.MutationObserver;
			if (MutationObserver) {
				var observer = new MutationObserver(function (mutations) {
					mutations.forEach(function (mutation) {
						if (mutation.addedNodes.length) {
							refreshHeroPattern();
						}
					});
				});

				// Observe the editor for changes
				var editorEl = doc.querySelector('.editor-styles-wrapper');
				if (editorEl) {
					observer.observe(editorEl, {
						childList: true,
						subtree: true,
					});
				}
			}

			// Also watch for resize events
			$(global).on('resize', function () {
				refreshHeroPattern();
			});
		}

		// Start the fix process
		fixHeroPatternDisplay();
	});
})(
	(function () {
		return this;
	})()
);
