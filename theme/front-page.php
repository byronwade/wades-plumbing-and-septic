<?php
/**
 * Template Name: Front Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Wades_Plumbing_&_Septic
 */

get_header();

$phone_number       = wades_plumbing_septic_get_location_based_phone();
$phone_display      = is_array($phone_number) ? $phone_number['active_phone'] : $phone_number;
$phone_numbers_only = preg_replace('/[^0-9]/', '', $phone_display);
$phone_href         = 'tel:' . $phone_numbers_only;
$business_hours     = wades_plumbing_septic_get_business_hours();
$service_area_summary = function_exists('wades_plumbing_septic_get_service_area_summary')
	? wades_plumbing_septic_get_service_area_summary()
	: 'Santa Cruz County, CA and Pickens County, GA';
$business_start_year = function_exists('wades_plumbing_septic_get_business_start_year')
	? wades_plumbing_septic_get_business_start_year()
	: '2021';

// ── Editable content via admin meta box (Settings > Home Page Content) ────────
$_fp_id = get_the_ID();
function _fp( $key, $default ) {
	static $_fp_id_cache = null;
	if ( null === $_fp_id_cache ) {
		$_fp_id_cache = (int) get_option( 'page_on_front' );
	}
	$v = get_post_meta( $_fp_id_cache, $key, true );
	return ( '' !== $v ) ? $v : $default;
}

$hero_line1  = _fp( 'fp_hero_headline_line1', 'Honest' );
$hero_line2  = _fp( 'fp_hero_headline_line2', 'Plumbing' );
$hero_accent = _fp( 'fp_hero_headline_accent', '& Septic' );
$hero_sub    = _fp( 'fp_hero_subtext', 'No sales pressure. No upselling. Quality workmanship from local professionals you can count on — with clear pricing before work begins.' );
$hero_trust  = array(
	_fp( 'fp_hero_trust_1', 'Licensed & insured' ),
	_fp( 'fp_hero_trust_2', 'Flat-rate pricing' ),
	_fp( 'fp_hero_trust_3', 'Satisfaction guaranteed' ),
);

$fp_stat_rating = _fp( 'fp_stat_rating', '4.9' );
$fp_stat_jobs   = _fp( 'fp_stat_jobs',   '200+' );
$fp_stat_states = _fp( 'fp_stat_states', '2' );

$fp_testimonials = array(
	array(
		'quote'    => _fp( 'fp_t1_quote',    "Wade's team was refreshingly honest. They could have sold me a whole new system, but instead recommended a simple repair that saved me thousands." ),
		'name'     => _fp( 'fp_t1_name',     'Sarah T.' ),
		'location' => _fp( 'fp_t1_location', 'Santa Cruz, CA' ),
		'stars'    => 5,
	),
	array(
		'quote'    => _fp( 'fp_t2_quote',    "After dealing with corporate plumbers who seemed more interested in their sales quotas, finding Wade's was a breath of fresh air. Real folks who happen to be excellent plumbers." ),
		'name'     => _fp( 'fp_t2_name',     'Michael R.' ),
		'location' => _fp( 'fp_t2_location', 'Stone County, GA' ),
		'stars'    => 5,
	),
	array(
		'quote'    => _fp( 'fp_t3_quote',    "They took time to show me exactly what was wrong and explained every option without pressure. I felt like I was getting advice from a knowledgeable friend, not a sales pitch." ),
		'name'     => _fp( 'fp_t3_name',     'Jennifer L.' ),
		'location' => _fp( 'fp_t3_location', 'Pickens County, GA' ),
		'stars'    => 5,
	),
);

$fp_faqs = array(
	array( 'q' => _fp( 'fp_faq1_q', 'How often should I have my septic tank pumped?' ),     'a' => _fp( 'fp_faq1_a', 'Most septic tanks should be pumped every 3–5 years, depending on household size, wastewater volume, and tank size. We recommend a professional inspection to determine the optimal schedule for your system.' ) ),
	array( 'q' => _fp( 'fp_faq2_q', 'What are the signs of a failing septic system?' ),     'a' => _fp( 'fp_faq2_a', 'Warning signs include slow drains, gurgling sounds, sewage backups, soggy areas around the drain field, unusually lush grass, strong odors, and contaminated well water. Contact us immediately.' ) ),
	array( 'q' => _fp( 'fp_faq3_q', 'How can I prevent frozen pipes in winter?' ),          'a' => _fp( 'fp_faq3_a', 'Insulate exposed pipes, seal air leaks, disconnect outdoor hoses, allow faucets to drip during severe cold, keep cabinet doors open, and maintain consistent indoor temps (at least 55°F).' ) ),
	array( 'q' => _fp( 'fp_faq4_q', 'What should I do if I have a water leak?' ),           'a' => _fp( 'fp_faq4_a', "Shut off water at the source or main valve. Turn off electricity to affected areas. Apply temporary fixes like plumber's tape for small leaks, and call us promptly for a professional repair." ) ),
);
$fp_extra_faqs = array(
	array( 'q' => _fp( 'fp_faq5_q',  'How long does a water heater typically last?' ),                       'a' => _fp( 'fp_faq5_a',  'Conventional tank water heaters last 8–12 years, tankless 15–20+ years, and heat pump models 13–15 years. Annual maintenance can extend lifespan.' ) ),
	array( 'q' => _fp( 'fp_faq6_q',  "What's the difference between conventional and advanced septic?" ),    'a' => _fp( 'fp_faq6_a',  'Conventional uses a simple tank and drain field. Advanced systems add aerobic treatment units, media filters, and disinfection — ideal for challenging sites.' ) ),
	array( 'q' => _fp( 'fp_faq7_q',  'Do you offer financing?' ),                                            'a' => _fp( 'fp_faq7_a',  'Yes — 0% interest financing for qualified customers, flexible payment plans, special financing for large projects, and all major credit cards, checks, and cash.' ) ),
	array( 'q' => _fp( 'fp_faq8_q',  'What areas do you serve?' ),                                           'a' => _fp( 'fp_faq8_a',  'We serve Santa Cruz County in California and Pickens County in Georgia. Our team is fully licensed and insured in both states — California CSLB (C-36 Plumbing and C-42 Sanitation System) and a Georgia master plumber license.' ) ),
	array( 'q' => _fp( 'fp_faq9_q',  'How do I schedule a service appointment?' ),                           'a' => _fp( 'fp_faq9_a',  'Call our office during business hours (' . $business_hours . '). We\'ll arrange a convenient appointment time promptly.' ) ),
	array( 'q' => _fp( 'fp_faq10_q', 'How do I know if my water pressure is off?' ),                         'a' => _fp( 'fp_faq10_a', 'High pressure (above 80 PSI) causes banging pipes and leaks. Low pressure (below 40 PSI) results in weak flow. We can test your pressure and install regulators or boosters.' ) ),
);
$services_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('services') : home_url('/services/');
$about_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('about') : home_url('/about-us/');
$contact_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('contact') : home_url('/contact/');
$faq_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('faq') : home_url('/faq/');
$service_areas_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('service_areas') : home_url('/service-areas/');
$expert_tips_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('expert_tips') : home_url('/expert-tips/');
$testimonials_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('testimonials') : home_url('/testimonials/');
$septic_solutions_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('septic_solutions') : '';
if ( empty($septic_solutions_url) || ! get_page_by_path('septic-solutions') ) {
	$septic_solutions_url = $services_url;
}
$insurance_claims_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('insurance_claims') : '';
if ( empty($insurance_claims_url) || ! get_page_by_path('insurance-claims') ) {
	$insurance_claims_url = $contact_url;
}
$homeowners_septic_guide_url = function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('homeowners_septic_guide') : home_url('/a-homeowners-guide-to-new-septic-systems-in-santa-cruz-county/');

$phone_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>';

$check_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>';
?>

<main class="site-main tpl-front-page">

	<?php /* ─────────────────────────────── HERO ─────────────────────────────── */ ?>
	<section class="relative overflow-hidden bg-[#111111] text-white">

		<?php /* Subtle brand-copper glow top-right */ ?>
		<div class="pointer-events-none absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-primary/10 blur-3xl"></div>
		<div class="pointer-events-none absolute bottom-0 left-0 h-64 w-64 rounded-full bg-primary/5 blur-2xl"></div>

		<div class="relative mx-auto max-w-7xl px-4 md:px-8 py-16 lg:py-24">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

				<?php /* Left: copy */ ?>
				<div>
					<div class="inline-flex items-center gap-2 rounded-full border border-primary/40 bg-primary/15 px-3.5 py-1.5 text-sm font-semibold text-primary mb-6">
						<span class="h-1.5 w-1.5 rounded-full bg-primary" aria-hidden="true"></span>
						<?php echo esc_html($service_area_summary); ?>
					</div>

					<h1 class="mb-6 text-5xl sm:text-6xl lg:text-7xl font-black leading-none tracking-tight">
						<?php echo esc_html( $hero_line1 ); ?><br>
						<?php echo esc_html( $hero_line2 ); ?><br>
						<span class="text-primary"><?php echo esc_html( $hero_accent ); ?></span>
					</h1>

					<p class="mb-8 max-w-md text-lg leading-relaxed text-gray-100">
						<?php echo esc_html( $hero_sub ); ?>
					</p>

					<div class="mb-8 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm text-gray-200">
						<?php foreach ( $hero_trust as $trust_item ) : ?>
						<div class="flex items-center gap-2">
							<span class="shrink-0 text-primary"><?php echo $check_svg; ?></span>
							<?php echo esc_html( $trust_item ); ?>
						</div>
						<?php endforeach; ?>
					</div>

					<div class="flex flex-col sm:flex-row gap-3">
						<a href="<?php echo esc_url($phone_href); ?>"
						   class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-primary px-7 py-4 text-lg font-bold text-white shadow-lg shadow-primary/30 transition-colors hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-gray-950"
						   data-track-cta="home-hero-call">
							<?php echo $phone_svg; ?>
							Call <?php echo esc_html($phone_display); ?>
						</a>
						<a href="<?php echo esc_url($services_url); ?>"
						   class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/20 bg-white/5 px-7 py-4 text-lg font-semibold text-white transition-colors hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/30"
						   data-track-cta="home-hero-services">
							Our Services
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					</div>

					<div class="mt-8 flex items-center gap-3 border-t border-white/10 pt-6">
						<div class="flex text-yellow-400 text-base" aria-label="5 stars">★★★★★</div>
						<p class="text-sm text-gray-200">4.9&#8202;★ local reputation &bull; Family owned since <?php echo esc_html($business_start_year); ?></p>
					</div>
				</div>

				<?php /* Right: image stack */ ?>
				<div class="relative hidden lg:flex items-end gap-4 h-[520px]">
					<?php /* Main tall image */ ?>
					<div class="relative flex-1 h-full rounded-2xl overflow-hidden shadow-2xl shadow-black/40">
						<img
							src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/FB635A5C-A558-454F-98EE-0377E812DE9C_1_105_c-jwCnwZZLLWCLMAjw5jLzu3LH4EB8jW.jpeg"
							alt="Professional plumber at work"
							class="h-full w-full object-cover"
							loading="eager"
							fetchpriority="high"
							decoding="async"
							width="960"
							height="1040"
						>
						<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
					</div>

					<?php /* Secondary column: two stacked images */ ?>
					<div class="flex flex-col gap-4 w-44 shrink-0">
						<div class="h-56 rounded-2xl overflow-hidden shadow-xl shadow-black/30">
							<img
								src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/5283B57C-0351-49FB-9D60-CDE2730895C3_1_105_c-ngqXxXrRTSxIpRUVpfYYWEIRntJHn5.jpeg"
								alt="Water heater installation"
								class="h-full w-full object-cover"
								loading="lazy"
								decoding="async"
								width="352"
								height="448"
							>
						</div>
						<div class="h-56 rounded-2xl overflow-hidden shadow-xl shadow-black/30">
							<img
								src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/D7E58607-81D8-42BB-B51A-340FCB2AF941_1_105_c-mAKW5ZoiylXTUJnYFa7txzL69h48G1.jpeg"
								alt="Septic system installation"
								class="h-full w-full object-cover"
								loading="lazy"
								decoding="async"
								width="352"
								height="448"
							>
						</div>
					</div>

					<?php /* Floating service-area badge */ ?>
					<div class="absolute top-6 left-6 rounded-xl bg-white/10 border border-white/20 backdrop-blur-sm px-4 py-3">
						<p class="text-xs font-medium text-gray-200">Serving</p>
						<p class="font-bold text-white text-sm">Two States</p>
						<p class="text-xs text-primary font-semibold">CA &bull; GA</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php /* ─── Trust strip ─── */ ?>
	<div class="border-b border-gray-100 bg-white">
		<div class="mx-auto max-w-7xl px-4 md:px-8 py-4">
			<div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm text-gray-600 sm:justify-between">
				<div class="flex items-center gap-2 font-medium">
					<span class="text-primary"><?php echo $check_svg; ?></span> Family Owned &amp; Operated
				</div>
				<div class="flex items-center gap-2 font-medium">
					<span class="text-primary"><?php echo $check_svg; ?></span> Licensed in California &amp; Georgia
				</div>
				<div class="flex items-center gap-2 font-medium">
					<span class="text-primary"><?php echo $check_svg; ?></span> 100% Satisfaction Guaranteed
				</div>
				<div class="flex items-center gap-2 font-medium">
					<span class="text-yellow-500 text-base">★★★★★</span> 4.9 Local Rating
				</div>
			</div>
		</div>
	</div>

	<?php /* ──────────────────── SEPTIC SOLUTIONS ──────────────────── */ ?>
	<section id="septic-solutions" class="pt-20 pb-0 bg-white">
		<div class="mx-auto max-w-7xl px-4 md:px-8">

			<?php /* ── Section header ── */ ?>
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge">Our Core Specialty</span></p>
				<h2 class="fp-section-title text-gray-900">Engineered <span class="text-primary">Septic Systems</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-2xl mx-auto text-gray-600 text-lg">When a standard system won't work — steep slopes, bad soil, tight lots, sensitive environments — that's exactly where we excel.</p>
			</div>

			<?php /* ── Two-col: capabilities left, feature photo right ── */ ?>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center mb-14">

				<div>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
						<?php
						$septic_caps = [
							['<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>',                                            'Licensed in CA &amp; GA',     'Fully permitted and code-compliant in both states'],
							['<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',              'Family-Owned &amp; Local',    'Not a franchise — we know these counties and their codes'],
							['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',                                                             'Advanced ATU Systems',        'Engineered for sites conventional contractors turn down'],
							['<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',                                         'Free Site Consultations',     'We tell you what will work before any money changes hands'],
						];
						foreach ($septic_caps as $cap) : ?>
						<div class="flex items-start gap-3 rounded-xl bg-gray-50 border border-gray-100 p-4">
							<div class="shrink-0 mt-0.5 w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $cap[0]; ?></svg>
							</div>
							<div>
								<p class="font-bold text-gray-900 text-sm mb-0.5"><?php echo $cap[1]; ?></p>
								<p class="text-xs text-gray-500 leading-snug"><?php echo $cap[2]; ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<a href="<?php echo esc_url($phone_href); ?>"
					   class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-primary px-7 py-4 text-base font-bold text-white shadow-lg shadow-primary/20 transition-colors hover:bg-brand-700">
						<?php echo $phone_svg; ?> Call to Schedule — <?php echo esc_html($phone_display); ?>
					</a>
				</div>

				<div class="relative rounded-2xl overflow-hidden h-80 md:h-96 shadow-md group">
					<img
						src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
						data-src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/403755C7-C88E-418F-8B7C-C07422B5640D_1_105_c-MFl3qR0pt8KO8mVult4Y7hJJW74rww.jpeg"
						alt="Three-tank septic system with concrete pad on hillside property"
						class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105 js-lazy-img"
						loading="lazy"
						decoding="async"
						width="768"
						height="1024"
					>
					<div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
					<div class="absolute bottom-4 left-4 right-4">
						<span class="inline-block rounded-full bg-primary/80 px-3 py-0.5 text-xs font-semibold text-white mb-2">Featured Installation</span>
						<p class="font-bold text-white text-lg leading-tight">Three-Tank System with Concrete Pad</p>
						<p class="text-gray-300 text-sm">Steep hillside terrain — Santa Cruz County, CA</p>
					</div>
				</div>

			</div>

			<?php /* ── Photo strip: 4 smaller installation photos ── */ ?>
			<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-14">
				<?php
				$gallery = [
					['https://hebbkx1anhila5yf.public.blob.vercel-storage.com/1C13305B-AA04-4588-8017-B61560D3192C_1_105_c-TBjIlBDTzWPzsaorScveIBXIqUH6DX.jpeg', 'Engineered Retaining Wall System',   'Block wall + custom control panel'],
					['https://hebbkx1anhila5yf.public.blob.vercel-storage.com/B4F0FD22-529A-423E-9BEB-068C18FAB3C7_4_5005_c-JMDiCtLmuAYMMVyRGIOwmNTTu0n2Ky.jpeg', 'Multi-tank excavation in progress', ''],
					['https://hebbkx1anhila5yf.public.blob.vercel-storage.com/3302FD78-B3FE-4665-AC43-5BCE252775DD_4_5005_c-4Pbj8K7ocFlfavLyvtw19ThIHjJZk7.jpeg', 'Completed multi-tank installation',  ''],
					['https://hebbkx1anhila5yf.public.blob.vercel-storage.com/2ECCED87-6859-4BC2-825D-B86D675D94E9_1_105_c-s4eyzM0pvupcEHq2XIe94EWH27wprF.jpeg',  'Advanced septic control panel',     ''],
				];
				foreach ($gallery as $g) : ?>
				<div class="relative rounded-xl overflow-hidden h-40 group shadow-sm">
					<img
						src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
						data-src="<?php echo esc_url($g[0]); ?>"
						alt="<?php echo esc_attr($g[1]); ?>"
						class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105 js-lazy-img"
						loading="lazy"
						decoding="async"
						width="768"
						height="669"
					>
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
					<?php if ($g[2]) : ?>
					<div class="absolute bottom-2 left-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
						<p class="text-white text-xs font-semibold leading-tight"><?php echo esc_html($g[2]); ?></p>
					</div>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>

			<?php /* ── Two-col: Sites we handle + Why our systems outperform ── */ ?>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

				<div>
					<h3 class="text-xl font-bold text-gray-900 mb-2">Sites Other Contractors Turn Down</h3>
					<p class="text-gray-500 text-sm mb-6">If conventional septic has been ruled out for your property, call us first. We specialize in the installs others won't touch.</p>
					<div class="space-y-3">
						<?php
						$challenge_items = [
							['<path d="M8 3H2v7l6.29 6.29c.94.94 2.48.94 3.42 0l3.58-3.58c.94-.94.94-2.48 0-3.42L8 3Z"/><path d="M4.5 6.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>',  'Steep Slopes &amp; Hillside Terrain',     'Gravity-fed and pumped systems for significant grade changes.'],
							['<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/>',         'Limited Lot Size or Setbacks',            'Compact systems designed to meet code on tight urban properties.'],
							['<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',  'Near Water Bodies &amp; Sensitive Areas', 'Advanced treatment meeting or exceeding environmental standards.'],
							['<path d="M12 22V12"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/><path d="M8 6a4 4 0 0 1 8 0v6H8V6z"/>',                                            'Poor Soil or High Groundwater',           'Mound systems and above-grade solutions for clay, caliche, and high water tables.'],
						];
						foreach ($challenge_items as $ci) : ?>
						<div class="flex items-start gap-3 rounded-xl bg-gray-50 border border-gray-100 p-4">
							<div class="shrink-0 mt-0.5 w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $ci[0]; ?></svg>
							</div>
							<div>
								<h4 class="font-bold text-gray-900 text-sm mb-0.5"><?php echo $ci[1]; ?></h4>
								<p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($ci[2]); ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div>
					<h3 class="text-xl font-bold text-gray-900 mb-2">Why Advanced Systems Often Outperform</h3>
					<p class="text-gray-500 text-sm mb-6">They're not just a workaround — engineered systems are often superior to conventional ones in every measurable way.</p>
					<div class="space-y-3 mb-8">
						<?php
						$benefits = [
							['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',                                                                                   'Superior Treatment Quality',   'Cleaner effluent output meeting or exceeding state standards.'],
							['<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>',  'Smaller Physical Footprint',   'High-efficiency designs use less land than conventional drain fields.'],
							['<path d="M3 3h18v18H3z"/><path d="M8 12h8"/><path d="M12 8v8"/>',                                                                            'Remote Monitoring Capability', 'Smart panels alert you before small issues become costly failures.'],
							['<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>',                                                                                    'Extended System Lifespan',     'Properly maintained advanced systems routinely outlast conventional installs.'],
							['<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',                                                   'Environmentally Responsible',  'Reduced nutrient loading and contamination risk near land and water.'],
						];
						foreach ($benefits as $b) : ?>
						<div class="flex items-start gap-3">
							<div class="shrink-0 mt-0.5 w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $b[0]; ?></svg>
							</div>
							<div>
								<p class="font-semibold text-gray-900 text-sm"><?php echo esc_html($b[1]); ?></p>
								<p class="text-gray-500 text-sm"><?php echo esc_html($b[2]); ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<a href="<?php echo esc_url( $homeowners_septic_guide_url ); ?>"
					   class="inline-flex items-center gap-2 text-primary font-semibold text-sm hover:text-brand-700 transition-colors">
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
						Read Our Homeowner's Guide to New Septic Systems
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				</div>

			</div>
		</div>

		<?php /* ── CTA strip ── */ ?>
		<div class="bg-primary mt-16">
			<div class="mx-auto max-w-7xl px-4 md:px-8 py-12">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
					<div>
						<h3 class="text-2xl sm:text-3xl font-bold text-white mb-2">Ready for a Site Assessment?</h3>
						<p class="text-white/80 text-lg">Tell us about your property — we'll let you know if an advanced system is the right fit and give you an honest estimate.</p>
					</div>
					<div class="flex flex-col sm:flex-row items-center gap-4 md:justify-end">
						<a href="<?php echo esc_url($phone_href); ?>"
						   class="inline-flex w-full sm:w-auto items-center justify-center gap-2.5 rounded-lg bg-white px-8 py-4 text-base font-bold text-primary shadow-lg hover:bg-gray-50 transition-colors">
							<?php echo $phone_svg; ?> Call <?php echo esc_html($phone_display); ?>
						</a>
						<a href="<?php echo esc_url( $septic_solutions_url ); ?>"
						   class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg border border-white/30 px-8 py-4 text-base font-semibold text-white hover:bg-white/10 transition-colors">
							Explore All Septic Services
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					</div>
				</div>
		</div>
	</div>
	</section>

	<?php /* ──────────────────── OUR SERVICES ──────────────────── */ ?>
	<section id="professional-services" class="py-20 bg-gray-50">
		<div class="mx-auto max-w-7xl px-4 md:px-8">
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge">What We Do</span></p>
				<h2 class="fp-section-title text-gray-900">Plumbing &amp; Septic <span class="text-primary">Services</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-3xl mx-auto text-gray-600 text-lg">From routine maintenance to complex new installations, our licensed team handles it all — cleanly, honestly, and on time.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
				<?php
				$service_cards = [
					[
						'title' => 'Residential Plumbing',
						'img'   => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/FB635A5C-A558-454F-98EE-0377E812DE9C_1_105_c-jwCnwZZLLWCLMAjw5jLzu3LH4EB8jW.jpeg',
						'alt'   => 'Precision valve installation',
						'items' => ['Leak detection & repair', 'Fixture installation & repair', 'Pipe replacement & repiping', 'Drain cleaning & unclogging'],
						'link'  => $services_url,
					],
					[
						'title' => 'Commercial Plumbing',
						'img'   => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/5059DCD2-AE84-47B6-8626-07813C4F5A18_1_105_c-qkX15h2FY3KzeRJThoNFPeUmK7LvG6.jpeg',
						'alt'   => 'Commercial plumbing installation',
						'items' => ['Commercial water heaters', 'Backflow prevention', 'Code compliance updates', 'Restaurant & kitchen plumbing'],
						'link'  => $services_url,
					],
					[
						'title' => 'New Construction',
						'img'   => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/F74AE311-5507-4DEB-910C-36768D14BF09_1_105_c-mQqaJtYMGZRKsZXjvWf5dLfkX27Llm.jpeg',
						'alt'   => 'New construction plumbing rough-in',
						'items' => ['Plumbing system design', 'Rough-in plumbing', 'Fixture installation', 'Final inspections & testing'],
						'link'  => $services_url,
					],
				];
				foreach ($service_cards as $s) : ?>
				<div class="group bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col">
					<div class="relative h-52 overflow-hidden shrink-0">
						<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?php echo esc_url($s['img']); ?>" alt="<?php echo esc_attr($s['alt']); ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 js-lazy-img" loading="lazy" decoding="async" width="768" height="669">
						<div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
						<h3 class="absolute bottom-4 left-4 text-xl font-bold text-white"><?php echo esc_html($s['title']); ?></h3>
					</div>
					<div class="p-5 flex flex-col flex-1">
						<ul class="space-y-2 flex-1">
							<?php foreach ($s['items'] as $item) : ?>
							<li class="flex items-center gap-2.5 text-gray-700 text-sm">
								<span class="shrink-0 text-primary"><?php echo $check_svg; ?></span>
								<?php echo esc_html($item); ?>
							</li>
							<?php endforeach; ?>
						</ul>
						<a href="<?php echo esc_url($s['link']); ?>" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-brand-700 transition-colors">
							View <?php echo esc_html($s['title']); ?> service details
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<?php /* Quick-scan service strip */ ?>
			<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-8">
				<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
					<?php
					$quick_services = [
						['<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>',  'Septic Pumping'],
						['<path d="M12 22V12"/><path d="m17 7-5-5-5 5"/><path d="M5 12H2a10 10 0 0 0 20 0h-3"/>',                   'Drain Cleaning'],
						['<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>', 'Leak Repair'],
						['<path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/>', 'Water Heaters'],
						['<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>',                           'Septic Inspections'],
						['<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',    'New Construction'],
						['<path d="m2 22 1-1h3l9-9"/><path d="M3 21v-3l9-9"/><path d="m15 6 3.4-3.4a2.1 2.1 0 1 1 3 3L18 9l.4.4a2.1 2.1 0 1 1-3 3l-3.8-3.8Z"/>','Pipe Repair'],
						['<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>',                                  'Backflow Testing'],
					];
					foreach ($quick_services as $qs) : ?>
					<a href="<?php echo esc_url($services_url); ?>" class="group flex flex-col items-center gap-2 p-3 rounded-xl hover:bg-primary/5 transition-colors">
						<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $qs[0]; ?></svg>
						</div>
						<span class="text-xs font-semibold text-gray-700 group-hover:text-primary transition-colors"><?php echo esc_html($qs[1]); ?></span>
					</a>
					<?php endforeach; ?>
				</div>
			</div>

			<?php /* CTA bar */ ?>
			<div class="rounded-2xl bg-primary text-white p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
				<div>
					<p class="text-xs font-semibold uppercase tracking-widest text-white/70 mb-1">Ready to get started?</p>
					<h3 class="text-xl font-bold text-white">We service <?php echo esc_html($service_area_summary); ?></h3>
					<p class="text-white/70 text-sm mt-1">Licensed, insured, and available <?php echo esc_html($business_hours); ?>.</p>
				</div>
				<div class="flex flex-col sm:flex-row gap-3 shrink-0">
					<a href="<?php echo esc_url($phone_href); ?>" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-white px-6 py-3.5 font-bold text-primary hover:bg-gray-100 transition-colors whitespace-nowrap">
						<?php echo $phone_svg; ?> Call <?php echo esc_html($phone_display); ?>
					</a>
					<a href="<?php echo esc_url($services_url); ?>" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/40 px-6 py-3.5 font-semibold text-white hover:bg-white/10 transition-colors whitespace-nowrap">
						View All Services
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				</div>
			</div>
		</div>
	</section>

	<?php /* ──────────────────── WHY WADE'S ──────────────────── */ ?>
	<section class="py-20 bg-[#111111] text-white relative overflow-hidden">
		<div class="pointer-events-none absolute top-0 right-0 w-96 h-96 rounded-full bg-primary/8 blur-3xl"></div>
		<div class="mx-auto max-w-7xl px-4 md:px-8">
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge-dark">Our Difference</span></p>
				<h2 class="fp-section-title text-white">Why Choose <span class="text-primary">Wade's</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-2xl mx-auto text-gray-200 text-lg">We're not corporate plumbers with iPads trying to upsell you. We're your neighbors, offering honest recommendations and quality work at fair prices.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
				<?php
				$why_items = [
					['icon' => '<path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/>', 'title' => 'Honest Recommendations', 'body' => "We'll never push unnecessary services. We recommend what you actually need, not what makes us the most money."],
					['icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>', 'title' => 'Real People, Real Service', 'body' => "Casual, approachable plumbers who treat you like a neighbor. No corporate scripts or high-pressure tactics."],
					['icon' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/><line x1="7" x2="7" y1="15" y2="15"/><line x1="12" x2="12" y1="15" y2="15"/>', 'title' => 'Transparent Pricing', 'body' => "Upfront flat-rate pricing — you know what you're paying before work begins. No surprises, no hidden fees."],
					['icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', 'title' => 'Quality Workmanship', 'body' => "Casual in approach, serious about quality. Our experienced team delivers reliable, long-lasting solutions."],
				];
				foreach ($why_items as $w) : ?>
				<div class="rounded-xl border border-white/8 bg-white/5 p-6 hover:bg-white/8 transition-colors">
					<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/20">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $w['icon']; ?></svg>
					</div>
					<h3 class="mb-2 font-bold text-white"><?php echo esc_html($w['title']); ?></h3>
					<p class="text-sm text-gray-200 leading-relaxed"><?php echo esc_html($w['body']); ?></p>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="mt-10 text-center">
				<?php echo wades_button( 'Learn More About Our Approach', $about_url, 'outline-brand', 'md' ); ?>
			</div>
		</div>
	</section>

	<?php /* ──────────────────── TESTIMONIALS ──────────────────── */ ?>
	<section class="py-20 bg-gray-50">
		<div class="mx-auto max-w-7xl px-4 md:px-8">
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge">Customer Stories</span></p>
				<h2 class="fp-section-title text-gray-900">Real People, <span class="text-primary">Real Results</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-2xl mx-auto text-gray-600">No corporate scripts. Just honest work that earns honest reviews.</p>
			</div>

		<?php /* Testimonial cards row */ ?>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
			<?php foreach ($fp_testimonials as $t) : ?>
				<div class="flex flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
					<div class="flex gap-0.5 text-yellow-400 mb-4">
						<?php for ($i = 0; $i < $t['stars']; $i++) : ?>★<?php endfor; ?>
					</div>
					<p class="text-gray-700 text-sm leading-relaxed flex-1 mb-5">&ldquo;<?php echo esc_html($t['quote']); ?>&rdquo;</p>
					<div class="flex items-center gap-3 pt-4 border-t border-gray-200">
						<div class="w-9 h-9 rounded-full bg-primary/15 flex items-center justify-center shrink-0">
							<span class="text-primary font-bold text-sm"><?php echo esc_html(substr($t['name'], 0, 1)); ?></span>
						</div>
						<div>
							<p class="font-semibold text-gray-900 text-sm"><?php echo esc_html($t['name']); ?></p>
							<p class="text-xs text-gray-500"><?php echo esc_html($t['location']); ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<?php /* Value props + CTA two-col */ ?>
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center rounded-2xl bg-white border border-gray-100 p-8 md:p-10">
				<div>
					<h3 class="text-2xl font-bold text-gray-900 mb-6">Why Customers Choose <span class="text-primary">Wade's</span></h3>
					<div class="space-y-4">
						<?php
						$value_props = [
							['We Explain, Not Just Sell',            'We walk you through the issue and your options in plain English — no jargon, no pressure.'],
							['Multiple Price-Point Options',         'Every situation is different. We give you real choices rather than one-size-fits-all pricing.'],
							['Built on Referrals, Not Advertising',  'Most of our new customers come from neighbors recommending us. Your satisfaction is our marketing.'],
						];
						foreach ($value_props as $vp) : ?>
						<div class="flex items-start gap-3">
							<span class="mt-0.5 shrink-0 text-primary"><?php echo $check_svg; ?></span>
							<div>
								<p class="font-semibold text-gray-900 text-sm"><?php echo esc_html($vp[0]); ?></p>
								<p class="text-gray-500 text-sm"><?php echo esc_html($vp[1]); ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="flex flex-col gap-4">
					<div class="flex items-center justify-between rounded-xl bg-white border border-gray-100 px-5 py-4 shadow-sm">
						<div>
							<p class="text-2xl font-black text-primary"><?php echo esc_html( $fp_stat_rating ); ?> ★</p>
							<p class="text-xs text-gray-500 font-medium">Average customer rating</p>
						</div>
						<div class="text-right">
							<p class="text-2xl font-black text-primary"><?php echo esc_html( $fp_stat_jobs ); ?></p>
							<p class="text-xs text-gray-500 font-medium">Jobs completed</p>
						</div>
						<div class="text-right">
							<p class="text-2xl font-black text-primary"><?php echo esc_html( $fp_stat_states ); ?></p>
							<p class="text-xs text-gray-500 font-medium">Licensed states</p>
						</div>
					</div>
					<a href="<?php echo esc_url($phone_href); ?>" class="inline-flex items-center justify-center gap-2.5 w-full rounded-xl bg-primary px-6 py-4 font-bold text-white hover:bg-brand-700 transition-colors shadow-lg shadow-primary/20" data-track-cta="home-testimonials-call">
						<?php echo $phone_svg; ?> Call <?php echo esc_html($phone_display); ?>
					</a>
					<?php echo wades_button( 'Read More Customer Stories', $testimonials_url, 'outline-brand', 'md', '', 'left', 'w-full text-center' ); ?>
				</div>
			</div>
		</div>
	</section>

	<?php /* ──────────────────── FINANCING ──────────────────── */ ?>
	<section class="py-20 bg-gray-50">
		<div class="mx-auto max-w-7xl px-4 md:px-8">
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge">Flexible Financing</span></p>
				<h2 class="fp-section-title text-gray-900">Flexible <span class="text-primary">Payment Options</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-3xl mx-auto text-gray-600 text-lg">Quality plumbing and septic services should be accessible to everyone. That's why we offer multiple payment solutions to fit your budget.</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
				<div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
					<div class="p-8">
						<h3 class="text-xl font-bold mb-6 text-gray-900">Payment Plans &amp; Financing</h3>
						<div class="divide-y divide-gray-100">
							<?php
							$payment_options = [
								['<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',       '0% Interest Financing',       'Qualified customers get 0% interest for 6, 12, or 18 months on larger projects.',             ['No interest', 'Fixed monthly payments', 'Quick approval']],
								['<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/><line x1="7" x2="7" y1="15" y2="15"/><line x1="12" x2="12" y1="15" y2="15"/>','Low Monthly Payments',        'Extended financing with competitive rates and terms up to 60 months.',                        ['Up to 60 months', 'Competitive rates', 'No prepayment penalty']],
								['<rect width="20" height="16" x="2" y="4" rx="2"/><circle cx="12" cy="12" r="4"/><path d="M2 12h4"/><path d="M18 12h4"/>',           'Traditional Payment Methods', 'All major credit cards, checks, and cash. Process on-site or online.',                        ['All major cards', 'Cash & checks', 'Online payments']],
							];
							foreach ($payment_options as $po) : ?>
							<div class="py-5 flex gap-5 items-start first:pt-0 last:pb-0">
								<div class="shrink-0 w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><?php echo $po[0]; ?></svg>
								</div>
								<div class="flex-1">
									<h4 class="font-bold text-gray-900 mb-1"><?php echo esc_html($po[1]); ?></h4>
									<p class="text-gray-600 text-sm mb-2"><?php echo esc_html($po[2]); ?></p>
									<div class="flex flex-wrap gap-1.5">
										<?php foreach ($po[3] as $tag) : ?>
										<span class="px-2.5 py-0.5 bg-gray-100 rounded-full text-xs text-gray-600 font-medium"><?php echo esc_html($tag); ?></span>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="flex flex-col gap-5">
					<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex-1">
						<h3 class="text-lg font-bold mb-4 text-primary">Special Programs</h3>
						<div class="space-y-4">
							<?php
							$specials = [
								['Senior Discount',                '10% off for customers 65+ — mention it when scheduling.'],
								['Military &amp; First Responder', '10% off for active duty, veterans, and first responders.'],
								['Maintenance Plan Members',       'Priority service, discounted rates, and exclusive financing.'],
							];
							foreach ($specials as $sp) : ?>
							<div class="p-3 rounded-xl bg-white border border-gray-100 shadow-sm">
								<h4 class="font-semibold text-gray-900 text-sm mb-1"><?php echo $sp[0]; ?></h4>
								<p class="text-gray-500 text-xs"><?php echo esc_html($sp[1]); ?></p>
							</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="bg-primary rounded-2xl p-6 text-white shadow-lg shadow-primary/20">
						<h3 class="font-bold text-lg mb-2">Insurance Claims Assistance</h3>
						<p class="text-white/80 text-sm mb-4">We work directly with insurance companies on covered plumbing emergencies.</p>
						<?php echo wades_button( 'View Insurance Claims Assistance', $insurance_claims_url, 'outline', 'sm', '', 'left', 'w-full border border-white/40 text-white hover:bg-white/10' ); ?>
					</div>
				</div>
			</div>

			<div class="text-center mt-10 flex flex-wrap justify-center gap-3">
				<?php echo wades_button( 'Explore Financing Options', '/financing', 'primary', 'md' ); ?>
				<?php echo wades_button( 'Call ' . esc_html( $phone_display ), $phone_href, 'outline-brand', 'md' ); ?>
			</div>
		</div>
	</section>

	<?php /* ──────────────────── FAQ ──────────────────── */ ?>
	<section id="faq" class="py-20 bg-gray-50">
		<div class="mx-auto max-w-7xl px-4 md:px-8">
			<div class="text-center mb-14">
				<p class="mb-3"><span class="eyebrow-badge">Got Questions?</span></p>
				<h2 class="fp-section-title text-gray-900">Frequently Asked <span class="text-primary">Questions</span></h2>
				<div class="flex justify-center mt-3" aria-hidden="true"><div class="h-[3px] w-12 rounded-full bg-primary"></div></div>
				<p class="mt-5 max-w-3xl mx-auto text-gray-600 text-lg">Get answers to common questions about our services. Don't see yours? Just call us.</p>
				<div class="mt-5 flex flex-wrap justify-center gap-3">
					<a href="<?php echo esc_url($faq_url); ?>" class="inline-flex items-center rounded-lg border border-primary/20 bg-primary/5 px-4 py-2 text-sm font-semibold text-primary hover:bg-primary/10 transition-colors">View Full FAQ Page</a>
					<a href="<?php echo esc_url($services_url); ?>" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-800 hover:border-primary/30 hover:text-primary transition-colors">Browse Service Pages</a>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<div class="lg:col-span-2">
				<div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
					<?php foreach ($fp_faqs as $faq) : ?>
					<div class="p-6">
						<h3 class="text-base font-bold text-gray-900 mb-2"><?php echo esc_html($faq['q']); ?></h3>
						<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($faq['a']); ?></p>
					</div>
					<?php endforeach; ?>

						<div class="p-6 bg-gray-50 text-center" id="see-more-faq">
							<?php
							$chevron_down_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
							echo wades_button( 'See More Questions', null, 'outline-brand', 'md', $chevron_down_icon, 'right' );
							?>
						</div>

					<div class="hidden divide-y divide-gray-100" id="hidden-faqs">
						<?php foreach ($fp_extra_faqs as $ef) : ?>
						<div class="p-6">
							<h3 class="text-base font-bold text-gray-900 mb-2"><?php echo esc_html($ef['q']); ?></h3>
							<p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($ef['a']); ?></p>
						</div>
						<?php endforeach; ?>
							<div class="p-6 bg-gray-50 text-center">
								<?php
								$chevron_up_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>';
								echo wades_button( 'See Fewer Questions', null, 'outline-brand', 'md', $chevron_up_icon, 'right', '', array( 'id' => 'see-less-faq' ) );
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="flex flex-col gap-5">
					<div class="rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm">
						<div class="relative h-44">
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/7045C6B8-F64C-4EF0-9A00-D0CDD7EEF28A_1_105_c-4C3vJbttKRtCaNDxnCBzmDMo6T3znP.jpeg" alt="Tankless water heater installation" class="h-full w-full object-cover js-lazy-img" loading="lazy" decoding="async" width="768" height="669">
							<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
							<p class="absolute bottom-4 left-4 text-white font-bold">Have More Questions?</p>
						</div>
						<div class="p-6">
							<p class="text-gray-600 text-sm mb-5">Our knowledgeable team is ready to answer any questions about our services. The fastest way to get an answer is to call.</p>
							<a href="<?php echo esc_url($phone_href); ?>" class="flex items-center justify-center gap-2.5 w-full rounded-lg bg-primary text-white font-bold py-3.5 hover:bg-brand-700 transition-colors" data-track-cta="home-faq-call">
								<?php echo $phone_svg; ?> Call <?php echo esc_html($phone_display); ?>
							</a>
						</div>
					</div>

					<div class="rounded-2xl bg-primary text-white p-6 shadow-lg shadow-primary/20">
						<h3 class="font-bold text-lg mb-2">Service Hours</h3>
						<p class="text-white/80 text-sm mb-4"><?php echo esc_html($business_hours); ?>.</p>
						<a href="<?php echo esc_url($phone_href); ?>" class="flex items-center justify-center gap-2.5 w-full rounded-lg border border-white/30 text-white font-semibold py-3 hover:bg-white/10 transition-colors text-sm" data-track-cta="home-hours-call">
							<?php echo $phone_svg; ?> Call Now
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
	(function () {
		var lazyImages = document.querySelectorAll('.js-lazy-img[data-src]');
		if (!lazyImages.length) {
			return;
		}

		var loadImage = function (img) {
			if (!img || !img.dataset || !img.dataset.src) {
				return;
			}
			img.src = img.dataset.src;
			img.removeAttribute('data-src');
		};

		if (!('IntersectionObserver' in window)) {
			lazyImages.forEach(loadImage);
			return;
		}

		var observer = new IntersectionObserver(function (entries, io) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}
				loadImage(entry.target);
				io.unobserve(entry.target);
			});
		}, { rootMargin: '200px 0px' });

		lazyImages.forEach(function (img) { observer.observe(img); });
	})();
	</script>
</main>

<?php get_template_part( 'template-parts/sections/front-page/faq-toggle-script' ); ?>

<?php
get_footer();
