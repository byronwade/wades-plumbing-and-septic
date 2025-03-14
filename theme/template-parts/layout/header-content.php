<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Wades_Plumbing_&_Septic
 */

// Get the phone number from customizer
$phone_number = get_theme_mod('phone_number', '831.225.4344');
$phone_cleaned = preg_replace('/[^0-9]/', '', $phone_number);
$business_hours = get_theme_mod('business_hours', 'Mon - Fri 9:00am - 5:00pm');
$service_areas = get_theme_mod('service_areas', 'Santa Cruz County, Monterey County, Santa Clara County');

// Check if Missouri state detection is enabled
$enable_state_detection = get_theme_mod('enable_state_detection', false);
$mo_phone_number = get_theme_mod('mo_phone_number', '');

// Get user's state preference from cookie
$user_state = isset($_COOKIE['wades_selected_state']) ? $_COOKIE['wades_selected_state'] : '';
$detected_state = isset($_COOKIE['wades_detected_state']) ? $_COOKIE['wades_detected_state'] : '';

// Determine which phone number to display
$display_phone = $phone_number;
if ($enable_state_detection && $mo_phone_number && ($user_state === 'MO' || ($detected_state === 'MO' && $user_state === ''))) {
    $display_phone = $mo_phone_number;
    $phone_cleaned = preg_replace('/[^0-9]/', '', $mo_phone_number);
}
?>

<header role="banner">
	<nav class="bg-black text-white sticky top-0 z-50" aria-label="Main navigation">
		<div class="relative flex p-3 items-center justify-between mx-auto max-w-7xl px-6 lg:px-8">
			<a class="flex items-center space-x-4" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?> - Back to home">
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
				<span class="hidden text-2xl font-bold xl:inline-flex"><?php bloginfo( 'name' ); ?></span>
			</a>
			
			<!-- Mobile menu button -->
			<div class="flex items-center font-bold md:hidden">
				<button class="inline-flex items-center justify-center p-2 text-gray-400 rounded hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
						type="button" 
						aria-expanded="false" 
						aria-controls="mobile-menu"
						id="mobile-menu-button">
					<span class="sr-only">Open main menu</span>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block w-6 h-6" aria-hidden="true">
						<line x1="3" y1="12" x2="21" y2="12"></line>
						<line x1="3" y1="6" x2="21" y2="6"></line>
						<line x1="3" y1="18" x2="21" y2="18"></line>
					</svg>
				</button>
			</div>
			
			<!-- Desktop navigation -->
			<div class="hidden md:flex space-x-8 items-center font-bold">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'hidden md:flex space-x-8 items-center font-bold',
						'container'      => false,
						'fallback_cb'    => function() {
							echo '<a class="hover:underline" href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
						},
						'items_wrap'     => '%3$s', 
						'walker'         => new Wade_Nav_Walker(),
					)
				);
				?>				
				<a class="inline-flex justify-center items-center rounded font-bold px-3.5 py-2.5 bg-brand text-black hover:bg-brand-600" href="tel:+1<?php echo esc_attr($phone_cleaned); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
						<path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
					</svg>
					<?php echo esc_html($display_phone); ?>
				</a>
				
				<?php if ($enable_state_detection && $mo_phone_number) : ?>
				<div class="relative" id="phone-region-selector">
					<button type="button" id="phone-region-button" class="inline-flex items-center text-sm font-medium text-gray-300 hover:text-white" aria-expanded="false">
						<span class="sr-only">Select region</span>
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
						</svg>
					</button>
					
					<div id="phone-region-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="phone-region-button" tabindex="-1">
						<a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white" role="menuitem" tabindex="-1" data-state="CA">California</a>
						<a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white" role="menuitem" tabindex="-1" data-state="MO">Missouri</a>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
		<!-- Contact bar -->
		<div class="hidden px-4 py-1 font-bold text-black shadow md:block bg-brand">
			<div class="items-center justify-center hidden p-1 px-6 pr-4 mx-auto space-x-10 text-sm lg:flex max-w-7xl lg:px-8">
				<?php if ($business_hours) : ?>
					<div><?php echo esc_html($business_hours); ?></div>
				<?php endif; ?>
				
				<?php if ($display_phone) : ?>
					<a class="text-lg font-extrabold hover:underline" href="tel:+1<?php echo esc_attr($phone_cleaned); ?>"><?php echo esc_html($display_phone); ?></a>
				<?php endif; ?>
				
				<div class="space-x-1">
					<?php 
					$areas = explode(',', $service_areas);
					$last_key = array_key_last($areas);
					
					foreach ($areas as $key => $area) {
						echo '<a class="hover:underline" href="#">' . esc_html(trim($area)) . '</a>';
						if ($key !== $last_key) {
							echo ',';
						}
					}
					?>
				</div>
			</div>
		</div>
	</nav>
	
	<!-- Mobile menu (hidden by default) -->
	<div class="hidden md:hidden bg-black text-white p-4" id="mobile-menu" role="menu" aria-labelledby="mobile-menu-button">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'mobile-primary-menu',
				'menu_class'     => 'space-y-4',
				'container'      => false,
				'fallback_cb'    => function() {
					echo '<div class="py-2"><a class="block text-lg font-bold hover:text-gray-300" href="' . esc_url( home_url( '/' ) ) . '">Home</a></div>';
				},
				'walker'         => new Wade_Mobile_Nav_Walker(),
			)
		);
		?>
		<div class="mt-4">
			<?php if ($display_phone) : ?>
			<a class="inline-flex justify-center items-center rounded font-bold px-3.5 py-2.5 bg-brand text-black hover:bg-brand-600 w-full" href="tel:+1<?php echo esc_attr($phone_cleaned); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
				</svg>
				<?php echo esc_html($display_phone); ?>
			</a>
			<?php endif; ?>
		</div>
		<div class="mt-4 space-y-2 text-sm">
			<?php if ($business_hours) : ?>
				<div><?php echo esc_html($business_hours); ?></div>
			<?php endif; ?>
			
			<?php if ($display_phone) : ?>
				<a class="block text-lg font-extrabold hover:underline" href="tel:+1<?php echo esc_attr($phone_cleaned); ?>"><?php echo esc_html($display_phone); ?></a>
			<?php endif; ?>
			
			<?php if ($enable_state_detection && $mo_phone_number) : ?>
			<div class="mt-4" id="mobile-phone-region-selector">
				<p class="text-sm text-gray-400 mb-2">Select your location:</p>
				<div class="grid grid-cols-2 gap-2">
					<button type="button" data-state="CA" class="text-center py-2 px-3 bg-gray-700 rounded hover:bg-gray-600 text-white <?php echo (!$user_state || $user_state === 'CA') ? 'ring-2 ring-white' : ''; ?>">California</button>
					<button type="button" data-state="MO" class="text-center py-2 px-3 bg-gray-700 rounded hover:bg-gray-600 text-white <?php echo ($user_state === 'MO') ? 'ring-2 ring-white' : ''; ?>">Missouri</button>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Mobile menu toggle functionality
	const mobileMenuButton = document.getElementById('mobile-menu-button');
	const mobileMenu = document.getElementById('mobile-menu');
	
	if (mobileMenuButton && mobileMenu) {
		mobileMenuButton.addEventListener('click', function() {
			mobileMenu.classList.toggle('hidden');
			const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
			mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
		});
	}
	
	// Set logo height CSS custom properties
	document.documentElement.style.setProperty('--logo-height', '48px');
	document.documentElement.style.setProperty('--logo-height-mobile', '38.4px');
	
	// Phone region selector functionality
	const regionButton = document.getElementById('phone-region-button');
	const regionDropdown = document.getElementById('phone-region-dropdown');
	
	if (regionButton && regionDropdown) {
		regionButton.addEventListener('click', function() {
			regionDropdown.classList.toggle('hidden');
			regionButton.setAttribute('aria-expanded', regionDropdown.classList.contains('hidden') ? 'false' : 'true');
		});
		
		// Close the dropdown when clicking outside
		document.addEventListener('click', function(event) {
			if (!regionButton.contains(event.target) && !regionDropdown.contains(event.target)) {
				regionDropdown.classList.add('hidden');
				regionButton.setAttribute('aria-expanded', 'false');
			}
		});
		
		// Handle region selection
		regionDropdown.querySelectorAll('a').forEach(function(link) {
			link.addEventListener('click', function(e) {
				e.preventDefault();
				setUserRegion(this.getAttribute('data-state'));
			});
		});
	}
	
	// Mobile region selector
	const mobileRegionSelector = document.getElementById('mobile-phone-region-selector');
	if (mobileRegionSelector) {
		mobileRegionSelector.querySelectorAll('button').forEach(function(button) {
			button.addEventListener('click', function() {
				setUserRegion(this.getAttribute('data-state'));
			});
		});
	}
	
	function setUserRegion(state) {
		// Set cookie for 30 days
		const date = new Date();
		date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
		document.cookie = "wades_selected_state=" + state + "; expires=" + date.toUTCString() + "; path=/; SameSite=Lax";
		// Reload the page to reflect the change
		window.location.reload();
	}
	
	// Location detection for first-time visitors
	if (!document.cookie.includes('wades_detected_state') && !document.cookie.includes('wades_selected_state')) {
		detectUserLocation();
	}
	
	function detectUserLocation() {
		// Use a free IP geolocation service
		fetch('https://ipapi.co/json/')
			.then(response => response.json())
			.then(data => {
				if (data && data.region_code) {
					// Set cookie for detected state
					const date = new Date();
					date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
					document.cookie = "wades_detected_state=" + data.region_code + "; expires=" + date.toUTCString() + "; path=/; SameSite=Lax";
					
					// If user is in Missouri, reload to show correct number
					if (data.region_code === 'MO') {
						window.location.reload();
					}
				}
			})
			.catch(error => {
				console.error('Error detecting location:', error);
			});
	}
});
</script>
