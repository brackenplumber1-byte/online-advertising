<?php
/**
 * Tysons Plumbers Roodepoort Pro — functions.php v2.0
 */

// ── CONSTANTS ──────────────────────────────────────────────────────────────
define('TP_PHONE',    '071 363 1433');
define('TP_EMAIL',    'info@tysonsplumbersroodepoort.co.za');
define('TP_DOMAIN',   'https://tysonsplumbersroodepoort.co.za');
define('TP_WA_NUM',   '27713631433');

define('TP_SERVICES', serialize([
    'emergency-plumbing'   => 'Emergency Plumbing Roodepoort',
    'geyser-repair'        => 'Geyser Repair Roodepoort',
    'geyser-installation'  => 'Geyser Installation Roodepoort',
    'drain-cleaning'       => 'Drain Cleaning Roodepoort',
    'pipe-repair'          => 'Pipe Repair Roodepoort',
    'leak-detection'       => 'Leak Detection Roodepoort',
    'toilet-repairs'       => 'Toilet Repairs Roodepoort',
    'bathroom-plumbing'    => 'Bathroom Plumbing Roodepoort',
    'water-backup-tanks'   => 'Water Backup Tanks Roodepoort',
    'gutters-downpipes'    => 'Gutters & Downpipe Systems Roodepoort',
    'grease-trap-cleaning' => 'Grease Trap Cleaning Roodepoort',
    'drain-camera'         => 'Drain Camera Inspections Roodepoort',
    'heat-pumps'           => 'Heat Pumps Roodepoort',
    'water-filtration'     => 'Water Filtration & Purification Roodepoort',
    'maintenance-contracts'=> 'Maintenance Contracts Roodepoort',
]));

define('TP_AREAS', serialize([
    'roodepoort'        => 'Roodepoort',
    'honeydew'          => 'Honeydew',
    'wilgeheuwel'       => 'Wilgeheuwel',
    'florida'           => 'Florida',
    'constantia-kloof'  => 'Constantia Kloof',
    'weltevreden-park'  => 'Weltevreden Park',
    'ruimsig'           => 'Ruimsig',
    'little-falls'      => 'Little Falls',
    'helderkruin'       => 'Helderkruin',
    'northcliff'        => 'Northcliff',
    'radiokop'          => 'Radiokop',
    'poortview'         => 'Poortview',
    'strubensvalley'    => 'Strubensvalley',
    'witpoortjie'       => 'Witpoortjie',
    'roodekrans'        => 'Roodekrans',
    'krugersdorp'       => 'Krugersdorp',
    'randfontein'       => 'Randfontein',
    'florida-lake'      => 'Florida Lake',
    'laser-park'        => 'Laser Park',
    'randburg'          => 'Randburg',
    'fourways'          => 'Fourways',
    // ── Added: West Rand / Roodepoort core (Tier 1) ──────────────────────
    'allensnek'         => 'Allensnek',
    'amorosa'           => 'Amorosa',
    'bergbron'          => 'Bergbron',
    'blackheath'        => 'Blackheath',
    'creswell-park'     => 'Creswell Park',
    'davidsonville'     => 'Davidsonville',
    'delarey'           => 'Delarey',
    'discovery'         => 'Discovery',
    'fleurhof'          => 'Fleurhof',
    'georginia'         => 'Georginia',
    'groblerpark'       => 'Groblerpark',
    'horison'           => 'Horison',
    'horison-park'      => 'Horison Park',
    'horison-view'      => 'Horison View',
    'panorama'          => 'Panorama',
    'princess'          => 'Princess',
    'quellerina'        => 'Quellerina',
    'wilropark'         => 'Wilropark',
    'florida-glen'      => 'Florida Glen',
    'florida-hills'     => 'Florida Hills',
    'florida-north'     => 'Florida North',
    // ── Added: Randburg / Fourways / Muldersdrift corridor (Tier 2) ──────
    'fontainebleau'     => 'Fontainebleau',
    'northgate'         => 'Northgate',
    'olivedale'         => 'Olivedale',
    'bromhof'           => 'Bromhof',
    'ferndale'          => 'Ferndale',
    'cosmo-city'        => 'Cosmo City',
    'douglasdale'       => 'Douglasdale',
    'broadacres'        => 'Broadacres',
    'dainfern'          => 'Dainfern',
    'lonehill'          => 'Lonehill',
    'craigavon'         => 'Craigavon',
    'muldersdrift'      => 'Muldersdrift',
    'featherbrooke-estate' => 'Featherbrooke Estate',
    'northriding'       => 'Northriding',
    'cresta'            => 'Cresta',
    'randpark-ridge'    => 'Randpark Ridge',
    'bordeaux'          => 'Bordeaux',
    'blairgowrie'       => 'Blairgowrie',
    'robindale'         => 'Robindale',
    'fairland'          => 'Fairland',
    // ── Added: Krugersdorp / Randfontein / Mogale City cluster (Tier 3) ──
    'rant-en-dal'       => 'Rant-en-Dal',
    'noordheuwel'       => 'Noordheuwel',
    'monument'          => 'Monument',
    'silverfields'      => 'Silverfields',
    'west-village'      => 'West Village',
    'chancliff'         => 'Chancliff',
    'kagiso'            => 'Kagiso',
    'toekomsrus'        => 'Toekomsrus',
    'greenhills'        => 'Greenhills',
    'mohlakeng'         => 'Mohlakeng',
    'azaadville'        => 'Azaadville',
    'rietfontein'       => 'Rietfontein',
    'luipaardsvlei'     => 'Luipaardsvlei',
]));

// Response-time claim varies by real distance from our Roodepoort base —
// Randburg and especially Fourways are a genuinely longer drive than the
// core West Rand suburbs, so we don't promise the same 45 minutes to all.
define('TP_AREA_TIER', serialize([
    'roodepoort'        => 1,
    'wilgeheuwel'       => 1,
    'florida'           => 1,
    'constantia-kloof'  => 1,
    'poortview'         => 1,
    'witpoortjie'       => 1,
    'florida-lake'      => 1,
    'helderkruin'       => 1,
    'radiokop'          => 1,
    'weltevreden-park'  => 1,
    'honeydew'          => 2,
    'ruimsig'           => 2,
    'little-falls'      => 2,
    'northcliff'        => 2,
    'strubensvalley'    => 2,
    'roodekrans'        => 2,
    'laser-park'        => 2,
    'krugersdorp'       => 3,
    'randfontein'       => 3,
    'randburg'          => 3,
    'fourways'          => 3,
    'allensnek'         => 1,
    'amorosa'           => 1,
    'bergbron'          => 1,
    'blackheath'        => 1,
    'creswell-park'     => 1,
    'davidsonville'     => 1,
    'delarey'           => 1,
    'discovery'         => 1,
    'fleurhof'          => 1,
    'georginia'         => 1,
    'groblerpark'       => 1,
    'horison'           => 1,
    'horison-park'      => 1,
    'horison-view'      => 1,
    'panorama'          => 1,
    'princess'          => 1,
    'quellerina'        => 1,
    'wilropark'         => 1,
    'florida-glen'      => 1,
    'florida-hills'     => 1,
    'florida-north'     => 1,
    'fontainebleau'     => 2,
    'northgate'         => 2,
    'olivedale'         => 2,
    'bromhof'           => 2,
    'ferndale'          => 2,
    'cosmo-city'        => 2,
    'douglasdale'       => 2,
    'broadacres'        => 2,
    'dainfern'          => 2,
    'lonehill'          => 2,
    'craigavon'         => 2,
    'muldersdrift'      => 2,
    'featherbrooke-estate' => 2,
    'northriding'       => 2,
    'cresta'            => 2,
    'randpark-ridge'    => 2,
    'bordeaux'          => 2,
    'blairgowrie'       => 2,
    'robindale'         => 2,
    'fairland'          => 2,
    'rant-en-dal'       => 3,
    'noordheuwel'       => 3,
    'monument'          => 3,
    'silverfields'      => 3,
    'west-village'      => 3,
    'chancliff'         => 3,
    'kagiso'            => 3,
    'toekomsrus'        => 3,
    'greenhills'        => 3,
    'mohlakeng'         => 3,
    'azaadville'        => 3,
    'rietfontein'       => 3,
    'luipaardsvlei'     => 3,
]));

// ── HELPERS ────────────────────────────────────────────────────────────────
function tp_phone()  { return get_theme_mod('tp_phone', TP_PHONE); }
function tp_email()  { return get_theme_mod('tp_email', TP_EMAIL); }
function tp_wa_num() { return get_theme_mod('tp_wa_num', TP_WA_NUM); }
function tp_review() { return get_theme_mod('tp_review', ''); }
function tp_maps()   { return get_theme_mod('tp_maps', ''); }
function tp_plink()  {
    $p = preg_replace('/[^0-9]/', '', tp_phone());
    if (substr($p,0,1)==='0') $p = '27'.substr($p,1);
    return 'tel:+' . $p;
}
function tp_wa_link($msg='Hi%2C+I+need+a+plumber+in+Roodepoort') {
    return 'https://wa.me/' . tp_wa_num() . '?text=' . $msg;
}
function tp_imgdir() { return get_template_directory_uri() . '/assets/images/'; }

function tp_area_tier($slug) {
    $tiers = unserialize(TP_AREA_TIER);
    return $tiers[$slug] ?? 2;
}
function tp_area_response_time($slug) {
    switch (tp_area_tier($slug)) {
        case 1: return '45 minutes';
        case 3: return 'the hour';
        default: return '45-60 minutes';
    }
}
// Same-tier (similarly-distant) areas first, then fills from the rest —
// keeps "other areas we serve" a genuinely nearby, reasonably sized list.
function tp_nearby_areas($slug, $all_areas, $max = 8) {
    $tier = tp_area_tier($slug);
    $same_tier = [];
    $others = [];
    foreach ($all_areas as $k => $v) {
        if ($k === $slug) continue;
        if (tp_area_tier($k) === $tier) {
            $same_tier[$k] = $v;
        } else {
            $others[$k] = $v;
        }
    }
    $result = array_slice($same_tier, 0, $max, true);
    if (count($result) < $max) {
        $needed = $max - count($result);
        $result = $result + array_slice($others, 0, $needed, true);
    }
    return $result;
}

// ── THEME SETUP ────────────────────────────────────────────────────────────
function tp_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','gallery','caption']);
}
add_action('after_setup_theme','tp_setup');

// ── ENQUEUE ASSETS ─────────────────────────────────────────────────────────
function tp_assets() {
    wp_enqueue_style('tp-main', get_template_directory_uri().'/assets/css/main.css', [], '2.0.0');
    wp_enqueue_script('tp-js',  get_template_directory_uri().'/assets/js/main.js',  [], '2.0.0', true);
}
add_action('wp_enqueue_scripts','tp_assets');

// ── SEO META + SCHEMA ──────────────────────────────────────────────────────
// Detect if a major SEO plugin is active — if so, that plugin owns the
// title, meta description, canonical URL and Open Graph tags. We defer to
// it for those rather than risk two competing sets of tags in <head>.
// We still output LocalBusiness/Service schema regardless, since that's
// plumbing-specific structured data most SEO plugins don't generate
// without manual configuration.
function tp_seo_plugin_active() {
    return function_exists('aioseo')            // All in One SEO
        || defined('WPSEO_VERSION')              // Yoast SEO
        || defined('RANK_MATH_VERSION');          // Rank Math
}

function tp_seo_head() {
    $has_seo_plugin = tp_seo_plugin_active();
    if (is_singular('tp_service')) {
        $post = get_post();
        $desc = get_post_meta($post->ID, 'tp_meta_desc', true) ?: get_the_excerpt();
        $kw   = get_post_meta($post->ID, 'tp_keywords', true) ?: '';
        if (!$has_seo_plugin) {
            echo '<meta name="description" content="'.esc_attr($desc).'">' . "\n";
            if ($kw) echo '<meta name="keywords" content="'.esc_attr($kw).'">' . "\n";
            echo '<link rel="canonical" href="'.esc_url(get_permalink()).'">' . "\n";
        }
        // Service schema
        $schema = ['@context'=>'https://schema.org','@type'=>'Service',
            'name'=>get_the_title(),
            'provider'=>['@type'=>'Plumber','name'=>'Tysons Plumbers Roodepoort','telephone'=>'+27713631433','url'=>home_url('/')],
            'areaServed'=>['@type'=>'City','name'=>'Roodepoort'],
            'description'=>$desc,
        ];
        echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>'."\n";
    } elseif (is_singular('tp_area')) {
        $post = get_post();
        $area = get_the_title();
        $desc = "Trusted plumbers in $area — Tysons Plumbers Roodepoort. 24/7 emergency plumbing, geyser repairs, drain cleaning, pipe repairs. No call-out fee. Call 071 363 1433.";
        if (!$has_seo_plugin) {
            echo '<meta name="description" content="'.esc_attr($desc).'">' . "\n";
            echo '<meta name="keywords" content="plumbers '.esc_attr(strtolower($area)).',plumber '.esc_attr(strtolower($area)).',emergency plumber '.esc_attr(strtolower($area)).'">' . "\n";
            echo '<link rel="canonical" href="'.esc_url(get_permalink()).'">' . "\n";
        }
    } else {
        if (!$has_seo_plugin) {
            echo '<meta name="description" content="Tysons Plumbers Roodepoort — local plumbers in Roodepoort. 24/7 emergency plumbing, geyser repairs, drain cleaning, pipe repair. No call-out fee. Call 071 363 1433.">' . "\n";
            echo '<meta name="keywords" content="plumbers roodepoort,plumber roodepoort,emergency plumber roodepoort,24 hour plumber roodepoort,geyser repair roodepoort,drain cleaning roodepoort,blocked drain roodepoort,burst pipe roodepoort,plumbing roodepoort">' . "\n";
            echo '<link rel="canonical" href="'.esc_url(home_url('/')).'">' . "\n";
        }
        // Full LocalBusiness schema — always output regardless of SEO plugin,
        // since this is plumbing-specific structured data. Area/service lists
        // now pull dynamically from TP_AREAS/TP_SERVICES instead of a stale
        // hardcoded subset (previously only 7 of 18 areas, 6 of 15 services).
        $all_areas    = unserialize(TP_AREAS);
        $all_services = unserialize(TP_SERVICES);
        $schema = [
            '@context'=>'https://schema.org','@type'=>'Plumber',
            'name'=>'Tysons Plumbers Roodepoort',
            'url'=>home_url('/'),
            'telephone'=>'+27713631433',
            'email'=>TP_EMAIL,
            'priceRange'=>'$$',
            'description'=>'Tysons Plumbers Roodepoort — trusted local plumbers serving Roodepoort and the West Rand. 24/7 emergency plumbing, geyser repairs, drain cleaning, leak detection. No call-out fee. PIRB registered.',
            'address'=>['@type'=>'PostalAddress','addressLocality'=>'Roodepoort','addressRegion'=>'Gauteng','addressCountry'=>'ZA'],
            'geo'=>['@type'=>'GeoCoordinates','latitude'=>-26.1625,'longitude'=>27.8727],
            'openingHoursSpecification'=>[['@type'=>'OpeningHoursSpecification','dayOfWeek'=>['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],'opens'=>'00:00','closes'=>'23:59']],
            'areaServed'=>array_map(function($name){ return ['@type'=>'City','name'=>$name]; }, array_values($all_areas)),
            'hasOfferCatalog'=>['@type'=>'OfferCatalog','name'=>'Plumbing Services Roodepoort','itemListElement'=>
                array_map(function($name){ return ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>$name]]; }, array_values($all_services))
            ],
        ];
        echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>'."\n";
    }
    // Open Graph — deferred to SEO plugin if one is active
    if (!$has_seo_plugin) {
        echo '<meta property="og:type" content="website">'."\n";
        echo '<meta property="og:locale" content="en_ZA">'."\n";
        echo '<meta property="og:url" content="'.esc_url(get_permalink()).'">'."\n";
    }
    // Geo — harmless alongside any SEO plugin, kept regardless
    echo '<meta name="geo.region" content="ZA-GP">'."\n";
    echo '<meta name="geo.placename" content="Roodepoort, Gauteng">'."\n";
    if (!$has_seo_plugin) {
        echo '<meta name="robots" content="index, follow, max-image-preview:large">'."\n";
    }
    // Breadcrumb schema for inner pages
    if (is_singular(['tp_service','tp_area'])) {
        $type = is_singular('tp_service') ? 'Services' : 'Areas';
        $bc = ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>home_url('/')],
            ['@type'=>'ListItem','position'=>2,'name'=>$type,'item'=>home_url('/').'#'.strtolower($type)],
            ['@type'=>'ListItem','position'=>3,'name'=>get_the_title(),'item'=>get_permalink()],
        ]];
        echo '<script type="application/ld+json">'.wp_json_encode($bc,JSON_UNESCAPED_SLASHES).'</script>'."\n";
    }
}
add_action('wp_head','tp_seo_head',1);

// When AIOSEO is active but hasn't been given a custom description for a
// specific page yet, fall back to this theme's own good description
// instead of AIOSEO's generic default — steps aside automatically once a
// real custom description is set for that page in AIOSEO.
add_filter('aioseo_description', function($description) {
    $post_id = get_the_ID();
    if (!$post_id) return $description;
    if (get_post_meta($post_id, '_aioseo_description', true)) return $description; // custom value already set — keep it
    if (is_singular('tp_service')) {
        $custom = get_post_meta($post_id, 'tp_meta_desc', true) ?: get_the_excerpt();
        return $custom ?: $description;
    }
    if (is_singular('tp_area')) {
        $area = get_the_title();
        return "Trusted plumbers in $area — Tysons Plumbers Roodepoort. 24/7 emergency plumbing, geyser repairs, drain cleaning, pipe repairs. No call-out fee. Call 071 363 1433.";
    }
    if (is_front_page()) {
        return "Tysons Plumbers Roodepoort — local plumbers in Roodepoort. 24/7 emergency plumbing, geyser repairs, drain cleaning, pipe repair. No call-out fee. Call 071 363 1433.";
    }
    return $description;
});

// ── REGISTER CPTs ──────────────────────────────────────────────────────────
function tp_register_cpts() {
    register_post_type('tp_service', [
        'labels'=>['name'=>'Services','singular_name'=>'Service','add_new_item'=>'Add New Service'],
        'public'=>true,'has_archive'=>true,
        'rewrite'=>['slug'=>'services','with_front'=>false],
        'supports'=>['title','editor','excerpt','thumbnail'],
        'show_in_rest'=>true,'menu_icon'=>'dashicons-admin-tools',
    ]);
    register_post_type('tp_area', [
        'labels'=>['name'=>'Areas','singular_name'=>'Area','add_new_item'=>'Add New Area'],
        'public'=>true,'has_archive'=>true,
        'rewrite'=>['slug'=>'areas','with_front'=>false],
        'supports'=>['title','editor','excerpt','thumbnail'],
        'show_in_rest'=>true,'menu_icon'=>'dashicons-location',
    ]);
}
add_action('init','tp_register_cpts');

// ── FLUSH REWRITE RULES ────────────────────────────────────────────────────
function tp_flush() {
    if (!get_option('tp_flushed_v4')) {
        tp_register_cpts();
        flush_rewrite_rules(false);
        update_option('tp_flushed_v4', true);
    }
}
add_action('init','tp_flush',20);

// ── AUTO CREATE PAGES ──────────────────────────────────────────────────────
// v4 bump: adds 54 new area pages (West Rand core, Randburg/Fourways/
// Muldersdrift corridor, Krugersdorp/Randfontein cluster). The per-item
// exists-check below means already-published areas are left untouched —
// only the new slugs get created.
function tp_create_pages() {
    if (get_option('tp_pages_v4')) return;

    $services_data = [
        'emergency-plumbing' => [
            'Emergency Plumbing Roodepoort | 24/7 Burst Pipes & Flooding — Call Now',
            'Emergency plumber in Roodepoort available 24/7. Burst pipes, flooding, no water — on-site in 45 minutes. No call-out fee. Call Tysons Plumbers Roodepoort: 071 363 1433.',
            'emergency plumber roodepoort,24 hour plumber roodepoort,burst pipe roodepoort,emergency plumbing roodepoort,plumbers roodepoort emergency',
        ],
        'geyser-repair' => [
            'Geyser Repair Roodepoort | Same-Day Service — 071 363 1433',
            'Geyser repair specialists in Roodepoort. Electric, gas and solar geysers repaired same day. PIRB compliance certificates. No call-out fee. Tysons Plumbers Roodepoort.',
            'geyser repair roodepoort,geyser plumber roodepoort,no hot water roodepoort,geyser fix roodepoort',
        ],
        'geyser-installation' => [
            'Geyser Installation Roodepoort | Supply & Install — Tysons Plumbers',
            'Professional geyser installation in Roodepoort. Electric, gas, solar and heat pump geysers supplied and installed. PIRB CoC issued. Call 071 363 1433.',
            'geyser installation roodepoort,new geyser roodepoort,solar geyser roodepoort,geyser replacement roodepoort',
        ],
        'drain-cleaning' => [
            'Drain Cleaning Roodepoort | Blocked Drains Cleared Fast — Call Now',
            'Professional drain cleaning and unblocking in Roodepoort. High-pressure hydro jetting clears any blockage. Fast response, no call-out fee. Tysons Plumbers Roodepoort.',
            'drain cleaning roodepoort,blocked drain roodepoort,blocked toilet roodepoort,drain unblocking roodepoort,plumbers roodepoort drains',
        ],
        'pipe-repair' => [
            'Pipe Repair Roodepoort | Burst & Leaking Pipes Fixed — Tysons Plumbers',
            'Pipe repair specialists in Roodepoort. Burst, cracked, corroded pipes fixed fast. Underground and internal repairs. SABS-approved materials. No call-out fee.',
            'pipe repair roodepoort,burst pipe roodepoort,leaking pipe roodepoort,pipe replacement roodepoort,plumbers roodepoort pipes',
        ],
        'leak-detection' => [
            'Leak Detection Roodepoort | Find Hidden Leaks Fast — Tysons Plumbers',
            'Professional water leak detection in Roodepoort. Hidden leaks found and fixed before serious damage. Non-invasive technology. Same-day repair available.',
            'leak detection roodepoort,water leak roodepoort,hidden leak roodepoort,underground leak roodepoort,plumbers roodepoort leaks',
        ],
        'toilet-repairs' => [
            'Toilet Repairs Roodepoort | Same-Day Service — Tysons Plumbers',
            'Toilet repair specialists in Roodepoort. Blocked, running, leaking toilets fixed fast. Same-day service, no call-out fee. Call Tysons Plumbers 071 363 1433.',
            'toilet repair roodepoort,blocked toilet roodepoort,running toilet roodepoort,plumbers roodepoort toilets',
        ],
        'bathroom-plumbing' => [
            'Bathroom Plumbing Roodepoort | Renovations & Repairs — Tysons Plumbers',
            'Full bathroom plumbing services in Roodepoort. Taps, basins, showers, toilets, baths installed and repaired. Renovations to SANS standards. No call-out fee.',
            'bathroom plumbing roodepoort,bathroom renovation roodepoort,plumbers roodepoort bathroom,tap repair roodepoort',
        ],
        'water-backup-tanks' => [
            'Water Backup Tanks Roodepoort | JoJo Tank Installation — Tysons Plumbers',
            'Water backup tank installation in Roodepoort. JoJo tanks, pressure pumps, filtration systems. Full supply and install. Never run out of water during outages.',
            'water backup tank roodepoort,jojo tank roodepoort,water storage roodepoort,pressure pump roodepoort',
        ],
        'gutters-downpipes' => [
            'Gutters & Downpipe Systems Roodepoort | Installation & Repair — Tysons Plumbers',
            'Gutter and downpipe installation and repair in Roodepoort. Stop overflow and water damage before the rainy season. No call-out fee. Tysons Plumbers Roodepoort.',
            'gutter installation roodepoort,downpipe repair roodepoort,gutter repair roodepoort,blocked gutters roodepoort',
        ],
        'grease-trap-cleaning' => [
            'Grease Trap Cleaning Roodepoort | Commercial Kitchens — Tysons Plumbers',
            'Grease trap cleaning for restaurants and commercial kitchens in Roodepoort. Compliant, scheduled servicing. No call-out fee. Tysons Plumbers Roodepoort.',
            'grease trap cleaning roodepoort,commercial kitchen plumber roodepoort,grease trap service roodepoort',
        ],
        'drain-camera' => [
            'Drain Camera Inspections Roodepoort | CCTV Diagnostics — Tysons Plumbers',
            'Drain camera inspections in Roodepoort. See exactly what is wrong before any digging starts. CCTV diagnostics, recorded footage. Tysons Plumbers Roodepoort.',
            'drain camera inspection roodepoort,cctv drain survey roodepoort,drain diagnostics roodepoort',
        ],
        'heat-pumps' => [
            'Heat Pumps Roodepoort | Energy-Efficient Hot Water — Tysons Plumbers',
            'Heat pump supply and installation in Roodepoort. Energy-efficient hot water for homes and businesses. No call-out fee. Tysons Plumbers Roodepoort.',
            'heat pump installation roodepoort,heat pump plumber roodepoort,energy efficient geyser roodepoort',
        ],
        'water-filtration' => [
            'Water Filtration & Purification Roodepoort | Clean Water Systems — Tysons Plumbers',
            'Water filtration and purification systems installed across Roodepoort. Cleaner water at every tap. Free quote. Tysons Plumbers Roodepoort.',
            'water filtration roodepoort,water purification roodepoort,water filter installation roodepoort',
        ],
        'maintenance-contracts' => [
            'Maintenance Contracts Roodepoort | Scheduled Plumbing Servicing — Tysons Plumbers',
            'Plumbing maintenance contracts for homes, complexes and businesses in Roodepoort. Scheduled servicing, priority call-outs. Tysons Plumbers Roodepoort.',
            'plumbing maintenance contract roodepoort,scheduled plumber roodepoort,body corporate plumber roodepoort',
        ],
    ];

    // Was a hardcoded duplicate of TP_AREAS that could silently drift out of
    // sync with it — now reads the same single source of truth.
    $areas_data = unserialize(TP_AREAS);

    foreach ($services_data as $slug => $data) {
        $exists = get_posts(['name'=>$slug,'post_type'=>'tp_service','post_status'=>'publish','numberposts'=>1]);
        if (empty($exists)) {
            $id = wp_insert_post(['post_title'=>$data[0],'post_name'=>$slug,'post_status'=>'publish','post_type'=>'tp_service','post_excerpt'=>$data[1]]);
            if ($id) {
                update_post_meta($id,'tp_meta_desc',$data[1]);
                update_post_meta($id,'tp_keywords',$data[2]);
                update_post_meta($id,'tp_slug',$slug);
            }
        }
    }
    foreach ($areas_data as $slug => $name) {
        $exists = get_posts(['name'=>$slug,'post_type'=>'tp_area','post_status'=>'publish','numberposts'=>1]);
        if (empty($exists)) {
            wp_insert_post(['post_title'=>"Plumbers $name | 24/7 Service — Tysons Plumbers Roodepoort",'post_name'=>$slug,'post_status'=>'publish','post_type'=>'tp_area','post_excerpt'=>"Trusted plumbers in $name. Tysons Plumbers Roodepoort offers 24/7 emergency plumbing, geyser repairs, drain cleaning and pipe repairs in $name. No call-out fee. Call 071 363 1433.",'meta_input'=>['tp_area_name'=>$name]]);
        }
    }
    update_option('tp_pages_v4', true);
    flush_rewrite_rules(false);
}
add_action('after_switch_theme','tp_create_pages');
add_action('init','tp_create_pages',30);

// ── CUSTOMIZER ─────────────────────────────────────────────────────────────
function tp_customizer($wp_customize) {
    $wp_customize->add_panel('tp_panel',['title'=>'Business Details','priority'=>30]);
    $wp_customize->add_section('tp_contact',['title'=>'Contact & Settings','panel'=>'tp_panel']);
    $fields = [
        'tp_phone'   =>['Phone Number',         TP_PHONE],
        'tp_wa_num'  =>['WhatsApp (intl format)',TP_WA_NUM],
        'tp_email'   =>['Email Address',         TP_EMAIL],
        'tp_review'  =>['Google Review Link',    '#'],
        'tp_maps'    =>['Google Maps Embed URL', ''],
    ];
    foreach ($fields as $id=>$cfg) {
        $wp_customize->add_setting($id,['default'=>$cfg[1],'sanitize_callback'=>'sanitize_text_field']);
        $wp_customize->add_control($id,['label'=>$cfg[0],'section'=>'tp_contact','type'=>'text']);
    }
}
add_action('customize_register','tp_customizer');

// ── CONTACT FORM ───────────────────────────────────────────────────────────
function tp_handle_form() {
    if (!isset($_POST['tp_nonce'])||!wp_verify_nonce($_POST['tp_nonce'],'tp_contact')) return;
    $name    = sanitize_text_field($_POST['tp_name']    ?? '');
    $phone   = sanitize_text_field($_POST['tp_phone']   ?? '');
    $service = sanitize_text_field($_POST['tp_service'] ?? '');
    $msg     = sanitize_textarea_field($_POST['tp_msg'] ?? '');
    $to      = tp_email();
    wp_mail($to,"Quote Request — $name","Name: $name\nPhone: $phone\nService: $service\nMessage:\n$msg");
    wp_redirect(add_query_arg('sent','1', wp_get_referer())); exit;
}
add_action('admin_post_nopriv_tp_contact','tp_handle_form');
add_action('admin_post_tp_contact',       'tp_handle_form');

// ── ADMIN RESET (visit /wp-admin/?tp_reset=1) ──────────────────────────────
function tp_admin_reset() {
    if (is_admin() && isset($_GET['tp_reset']) && current_user_can('manage_options')) {
        delete_option('tp_pages_v2'); delete_option('tp_flushed_v2');
        delete_option('tp_pages_v3'); delete_option('tp_flushed_v3');
        delete_option('tp_pages_v4'); delete_option('tp_flushed_v4');
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init','tp_admin_reset');
