<?php
/**
 * Brackendowns Plumber — functions.php v2.0
 * Rebuilt on the 247 Plumbers GP architecture: expanded from 9 to 16
 * services, from 20 to 30 areas (10 new East Rand suburbs), AIOSEO/Yoast/
 * Rank Math aware SEO, dynamic schema, security headers.
 * Phone: 073 537 6298
 */

// ── CONSTANTS ──────────────────────────────────────────────────────────────────
define('GP_PHONE',    '073 537 6298');
define('GP_PHONE_RAW','27735376298');
define('GP_EMAIL',    'info@brackendownsplumber.co.za');
define('GP_FB',       'https://www.facebook.com/brackendownsplumber');
define('GP_IG',       'https://www.instagram.com/brackendownsplumber');
define('GP_TIKTOK',   'https://www.tiktok.com/@brackendownsplumber');
define('GP_YT',       '');
define('GP_GOOGLE',   'https://share.google/ltGieJmxVgIjZDukU');
define('GP_REVIEW',   'https://g.page/r/CfF8WyEVjuinEAE/review');

// ── ADS & ANALYTICS TRACKING IDS (set these in Customizer once you have them) ──
// GA4 measurement ID looks like: G-XXXXXXXXXX
// Google Ads conversion ID looks like: AW-XXXXXXXXXX
// Google Ads conversion label looks like: AbCdEfGhIjKlMnOp (from the conversion action setup)
// Call tracking number is the Google Forwarding Number shown in your Ads call asset setup
function gp_ga4_id()        { return get_theme_mod('gp_ga4_id', ''); }
function gp_ads_id()        { return get_theme_mod('gp_ads_id', ''); }
function gp_ads_label_form(){ return get_theme_mod('gp_ads_label_form', ''); }
function gp_ads_label_call(){ return get_theme_mod('gp_ads_label_call', ''); }
function gp_call_tracking_num() { return get_theme_mod('gp_call_tracking_num', ''); }

define('GP_SERVICES', serialize([
    'emergency-plumbing'       => 'Emergency Plumbing',
    'leak-detection'           => 'Leak Detection & Repair',
    'geyser-repair'            => 'Geyser Repair & Installation',
    'geyser-installation'      => 'Geyser Installation',
    'drain-cleaning'           => 'Drain Cleaning & Unblocking',
    'pipe-repair'              => 'Pipe Repair & Replacement',
    'bathroom-plumbing'        => 'Bathroom & Kitchen Plumbing',
    'toilet-repairs'           => 'Toilet Repairs',
    'water-backup-tank'        => 'Water Backup Tank Installation',
    'gutters-downpipes'        => 'Gutters & Downpipe Systems',
    'grease-trap-cleaning'     => 'Grease Trap Cleaning',
    'drain-camera-inspections' => 'Drain Camera Inspections',
    'heat-pumps'               => 'Heat Pumps',
    'water-filtration'         => 'Water Filtration & Purification',
    'maintenance-contracts'    => 'Maintenance Contracts',
    'industrial-plumbing'      => 'Industrial Plumbing Services',
]));

// Distinct icon per service (used on homepage service cards + service pages)
// so each card reads as its own service rather than 9 repeats of one icon.
function gp_service_icon_path($slug) {
    $icons = [
        'emergency-plumbing'  => 'M13 2 3 14h7l-2 8 12-14h-8l1-6z',
        'leak-detection'      => 'M15.5 14h-.79l-.28-.27a6.5 6.5 0 1 0-.7.7l.27.28v.79l5 5L20.49 19l-5-5zM9.5 14A4.5 4.5 0 1 1 14 9.5 4.51 4.51 0 0 1 9.5 14z',
        'geyser-repair'       => 'M22.7 19 13.6 9.9c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.4-.4.4-1.1.1-1.4z',
        'geyser-installation' => 'M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8c0-5.39-2.59-10.2-6.5-13.33zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z',
        'drain-cleaning'      => 'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 16a6 6 0 1 1 6-6 6 6 0 0 1-6 6zm0-9a3 3 0 1 0 3 3 3 3 0 0 0-3-3z',
        'pipe-repair'         => 'M4 10h6V4a2 2 0 0 1 4 0v6h6v4h-6v6a2 2 0 0 1-4 0v-6H4z',
        'bathroom-plumbing'   => 'M7 6V5a1 1 0 0 1 2 0v1h6a1 1 0 0 1 1 1v1h2a1 1 0 0 1 0 2h-1v2a5 5 0 0 1-4 4.9V19a1 1 0 1 1-2 0v-1.1A5 5 0 0 1 6 13v-2H5a1 1 0 1 1 0-2h2V7a1 1 0 0 1 0-1z',
        'toilet-repairs'      => 'M7 2h10a2 2 0 0 1 2 2v6H5V4a2 2 0 0 1 2-2zm-2 10h14a1 1 0 0 1 1 1c0 4.5-2.5 8-6 9v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1c-3.5-1-6-4.5-6-9a1 1 0 0 1 1-1z',
        'water-backup-tank'   => 'M6 2h12l2 6v11a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V8zM7.5 12a4.5 6 0 1 0 9 0 4.5 6 0 1 0-9 0z',
        'gutters-downpipes'        => 'M4 4h16v3H4zM6 9h2v11a2 2 0 0 1-4 0V9zm10 0h2v6a2 2 0 0 1-4 0V9z',
        'grease-trap-cleaning'     => 'M6 3h12l-1.5 8.5a5 5 0 0 1-4.5 4.4V19h2a1 1 0 1 1 0 2H9.5a1 1 0 1 1 0-2h2v-3.1a5 5 0 0 1-4-4.4z',
        'drain-camera-inspections' => 'M4 8a2 2 0 0 1 2-2h2l1-2h6l1 2h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm8 2a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7z',
        'heat-pumps'               => 'M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z',
        'water-filtration'         => 'M12 2 5 10.5C3.5 12.5 3 14 3 16a9 9 0 0 0 18 0c0-2-.5-3.5-2-5.5zm0 15a4.5 4.5 0 0 1-4.5-4.5c0-1 .3-1.8 1.2-3L12 5.5l3.3 4c.9 1.2 1.2 2 1.2 3A4.5 4.5 0 0 1 12 17z',
        'maintenance-contracts'    => 'M9 2h6a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1V3a1 1 0 0 1 1-1zm-1 9 2 2 4-4',
        'industrial-plumbing'      => 'M3 21V10l6 4v-4l6 4V6l6 4v11H3zm4-3h2v-3H7zm5 0h2v-5h-2zm5 0h2v-3h-2z',
    ];
    return $icons[$slug] ?? 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z';
}

define('GP_AREAS', serialize([
    'brackendowns'   => 'Brackendowns',
    'alberton'       => 'Alberton',
    'brackenhurst'   => 'Brackenhurst',
    'meyersdal'      => 'Meyersdal',
    'new-redruth'    => 'New Redruth',
    'florentia'      => 'Florentia',
    'randhart'       => 'Randhart',
    'alrode'         => 'Alrode',
    'albertsdal'     => 'Albertsdal',
    'verwoerdpark'   => 'Verwoerdpark',
    'albemarle'      => 'Albemarle',
    'dinwiddie'      => 'Dinwiddie',
    'mayberry-park'  => 'Mayberry Park',
    'germiston'      => 'Germiston',
    'boksburg'       => 'Boksburg',
    'edenvale'       => 'Edenvale',
    'bedfordview'    => 'Bedfordview',
    'glenvista'      => 'Glenvista',
    'palm-ridge'     => 'Palm Ridge',
    'henley-on-klip' => 'Henley-on-Klip',
    'springs'        => 'Springs',
    'brakpan'        => 'Brakpan',
    'benoni'         => 'Benoni',
    'nigel'          => 'Nigel',
    'impala-park'    => 'Impala Park',
    'dawn-park'      => 'Dawn Park',
    'bartlett'       => 'Bartlett',
    'sunward-park'   => 'Sunward Park',
    'selcourt'       => 'Selcourt',
    'van-dyk-park'   => 'Van Dyk Park',
]));

// ── REAL CUSTOMER REVIEWS ──────────────────────────────────────────────────────
// Genuine 5-star Google reviews for Brackendowns Plumber (source: the
// business's own Google Business Profile), lightly copy-edited for spelling
// only — never invent quotes or attribute a review to an area/suburb we
// can't confirm the reviewer is actually in. Replaces the earlier fabricated
// "— Resident, {area}" / "— Real reviews coming soon" placeholder quotes
// that were hardcoded per page.
define('GP_REAL_REVIEWS', serialize([
    ['name' => 'Lebogang Kekae',    'quote' => 'Thank you for fixing up my geyser. Highly recommended plumber.'],
    ['name' => 'Sindy Zwane',       'quote' => 'Excellent service — prompt, reliable and affordable. Our go-to plumber in Brackendowns.'],
    ['name' => 'Tokkelok Kilian',   'quote' => "Very well mannered and educated, and confident in his trade. I'll recommend him and his services with pleasure."],
    ['name' => 'SD',                'quote' => 'Great experience — very honest, fixed our issue for a great price, and very nice.'],
    ['name' => 'Marlene Kinnear',   'quote' => 'Quick, friendly, efficient service. Call logged 8am, repairs completed by 10:15.'],
    ['name' => 'Lethabo',           'quote' => 'Very good service and user friendly. I am very happy with their service.'],
    ['name' => 'Darryl Slater',     'quote' => 'Efficient, helpful and affordable. Absolute pleasure to deal with!'],
    ['name' => 'Luis Quintino',     'quote' => 'Impressed with the punctuality, professionalism and quick service — sorted the overflow from my geyser fast.'],
    ['name' => 'Marleen Mojapelo',  'quote' => 'So professional, and he knows his work.'],
    ['name' => 'Andre Bekker',      'quote' => 'Called for an emergency pipe leak — came out and fixed it effectively. Reasonable fees and friendly service.'],
    ['name' => 'Siva Govinda',      'quote' => 'Service was excellent, thank you!'],
    ['name' => 'Pickadilly',        'quote' => 'Great service and competitive prices.'],
    ['name' => 'Kabir Singh',       'quote' => 'Good guy — reliable service.'],
]));

// Deterministically picks $count real reviews starting at a position derived
// from $seed (e.g. the current page's slug), so different pages show a
// different rotation of genuine quotes instead of all pages repeating the
// same three — same technique already used for gp_area's photo pool.
function gp_review_cards($seed, $count = 3) {
    $reviews = unserialize(GP_REAL_REVIEWS);
    $total   = count($reviews);
    $start   = abs(crc32($seed)) % $total;
    $html    = '';
    for ($i = 0; $i < min($count, $total); $i++) {
        $r = $reviews[($start + $i) % $total];
        $html .= '<div class="mini-review"><div class="stars">★★★★★</div><blockquote>"'
            . esc_html($r['quote']) . '"</blockquote><div class="mini-reviewer">— '
            . esc_html($r['name']) . ', Google Review</div></div>';
    }
    return $html;
}

// ── HELPERS ────────────────────────────────────────────────────────────────────
function gp_phone_link() {
    $p = get_theme_mod('gp_phone', GP_PHONE);
    $d = preg_replace('/[^0-9]/', '', $p);
    if (substr($d,0,1)==='0') $d = '27'.substr($d,1);
    return 'tel:+' . $d;
}
function gp_wa_link($msg='Hi, I need a plumber') {
    $wa = get_theme_mod('gp_whatsapp', GP_PHONE_RAW);
    return 'https://wa.me/' . $wa . '?text=' . urlencode($msg);
}
function gp_phone()  { return get_theme_mod('gp_phone',    GP_PHONE);  }
function gp_email()  { return get_theme_mod('gp_email',    GP_EMAIL);  }
function gp_fb()     { return get_theme_mod('gp_facebook', GP_FB);     }
function gp_ig()     { return get_theme_mod('gp_instagram',GP_IG);     }
function gp_tiktok() { return get_theme_mod('gp_tiktok',   GP_TIKTOK); }
function gp_google() { return get_theme_mod('gp_google',   GP_GOOGLE); }
function gp_review() { return get_theme_mod('gp_review',   GP_REVIEW); }

// ── THEME SETUP ────────────────────────────────────────────────────────────────
function gp_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','gallery','caption']);
}
add_action('after_setup_theme', 'gp_setup');

// ── ENQUEUE ASSETS ─────────────────────────────────────────────────────────────
function gp_assets() {
    // Main theme stylesheet loads immediately, with NO dependency on the
    // Google Fonts request — this was the cause of the render-blocking chain
    // and the "Font display" warning in PageSpeed Insights.
    wp_enqueue_style('gp-main', get_template_directory_uri().'/assets/css/main.css',[],'1.0.0');
    wp_enqueue_script('gp-js',  get_template_directory_uri().'/assets/js/main.js',[],  '1.0.0', true);

    // Google Fonts stylesheet still gets enqueued (so it's in the dependency
    // graph correctly) but is loaded async via gp_async_fonts() below instead
    // of blocking the page render.
    wp_enqueue_style('gp-fonts','https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap',[],null);
}
add_action('wp_enqueue_scripts', 'gp_assets');

// WP core loads jQuery (a dependency of some admin-bar/embed scripts) in
// <head> with no defer/async, while every theme script below is already
// deferred to the footer — this was the one inconsistency flagged in the
// SEO audit. Add defer specifically to the two jQuery handles rather than
// touching how they're enqueued, so dependency order stays intact.
add_filter('script_loader_tag', function($tag, $handle) {
    if (in_array($handle, ['jquery-core', 'jquery-migrate'], true) && strpos($tag, 'defer') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);

// ── PRECONNECT + ASYNC FONT LOADING ────────────────────────────────────────────
// Preconnect tells the browser to open the connection to Google Fonts' two
// domains early, in parallel with everything else, instead of waiting to
// discover it needs to mid-page. Combined with loading the stylesheet
// non-blocking, this directly addresses both the "Font display" and
// "Render-blocking requests" issues flagged by PageSpeed Insights.
function gp_resource_hints() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'gp_resource_hints', 0);

// Rewrites the gp-fonts <link> tag to load non-blocking (rel="preload" +
// swap to stylesheet via onload), with a <noscript> fallback for the rare
// visitor with JavaScript disabled.
function gp_async_fonts($html, $handle) {
    if ($handle !== 'gp-fonts') return $html;
    $noscript_version = $html; // original <link rel='stylesheet' ...> tag, untouched
    $async_version = str_replace(
        "rel='stylesheet'",
        "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
        $html
    );
    return $async_version . '<noscript>' . $noscript_version . '</noscript>';
}
add_filter('style_loader_tag', 'gp_async_fonts', 10, 2);

// ── SEO META + SCHEMA ──────────────────────────────────────────────────────────
// ── PAGE TITLE + META DESCRIPTION BUILDERS ─────────────────────────────────────
// Centralised here so every page type (service, area, article, home, static
// page) gets a deliberate, length-checked title and description instead of
// relying on WordPress defaults — fixes both the "Title too long" and
// "Meta description missing" issues flagged in the Ahrefs site audit.

// Detect if a major SEO plugin is active. If so, that plugin owns the
// <title>, meta description, canonical URL and Open Graph tags — we defer
// to it entirely for those rather than risk two competing/duplicate sets
// of tags in <head>. We still output our own LocalBusiness/Plumber schema
// below regardless, since that's plumbing-specific structured data most
// SEO plugins don't generate on their own.
function gp_seo_plugin_active() {
    return defined('WPSEO_VERSION')            // Yoast SEO
        || defined('RANK_MATH_VERSION')         // Rank Math
        || function_exists('aioseo');           // All in One SEO (current plugin — old class-name check replaced)
}

function gp_build_page_title() {
    global $wp_query;
    // Use $wp_query directly instead of is_front_page()/is_home() —
    // those functions call get_option() too early in the load cycle,
    // which was causing the infinite recursion loop reported by hosting.
    if (!isset($wp_query)) {
        return 'Brackendowns Plumber | 24/7 Plumber Alberton & East Rand';
    }
    if ($wp_query->is_front_page() || $wp_query->is_home()) {
        return 'Brackendowns Plumber | 24/7 Plumber Alberton & East Rand';
    }
    if ($wp_query->is_singular('gp_service')) {
        // Shortened from "$name Alberton & East Rand | Brackendowns Plumber"
        // (71-72 chars, clipped by Google around 60) — location is already
        // covered in the meta description and body copy, so it doesn't need
        // to be in the title too.
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        return $name . ' | Brackendowns Plumber';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Plumber in ' . $area . ' | 24/7 Service | Brackendowns Plumber';
    }
    if ($wp_query->is_singular('post')) {
        $t = get_the_title();
        if (mb_strlen($t) > 50) $t = mb_substr($t, 0, 47) . '...';
        return $t . ' | Brackendowns Plumber';
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing Articles & Guides | Brackendowns Plumber';
    }
    // Return empty string instead of wp_get_document_title() — calling
    // wp_get_document_title() here would trigger pre_get_document_title
    // again, causing the infinite recursion. Empty string tells WordPress
    // to use its own default title logic for any unmatched page type.
    return '';
}

function gp_build_meta_description() {
    global $wp_query;
    if (!isset($wp_query) || $wp_query->is_front_page() || $wp_query->is_home()) {
        return 'PIRB registered plumbers serving Brackendowns, Alberton, Germiston, Boksburg and the wider East Rand. 24/7 emergency plumbing, no call-out fee.';
    }
    if ($wp_query->is_singular('gp_service')) {
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return $name . ' across Brackendowns and the East Rand. Available 24/7, no call-out fee, PIRB registered plumbers. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Looking for a plumber in ' . $area . '? Brackendowns Plumber offers 24/7 emergency plumbing, geyser repairs and drain cleaning. No call-out fee. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('post')) {
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return wp_trim_words(get_the_content(), 28);
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing tips and guides for Brackendowns, Alberton and East Rand homeowners — geysers, leaks, drains and more, from the team at Brackendowns Plumber.';
    }
    return 'PIRB registered plumbers serving Brackendowns and the East Rand. 24/7 emergency plumbing, no call-out fee. Call ' . gp_phone() . '.';
}

// Override the <title> tag itself (not just the og:title meta) so the
// browser tab, search result snippet, and social share all stay consistent
// and within length limits.
add_filter('pre_get_document_title', function($title) {
    if (gp_seo_plugin_active()) return $title; // let Yoast/RankMath/AIOSEO own the title
    $custom = gp_build_page_title();
    return $custom !== '' ? $custom : $title;
});

// When Yoast IS active: Yoast still needs *something* to show for every page.
// Rather than defer blindly (which left every page with no description until
// each one was manually edited), hook Yoast's own extension filters so our
// good auto-generated title/description are used as the live fallback — and
// automatically step aside the moment a page has a real custom value saved
// via the Yoast meta box, with no duplicate tags either way.
add_filter('wpseo_title', function($title) {
    if (get_post_meta(get_the_ID(), '_yoast_wpseo_title', true)) return $title; // custom value set — keep it
    $custom = gp_build_page_title();
    return $custom !== '' ? $custom : $title;
});
add_filter('wpseo_metadesc', function($desc) {
    if (get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true)) return $desc; // custom value set — keep it
    return gp_build_meta_description();
});
// Same fallback pattern, for All in One SEO's own extension filters.
add_filter('aioseo_title', function($title) {
    if (get_post_meta(get_the_ID(), '_aioseo_title', true)) return $title; // custom value set — keep it
    $custom = gp_build_page_title();
    return $custom !== '' ? $custom : $title;
});
add_filter('aioseo_description', function($desc) {
    if (get_post_meta(get_the_ID(), '_aioseo_description', true)) return $desc; // custom value set — keep it
    return gp_build_meta_description();
});
// Fallback social-share image for pages with no featured image set (this is
// what "Open Graph tags incomplete" in the Ahrefs audit was flagging on the
// area/service pages, which don't have individual photos).
add_filter('wpseo_opengraph_image', function($image) {
    if ($image) return $image; // a real image (e.g. featured image) already found
    return get_template_directory_uri() . '/assets/images/geyser-branded.jpg';
});

function gp_seo_meta() {
    $has_seo_plugin = gp_seo_plugin_active();

    echo '<meta name="geo.region" content="ZA-GP">'."\n";
    echo '<meta name="geo.placename" content="Brackendowns, Gauteng">'."\n";

    if (!$has_seo_plugin) {
        echo '<meta name="robots" content="index, follow">'."\n";
        echo '<link rel="canonical" href="'.esc_url(get_permalink()).'">'."\n";

        // Meta description — was missing site-wide, flagged by Ahrefs on every
        // page (54 pages with no description). Built per page-type below so
        // every page gets something specific, never the generic fallback.
        $desc = gp_build_meta_description();
        echo '<meta name="description" content="'.esc_attr($desc).'">'."\n";
        echo '<meta property="og:description" content="'.esc_attr($desc).'">'."\n";

        echo '<meta property="og:type" content="website">'."\n";
        echo '<meta property="og:title" content="'.esc_attr(gp_build_page_title()).'">'."\n";
        echo '<meta property="og:url" content="'.esc_url(get_permalink()).'">'."\n";
        echo '<meta property="og:locale" content="en_ZA">'."\n";
    }
    // else: Yoast/RankMath/AIOSEO already outputs robots, canonical,
    // description, and Open Graph tags — outputting our own here would
    // create duplicate/conflicting tags in <head>.

    // LocalBusiness schema on every page — kept regardless of SEO plugin,
    // since this is plumbing-specific structured data (service area,
    // opening hours, PIRB registration) that generic SEO plugins don't
    // generate without manual configuration.
    $all_areas    = unserialize(GP_AREAS);
    $all_services = unserialize(GP_SERVICES);
    $schema = [
        '@context'=>'https://schema.org','@type'=>'Plumber',
        'name'=>'Brackendowns Plumber',
        'url'=>home_url('/'),
        'telephone'=>'+27735376298',
        'priceRange'=>'$$',
        'description'=>'Brackendowns Plumber — trusted local plumbers serving Brackendowns, Alberton and the East Rand. 24/7 emergency plumbing, geyser repairs, drain cleaning, leak detection. No call-out fee. PIRB registered.',
        'address'=>['@type'=>'PostalAddress','addressLocality'=>'Brackendowns','addressRegion'=>'Gauteng','postalCode'=>'1448','addressCountry'=>'ZA'],
        'geo'=>['@type'=>'GeoCoordinates','latitude'=>-26.3167,'longitude'=>28.1167],
        'openingHoursSpecification'=>[['@type'=>'OpeningHoursSpecification','dayOfWeek'=>['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],'opens'=>'00:00','closes'=>'23:59']],
        'areaServed'=>array_map(function($name){ return ['@type'=>'City','name'=>$name]; }, array_values($all_areas)),
        'hasOfferCatalog'=>['@type'=>'OfferCatalog','name'=>'Plumbing Services Brackendowns','itemListElement'=>
            array_map(function($name){ return ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>$name]]; }, array_values($all_services))
        ],
        'sameAs'=>array_values(array_filter([gp_fb(), gp_ig(), gp_tiktok(), GP_YT, gp_google()])),
    ];
    echo '<script type="application/ld+json">'.wp_json_encode($schema, JSON_UNESCAPED_SLASHES).'</script>'."\n";
}
add_action('wp_head','gp_seo_meta',1);

// ── FAVICON ────────────────────────────────────────────────────────────────────
function gp_favicon() {
    $imgdir = get_template_directory_uri() . '/assets/images/';
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($imgdir . 'favicon-32.png') . '">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($imgdir . 'favicon-180.png') . '">' . "\n";
}
add_action('wp_head', 'gp_favicon', 0);

// ── GOOGLE ADS + GA4 TRACKING ──────────────────────────────────────────────────
// Loads gtag.js once, using whichever IDs are set in Customizer.
// Safe to leave blank — outputs nothing until you add real IDs.
function gp_tracking_head() {
    $ga4  = gp_ga4_id();
    $ads  = gp_ads_id();
    if (!$ga4 && !$ads) return; // nothing configured yet, skip entirely

    $primary_id = $ga4 ?: $ads; // gtag.js loads off whichever ID exists
    echo "<!-- Google tag (gtag.js) -->\n";
    echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr($primary_id) . '"></script>' . "\n";
    echo "<script>\n";
    echo "window.dataLayer = window.dataLayer || [];\n";
    echo "function gtag(){dataLayer.push(arguments);}\n";
    echo "gtag('js', new Date());\n";
    if ($ga4) echo "gtag('config', '" . esc_js($ga4) . "');\n";
    if ($ads) echo "gtag('config', '" . esc_js($ads) . "');\n";
    echo "</script>\n";
}
add_action('wp_head', 'gp_tracking_head', 2);

// Ahrefs Analytics
function gp_ahrefs_analytics() {
    echo '<script src="https://analytics.ahrefs.com/analytics.js" data-key="E6bkLDFJOGtHJxuP5Q/AiQ" async></script>' . "\n";
}
add_action('wp_head', 'gp_ahrefs_analytics', 3);

// ── CONVERSION EVENT HELPERS (called from JS via gp_fire_conversion()) ────────
// Outputs a small JS helper once IDs are configured, used by the call/WA/form buttons.
function gp_conversion_js() {
    $ads_id    = gp_ads_id();
    $label_form= gp_ads_label_form();
    $label_call= gp_ads_label_call();
    if (!$ads_id) return;
    ?>
    <script>
    (function() {
      var ADS_ID    = '<?php echo esc_js($ads_id); ?>';
      var LABEL_CALL= '<?php echo esc_js($label_call); ?>';
      var LABEL_FORM= '<?php echo esc_js($label_form); ?>';

      function fire(label) {
        if (typeof gtag !== 'function' || !label) return;
        gtag('event', 'conversion', {'send_to': ADS_ID + '/' + label});
      }

      // Catch every call and WhatsApp link on the page automatically —
      // no need to add onclick to every button across every template.
      document.addEventListener('click', function(e) {
        var a = e.target.closest('a');
        if (!a) return;
        var href = a.getAttribute('href') || '';
        if (href.indexOf('tel:') === 0) {
          fire(LABEL_CALL);
        } else if (href.indexOf('wa.me') !== -1 || href.indexOf('whatsapp') !== -1) {
          fire(LABEL_CALL); // WhatsApp clicks count as a "call" type conversion
        }
      }, true);

      // Exposed for the contact form handler (fired manually on successful submit)
      window.gpFireFormConversion = function() { fire(LABEL_FORM); };
    })();
    </script>
    <?php
}
add_action('wp_footer', 'gp_conversion_js');

// ── BREADCRUMB SCHEMA ──────────────────────────────────────────────────────────
function gp_breadcrumb_schema() {
    if (!is_singular('gp_service') && !is_singular('gp_area') && !is_singular('post')) return;

    if (is_singular('post')) {
        $schema = ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[
            ['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>home_url('/')],
            ['@type'=>'ListItem','position'=>2,'name'=>'Articles','item'=>home_url('/articles/')],
            ['@type'=>'ListItem','position'=>3,'name'=>get_the_title(),'item'=>get_permalink()],
        ]];
        echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>'."\n";

        // BlogPosting schema — helps Google understand this is an article, not a service page
        $blog_schema = [
            '@context'=>'https://schema.org','@type'=>'BlogPosting',
            'headline'=>get_the_title(),
            'datePublished'=>get_the_date('c'),
            'dateModified'=>get_the_modified_date('c'),
            'author'=>['@type'=>'Organization','name'=>'Brackendowns Plumber'],
            'publisher'=>['@type'=>'Organization','name'=>'Brackendowns Plumber','logo'=>['@type'=>'ImageObject','url'=>get_template_directory_uri().'/assets/images/logo.png']],
            'mainEntityOfPage'=>['@type'=>'WebPage','@id'=>get_permalink()],
            'description'=>get_the_excerpt() ?: wp_trim_words(get_the_content(),30),
        ];
        if (has_post_thumbnail()) {
            $blog_schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
        echo '<script type="application/ld+json">'.wp_json_encode($blog_schema,JSON_UNESCAPED_SLASHES).'</script>'."\n";
        return;
    }

    $type     = is_singular('gp_service') ? 'Services' : 'Areas';
    $type_url = is_singular('gp_service') ? home_url('/#services') : home_url('/#areas');
    $schema = ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[
        ['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>home_url('/')],
        ['@type'=>'ListItem','position'=>2,'name'=>$type,'item'=>$type_url],
        ['@type'=>'ListItem','position'=>3,'name'=>get_the_title(),'item'=>get_permalink()],
    ]];
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>'."\n";
}
add_action('wp_head','gp_breadcrumb_schema');

// ── FORCE HTTPS ────────────────────────────────────────────────────────────
// The HSTS header below assumed the site "already runs on HTTPS sitewide" —
// tested directly (July 2026) and that wasn't actually true: the live site
// did not redirect plain-HTTP requests to HTTPS, and several image URLs
// (logo, job photos in the footer) were being output as http:// links —
// classic mixed content. HSTS alone doesn't fix either of those; it only
// tells browsers to stick to HTTPS on *future* visits once they've already
// been on the HTTPS version once. This closes that gap at the application
// level, independent of whatever the host configures (or fails to) at
// server level, and fixes the mixed-content image URLs at the source.
add_filter('option_siteurl', 'gp_force_https_url');
add_filter('option_home', 'gp_force_https_url');
function gp_force_https_url($url) {
    return set_url_scheme($url, 'https');
}
add_action('template_redirect', 'gp_force_https_redirect');
function gp_force_https_redirect() {
    if (!is_ssl() && !is_admin()) {
        wp_safe_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit;
    }
}

// ── SECURITY HEADERS ─────────────────────────────────────────────────────────
// Flagged by Sucuri SiteCheck. Set via PHP (send_headers hook) rather than
// .htaccess, so this works regardless of hosting setup and doesn't need
// server-level access.
function gp_security_headers() {
    if (is_admin()) return; // don't affect wp-admin
    header('X-Frame-Options: SAMEORIGIN');           // clickjacking protection
    header('X-Content-Type-Options: nosniff');       // stop content-type sniffing
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains'); // HSTS — only safe because the site already runs on HTTPS sitewide
    header_remove('X-Powered-By');                   // hide leaked PHP version where possible

    // Content-Security-Policy — deliberately permissive rather than strict,
    // scoped to what this theme actually uses (heavy inline styles, Google
    // Fonts, Google Maps embed, Google Tag Manager, Ahrefs analytics). A
    // stricter policy (no 'unsafe-inline') would need inline styles/scripts
    // moved into enqueued files first — worth doing eventually, but risks
    // breaking the site if applied blindly now. TEST THE LIVE SITE after
    // deploying this — page styling, Google Maps embed, and tracking
    // scripts should all still work; if anything looks broken, report it
    // rather than loosening the policy blindly.
    $csp = "default-src 'self'; "
         . "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com https://analytics.ahrefs.com; "
         . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
         . "img-src 'self' data: https:; "
         . "font-src 'self' https://fonts.gstatic.com data:; "
         . "frame-src 'self' https://www.google.com https://maps.google.com; "
         . "connect-src 'self' https://www.google-analytics.com https://analytics.ahrefs.com; "
         . "object-src 'none'; base-uri 'self';";
    header("Content-Security-Policy: $csp");
}
add_action('send_headers', 'gp_security_headers');

// ── AUTO-CREATE THE ARTICLES LANDING PAGE ──────────────────────────────────────
// Creates a WordPress Page at /articles/ using the page-articles.php template,
// the same way service/area pages are auto-created on theme activation.
function gp_create_articles_page() {
    // All pages use the standard WordPress Page post type and a dedicated
    // PHP template file (identified via Template Name header — WordPress's
    // native template-selection mechanism, no custom rewrite/template_include
    // hacks required).
    //
    // NOTE: Mondeor, Parkview and Norwood used to be created here as a
    // second, separate "page" post sharing the same slug as their
    // "gp_area" custom-post-type entry (created by gp_create_all_pages()
    // below). Because the gp_area post type is registered as public with
    // its own rewrite rules, WordPress's wp_unique_post_slug() detected the
    // slug was already taken and silently renamed the Page to
    // "mondeor-2" / "parkview-2" / "norwood-2" — while the hand-written
    // rewrite rule still pointed at the original slug. That mismatch is
    // what produced the 404s. Those three suburbs are now served solely
    // through the gp_area custom post type at /areas/{slug}/, exactly like
    // every other suburb, so there is only ever one canonical URL and one
    // code path for area pages — no possible slug collision.
    $pages = [
        'articles'                       => ['Articles',                                    'page-articles.php'],
        'geyser-repair-vs-replacement'   => ['Is Your Geyser Worth Fixing? A 3-Question Test',  'page-geyser-repair-vs-replacement.php'],
        'plumbing-emergency-gauteng'     => ['The East Rand Plumbing Emergency Checklist',    'page-plumbing-emergency-gauteng.php'],
    ];

    foreach ($pages as $slug => $data) {
        $existing = get_page_by_path($slug);
        if (!$existing) {
            $page_id = wp_insert_post([
                'post_title'   => $data[0],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);
            if ($page_id) {
                update_post_meta($page_id, '_wp_page_template', $data[1]);
            }
        } else {
            // Make sure template is set even if page already exists
            $current_template = get_post_meta($existing->ID, '_wp_page_template', true);
            if ($current_template !== $data[1]) {
                update_post_meta($existing->ID, '_wp_page_template', $data[1]);
            }
        }
    }
}
add_action('init', 'gp_create_articles_page', 31);

// ── REGISTER CUSTOM POST TYPES — fires on every init ──────────────────────────
// THIS IS THE KEY FIX: must run on init every time, not just on activation
function gp_register_cpts() {
    register_post_type('gp_service', [
        'labels'      => ['name'=>'Services','singular_name'=>'Service','add_new_item'=>'Add New Service','edit_item'=>'Edit Service','view_item'=>'View Service'],
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => ['slug'=>'services','with_front'=>false],
        'supports'    => ['title','editor','thumbnail','excerpt'],
        'show_in_rest'=> true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-admin-tools',
    ]);
    register_post_type('gp_area', [
        'labels'      => ['name'=>'Areas','singular_name'=>'Area','add_new_item'=>'Add New Area','edit_item'=>'Edit Area','view_item'=>'View Area'],
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => ['slug'=>'areas','with_front'=>false],
        'supports'    => ['title','editor','thumbnail','excerpt'],
        'show_in_rest'=> true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-location',
    ]);
}
add_action('init', 'gp_register_cpts');

// ── FLUSH REWRITE RULES ────────────────────────────────────────────────────────
// Ensures /services/{slug}/ and /areas/{slug}/ URLs always work. Runs once per
// theme version (version bumped to v6 for this release to force a clean flush,
// since the rewrite structure changed — old custom rewrite rules removed).
function gp_maybe_flush() {
    if (!get_option('gp_flushed_v6')) {
        gp_register_cpts();
        flush_rewrite_rules(false);
        update_option('gp_flushed_v6', true);
        delete_option('gp_flushed_v5');
        delete_option('gp_flushed_v4');
    }
}
add_action('init', 'gp_maybe_flush', 20);

// ── LEGACY URL REDIRECTS ───────────────────────────────────────────────────────
// Mondeor, Parkview, Norwood and Randburg previously existed (or were linked /
// indexed by Google) at bare-slug URLs like /mondeor/ instead of the canonical
// /areas/mondeor/. Rather than leaving those old links and any indexed Google
// results as dead 404s, permanently redirect them to the correct page so no
// SEO value or existing traffic is lost.
function gp_legacy_area_redirects() {
    if (is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) return;
    $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');

    // Old suburb-slug 404s from the theme rebuild
    $legacy_area_slugs = ['mondeor', 'parkview', 'norwood', 'randburg'];
    if (in_array($path, $legacy_area_slugs, true)) {
        wp_redirect(home_url('/areas/' . $path . '/'), 301);
        exit;
    }

    // Old 2022-era site structure still indexed by Google — redirect straight
    // to the closest current equivalent so any existing ranking/backlink
    // value transfers instead of dying as a duplicate or a dead 404.
    $legacy_url_map = [
        'plumbers-in-fourways'   => '/areas/fourways/',
        'plumbers-in-norwood'    => '/areas/norwood/',
        'plumbers-in-mondeor'    => '/areas/mondeor/',
        'plumbers-in-parkview'   => '/areas/parkview/',
        'plumbers-in-midrand'    => '/areas/midrand/',
        'plumbers-in-centurion'  => '/areas/centurion/',
        'plumbers-in-pretoria'   => '/areas/pretoria/',
        'plumbers-in-sandton'    => '/areas/sandton/',
        'geyser-repairs'         => '/services/geyser-repair/',
        'geyser-installations'   => '/services/geyser-installation/',
        'drain-cleaning-services'=> '/services/drain-cleaning/',
        'about-us'               => '/#contact',
        'about'                  => '/#contact',
        'contact-us'             => '/#contact',
        'contact'                => '/#contact',
        // Found via Ahrefs crawl 09-Jul-2026 — old/duplicate pages still
        // live and indexable, competing directly with the correct pages.
        'plumber-in-mondeor'     => '/areas/mondeor/',
        'plumber-in-norwood'     => '/areas/norwood/',
        'plumber-in-parkview'    => '/areas/parkview/',
        'sample-page'            => '/',
        'category/uncategorized' => '/articles/',
    ];
    if (isset($legacy_url_map[$path])) {
        wp_redirect(home_url($legacy_url_map[$path]), 301);
        exit;
    }

    // Duplicate gp_area posts found with wrong slugs (e.g. someone created
    // "areas/plumber-in-glenvista" alongside the correct "areas/glenvista").
    // Redirect straight to the canonical version regardless of whether the
    // duplicate post itself has been deleted in wp-admin yet.
    $duplicate_area_map = [
        'areas/plumber-in-glenvista'      => '/areas/glenvista/',
        'areas/plumbers-in-glenvista'     => '/areas/glenvista/',
        'areas/plumber-in-moreleta-park'  => '/areas/moreleta-park/',
    ];
    if (isset($duplicate_area_map[$path])) {
        wp_redirect(home_url($duplicate_area_map[$path]), 301);
        exit;
    }

    // A stray dated post ("/2026/07/06/plumber-in-parkview/") was found
    // duplicating the Parkview area page. Catch any date-permalink post
    // whose slug matches a known area, regardless of the date prefix.
    if (preg_match('#^\d{4}/\d{2}/\d{2}/plumber-in-([a-z-]+)/?$#', $path, $m)) {
        $areas_check = unserialize(GP_AREAS);
        if (isset($areas_check[$m[1]])) {
            wp_redirect(home_url('/areas/' . $m[1] . '/'), 301);
            exit;
        }
    }
}
add_action('template_redirect', 'gp_legacy_area_redirects', 1);

// ── AUTO-CREATE ALL SERVICE & AREA POSTS ──────────────────────────────────────
// Runs on theme switch and on every init — safe to run repeatedly because
// each area/service is checked individually before creating, so no duplicates.
function gp_create_all_pages() {

    $services_data = [
        'emergency-plumbing' => ['Emergency Plumbing', '24/7 emergency plumber covering Brackendowns and the East Rand. Burst pipes, flooding, no water — fast response. No call-out fee. PIRB registered.'],
        'leak-detection' => ['Leak Detection & Repair', 'Professional water leak detection across Brackendowns, Alberton and the East Rand. Hidden leaks found fast using proper equipment. No call-out fee.'],
        'geyser-repair' => ['Geyser Repair & Installation', 'Geyser repair and installation across Brackendowns and the East Rand. Gas, electric, solar — all brands. PIRB compliance certificates. Same-day service.'],
        'geyser-installation' => ['Geyser Installation', 'New geyser installation across Brackendowns and the East Rand. Electric, gas, solar and heat pump geysers supplied and fitted. PIRB certified.'],
        'drain-cleaning' => ['Drain Cleaning & Unblocking', 'Drain and sewer cleaning across Brackendowns and the East Rand. High-pressure jetting, root removal. Fast response, no call-out fee.'],
        'pipe-repair' => ['Pipe Repair & Replacement', 'Pipe repair and replacement across Brackendowns and the East Rand. Burst, corroded, cracked pipes fixed with SABS-approved materials. Guaranteed.'],
        'bathroom-plumbing' => ['Bathroom & Kitchen Plumbing', 'Full bathroom and kitchen plumbing across Brackendowns and the East Rand. Renovations, taps, toilets, showers, basins. Guaranteed workmanship.'],
        'toilet-repairs' => ['Toilet Repairs', 'Toilet repair specialists covering Brackendowns and the East Rand. Blocked, leaking, running toilets fixed fast. Same-day service. No call-out fee.'],
        'water-backup-tank' => ['Water Backup Tank Installation', 'Water backup tank installation across Brackendowns and the East Rand. Never run out of water during outages. JoJo tanks, pressure pumps, full installation.'],
        'gutters-downpipes' => ['Gutters & Downpipe Systems', 'Gutter and downpipe installation and repair across Brackendowns and the East Rand. Stop overflow and water damage before the rainy season. No call-out fee.'],
        'grease-trap-cleaning' => ['Grease Trap Cleaning', 'Grease trap cleaning for restaurants and commercial kitchens across Brackendowns, Alberton and the East Rand. Compliant, scheduled servicing.'],
        'drain-camera-inspections' => ['Drain Camera Inspections', 'Drain camera (CCTV) inspections across Brackendowns and the East Rand. See exactly what\'s wrong before any digging starts. Recorded footage provided.'],
        'heat-pumps' => ['Heat Pumps', 'Heat pump supply and installation across Brackendowns and the East Rand. Energy-efficient hot water for homes and businesses. PIRB registered.'],
        'water-filtration' => ['Water Filtration & Purification', 'Water filtration and purification systems installed across Brackendowns and the East Rand. Cleaner water at every tap. Free quote.'],
        'maintenance-contracts' => ['Maintenance Contracts', 'Plumbing maintenance contracts for homes, complexes and businesses across Brackendowns and the East Rand. Scheduled servicing, priority call-outs.'],
        'industrial-plumbing' => ['Industrial Plumbing Services', 'Industrial plumbing services for businesses across the East Rand. Larger-scale installations, repairs and compliance work. PIRB registered.'],
    ];

    $areas_data = [
        'brackendowns' => ['Brackendowns', 'Plumber in Brackendowns — our home base. 24/7 emergency plumbing, leak detection, geyser repairs and drain cleaning. Fast response, no call-out fee.', 'Brackendowns is our home base, so response times here are the fastest we offer — often well under our 30-minute target for a genuine emergency. We know the area\'s older single-storey homes and their original plumbing well, which means faster, more accurate diagnosis on burst pipes and ageing geysers than a plumber unfamiliar with the local housing stock.'],
        'alberton' => ['Alberton', 'Plumber in Alberton. Professional plumbing services including geyser repairs, leak detection, drain cleaning. PIRB registered. Call 073 537 6298.', 'Alberton\'s residential streets range from older established homes near the CBD to newer townhouse complexes further out, so our Alberton call-outs cover everything from replacing decades-old pipework to servicing modern geysers and complex-wide water systems. Being based just up the road in Brackendowns means we\'re usually on-site well inside our 30-minute target.'],
        'brackenhurst' => ['Brackenhurst', 'Plumber in Brackenhurst. Emergency plumbing, geyser replacements, drain clearing and general maintenance. No call-out fee. Call 073 537 6298.', 'Brackenhurst\'s larger stands and mature gardens often mean longer pipe runs and tree roots near drainage lines — a common cause of the recurring blocked drains we\'re called out for here. We carry drain camera equipment on every Brackenhurst job so we can show you exactly where root ingress or pipe damage is before any digging starts.'],
        'meyersdal' => ['Meyersdal', 'Plumber in Meyersdal. Burst pipe repairs, geyser installation and leak detection for Meyersdal\'s larger estate homes. No call-out fee. Call 073 537 6298.', 'Meyersdal\'s larger estate homes typically run bigger geyser and pressure systems than older suburbs nearby, and many residents ask us about backup water tanks for load-shedding and outage cover. We supply and install water backup tanks and pressure pumps alongside our usual geyser and leak-detection work for Meyersdal\'s estate and cluster-home residents.'],
        'new-redruth' => ['New Redruth', 'Plumber in New Redruth. Geyser repairs, drain cleaning and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'New Redruth is one of Alberton\'s older, well-established suburbs, and most of our call-outs here involve ageing plumbing reaching the end of its working life — corroded pipes, tired old geysers, and toilets that have been patched one too many times. We replace rather than patch where it will save you a repeat call-out down the line.'],
        'florentia' => ['Florentia', 'Plumber in Florentia, Alberton. Emergency plumbing, geyser repairs and drain unblocking for homes and businesses. No call-out fee. Call 073 537 6298.', 'Florentia is one of Alberton\'s established light-industrial areas, so alongside residential work we handle commercial plumbing for the businesses and workshops based here — grease trap servicing, industrial drain camera inspections, and larger-scale pipe repairs sized for commercial premises rather than a typical home.'],
        'randhart' => ['Randhart', 'Plumber in Randhart. Burst pipe repairs, geyser installation and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Randhart\'s mix of freestanding homes and smaller complexes means our call-outs here split fairly evenly between individual homeowners and body corporates managing shared plumbing infrastructure. We offer maintenance contracts for Randhart complexes wanting scheduled servicing instead of waiting for the next emergency.'],
        'alrode' => ['Alrode', 'Plumber in Alrode. Industrial and commercial plumbing services for Alrode\'s business and light industrial properties. PIRB registered. Call 073 537 6298.', 'Alrode is one of the East Rand\'s major industrial nodes, and our work here is almost entirely commercial — grease trap cleaning for food-service tenants, compliance-focused industrial pipe installations, and scheduled maintenance contracts for factories and warehouses that can\'t afford unplanned downtime.'],
        'albertsdal' => ['Albertsdal', 'Plumber in Albertsdal. Geyser repairs, leak detection and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Albertsdal is a quieter, established Alberton suburb, and most of our call-outs are routine maintenance rather than dramatic emergencies — geyser servicing before it fails outright, drain cleaning before a blockage becomes a flood. We\'re happy to do the preventative work most plumbers only get called for after something\'s already gone wrong.'],
        'verwoerdpark' => ['Verwoerdpark', 'Plumber in Verwoerdpark. Emergency plumbing, drain cleaning and geyser installation. No call-out fee. Call 073 537 6298.', 'Verwoerdpark residents call us most often for geyser installations and drain work, and being just minutes from Brackendowns means we can usually fit in a same-day inspection rather than the multi-day wait some plumbers quote. We give an upfront price before starting, not an estimate that grows once the job is underway.'],
        'albemarle' => ['Albemarle', 'Plumber in Albemarle, Germiston. Burst pipe repairs, geyser repairs and drain specialists. No call-out fee. Call 073 537 6298.', 'Albemarle sits in Germiston\'s older residential belt, where many homes still have their original plumbing from decades back. We regularly find and replace deteriorating pipework here before it fails catastrophically, and our drain camera inspections are particularly useful on Albemarle\'s older sewer connections.'],
        'dinwiddie' => ['Dinwiddie', 'Plumber in Dinwiddie, Germiston. Geyser installation, leak detection and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Dinwiddie is a settled residential pocket of Germiston, and our call-outs here are a mix of geyser replacements and general maintenance for homeowners who\'ve been in the same house for years. We know the area well enough to give a realistic same-day arrival window rather than a vague \'sometime today\'.'],
        'mayberry-park' => ['Mayberry Park', 'Plumber in Mayberry Park. Emergency plumbing and geyser repairs for Mayberry Park homes. No call-out fee. Call 073 537 6298.', 'Mayberry Park\'s older housing stock means geyser failures and ageing pipework are the most common reason we\'re called out here. We stock the geyser brands and sizes most common in Mayberry Park homes on our vans, so same-day replacement is usually possible rather than a multi-day special order.'],
        'germiston' => ['Germiston', 'Plumber in Germiston. 24/7 emergency plumbing, geyser repairs, drain cleaning across Germiston. PIRB registered. Call 073 537 6298.', 'Germiston has long been one of Ekurhuleni\'s major industrial and rail hubs, so our Germiston work spans both residential homes and the commercial and industrial premises the town is known for — from a household geyser repair to grease trap servicing and industrial pipe work for a Germiston-based business.'],
        'boksburg' => ['Boksburg', 'Plumber in Boksburg. Emergency plumbing, geyser repairs, blocked drains and leak detection on the East Rand. 24/7 service, no call-out fee.', 'Boksburg is one of the East Rand\'s largest and most established towns, and our call-outs here range from older homes near the CBD needing pipe replacements to newer developments further out needing standard installations. Whichever part of Boksburg you\'re in, we quote a straight price before starting — no surprises once the job is done.'],
        'edenvale' => ['Edenvale', 'Plumber in Edenvale. Emergency plumbing, leak repairs, geyser installation and drain unblocking. Fast response. No call-out fee.', 'Edenvale\'s proximity to OR Tambo means a good number of our call-outs here are from homeowners renting out rooms or whole properties short-term, where a plumbing emergency needs sorting fast so a guest isn\'t left without water. We prioritise same-day emergency response for exactly this reason.'],
        'bedfordview' => ['Bedfordview', 'Plumber in Bedfordview. Geyser repairs, drain specialists and general plumbing maintenance for homes and offices. No call-out fee. Call 073 537 6298.', 'Bedfordview\'s homes and office parks near the N3 tend to run higher-spec plumbing fittings than older suburbs nearby, and we carry the parts and expertise to service them properly rather than force a generic replacement. We work with both homeowners and the office and commercial properties Bedfordview is known for.'],
        'glenvista' => ['Glenvista', 'Plumber in Glenvista. Geyser replacements, drain specialists and leak detection. No call-out fee. Call 073 537 6298.', 'Glenvista\'s hillier terrain means drainage and pipe-slope issues come up more often here than in flatter suburbs — water finding the wrong path is a common cause of the damp patches and drain problems we get called out for. Our drain camera inspections let us pinpoint exactly where the problem sits before any digging.'],
        'palm-ridge' => ['Palm Ridge', 'Plumber in Palm Ridge, Alberton. Burst pipe repairs, geyser installation and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Palm Ridge is a residential Alberton suburb where most of our work is the everyday plumbing every household eventually needs — geyser servicing, blocked drains, the odd burst pipe. We keep call-outs here straightforward and reasonably priced, with no call-out fee regardless of how simple or complex the job turns out to be.'],
        'henley-on-klip' => ['Henley-on-Klip', 'Plumber in Henley-on-Klip. Plumbing services for riverside homes and smallholdings — geyser repairs, leak detection, drain work. Call 073 537 6298.', 'Henley-on-Klip\'s riverside smallholdings and weekend homes often have older or non-standard plumbing setups compared to a typical suburban house, and it\'s common for a property to sit empty for stretches between visits — exactly when small leaks turn into big problems unnoticed. We\'re happy to travel out for Henley-on-Klip call-outs and diagnose setups a city-suburb plumber might not be used to.'],
        'springs' => ['Springs', 'Plumber in Springs. Emergency plumbing, geyser repairs and drain cleaning across Springs and the wider East Rand. No call-out fee. Call 073 537 6298.', 'Springs\' older housing stock, much of it dating back to the town\'s mining-era growth, means we regularly deal with ageing pipework and geysers well past their expected lifespan. We\'d rather tell you honestly that a repair is a stopgap and a replacement is coming soon than quietly patch the same fault twice.'],
        'brakpan' => ['Brakpan', 'Plumber in Brakpan. 24/7 emergency plumbing, geyser installation and blocked drains. PIRB registered. Call 073 537 6298.', 'Brakpan, like much of the older East Rand, has plenty of homes running original plumbing installed decades ago. Burst pipes and failing geysers are our most common Brakpan call-outs, and we carry enough stock on our vans to handle a same-day replacement rather than leaving you without hot water for days.'],
        'benoni' => ['Benoni', 'Plumber in Benoni. Geyser repairs, leak detection and drain cleaning for Benoni homes and businesses. No call-out fee. Call 073 537 6298.', 'Benoni is one of the East Rand\'s larger, older towns, and our call-outs here cover the full range from routine geyser servicing to full bathroom plumbing renovations. Whether it\'s an older home near the town centre or a newer property further out, we quote a clear price upfront.'],
        'nigel' => ['Nigel', 'Plumber in Nigel. Emergency plumbing, geyser replacements and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Nigel is a smaller East Rand town, and we don\'t let that mean a slower response — the same 24/7 emergency service and no call-out fee policy applies here as everywhere else we cover. Most Nigel call-outs are geyser repairs and general plumbing maintenance for long-standing homeowners.'],
        'impala-park' => ['Impala Park', 'Plumber in Impala Park, Boksburg. Burst pipe repairs, geyser repairs and drain specialists. No call-out fee. Call 073 537 6298.', 'Impala Park is a settled residential pocket of Boksburg, and our most common call-outs here are geyser repairs and blocked drains for homeowners who\'ve been in the same house for years. We know the area well enough to give a realistic arrival window rather than a vague estimate.'],
        'dawn-park' => ['Dawn Park', 'Plumber in Dawn Park, Boksburg. Geyser installation, leak detection and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Dawn Park residents call us mostly for geyser installations and general plumbing maintenance, and being a short drive from our Brackendowns base means we can usually fit in a same-day inspection. We give an upfront price before any work starts, not an estimate that grows once we\'re on-site.'],
        'bartlett' => ['Bartlett', 'Plumber in Bartlett, Boksburg. Emergency plumbing and geyser repairs for Bartlett homes. No call-out fee. Call 073 537 6298.', 'Bartlett\'s older homes mean ageing pipework and geysers reaching the end of their working life are common reasons for our call-outs here. We carry drain camera equipment and enough stock on our vans to handle most Bartlett jobs same-day rather than requiring a return visit.'],
        'sunward-park' => ['Sunward Park', 'Plumber in Sunward Park, Boksburg. Geyser repairs, drain cleaning and general plumbing maintenance. No call-out fee. Call 073 537 6298.', 'Sunward Park\'s hillier streets and established gardens mean tree-root drainage issues come up regularly, alongside the usual geyser and pipe work every suburb needs. Our drain camera inspections let us show you exactly what\'s causing a recurring blockage before any digging starts.'],
        'selcourt' => ['Selcourt', 'Plumber in Selcourt, Springs. Burst pipe repairs, geyser installation and leak detection. No call-out fee. Call 073 537 6298.', 'Selcourt is a residential pocket of Springs where most of our work is routine — geyser servicing, drain cleaning, the occasional burst pipe — for homeowners who\'ve called us more than once and know what to expect. No call-out fee applies here the same as everywhere else we service.'],
        'van-dyk-park' => ['Van Dyk Park', 'Plumber in Van Dyk Park, Boksburg. Emergency plumbing, geyser repairs and drain specialists. No call-out fee. Call 073 537 6298.', 'Van Dyk Park residents call us mainly for emergency plumbing and geyser repairs, and being part of our regular Boksburg coverage area means response times here are consistent rather than an afterthought. We quote a clear price before starting and stand behind the work with a full guarantee.'],
    ];

        foreach ($services_data as $slug => $data) {
        // Match on 'any' status, not just 'publish' — matching publish-only
        // meant every page load would re-insert a brand new duplicate post
        // for any page an editor had intentionally set to draft/private,
        // since the check couldn't see it and assumed it didn't exist yet.
        $existing = get_posts(['name'=>$slug,'post_type'=>'gp_service','post_status'=>'any','numberposts'=>1]);
        if (empty($existing)) {
            $id = wp_insert_post(['post_title'=>$data[0],'post_name'=>$slug,'post_status'=>'publish','post_type'=>'gp_service','post_excerpt'=>$data[1]]);
            if ($id) update_post_meta($id, 'gp_meta_desc', $data[1]);
        }
    }

    foreach ($areas_data as $slug => $data) {
        $existing = get_posts(['name'=>$slug,'post_type'=>'gp_area','post_status'=>'any','numberposts'=>1]);
        if (empty($existing)) {
            $post_args = ['post_title'=>$data[0],'post_name'=>$slug,'post_status'=>'publish','post_type'=>'gp_area','post_excerpt'=>$data[1]];
            if (isset($data[2])) $post_args['post_content'] = '<p>' . esc_html($data[2]) . '</p>';
            $id = wp_insert_post($post_args);
            if ($id) update_post_meta($id, 'gp_meta_desc', $data[1]);
        }
    }

    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'gp_create_all_pages');
// Not hooked to 'init' anymore — running a get_posts()-per-area existence
// check plus potential wp_insert_post() on every single request (including
// every REST API call) is what caused runaway duplicate creation on
// 247plumbersgp the moment any one of these posts wasn't in 'publish'
// status. Page/post creation only needs to happen once, on theme
// activation.

// ── CUSTOMIZER ─────────────────────────────────────────────────────────────────
function gp_customizer($wp_customize) {
    $wp_customize->add_panel('gp_panel',['title'=>'Business Details','priority'=>30]);
    $wp_customize->add_section('gp_contact',['title'=>'Contact & Social Links','panel'=>'gp_panel']);
    $fields = [
        'gp_phone'    =>['Phone Number (display)',       GP_PHONE],
        'gp_whatsapp' =>['WhatsApp Number (intl format)',GP_PHONE_RAW],
        'gp_email'    =>['Email Address',                GP_EMAIL],
        'gp_facebook' =>['Facebook Page URL',            GP_FB],
        'gp_instagram'=>['Instagram Profile URL',        GP_IG],
        'gp_tiktok'   =>['TikTok Profile URL',           GP_TIKTOK],
        'gp_google'   =>['Google Business Profile URL',  GP_GOOGLE],
        'gp_review'   =>['Google Review Link',           GP_REVIEW],
        'gp_maps'     =>['Google Maps Embed URL',        ''],
    ];
    foreach ($fields as $id=>$cfg) {
        $wp_customize->add_setting($id,['default'=>$cfg[1],'sanitize_callback'=>'sanitize_text_field']);
        $wp_customize->add_control($id,['label'=>$cfg[0],'section'=>'gp_contact','type'=>'text']);
    }

    // ── ADS & TRACKING SECTION ──
    $wp_customize->add_section('gp_tracking',['title'=>'Ads & Tracking','panel'=>'gp_panel','description'=>'Paste your Google Analytics 4 and Google Ads IDs here. Leave blank until you have them — nothing breaks either way.']);
    $tracking_fields = [
        'gp_ga4_id'            =>['GA4 Measurement ID (e.g. G-XXXXXXXXXX)',''],
        'gp_ads_id'            =>['Google Ads Conversion ID (e.g. AW-XXXXXXXXXX)',''],
        'gp_ads_label_call'    =>['Ads Conversion Label — Phone Calls',''],
        'gp_ads_label_form'    =>['Ads Conversion Label — Form Submits',''],
        'gp_call_tracking_num' =>['Google Forwarding Number (optional, for call tracking)',''],
    ];
    foreach ($tracking_fields as $id=>$cfg) {
        $wp_customize->add_setting($id,['default'=>$cfg[1],'sanitize_callback'=>'sanitize_text_field']);
        $wp_customize->add_control($id,['label'=>$cfg[0],'section'=>'gp_tracking','type'=>'text']);
    }
}
add_action('customize_register','gp_customizer');

// ── CONTACT FORM HANDLER ───────────────────────────────────────────────────────
function gp_handle_form() {
    if (!isset($_POST['gp_nonce']) || !wp_verify_nonce($_POST['gp_nonce'],'gp_contact')) return;
    $name    = sanitize_text_field($_POST['gp_name']    ?? '');
    $contact = sanitize_text_field($_POST['gp_contact'] ?? '');
    $service = sanitize_text_field($_POST['gp_service'] ?? '');
    $msg     = sanitize_textarea_field($_POST['gp_msg'] ?? '');
    $to      = get_theme_mod('gp_email', get_option('admin_email'));
    wp_mail($to, "Quote Request from $name", "Name: $name\nContact: $contact\nService: $service\nMessage:\n$msg");
    wp_redirect(add_query_arg('sent','1', wp_get_referer())); exit;
}
add_action('admin_post_nopriv_gp_contact','gp_handle_form');
add_action('admin_post_gp_contact',       'gp_handle_form');

// ── ADMIN HELPER: Reset button to re-create pages ─────────────────────────────
// Visit: yoursite.co.za/wp-admin/?gp_reset=1 to force re-create all pages
function gp_admin_reset() {
    if (is_admin() && isset($_GET['gp_reset']) && current_user_can('manage_options')) {
        delete_option('gp_pages_v4');
        delete_option('gp_flushed_v4');
        delete_option('gp_flushed_v5');
        delete_option('gp_flushed_v6');
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init','gp_admin_reset');
