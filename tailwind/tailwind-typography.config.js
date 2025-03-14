/**
 * Tailwind Typography can only be configured via JavaScript, using a legacy
 * configuration file like this one.
 */

// Copied from Tailwind Typography.
const hexToRgb = (hex) => {
	if (typeof hex !== 'string' || hex.length === 0) {
		return hex;
	}

	hex = hex.replace('#', '');
	hex = hex.length === 3 ? hex.replace(/./g, '$&$&') : hex;
	const r = parseInt(hex.substring(0, 2), 16);
	const g = parseInt(hex.substring(2, 4), 16);
	const b = parseInt(hex.substring(4, 6), 16);
	return `${r} ${g} ${b}`;
};

module.exports = {
	theme: {
		extend: {
			typography: (theme) => ({
				/**
				 * Tailwind Typography's default styles are opinionated, and
				 * you may need to override them if you have mockups to
				 * replicate. You can view the default modifiers here:
				 *
				 * https://github.com/tailwindlabs/tailwindcss-typography/blob/master/src/styles.js
				 */

				DEFAULT: {
					css: [
						{
							/**
							 * By default, max-width is set to 65 characters.
							 * This is a good default for readability, but
							 * often in conflict with client-supplied designs.
							 */
							maxWidth: 'none',
							color: 'hsl(var(--foreground))',
							a: {
								color: 'hsl(var(--primary))',
								'&:hover': {
									color: 'hsl(var(--primary-foreground))',
								},
							},

							/**
							 * Tailwind Typography uses the font weights 400
							 * through 900. If you're not using a variable font,
							 * you may need to limit the number of supported
							 * weights. Below are all of the default weights,
							 * ready to be overridden.
							 */
							// a: {
							// 	fontWeight: '500',
							// },
							// strong: {
							// 	fontWeight: '600',
							// },
							// 'ol > li::marker': {
							// 	fontWeight: '400',
							// },
							// dt: {
							// 	fontWeight: '600',
							// },
							// blockquote: {
							// 	fontWeight: '500',
							// },
							// h1: {
							// 	fontWeight: '800',
							// },
							// 'h1 strong': {
							// 	fontWeight: '900',
							// },
							// h2: {
							// 	fontWeight: '700',
							// },
							// 'h2 strong': {
							// 	fontWeight: '800',
							// },
							// h3: {
							// 	fontWeight: '600',
							// },
							// 'h3 strong': {
							// 	fontWeight: '700',
							// },
							// h4: {
							// 	fontWeight: '600',
							// },
							// 'h4 strong': {
							// 	fontWeight: '700',
							// },
							// kbd: {
							// 	fontWeight: '500',
							// },
							// code: {
							// 	fontWeight: '600',
							// },
							// pre: {
							// 	fontWeight: '400',
							// },
							// 'thead th': {
							// 	fontWeight: '600',
							// },
						},
					],
				},

				/**
				 * By default, _tw uses Tailwind Typography's Neutral gray
				 * scale. If you are adapting an existing design and you need
				 * to set specific colors throughout, you can do so here. In
				 * your `./theme/functions.php file, you will need to replace
				 * `-neutral` with `-Wades Plumbing & Septic`.
				 */
				'wades-plumbing-septic': {
					css: {
						'--tw-prose-body': theme('colors.foreground'),
						'--tw-prose-headings': theme('colors.foreground'),
						'--tw-prose-lead': theme('colors.foreground'),
						'--tw-prose-links': theme('colors.primary'),
						'--tw-prose-bold': theme('colors.foreground'),
						'--tw-prose-counters': theme('colors.primary'),
						'--tw-prose-bullets': theme('colors.primary'),
						'--tw-prose-hr': theme('colors.foreground'),
						'--tw-prose-quotes': theme('colors.foreground'),
						'--tw-prose-quote-borders': theme('colors.primary'),
						'--tw-prose-captions': theme('colors.foreground'),
						'--tw-prose-kbd': theme('colors.foreground'),
						'--tw-prose-kbd-shadows': hexToRgb(
							theme('colors.foreground')
						),
						'--tw-prose-code': theme('colors.foreground'),
						'--tw-prose-pre-code': theme('colors.background'),
						'--tw-prose-pre-bg': theme('colors.foreground'),
						'--tw-prose-th-borders': theme('colors.foreground'),
						'--tw-prose-td-borders': theme('colors.foreground'),
						'--tw-prose-invert-body': theme('colors.background'),
						'--tw-prose-invert-headings':
							theme('colors.background'),
						'--tw-prose-invert-lead': theme('colors.background'),
						'--tw-prose-invert-links': theme('colors.primary'),
						'--tw-prose-invert-bold': theme('colors.background'),
						'--tw-prose-invert-counters': theme('colors.primary'),
						'--tw-prose-invert-bullets': theme('colors.primary'),
						'--tw-prose-invert-hr': theme('colors.background'),
						'--tw-prose-invert-quotes': theme('colors.background'),
						'--tw-prose-invert-quote-borders':
							theme('colors.primary'),
						'--tw-prose-invert-captions':
							theme('colors.background'),
						'--tw-prose-invert-kbd': theme('colors.background'),
						'--tw-prose-invert-kbd-shadows': hexToRgb(
							theme('colors.background')
						),
						'--tw-prose-invert-code': theme('colors.foreground'),
						'--tw-prose-invert-pre-code':
							theme('colors.background'),
						'--tw-prose-invert-pre-bg': 'rgb(0 0 0 / 50%)',
						'--tw-prose-invert-th-borders':
							theme('colors.background'),
						'--tw-prose-invert-td-borders':
							theme('colors.background'),
					},
				},
			}),
			// Adding additional extended theme configurations from original website
			textShadow: {
				sm: '0 1px 2px rgba(0, 0, 0, 0.3)',
				DEFAULT: '0 2px 4px rgba(0, 0, 0, 0.4)',
				lg: '0 4px 8px rgba(0, 0, 0, 0.5)',
			},
			keyframes: {
				'accordion-down': {
					from: { height: 0 },
					to: { height: 'var(--radix-accordion-content-height)' },
				},
				'accordion-up': {
					from: { height: 'var(--radix-accordion-content-height)' },
					to: { height: 0 },
				},
				'fade-in': {
					'0%': { opacity: '0' },
					'100%': { opacity: '1' },
				},
				'fade-in-right': {
					'0%': { opacity: '0', transform: 'translateX(20px)' },
					'100%': { opacity: '1', transform: 'translateX(0)' },
				},
				'slide-up': {
					'0%': { opacity: '0', transform: 'translateY(20px)' },
					'100%': { opacity: '1', transform: 'translateY(0)' },
				},
				fadeIn: {
					'0%': { opacity: '0' },
					'100%': { opacity: '1' },
				},
				slideUp: {
					'0%': { transform: 'translateY(10px)', opacity: '0' },
					'100%': { transform: 'translateY(0)', opacity: '1' },
				},
			},
			animation: {
				'accordion-down': 'accordion-down 0.2s ease-out',
				'accordion-up': 'accordion-up 0.2s ease-out',
				'fade-in': 'fade-in 0.6s ease-out',
				'fade-in-right': 'fade-in-right 0.6s ease-out',
				'slide-up': 'slide-up 0.5s ease-out',
				fadeIn: 'fadeIn 0.5s ease-in-out',
				slideUp: 'slideUp 0.3s ease-out',
				'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
			},
			borderRadius: {
				none: '0px',
				sm: '0.125rem',
				DEFAULT: '0.20rem',
				md: '0.375rem',
				lg: '0.5rem',
				xl: '0.75rem',
				'2xl': '1rem',
				'3xl': '1.5rem',
				full: '9999px',
			},
			colors: {
				transparent: 'transparent',
				current: 'currentColor',
				brand: {
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
				},
				brandCream: {
					DEFAULT: '#f4ece8',
					800: '#d8c8c3',
					700: '#e1d1cd',
					600: '#e9dad6',
					500: '#f4ece8',
					400: '#f7f1ef',
					300: '#faf5f2',
					200: '#fdf8f6',
					100: '#fefbfa',
				},
				black: {
					DEFAULT: '#1B1B1B',
					800: '#000000',
					700: '#0C0C0C',
					600: '#151515',
					500: '#1B1B1B',
					400: '#222222',
					300: '#292929',
					200: '#303030',
					100: '#373737',
				},
				white: {
					DEFAULT: '#F7F7F7',
					800: '#adadad',
					700: '#c6c6c6',
					600: '#dedede',
					500: '#F7F7F7',
					400: '#f8f8f8',
					300: '#f9f9f9',
					200: '#fafafa',
					100: '#fbfbfb',
				},
				gray: {
					DEFAULT: '#808080',
					800: '#4C4C4C',
					700: '#5E5E5E',
					600: '#6F6F6F',
					500: '#808080',
					400: '#939393',
					300: '#A6A6A6',
					200: '#B9B9B9',
					100: '#CCCCCC',
					50: '#e5e7eb',
				},
				red: {
					DEFAULT: '#C53D3A',
					800: '#7C1512',
					700: '#911A16',
					600: '#A41F1A',
					500: '#C53D3A',
					400: '#D96E6C',
					300: '#E89B9C',
					200: '#F4C9CA',
					100: '#FCE4E4',
				},
				orange: {
					DEFAULT: '#E18B41',
					800: '#9C4E1F',
					700: '#AF5A24',
					600: '#C2662A',
					500: '#E18B41',
					400: '#EBAA73',
					300: '#F2C5A1',
					200: '#F7DECA',
					100: '#FBEAE4',
				},
				yellow: {
					DEFAULT: '#F4E04D',
					800: '#c3b33e',
					700: '#c3b33e',
					600: '#dcca45',
					500: '#F4E04D',
					400: '#f5e35f',
					300: '#f6e671',
					200: '#f7e982',
					100: '#f7e982',
				},
				green: {
					DEFAULT: '#548B54',
					800: '#2C4F2C',
					700: '#355E35',
					600: '#406E40',
					500: '#548B54',
					400: '#76A476',
					300: '#9CC99C',
					200: '#C2E2C2',
					100: '#E8F1E8',
				},
				blue: {
					DEFAULT: '#199DDB',
					800: '#126e99',
					700: '#147eaf',
					600: '#178dc5',
					500: '#199DDB',
					400: '#30a7df',
					300: '#47b1e2',
					200: '#5ebae6',
					100: '#75c4e9',
				},
				purple: {
					DEFAULT: '#9B4E91',
					800: '#5E2B57',
					700: '#6D3367',
					600: '#7C3A76',
					500: '#9B4E91',
					400: '#B274A9',
					300: '#C9A1C1',
					200: '#DEC8D3',
					100: '#F2E5ED',
				},
				cream: {
					DEFAULT: '#E8DDB5',
					800: '#BDAF83',
					700: '#CABE95',
					600: '#D7CCAA',
					500: '#E8DDB5',
					400: '#F0E4C9',
					300: '#F6ECD8',
					200: '#FBF3E7',
					100: '#FDF9F2',
				},
				border: 'hsl(var(--border))',
				input: 'hsl(var(--input))',
				ring: 'hsl(var(--ring))',
				background: 'hsl(var(--background))',
				foreground: 'hsl(var(--foreground))',
				primary: {
					DEFAULT: 'hsl(var(--primary))',
					foreground: 'hsl(var(--primary-foreground))',
				},
				secondary: {
					DEFAULT: 'hsl(var(--secondary))',
					foreground: 'hsl(var(--secondary-foreground))',
				},
				destructive: {
					DEFAULT: 'hsl(var(--destructive))',
					foreground: 'hsl(var(--destructive-foreground))',
				},
				muted: {
					DEFAULT: 'hsl(var(--muted))',
					foreground: 'hsl(var(--muted-foreground))',
				},
				accent: {
					DEFAULT: 'hsl(var(--accent))',
					foreground: 'hsl(var(--accent-foreground))',
				},
				popover: {
					DEFAULT: 'hsl(var(--popover))',
					foreground: 'hsl(var(--popover-foreground))',
				},
				card: {
					DEFAULT: 'hsl(var(--card))',
					foreground: 'hsl(var(--card-foreground))',
				},
			},
			dropShadow: {
				sm: '0 1px 1px rgb(0 0 0 / 0.05)',
				DEFAULT: [
					'0 1px 2px rgb(0 0 0 / 0.1)',
					'0 1px 1px rgb(0 0 0 / 0.06)',
				],
				md: [
					'0 4px 3px rgb(0 0 0 / 0.07)',
					'0 2px 2px rgb(0 0 0 / 0.06)',
				],
				lg: [
					'0 10px 8px rgb(0 0 0 / 0.04)',
					'0 4px 3px rgb(0 0 0 / 0.1)',
				],
				xl: [
					'0 20px 13px rgb(0 0 0 / 0.03)',
					'0 8px 5px rgb(0 0 0 / 0.08)',
				],
				'2xl': '0 25px 25px rgb(0 0 0 / 0.15)',
				none: '0 0 #0000',
			},
			fontFamily: {
				sans: ['var(--font-geist-sans)'],
				mono: ['var(--font-geist-mono)'],
				base: [
					'Segoe UI',
					'Noto Sans',
					'Helvetica',
					'Arial',
					'sans-serif',
					'Apple Color Emoji',
					'Segoe UI Emoji',
				],
				times: ['Times New Roman', 'serif'],
			},
			fontSize: {
				xs: ['0.75rem', { lineHeight: '1rem' }],
				sm: ['0.875rem', { lineHeight: '1.25rem' }],
				base: ['1rem', { lineHeight: '1.5rem' }],
				lg: ['1.125rem', { lineHeight: '1.75rem' }],
				xl: ['1.25rem', { lineHeight: '1.75rem' }],
				'2xl': ['1.5rem', { lineHeight: '2rem' }],
				'3xl': ['1.875rem', { lineHeight: '2.25rem' }],
				'4xl': ['2.25rem', { lineHeight: '2.5rem' }],
				'5xl': ['3rem', { lineHeight: '1' }],
				'6xl': ['3.75rem', { lineHeight: '1' }],
				'7xl': ['4.5rem', { lineHeight: '1' }],
				'8xl': ['6rem', { lineHeight: '1' }],
				'9xl': ['8rem', { lineHeight: '1' }],
			},
			fontWeight: {
				thin: '100',
				extralight: '200',
				light: '300',
				normal: '400',
				medium: '500',
				semibold: '600',
				bold: '700',
				extrabold: '800',
				black: '900',
			},
			letterSpacing: {
				tighter: '-0.05em',
				tight: '-0.025em',
				normal: '0em',
				wide: '0.025em',
				wider: '0.05em',
				widest: '0.1em',
			},
			lineHeight: {
				none: '1',
				tight: '1.25',
				snug: '1.375',
				normal: '1.5',
				relaxed: '1.625',
				loose: '2',
				3: '.75rem',
				4: '1rem',
				5: '1.25rem',
				6: '1.5rem',
				7: '1.75rem',
				8: '2rem',
				9: '2.25rem',
				10: '2.5rem',
			},
			spacing: {
				'safe-top': 'env(safe-area-inset-top)',
				'safe-bottom': 'env(safe-area-inset-bottom)',
				'safe-left': 'env(safe-area-inset-left)',
				'safe-right': 'env(safe-area-inset-right)',
			},
			screens: {
				xs: '475px',
			},
		},
	},
	// These plugins would normally be in the main tailwind.config.js file
	// Including them here for reference, but they should be added to the main config
	plugins: [
		// require('@tailwindcss/typography'), // This is already used in the main config
		// require('@tailwindcss/forms'),
		// require('tailwindcss-animate'),
		// require('@tailwindcss/aspect-ratio'),
		// function for custom utilities like text-shadow
	],
};
