<?php
/**
 * 247 Plumbers GP — functions.php v1.2
 * v1.1: Fixed 404s on /mondeor/, /parkview/, /randburg/ (slug-collision bug),
 *       removed redundant custom rewrite/template_include system, added
 *       10 new suburb pages, added 301 redirects for legacy URLs.
 * v1.2: Fixed duplicate meta description bug, added smart Yoast fallback
 *       (auto title/description until manually overridden per page),
 *       expanded legacy redirects for old 2022-era indexed URLs, added
 *       6 auto-created blog posts (see inc/blog-posts.php).
 * Phone: 072 280 7603
 */

require_once get_template_directory() . '/inc/blog-posts.php';

// ── CONSTANTS ──────────────────────────────────────────────────────────────────
define('GP_PHONE',    '072 280 7603');
define('GP_PHONE_RAW','27722807603');
define('GP_EMAIL',    'info@247plumbersgp.co.za');
define('GP_FB',       'https://www.facebook.com/247plumbersgp');
define('GP_IG',       'https://www.instagram.com/247plumbersgp');
define('GP_YT',       'https://www.youtube.com/@247PlumbersGP');
define('GP_GOOGLE',   'https://share.google/4FiIr62rdgQuH1Nbw');
define('GP_REVIEW',   'https://share.google/4FiIr62rdgQuH1Nbw');

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
    ];
    return $icons[$slug] ?? 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z';
}

// Alberton, Bedfordview, Benoni, Boksburg, Brackendowns, Brakpan, Edenvale,
// Germiston and Glenvista are deliberately excluded here — those suburbs are
// already covered by our other client, Bracken Downs Plumber, and we don't
// want two managed sites competing for the same local searches.
define('GP_AREAS', serialize([
    'midrand'        => 'Midrand',
    'centurion'      => 'Centurion',
    'pretoria'       => 'Pretoria',
    'fourways'       => 'Fourways',
    'sandton'        => 'Sandton',
    'woodmead'       => 'Woodmead',
    'sunninghill'    => 'Sunninghill',
    'johannesburg'   => 'Johannesburg',
    'kempton-park'   => 'Kempton Park',
    'roodepoort'     => 'Roodepoort',
    'randburg'       => 'Randburg',
    'norwood'        => 'Norwood',
    'parkview'       => 'Parkview',
    'mondeor'        => 'Mondeor',
    'kibler-park'    => 'Kibler Park',
    'soweto'         => 'Soweto',
    'tembisa'        => 'Tembisa',
    'krugersdorp'    => 'Krugersdorp',
    'midstream'      => 'Midstream Estate',
    'pretoria-north' => 'Pretoria North',
    'centurion-east' => 'Centurion East',
    'bryanston'      => 'Bryanston',
    'rivonia'        => 'Rivonia',
    'melville'       => 'Melville',
    'rosebank'       => 'Rosebank',
    'waterkloof'     => 'Waterkloof',
    'menlyn'         => 'Menlyn',
    'montana'        => 'Montana',
    'moreleta-park'  => 'Moreleta Park',
]));

// ── HELPERS ────────────────────────────────────────────────────────────────────
// ── AREA REGIONS ──────────────────────────────────────────────────────────────
// Real geographic grouping, used so area pages only cross-link to genuinely
// nearby suburbs instead of all 37 others uniformly. That uniform pattern is
// exactly what was flattening internal link authority — every page linking
// to every other page equally means no page can stand out. Grouping by real
// region concentrates link relevance instead of diluting it evenly.
function gp_area_region($slug) {
    $regions = [
        'midrand'        => 'midrand',
        'midstream'      => 'midrand',
        'kempton-park'    => 'midrand',
        'sunninghill'    => 'midrand',
        'woodmead'       => 'midrand',
        'centurion'      => 'centurion',
        'centurion-east' => 'centurion',
        'pretoria'       => 'centurion',
        'pretoria-north' => 'centurion',
        'waterkloof'     => 'centurion',
        'menlyn'         => 'centurion',
        'montana'        => 'centurion',
        'moreleta-park'  => 'centurion',
        'sandton'        => 'sandton',
        'fourways'       => 'sandton',
        'bryanston'      => 'sandton',
        'rivonia'        => 'sandton',
        'rosebank'       => 'sandton',
        'johannesburg'   => 'joburg',
        'norwood'        => 'joburg',
        'parkview'       => 'joburg',
        'melville'       => 'joburg',
        'mondeor'        => 'joburg-south',
        'kibler-park'    => 'joburg-south',
        'glenvista'      => 'joburg-south',
        'soweto'         => 'joburg-south',
        'randburg'       => 'west-rand',
        'roodepoort'     => 'west-rand',
        'krugersdorp'    => 'west-rand',
        'tembisa'        => 'east-rand',
    ];
    return $regions[$slug] ?? 'midrand';
}

// Returns up to $max area slugs from the same region as $slug (excluding
// itself). Falls back to filling from the full list if a region is thin,
// so no area page ever shows an empty "nearby areas" section.
function gp_nearby_areas($slug, $all_areas, $max = 6) {
    $region = gp_area_region($slug);
    $same_region = [];
    $others = [];
    foreach ($all_areas as $k => $v) {
        if ($k === $slug) continue;
        if (gp_area_region($k) === $region) {
            $same_region[$k] = $v;
        } else {
            $others[$k] = $v;
        }
    }
    $result = array_slice($same_region, 0, $max, true);
    if (count($result) < $max) {
        $needed = $max - count($result);
        $result = $result + array_slice($others, 0, $needed, true);
    }
    return $result;
}

// Real Google reviews only, pulled from the business's actual Google
// Business Profile — do not add fabricated names/quotes here.
function gp_review_pool() {
    return [
        ['name' => 'Vis Naidu', 'text' => "It took a little over an hour from my call, to replacing a faulty pressure control valve. Charles was responsive, communicative, and a pleasure to deal with. I have no hesitation in recommending him."],
        ['name' => 'Jerrica Jenkins', 'text' => "The quality of work was exceptional, and the price was very reasonable. I was impressed with the attention to detail and the care taken to protect my property during the repair."],
        ['name' => "Complicated Lots", 'text' => "Can't recommend Charles enough \u{2014} reasonable pricing, on time, professional, job done, so pleased. He's saved in my phone, only plumber I'll call from now on."],
        ['name' => 'Alan Krinch', 'text' => "I contacted at 8am requesting same-day assistance for a drain pipe that needed cleaning and a blockage cleared. Very pleasant, and explained everything they were going to do to fix my problem."],
        ['name' => 'Matthew McCathie', 'text' => "247 Plumbers GP were fantastic. Charles arranged to assist me urgently. Quality service and very professional from him and his team. I highly recommend using them."],
        ['name' => 'Tracy Fu', 'text' => "Prompt response and problem resolved immediately! Very happy!"],
        ['name' => 'Hazel Kaye', 'text' => "Reliable quality service, would highly recommend."],
        ['name' => 'Herman Swart', 'text' => "Charles and his team are amazing."],
    ];
}

// Deterministic per-page rotation (same idea as $area_photo_pool below) so
// different pages show a different real combination instead of identical
// reviews everywhere, without picking randomly on every page load.
function gp_pick_reviews($seed, $count = 3) {
    $pool = gp_review_pool();
    $n = count($pool);
    $start = abs(crc32($seed)) % $n;
    $picked = [];
    for ($i = 0; $i < $count; $i++) {
        $picked[] = $pool[($start + $i) % $n];
    }
    return $picked;
}

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
        return '247 Plumbers GP | 24/7 Plumber Midrand & Gauteng';
    }
    if ($wp_query->is_front_page() || $wp_query->is_home()) {
        return '247 Plumbers GP | 24/7 Plumber Midrand & Gauteng';
    }
    if ($wp_query->is_singular('gp_service')) {
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        return $name . ' Midrand | 247 Plumbers GP';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Plumber in ' . $area . ' | 24/7 Service | 247 Plumbers GP';
    }
    if ($wp_query->is_singular('post')) {
        $t = get_the_title();
        if (mb_strlen($t) > 50) $t = mb_substr($t, 0, 47) . '...';
        return $t . ' | 247 Plumbers GP';
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing Articles & Guides | 247 Plumbers GP';
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
        return 'PIRB registered plumbers serving Midrand, Centurion, Pretoria, Sandton, Johannesburg and all of Gauteng. 24/7 emergency plumbing, no call-out fee.';
    }
    if ($wp_query->is_singular('gp_service')) {
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return $name . ' across Midrand and Gauteng. Available 24/7, no call-out fee, PIRB registered plumbers. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Looking for a plumber in ' . $area . '? 247 Plumbers GP offers 24/7 emergency plumbing, geyser repairs and drain cleaning. No call-out fee. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('post')) {
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return wp_trim_words(get_the_content(), 28);
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing tips and guides for Midrand, Johannesburg and Gauteng homeowners — geysers, leaks, drains and more, from the team at 247 Plumbers GP.';
    }
    return 'PIRB registered plumbers serving Midrand and all of Gauteng. 24/7 emergency plumbing, no call-out fee. Call ' . gp_phone() . '.';
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
// NOTE: This filter only fires when Yoast SEO is active — AIOSEO does NOT
// use this hook (confirmed: AIOSEO has its own separate, unrelated filter
// system). If AIOSEO is the active plugin, this code silently does nothing,
// which is exactly why 60 pages were flagged by Ahrefs for "Open Graph tags
// incomplete" (missing og:image specifically) — AIOSEO had no fallback image
// to use for area/service pages without a featured image set.
//
// THE ACTUAL FIX for AIOSEO: set a Default OG Image directly in its admin
// settings — AIOSEO → Social Networks → Facebook tab → "Default OG Image"
// (recommended minimum 1200×630px). This is AIOSEO's own supported,
// documented mechanism for exactly this situation, and is more reliable
// than chasing an internal plugin filter that could change between AIOSEO
// versions. Takes about 2 minutes, fixes all 60 pages at once.
add_filter('wpseo_opengraph_image', function($image) {
    if ($image) return $image; // a real image (e.g. featured image) already found
    return get_template_directory_uri() . '/assets/images/geyser-branded.jpg';
});

function gp_seo_meta() {
    $has_seo_plugin = gp_seo_plugin_active();

    echo '<meta name="geo.region" content="ZA-GP">'."\n";
    echo '<meta name="geo.placename" content="Midrand, Gauteng">'."\n";

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
    $schema = [
        '@context'=>'https://schema.org','@type'=>'Plumber',
        'name'=>'247 Plumbers GP',
        'url'=>home_url('/'),
        'telephone'=>'+27722807603',
        'priceRange'=>'$$',
        'description'=>'Professional plumbing company based in Midrand, serving all of Gauteng. Available 24/7. No call-out fee. PIRB registered.',
        'address'=>['@type'=>'PostalAddress','streetAddress'=>'Silkwood Complex, Berger Rd, Vorna Valley','addressLocality'=>'Midrand','addressRegion'=>'Gauteng','postalCode'=>'1686','addressCountry'=>'ZA'],
        'geo'=>['@type'=>'GeoCoordinates','latitude'=>-25.9892,'longitude'=>28.1267],
        'openingHoursSpecification'=>[['@type'=>'OpeningHoursSpecification','dayOfWeek'=>['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],'opens'=>'00:00','closes'=>'23:59']],
        'areaServed'=>[['@type'=>'City','name'=>'Midrand'],['@type'=>'City','name'=>'Centurion'],['@type'=>'City','name'=>'Pretoria'],['@type'=>'City','name'=>'Fourways'],['@type'=>'City','name'=>'Sandton'],['@type'=>'City','name'=>'Woodmead'],['@type'=>'City','name'=>'Sunninghill'],['@type'=>'City','name'=>'Johannesburg'],['@type'=>'City','name'=>'Kempton Park'],['@type'=>'City','name'=>'Roodepoort'],['@type'=>'City','name'=>'Randburg'],['@type'=>'City','name'=>'Boksburg'],['@type'=>'City','name'=>'Edenvale'],['@type'=>'City','name'=>'Alberton'],['@type'=>'City','name'=>'Germiston'],['@type'=>'City','name'=>'Brackendowns'],['@type'=>'City','name'=>'Norwood'],['@type'=>'City','name'=>'Parkview'],['@type'=>'City','name'=>'Mondeor'],['@type'=>'City','name'=>'Kibler Park'],['@type'=>'City','name'=>'Benoni'],['@type'=>'City','name'=>'Soweto'],['@type'=>'City','name'=>'Brakpan'],['@type'=>'City','name'=>'Tembisa'],['@type'=>'City','name'=>'Krugersdorp'],['@type'=>'City','name'=>'Midstream Estate'],['@type'=>'City','name'=>'Pretoria North'],['@type'=>'City','name'=>'Centurion East'],['@type'=>'City','name'=>'Bedfordview'],['@type'=>'City','name'=>'Bryanston'],['@type'=>'City','name'=>'Rivonia'],['@type'=>'City','name'=>'Melville'],['@type'=>'City','name'=>'Rosebank'],['@type'=>'City','name'=>'Glenvista'],['@type'=>'City','name'=>'Waterkloof'],['@type'=>'City','name'=>'Menlyn'],['@type'=>'City','name'=>'Montana'],['@type'=>'City','name'=>'Moreleta Park']],
        'sameAs'=>[gp_fb(), gp_ig(), GP_YT, gp_google()],
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
            'author'=>['@type'=>'Organization','name'=>'247 Plumbers GP'],
            'publisher'=>['@type'=>'Organization','name'=>'247 Plumbers GP','logo'=>['@type'=>'ImageObject','url'=>get_template_directory_uri().'/assets/images/logo.png']],
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
        'geyser-repair-vs-replacement'   => ['Geyser Repair vs Replacement Gauteng Guide',  'page-geyser-repair-vs-replacement.php'],
        'plumbing-emergency-gauteng'     => ['Plumbing Emergency in Gauteng What to Do',    'page-plumbing-emergency-gauteng.php'],
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
        // Found via Search Console export 12-Aug-2026 — stray dated
        // duplicate of the geyser-size post still indexed, competing with
        // the current post at the 07/17 permalink.
        '2026/07/10/how-to-choose-the-right-geyser-size' => '/2026/07/17/how-to-choose-the-right-geyser-size/',
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
        'emergency-plumbing'  => ['Emergency Plumbing',    '24/7 emergency plumber covering Midrand and all of Gauteng. Burst pipes, flooding, no water — fast response. No call-out fee. PIRB registered.'],
        'leak-detection'      => ['Leak Detection & Repair','Professional water and pool leak detection across Midrand, Fourways, Edenvale and Gauteng. Hidden leaks found fast. No call-out fee.'],
        'geyser-repair'       => ['Geyser Repair & Installation','Geyser repair and installation across Midrand and Gauteng. Gas, electric, solar — all brands. PIRB compliance certificates. Same-day service.'],
        'geyser-installation' => ['Geyser Installation',   'New geyser installation across Midrand and Gauteng. Electric, gas, solar and heat pump geysers supplied and fitted. PIRB certified.'],
        'drain-cleaning'      => ['Drain Cleaning & Unblocking','Drain and sewer cleaning across Midrand and Gauteng. High-pressure jetting, root removal. Fast response, no call-out fee.'],
        'pipe-repair'         => ['Pipe Repair & Replacement','Pipe repair and replacement across Midrand and Gauteng. Burst, corroded, cracked pipes fixed with SABS-approved materials. Guaranteed.'],
        'bathroom-plumbing'   => ['Bathroom & Kitchen Plumbing','Full bathroom and kitchen plumbing across Midrand and Gauteng. Renovations, taps, toilets, showers, basins. Guaranteed workmanship.'],
        'toilet-repairs'      => ['Toilet Repairs',        'Toilet repair specialists covering Midrand and Gauteng. Blocked, leaking, running toilets fixed fast. Same-day service. No call-out fee.'],
        'water-backup-tank'   => ['Water Backup Tank Installation','Water backup tank installation across Midrand and Gauteng. Never run out of water during outages. JoJo tanks, pressure pumps, full installation.'],
    ];

    $areas_data = [
        'midrand'      => ['Midrand',      'Plumber in Midrand — our home base. 24/7 emergency plumbing, leak detection, geyser repairs and drain cleaning. Fast response, no call-out fee.'],
        'centurion'    => ['Centurion',    'Plumber in Centurion — trusted local plumbers available 24/7. Emergency plumbing, geyser repairs, drain cleaning and more. No call-out fee.'],
        'pretoria'     => ['Pretoria',     'Plumber in Pretoria. Emergency plumbing, leaks, geysers, drains across Pretoria East, Menlyn and Hatfield. No call-out fee. Call 072 280 7603.'],
        'fourways'     => ['Fourways',     'Plumber in Fourways. Emergency plumbing, geyser installation, leak detection and drain unblocking. PIRB registered. Call 072 280 7603.'],
        'sandton'      => ['Sandton',      'Plumber in Sandton. 24/7 emergency plumbing for homes and businesses — burst pipes, geyser repairs and blocked drains. No call-out fee.'],
        'woodmead'     => ['Woodmead',     'Plumber in Woodmead. Emergency plumbing, leak repairs, geyser services for homes and office parks. Fast response, no call-out fee. Call 072 280 7603.'],
        'sunninghill'  => ['Sunninghill',  'Plumber in Sunninghill. 24/7 plumbing services for homes and townhouse complexes — burst pipes, drain cleaning, geyser repairs. PIRB registered.'],
        'johannesburg' => ['Johannesburg', 'Plumber in Johannesburg. Emergency plumbing, geyser repairs, leak detection and drain cleaning across Greater Johannesburg. Fast response. No call-out fee. Call 072 280 7603.'],
        'kempton-park' => ['Kempton Park', 'Plumber in Kempton Park. 24/7 emergency plumbing, geyser installation and blocked drains near OR Tambo. PIRB registered. No call-out fee.'],
        'roodepoort'   => ['Roodepoort',   'Plumber in Roodepoort. Emergency plumbing services including leak detection, geyser repairs, drain unblocking across the West Rand. Fast response. Call 072 280 7603.'],
        'randburg'     => ['Randburg',     'Plumber in Randburg. Professional plumbing services available 24/7 from Ferndale to Bromhof. Geyser repairs, leak detection, drain cleaning. No call-out fee.'],
        'boksburg'     => ['Boksburg',     'Plumber in Boksburg. Emergency plumbing, geyser repairs, blocked drains and leak detection on the East Rand. 24/7 service, no call-out fee.'],
        'edenvale'     => ['Edenvale',     'Plumber in Edenvale. Emergency plumbing, leak repairs, geyser installation and drain unblocking. Fast response. No call-out fee.'],
        'alberton'     => ['Alberton',     'Plumber in Alberton. Professional plumbing services including geyser repairs, leak detection, drain cleaning. PIRB registered. Call 072 280 7603.'],
        'germiston'    => ['Germiston',    'Plumber in Germiston. Emergency plumbing available 24/7 for homes and small businesses. Leak detection, geyser repairs, drain unblocking. No call-out fee.'],
        'brackendowns' => ['Brackendowns', 'Plumber in Brackendowns. 24/7 emergency plumbing, geyser repairs and drain cleaning for this established Alberton suburb. No call-out fee. Call 072 280 7603.', 'Brackendowns is a well-established residential suburb where many homes still run original 1980s and 90s plumbing — meaning ageing geysers and corroded pipework are common call-outs for us here. We carry replacement parts for most older fittings on every vehicle, so a repair rather than a full replacement is often possible.'],
        'norwood'      => ['Norwood',      'Plumber in Norwood. Geyser repairs, blocked drain clearing and burst pipe repairs for Norwood homes and apartments. PIRB registered. No call-out fee.', 'Norwood\'s mix of older houses and converted apartment blocks means our team regularly handles shared-pipe issues in sectional title buildings alongside standard residential plumbing. We work directly with body corporates when needed.'],
        'parkview'     => ['Parkview',     'Plumber in Parkview. Trusted local plumbing for Parkview\'s older homes — geyser descaling, leak detection and drain repairs. Fast response, no call-out fee.', 'Parkview\'s tree-lined streets and older housing stock often mean root intrusion into drain lines — one of the most common call-outs we get in this suburb. We use sewer camera inspection to confirm the cause before recommending a fix.'],
        'mondeor'      => ['Mondeor',      'Plumber in Mondeor. Emergency plumbing, geyser installation and drain unblocking for Mondeor residents. PIRB registered plumbers. Call 072 280 7603.', 'Mondeor residents most often call us for geyser installations and replacements — we keep common tank sizes in stock so same-day swaps are usually possible without a special order.'],
        'kibler-park'    => ['Kibler Park',  'Plumber in Kibler Park. Reliable plumbing services including burst pipe repair, geyser servicing and blocked drains. No call-out fee, fast response.', 'Kibler Park\'s established homes keep our drain cleaning and pipe repair teams busy year-round. We handle both emergency call-outs and scheduled maintenance visits for residents who want to stay ahead of problems.'],
        'benoni'         => ['Benoni',        'Plumber in Benoni. 24/7 emergency plumbing, geyser repairs and drain cleaning across Benoni and the East Rand. PIRB registered. No call-out fee. Call 072 280 7603.', 'Benoni\'s older residential areas and mix of freehold and sectional title properties mean we frequently handle both emergency burst pipe call-outs and planned geyser replacements here. The area\'s water infrastructure in some older suburbs tends to produce higher-than-average lime scale buildup, making geyser element replacement a common service request.'],
        'soweto'         => ['Soweto',        'Plumber in Soweto. Emergency plumbing, geyser repairs, drain cleaning and leak detection across Soweto. No call-out fee, 24/7 availability. Call 072 280 7603.', 'Soweto\'s diverse mix of housing — from older RDP homes to newer developments in areas like Mofolo, Diepkloof and Protea Glen — means we handle a wide range of plumbing needs, from basic pipe repairs to full geyser installations. We\'re familiar with the specific infrastructure challenges common to different parts of the area.'],
        'brakpan'        => ['Brakpan',       'Plumber in Brakpan. Fast emergency plumbing, geyser replacement and blocked drain clearing across Brakpan and surrounds. No call-out fee. PIRB registered.', 'Brakpan\'s older mining-era housing stock means corroded pipes and ageing geysers are among the most common call-outs we attend here. We carry stock for older geyser brands and pipe fittings that can be harder to source, so we can usually fix rather than replace on older systems.'],
        'tembisa'        => ['Tembisa',       'Plumber in Tembisa. 24/7 emergency plumbing, geyser repairs, drain unblocking and leak detection for Tembisa homes and businesses. No call-out fee. Call 072 280 7603.', 'Tembisa\'s rapid residential growth means newer plumbing installations alongside older existing infrastructure — we handle both. Emergency drain blockages and geyser failures are the most frequent call-outs we receive from this area.'],
        'krugersdorp'    => ['Krugersdorp',   'Plumber in Krugersdorp. Emergency plumbing, geyser installation, pipe repairs and drain cleaning across Krugersdorp and the West Rand. No call-out fee. PIRB registered.', 'Krugersdorp\'s established suburbs like Munsieville, Kenmare and Rant en Dal have older water infrastructure where we regularly attend to corroded pipes and pressure valve failures. We also cover newer developments in the wider West Rand area.'],
        'midstream'      => ['Midstream Estate', 'Plumber in Midstream Estate. Professional plumbing services for this premium Centurion estate — geyser repairs, leak detection, pipe work. No call-out fee. Call 072 280 7603.', 'Midstream Estate\'s newer homes and estate management structure mean we work closely with body corporates and estate managers on planned maintenance as well as emergency call-outs. Geyser installations and solar geyser upgrades are particularly common requests from residents here.'],
        'pretoria-north' => ['Pretoria North', 'Plumber in Pretoria North. 24/7 emergency plumbing, geyser repairs, blocked drains and leak detection across Pretoria North, Akasia and surrounds. No call-out fee.', 'Pretoria North and Akasia see high demand for geyser services due to the area\'s water hardness causing accelerated scale buildup on heating elements. We service all major geyser brands and issue PIRB compliance certificates on installation.'],
        'centurion-east' => ['Centurion East', 'Plumber in Centurion East. Emergency plumbing, geyser repairs, drain cleaning and pipe repairs in Centurion East including Highveld, Wierda Park and The Reeds. No call-out fee.', 'Centurion East\'s mix of older Highveld-era homes and newer Wierda Park and The Reeds developments means we handle everything from routine geyser maintenance to emergency burst pipe repairs across very different housing types within a short distance of each other.'],

        // ── 10 additional Johannesburg & Pretoria suburbs ──
        'bedfordview'   => ['Bedfordview',   'Plumber in Bedfordview. 24/7 emergency plumbing, geyser repairs and drain cleaning for Bedfordview homes and businesses. No call-out fee. PIRB registered. Call 072 280 7603.', 'Bedfordview\'s established homes and busy commercial nodes along Van Buuren and Bradford Road keep us attending to both routine maintenance and after-hours emergencies. We work with body corporates on nearby office parks as well as private homeowners.'],
        'bryanston'     => ['Bryanston',     'Plumber in Bryanston. Professional plumbing for Bryanston homes and estates — geyser installation, leak detection, drain unblocking. No call-out fee. Call 072 280 7603.', 'Bryanston\'s large properties and irrigation-heavy gardens mean underground leak detection is one of our most requested services in this suburb, alongside geyser servicing for bigger household hot water systems.'],
        'rivonia'       => ['Rivonia',       'Plumber in Rivonia. 24/7 emergency plumbing, geyser repairs and blocked drains for Rivonia homes and offices. No call-out fee. PIRB registered plumbers.', 'Rivonia\'s blend of residential streets and office parks near the M1 means our callouts range from home geyser failures to commercial washroom repairs, often on the same day.'],
        'melville'      => ['Melville',      'Plumber in Melville. Trusted local plumbing for Melville\'s character homes and apartments — leak repairs, geyser servicing, drain cleaning. No call-out fee.', 'Melville\'s older Johannesburg housing stock, much of it built last century, means ageing pipework and original geysers are common — our team carries fittings suited to older properties so repairs can usually be done without ripping out walls.'],
        'rosebank'      => ['Rosebank',      'Plumber in Rosebank. Emergency plumbing for Rosebank apartments, homes and businesses. Geyser repairs, leak detection, drain unblocking. No call-out fee. Call 072 280 7603.', 'Rosebank\'s mix of high-rise apartments and older homes means we regularly coordinate with body corporates and managing agents on shared-line issues, in addition to standard residential call-outs.'],
        'glenvista'     => ['Glenvista',     'Plumber in Glenvista. 24/7 emergency plumbing, geyser installation and drain cleaning for Glenvista and the greater Johannesburg south. No call-out fee.', 'Glenvista\'s hilly terrain means water pressure issues and gravity-fed drainage problems are common call-outs here — we test and adjust pressure valves as part of most geyser and pipe jobs in the area.'],
        'waterkloof'    => ['Waterkloof',    'Plumber in Waterkloof. Professional plumbing for Waterkloof and Waterkloof Ridge homes — geyser repairs, leak detection, bathroom plumbing. No call-out fee. Call 072 280 7603.', 'Waterkloof\'s large, established gardens and older embassy-era homes mean we often deal with mature tree root intrusion in drain lines alongside standard geyser and pipe work.'],
        'menlyn'        => ['Menlyn',        'Plumber in Menlyn. 24/7 emergency plumbing, geyser repairs and drain unblocking for Menlyn homes, apartments and businesses. No call-out fee. PIRB registered.', 'Menlyn\'s fast-growing mix of apartment developments and retail nodes means quick response times matter — we prioritise emergency call-outs here given the density of residents and businesses in a small area.'],
        'montana'       => ['Montana',       'Plumber in Montana. Emergency plumbing, geyser installation and blocked drain clearing for Montana and Pretoria North homes. No call-out fee. Call 072 280 7603.', 'Montana\'s newer residential estates alongside older freehold homes mean we handle everything from routine geyser servicing on new builds to repair work on ageing infrastructure in the older parts of the suburb.'],
        'moreleta-park' => ['Moreleta Park', 'Plumber in Moreleta Park. 24/7 emergency plumbing, geyser repairs and drain cleaning for Moreleta Park and greater Pretoria East. No call-out fee. PIRB registered.', 'Moreleta Park\'s many townhouse complexes and family homes keep our geyser and drain-cleaning teams busy — we\'re experienced working with both individual homeowners and complex trustees on shared plumbing infrastructure.'],
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
// every REST API call) is what caused runaway duplicate creation the
// moment any one of these posts wasn't in 'publish' status. Page/post
// creation only needs to happen once, on theme activation.

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
    $name     = sanitize_text_field($_POST['gp_name']     ?? '');
    $contact  = sanitize_text_field($_POST['gp_contact']  ?? '');
    $service  = sanitize_text_field($_POST['gp_service']  ?? '');
    $msg      = sanitize_textarea_field($_POST['gp_msg']  ?? '');
    // Present only on the Ads landing page — tags which paid campaign a
    // lead came from, so leads can actually be attributed back to a
    // specific campaign instead of all landing in one undifferentiated pile.
    $campaign = sanitize_text_field($_POST['gp_campaign'] ?? '');
    $to       = get_theme_mod('gp_email', get_option('admin_email'));
    $body     = "Name: $name\nContact: $contact\nService: $service\n";
    if ($campaign) $body .= "Ads campaign: $campaign\n";
    $body .= "Message:\n$msg";
    wp_mail($to, "Quote Request from $name", $body);
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
