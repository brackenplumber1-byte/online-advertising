<?php
/**
 * Mondeor Plumbing Services — functions.php v1.0
 * Built from the proven 247plumbersgp architecture: gp_area/gp_service
 * custom post types, auto-generated titles/meta/schema, Yoast-aware SEO
 * fallbacks, responsive grids, legacy-URL redirect handling.
 * Phone: 078 300 2813
 */

// ── CONSTANTS ──────────────────────────────────────────────────────────────────
define('GP_PHONE',    '078 300 2813');
define('GP_PHONE_RAW','27783002813');
define('GP_EMAIL',    'info@mondeorplumbingservices.co.za');
define('GP_FB',       'https://www.facebook.com/mondeorplumbingservices');
define('GP_IG',       '');
define('GP_YT',       '');
define('GP_GOOGLE',   'https://share.google/f5kLfSwUzo1ec6Qom');
define('GP_REVIEW',   'https://g.page/r/CcLgHJKPQX3bEAI/review');
define('GP_SITE_NAME','Mondeor Plumbing Services');

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
    'burst-pipe-repairs'        => 'Burst Water Pipe Repairs',
    'geyser-replacements'       => 'Geyser Replacements',
    'geyser-repair'             => 'Geyser Repair',
    'gutters-downpipes'         => 'Gutters & Downpipe Systems',
    'plumbing-maintenance'      => 'General Plumbing Maintenance',
    'grease-trap-cleaning'      => 'Grease Trap Cleaning',
    'leak-detection'            => 'Leak Detection',
    'drain-specialists'         => 'Drain Specialists',
    'drain-camera-inspections'  => 'Drain Camera Inspections',
    'heat-pumps'                => 'Heat Pumps',
    'gas-geyser-installations'  => 'Gas Geyser Supply & Installations',
    'water-filtration'          => 'Water Filtration & Purification Systems',
    'water-backup-tanks'        => 'Water Backup Tanks',
    'maintenance-contracts'     => 'Maintenance Contracts',
    'industrial-plumbing'       => 'Industrial Plumbing Services',
    'toilet-repairs'            => 'Toilet Repairs',
    'bathroom-plumbing'         => 'Bathroom Plumbing',
]));

define('GP_AREAS', serialize([
    'mondeor' => 'Mondeor',
    'kibler-park' => 'Kibler Park',
    'meredale' => 'Meredale',
    'ormonde' => 'Ormonde',
    'ridgeway' => 'Ridgeway',
    'winchester-hills' => 'Winchester Hills',
    'bassonia' => 'Bassonia',
    'glenvista' => 'Glenvista',
    'rosettenville' => 'Rosettenville',
    'turffontein' => 'Turffontein',
    'meyersdal' => 'Meyersdal',
    'brackendowns' => 'Brackendowns',
    'brackenhurst' => 'Brackenhurst',
    'aeroton' => 'Aeroton',
    'mulbarton' => 'Mulbarton',
    'la-rochelle' => 'La Rochelle',
    'regents-park' => 'Regents Park',
    'village-main' => 'Village Main',
    'forest-hill' => 'Forest Hill',
    'tulisa-park' => 'Tulisa Park',
    'linmeyer' => 'Linmeyer',
    'naturena' => 'Naturena',
    'moffat-view' => 'Moffat View',
    'southgate' => 'Southgate',
    'city-deep' => 'City Deep',
    'kenilworth' => 'Kenilworth',
    'comet' => 'Comet',
    'rangeview' => 'Rangeview',
    'booysens' => 'Booysens',
    'booysens-reserve' => 'Booysens Reserve',
    'crown-gardens' => 'Crown Gardens',
    'crown-mines' => 'Crown Mines',
    'denver' => 'Denver',
    'eastcliff' => 'Eastcliff',
    'geldenhuis' => 'Geldenhuis',
    'glenanda' => 'Glenanda',
    'glenesk' => 'Glenesk',
    'grasmere' => 'Grasmere',
    'lakeside' => 'Lakeside',
    'ophirton' => 'Ophirton',
    'rossmore' => 'Rossmore',
    'south-hills' => 'South Hills',
    'suideroord' => 'Suideroord',
    'the-hill' => 'The Hill',
    'townsview' => 'Townsview',
    'robertsham' => 'Robertsham',
    'oakdene' => 'Oakdene',
    'kenmere' => 'Kenmere',
    'new-centre' => 'New Centre',
    'selby' => 'Selby',
    'berea' => 'Berea',
    'bertrams' => 'Bertrams',
    'bez-valley' => 'Bez Valley',
    'jeppestown' => 'Jeppestown',
    'judiths-paarl' => 'Judith\'s Paarl',
    'kensington' => 'Kensington',
    'malvern' => 'Malvern',
    'malvern-east' => 'Malvern East',
    'cyrildene' => 'Cyrildene',
    'bruma' => 'Bruma',
    'observatory' => 'Observatory',
    'troyeville' => 'Troyeville',
    'belgravia' => 'Belgravia',
    'city-and-suburban' => 'City and Suburban',
    'yeoville' => 'Yeoville',
    'bellevue' => 'Bellevue',
    'bellevue-east' => 'Bellevue East',
    'lorentzville' => 'Lorentzville',
    'doornfontein' => 'Doornfontein',
    'new-doornfontein' => 'New Doornfontein',
    'fairview' => 'Fairview',
    'marshalltown' => 'Marshalltown',
    'fordsburg' => 'Fordsburg',
    'mayfair' => 'Mayfair',
    'vrededorp' => 'Vrededorp',
    'newtown' => 'Newtown',
    'industria' => 'Industria',
    'cottesloe' => 'Cottesloe',
    'alberton-north' => 'Alberton North',
    'new-redruth' => 'New Redruth',
    'verwoerdpark' => 'Verwoerdpark',
    'randhart' => 'Randhart',
    'florentia' => 'Florentia',
    'wadeville' => 'Wadeville',
    'elandsfontein' => 'Elandsfontein',
    'primrose' => 'Primrose',
    'delville' => 'Delville',
    'dawnview' => 'Dawnview',
    'crosby' => 'Crosby',
    'pageview' => 'Pageview',
    'ferreirasdorp' => 'Ferreirasdorp',
    'cleveland' => 'Cleveland',
    'heriotdale' => 'Heriotdale',
    'coronationville' => 'Coronationville',
    'brixton' => 'Brixton',
    'auckland-park' => 'Auckland Park',
    'milpark' => 'Milpark',
    'linden' => 'Linden',
]));

define('GP_AREA_TIER', serialize([
    'mondeor' => 1,
    'kibler-park' => 1,
    'meredale' => 1,
    'ormonde' => 1,
    'ridgeway' => 1,
    'winchester-hills' => 1,
    'bassonia' => 1,
    'glenvista' => 1,
    'rosettenville' => 1,
    'turffontein' => 1,
    'meyersdal' => 2,
    'brackendowns' => 2,
    'brackenhurst' => 2,
    'aeroton' => 2,
    'mulbarton' => 2,
    'la-rochelle' => 2,
    'regents-park' => 2,
    'village-main' => 2,
    'forest-hill' => 2,
    'tulisa-park' => 2,
    'linmeyer' => 3,
    'naturena' => 3,
    'moffat-view' => 3,
    'southgate' => 3,
    'city-deep' => 3,
    'kenilworth' => 3,
    'comet' => 3,
    'rangeview' => 3,
    'booysens' => 1,
    'booysens-reserve' => 1,
    'crown-gardens' => 1,
    'crown-mines' => 1,
    'denver' => 1,
    'eastcliff' => 1,
    'geldenhuis' => 1,
    'glenanda' => 1,
    'glenesk' => 1,
    'grasmere' => 1,
    'lakeside' => 1,
    'ophirton' => 1,
    'rossmore' => 1,
    'south-hills' => 1,
    'suideroord' => 1,
    'the-hill' => 1,
    'townsview' => 1,
    'robertsham' => 1,
    'oakdene' => 1,
    'kenmere' => 1,
    'new-centre' => 1,
    'selby' => 1,
    'berea' => 2,
    'bertrams' => 2,
    'bez-valley' => 2,
    'jeppestown' => 2,
    'judiths-paarl' => 2,
    'kensington' => 2,
    'malvern' => 2,
    'malvern-east' => 2,
    'cyrildene' => 2,
    'bruma' => 2,
    'observatory' => 2,
    'troyeville' => 2,
    'belgravia' => 2,
    'city-and-suburban' => 2,
    'yeoville' => 2,
    'bellevue' => 2,
    'bellevue-east' => 2,
    'lorentzville' => 2,
    'doornfontein' => 2,
    'new-doornfontein' => 2,
    'fairview' => 2,
    'marshalltown' => 2,
    'fordsburg' => 2,
    'mayfair' => 2,
    'vrededorp' => 2,
    'newtown' => 2,
    'industria' => 2,
    'cottesloe' => 2,
    'alberton-north' => 3,
    'new-redruth' => 3,
    'verwoerdpark' => 3,
    'randhart' => 3,
    'florentia' => 3,
    'wadeville' => 3,
    'elandsfontein' => 3,
    'primrose' => 3,
    'delville' => 3,
    'dawnview' => 3,
    'crosby' => 3,
    'pageview' => 3,
    'ferreirasdorp' => 3,
    'cleveland' => 3,
    'heriotdale' => 3,
    'coronationville' => 3,
    'brixton' => 3,
    'auckland-park' => 3,
    'milpark' => 3,
    'linden' => 3,
]));

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
// Response-time claim varies by how far the suburb actually is from our
// Mondeor base (see GP_AREA_TIER) — avoids promising the same 30-minute
// response to a suburb 20km away as to one 3km away.
function gp_area_tier($slug) {
    $tiers = unserialize(GP_AREA_TIER);
    return $tiers[$slug] ?? 2;
}
// Picks a handful of same-tier (similarly-distant) areas first, then fills
// from the rest — keeps the "nearby areas" link block a genuinely nearby,
// reasonably sized list instead of dumping all 97 other suburb pages onto
// every single area page.
function gp_nearby_areas($slug, $all_areas, $max = 8) {
    $tier = gp_area_tier($slug);
    $same_tier = [];
    $others = [];
    foreach ($all_areas as $k => $v) {
        if ($k === $slug) continue;
        if (gp_area_tier($k) === $tier) {
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
function gp_area_response_time($slug) {
    switch (gp_area_tier($slug)) {
        case 1: return '30 minutes';
        case 3: return 'the hour';
        default: return '45 minutes';
    }
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
    wp_enqueue_style('gp-fonts','https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800;900&display=swap',[],null);
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
        return 'Mondeor Plumbing Services | 24/7 Plumber Mondeor & Johannesburg South';
    }
    if ($wp_query->is_front_page() || $wp_query->is_home()) {
        return 'Mondeor Plumbing Services | 24/7 Plumber Mondeor & Johannesburg South';
    }
    if ($wp_query->is_singular('gp_service')) {
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        return $name . ' | Mondeor Plumbing Services';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Plumber in ' . $area . ' | 24/7 Service | Mondeor Plumbing Services';
    }
    if ($wp_query->is_singular('post')) {
        $t = get_the_title();
        if (mb_strlen($t) > 50) $t = mb_substr($t, 0, 47) . '...';
        return $t . ' | Mondeor Plumbing Services';
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing Articles & Guides | Mondeor Plumbing Services';
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
        return 'PIRB registered plumbers serving Mondeor, Kibler Park, Meredale, Ormonde and Johannesburg South. 24/7 emergency plumbing, no call-out fee.';
    }
    if ($wp_query->is_singular('gp_service')) {
        $services = unserialize(GP_SERVICES);
        $slug = get_post_field('post_name', get_the_ID());
        $name = $services[$slug] ?? get_the_title();
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return $name . ' across Mondeor and Johannesburg South. Available 24/7, no call-out fee, PIRB registered plumbers. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('gp_area')) {
        $area = get_post_meta(get_the_ID(), 'gp_area_name', true) ?: get_the_title();
        return 'Need a plumber in ' . $area . '? We offer 24/7 emergency plumbing, geyser repairs & drain cleaning. No call-out fee. Call ' . gp_phone() . '.';
    }
    if ($wp_query->is_singular('post')) {
        $excerpt = get_the_excerpt();
        if ($excerpt) return wp_trim_words($excerpt, 28);
        return wp_trim_words(get_the_content(), 28);
    }
    if ($wp_query->is_page('articles')) {
        return 'Plumbing tips and guides for Mondeor and Johannesburg South homeowners — geysers, leaks, drains and more, from the team at Mondeor Plumbing Services.';
    }
    return 'PIRB registered plumbers serving Mondeor and Johannesburg South. 24/7 emergency plumbing, no call-out fee. Call ' . gp_phone() . '.';
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
    return get_template_directory_uri() . '/assets/images/mondeor-geyser-installation.jpg';
});

function gp_seo_meta() {
    $has_seo_plugin = gp_seo_plugin_active();

    echo '<meta name="geo.region" content="ZA-GP">'."\n";
    echo '<meta name="geo.placename" content="Mondeor, Johannesburg South">'."\n";

    if (!$has_seo_plugin) {
        echo '<meta name="robots" content="index, follow">'."\n";
        echo '<link rel="canonical" href="'.esc_url(get_permalink()).'">'."\n";

        // Meta description — was missing site-wide, flagged by Ahrefs on every
        // page (54 pages with no description). Built per page-type below so
        // every page gets something specific, never the generic fallback.
        $desc = gp_build_meta_description();
        echo '<meta name="description" content="'.esc_attr($desc).'">'."\n";
        echo '<meta property="og:description" content="'.esc_attr($desc).'">'."\n";

        // og:url — get_permalink() returns false on the front page when it's
        // the posts index rather than a static page, which left this empty
        // there. home_url(add_query_arg(...)) covers every context.
        $current_url = is_singular() ? get_permalink() : home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? '/'));

        echo '<meta property="og:type" content="website">'."\n";
        echo '<meta property="og:title" content="'.esc_attr(gp_build_page_title()).'">'."\n";
        echo '<meta property="og:url" content="'.esc_url($current_url).'">'."\n";
        echo '<meta property="og:locale" content="en_ZA">'."\n";

        // og:image / twitter:image — was missing on every single page (no
        // fallback existed at all, unlike description/title above). Use the
        // post's own featured image where one is set, otherwise a branded
        // default share image, so every page always has one.
        $og_image = (is_singular() && has_post_thumbnail()) ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
        if (!$og_image) $og_image = home_url('/wp-content/uploads/2026/08/mondeor-og-default.png');
        echo '<meta property="og:image" content="'.esc_url($og_image).'">'."\n";
        echo '<meta property="og:image:width" content="1200">'."\n";
        echo '<meta property="og:image:height" content="630">'."\n";
        echo '<meta name="twitter:card" content="summary_large_image">'."\n";
        echo '<meta name="twitter:image" content="'.esc_url($og_image).'">'."\n";
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
        'name'=>'Mondeor Plumbing Services',
        'url'=>home_url('/'),
        'telephone'=>'+27783002813',
        'priceRange'=>'$$',
        'description'=>'Professional plumbing company based in Mondeor, serving Johannesburg South. Available 24/7. No call-out fee. PIRB registered.',
        'address'=>['@type'=>'PostalAddress','streetAddress'=>'10 Boswell Ave','addressLocality'=>'Mondeor','addressRegion'=>'Gauteng','postalCode'=>'2095','addressCountry'=>'ZA'],
        // NOTE: verify against the exact Google Maps pin for 10 Boswell Ave,
        // Mondeor before publishing — this replaces coordinates that were
        // pointing to Midrand (leftover from the 247plumbersgp template).
        'geo'=>['@type'=>'GeoCoordinates','latitude'=>-26.2822,'longitude'=>27.9832],
        'openingHoursSpecification'=>[['@type'=>'OpeningHoursSpecification','dayOfWeek'=>['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],'opens'=>'00:00','closes'=>'23:59']],
        'areaServed'=>[['@type'=>'City','name'=>'Mondeor'],['@type'=>'City','name'=>'Kibler Park'],['@type'=>'City','name'=>'Meredale'],['@type'=>'City','name'=>'Ormonde'],['@type'=>'City','name'=>'Ridgeway'],['@type'=>'City','name'=>'Winchester Hills'],['@type'=>'City','name'=>'Bassonia'],['@type'=>'City','name'=>'Meyersdal'],['@type'=>'City','name'=>'Brackendowns'],['@type'=>'City','name'=>'Brackenhurst'],['@type'=>'City','name'=>'Aeroton'],['@type'=>'City','name'=>'Glenvista'],['@type'=>'City','name'=>'Mulbarton'],['@type'=>'City','name'=>'Turffontein'],['@type'=>'City','name'=>'Rangeview'],['@type'=>'City','name'=>'La Rochelle'],['@type'=>'City','name'=>'Rosettenville'],['@type'=>'City','name'=>'Regents Park'],['@type'=>'City','name'=>'Village Main'],['@type'=>'City','name'=>'Forest Hill'],['@type'=>'City','name'=>'Tulisa Park'],['@type'=>'City','name'=>'Linmeyer'],['@type'=>'City','name'=>'Naturena'],['@type'=>'City','name'=>'Moffat View'],['@type'=>'City','name'=>'Southgate'],['@type'=>'City','name'=>'City Deep'],['@type'=>'City','name'=>'Kenilworth'],['@type'=>'City','name'=>'Comet']],
        'sameAs'=>array_values(array_filter([gp_fb(), gp_ig(), GP_YT, gp_google()])),
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
            'author'=>['@type'=>'Organization','name'=>'Mondeor Plumbing Services'],
            'publisher'=>['@type'=>'Organization','name'=>'Mondeor Plumbing Services','logo'=>['@type'=>'ImageObject','url'=>get_template_directory_uri().'/assets/images/logo.png']],
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
        'geyser-repair-vs-replacement'   => ['Geyser Repair vs Replacement Guide',  'page-geyser-repair-vs-replacement.php'],
        'plumbing-emergency-gauteng'     => ['Plumbing Emergency What to Do',    'page-plumbing-emergency-gauteng.php'],
    ];

    foreach ($pages as $slug => $data) {
        // Check any status, not just 'publish' — same reasoning as the
        // gp_create_all_pages() fix above: a drafted page shouldn't look
        // "missing" to a function that recreates it on every page load.
        $existing = get_page_by_path($slug, OBJECT, 'page', ['publish', 'draft', 'pending', 'private', 'future', 'trash']);
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

    // Common leftover URLs from the previous version of this site — update
    // this map once you know the old site's actual indexed URLs (check
    // Google Search Console's Pages report, same process used for
    // 247plumbersgp) so any existing ranking/backlink value transfers
    // instead of dying as a duplicate or a dead 404.
    $legacy_url_map = [
        'about-us'               => '/#contact',
        'about'                  => '/#contact',
        'contact-us'             => '/#contact',
        'contact'                => '/#contact',
        'sample-page'            => '/',
        'category/uncategorized' => '/articles/',
        'home'                   => '/',
    ];
    if (isset($legacy_url_map[$path])) {
        wp_redirect(home_url($legacy_url_map[$path]), 301);
        exit;
    }

    // Defensive catch-all: if a duplicate "plumber-in-{area}" page ever
    // appears (dated post-permalink or otherwise) for a known service area,
    // redirect straight to the canonical area page rather than letting it
    // compete as duplicate content. Same pattern that fixed this exact
    // problem on 247plumbersgp.
    if (preg_match('#^(?:\d{4}/\d{2}/\d{2}/)?plumber(?:s)?-in-([a-z-]+)/?$#', $path, $m)) {
        $areas_check = unserialize(GP_AREAS);
        if (isset($areas_check[$m[1]])) {
            wp_redirect(home_url('/areas/' . $m[1] . '/'), 301);
            exit;
        }
    }

    // Areas removed from the declared Google Business Profile service area
    // (07-2026 correction) — if these were already created on a prior
    // upload, redirect them to the nearest still-active area rather than
    // leaving them live as undeclared duplicate content.
    $removed_areas_map = [
        'areas/robertsham'  => '/areas/mondeor/',
        'areas/turffontein' => '/areas/mondeor/',
        'areas/suideroord'  => '/areas/mondeor/',
        'areas/glenanda'    => '/areas/kibler-park/',
        'areas/booysens'    => '/areas/aeroton/',
    ];
    if (isset($removed_areas_map[$path])) {
        wp_redirect(home_url($removed_areas_map[$path]), 301);
        exit;
    }
}
add_action('template_redirect', 'gp_legacy_area_redirects', 1);

// ── AUTO-CREATE ALL SERVICE & AREA POSTS ──────────────────────────────────────
// Runs on theme switch and on every init — safe to run repeatedly because
// each area/service is checked individually before creating, so no duplicates.
function gp_create_all_pages() {

    $services_data = [
        'burst-pipe-repairs' => ['Burst Water Pipe Repairs', 'Burst water pipe repairs in Mondeor and Johannesburg South. Fast response, no call-out fee, PIRB registered. Call 078 300 2813.'],
        'geyser-replacements' => ['Geyser Replacements', 'Geyser replacements across Mondeor and Johannesburg South. All brands, same-day service where possible. PIRB compliance certificates. Call 078 300 2813.'],
        'gutters-downpipes' => ['Gutters & Downpipe Systems', 'Gutter and downpipe installation and repair in Mondeor and Johannesburg South. Stop overflow and water damage before the rainy season. Call 078 300 2813.'],
        'plumbing-maintenance' => ['General Plumbing Maintenance', 'General plumbing maintenance for homes and businesses in Mondeor and Johannesburg South. Scheduled check-ups that catch problems early. Call 078 300 2813.'],
        'grease-trap-cleaning' => ['Grease Trap Cleaning', 'Grease trap cleaning for restaurants and commercial kitchens in Johannesburg South. Compliant, scheduled servicing. Call 078 300 2813 for a quote.'],
        'leak-detection' => ['Leak Detection', 'Leak detection in Mondeor and Johannesburg South. Hidden water and pipe leaks found fast using proper equipment, not guesswork. Call 078 300 2813.'],
        'drain-specialists' => ['Drain Specialists', 'Drain specialists serving Mondeor and Johannesburg South. Blocked, slow or smelly drains cleared properly the first time. Call 078 300 2813.'],
        'drain-camera-inspections' => ['Drain Camera Inspections', 'Drain camera inspections in Mondeor and Johannesburg South. See exactly what\'s wrong before any digging starts. Call 078 300 2813 to book.'],
        'heat-pumps' => ['Heat Pumps', 'Heat pump supply and installation in Mondeor and Johannesburg South. Energy-efficient hot water for homes and businesses. Call 078 300 2813.'],
        'gas-geyser-installations' => ['Gas Geyser Supply & Installations', 'Gas geyser supply and installation in Mondeor and Johannesburg South. Certified installs, compliance paperwork included. Call 078 300 2813.'],
        'water-filtration' => ['Water Filtration & Purification Systems', 'Water filtration and purification systems installed across Mondeor and Johannesburg South. Cleaner water at every tap. Call 078 300 2813 for options.'],
        'maintenance-contracts' => ['Maintenance Contracts', 'Plumbing maintenance contracts for homes, complexes and businesses in Johannesburg South. Scheduled servicing, priority call-outs. Call 078 300 2813.'],
        'industrial-plumbing' => ['Industrial Plumbing Services', 'Industrial plumbing services for businesses across Johannesburg South. Larger-scale installations, repairs and compliance work. Call 078 300 2813.'],
        'geyser-repair' => ['Geyser Repair', 'Geyser repair specialists in Mondeor and Johannesburg South. Electric, gas and solar geysers repaired — often same day. No call-out fee. Call 078 300 2813.'],
        'water-backup-tanks' => ['Water Backup Tanks', 'Water backup tank installation in Mondeor and Johannesburg South. JoJo tanks, pressure pumps, full supply and install. Call 078 300 2813.'],
        'toilet-repairs' => ['Toilet Repairs', 'Toilet repairs in Mondeor and Johannesburg South. Blocked, running or leaking toilets fixed fast. No call-out fee. Call 078 300 2813.'],
        'bathroom-plumbing' => ['Bathroom Plumbing', 'Bathroom plumbing in Mondeor and Johannesburg South — taps, basins, showers and full renovations. No call-out fee. Call 078 300 2813.'],
    ];

    $areas_data = [
        'mondeor' => ['Mondeor', 'Plumber in Mondeor. Burst pipes, geyser replacements, drain clearing and general plumbing maintenance. No call-out fee. PIRB registered. Call 078 300 2813.', 'Mondeor is our home turf — we know the area\'s older housing stock well, and geyser replacements plus burst pipe repairs are our most common call-outs here.'],
        'kibler-park' => ['Kibler Park', 'Plumber in Kibler Park. Reliable burst pipe repairs, geyser replacements and drain clearing. No call-out fee, fast response. Call 078 300 2813.', 'Kibler Park\'s established homes keep our drain and pipe repair teams busy year-round, alongside scheduled maintenance for residents who want to stay ahead of problems.'],
        'meredale' => ['Meredale', 'Plumber in Meredale. Emergency burst pipe repairs, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Meredale\'s mix of family homes means our team covers everything from routine maintenance to burst pipe emergencies, usually with same-day response.'],
        'ormonde' => ['Ormonde', 'Plumber in Ormonde. Industrial and residential plumbing — burst pipes, drain specialists, geyser replacements. No call-out fee. Call 078 300 2813.', 'Ormonde\'s mix of residential streets and nearby commercial/industrial nodes means we handle both home plumbing emergencies and larger industrial plumbing jobs in the same area.'],
        'ridgeway' => ['Ridgeway', 'Plumber in Ridgeway. Fast response for burst pipes, geyser replacements and blocked drains. No call-out fee. Call 078 300 2813.', 'Ridgeway residents call us most often for geyser replacements and drain clearing — we keep common tank sizes in stock for same-day swaps.'],
        'winchester-hills' => ['Winchester Hills', 'Plumber in Winchester Hills. Leak detection, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Winchester Hills\' hilly terrain means water pressure issues are common — we check and adjust pressure as part of most geyser and pipe jobs here.'],
        'bassonia' => ['Bassonia', 'Plumber in Bassonia. Geyser replacements, leak detection and general plumbing maintenance for Bassonia homes. No call-out fee. Call 078 300 2813.', 'Bassonia\'s larger properties and gardens mean leak detection is one of our most requested services here, alongside standard geyser and drain work.'],
        'meyersdal' => ['Meyersdal', 'Plumber in Meyersdal, Alberton. Burst pipe repairs, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Meyersdal\'s larger estate-style properties mean irrigation-related leaks and bigger geyser systems are common call-outs — we carry the fittings for bigger household setups.'],
        'brackendowns' => ['Brackendowns', 'Plumber in Brackendowns, Alberton. Geyser replacements, drain specialists and burst pipe repairs. No call-out fee. Call 078 300 2813.', 'Brackendowns is an established residential suburb where ageing geysers and older pipework are common — we carry replacement parts suited to older fittings on every vehicle.'],
        'brackenhurst' => ['Brackenhurst', 'Plumber in Brackenhurst, Alberton. Burst pipe repairs, geyser replacements, drain clearing and plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Brackenhurst\'s mix of established family homes keeps our geyser replacement and general maintenance teams busy, with many residents on scheduled maintenance contracts.'],
        'aeroton' => ['Aeroton', 'Plumber in Aeroton, Johannesburg South. Industrial plumbing, grease trap cleaning and burst pipe repairs. No call-out fee. Call 078 300 2813.', 'Aeroton\'s industrial and commercial properties mean grease trap cleaning and industrial plumbing services are among our most requested work in this area.'],
        'glenvista' => ['Glenvista', 'Plumber in Glenvista, Johannesburg South. Geyser replacements, drain specialists and leak detection. No call-out fee. Call 078 300 2813.', 'Glenvista\'s hilly terrain means water pressure issues and drainage problems are common call-outs here — we check pressure as part of most geyser and pipe jobs.'],
        'mulbarton' => ['Mulbarton', 'Plumber in Mulbarton, Johannesburg South. Burst pipe repairs, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Mulbarton\'s established homes and larger gardens mean leak detection and geyser replacement are our most common call-outs in this suburb.'],
        'turffontein' => ['Turffontein', 'Plumber in Turffontein, Johannesburg South. Burst pipe repairs, drain specialists and geyser replacements for homes and businesses. No call-out fee. Call 078 300 2813.', 'Turffontein\'s established homes and nearby commercial properties mean our call-outs range from residential geyser work to small business plumbing maintenance.'],
        'rangeview' => ['Rangeview', 'Plumber in Rangeview. Burst pipe repairs, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Rangeview\'s residential streets keep our geyser replacement and general maintenance teams busy, with a mix of older and newer homes in the area.'],
        'la-rochelle' => ['La Rochelle', 'Plumber in La Rochelle, Johannesburg South. Drain specialists, geyser replacements and burst pipe repairs. No call-out fee. Call 078 300 2813.', 'La Rochelle\'s older housing stock means ageing pipework is a common find — we carry fittings suited to older homes on every vehicle.'],
        'rosettenville' => ['Rosettenville', 'Plumber in Rosettenville, Johannesburg South. Burst pipe repairs, drain specialists and geyser replacements. No call-out fee. Call 078 300 2813.', 'Rosettenville is one of Johannesburg South\'s older suburbs, and original pipework plus overdue geyser replacements are frequent finds on inspection here.'],
        'regents-park' => ['Regents Park', 'Plumber in Regents Park, Johannesburg South. Geyser replacements, drain specialists and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Regents Park\'s established residential streets mean routine maintenance and geyser servicing make up much of our work in this suburb.'],
        'village-main' => ['Village Main', 'Plumber in Village Main, Johannesburg South. Burst pipe repairs, industrial plumbing and drain specialists. No call-out fee. Call 078 300 2813.', 'Village Main\'s mix of residential and light industrial properties means our work here ranges from household plumbing to small business maintenance.'],
        'forest-hill' => ['Forest Hill', 'Plumber in Forest Hill, Johannesburg South. Geyser replacements, leak detection and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Forest Hill\'s established homes keep our geyser replacement and leak detection teams busy, particularly in the older sections of the suburb.'],
        'tulisa-park' => ['Tulisa Park', 'Plumber in Tulisa Park, Johannesburg South. Burst pipe repairs, drain specialists and geyser replacements. No call-out fee. Call 078 300 2813.', 'Tulisa Park\'s residential character means our most common call-outs are burst pipe repairs and scheduled geyser maintenance.'],
        'linmeyer' => ['Linmeyer', 'Plumber in Linmeyer, Johannesburg South. Geyser replacements, drain specialists and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Linmeyer\'s established family homes mean routine plumbing maintenance and geyser servicing are our most frequent jobs in this suburb.'],
        'naturena' => ['Naturena', 'Plumber in Naturena, Johannesburg South. Burst pipe repairs, drain specialists and geyser replacements. No call-out fee. Call 078 300 2813.', 'Naturena\'s mix of housing types means our call-outs range from standard residential repairs to larger complex maintenance work.'],
        'moffat-view' => ['Moffat View', 'Plumber in Moffat View, Johannesburg South. Geyser replacements, general plumbing maintenance and drain specialists. No call-out fee. Call 078 300 2813.', 'Moffat View\'s residential streets keep our team busy with routine maintenance and the occasional burst pipe emergency.'],
        'southgate' => ['Southgate', 'Plumber in Southgate, Johannesburg South. Burst pipe repairs, industrial plumbing and drain specialists. No call-out fee. Call 078 300 2813.', 'Southgate\'s mix of commercial and residential properties means we regularly handle both business plumbing maintenance and household call-outs.'],
        'city-deep' => ['City Deep', 'Plumber in City Deep, Johannesburg South. Industrial plumbing, grease trap cleaning and burst pipe repairs. No call-out fee. Call 078 300 2813.', 'City Deep\'s industrial and commercial properties mean industrial plumbing and grease trap cleaning are among our most requested services here.'],
        'kenilworth' => ['Kenilworth', 'Plumber in Kenilworth, Johannesburg South. Geyser replacements, drain specialists and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Kenilworth\'s established residential streets mean geyser servicing and routine maintenance make up much of our work in the area.'],
        'comet' => ['Comet', 'Plumber in Comet, Alberton. Burst pipe repairs, geyser replacements and general plumbing maintenance. No call-out fee. Call 078 300 2813.', 'Comet\'s residential character close to the Alberton border means our most common call-outs are geyser replacements and general maintenance.'],
    ];

    foreach ($services_data as $slug => $data) {
        // post_status=>'any' — checking 'publish' only meant a page that
        // was ever drafted/trashed looked "missing" and got recreated,
        // and running this on every 'init' request compounded that into
        // dozens of duplicates site-wide. Fixed here the same way it was
        // fixed on 247plumbersgp on 2026-08-02 (see SITES.md).
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
// The 'init' hook was removed — page creation only needs to run once, on
// theme activation. Running it on every request was what turned a single
// missed page into a duplicate on the very next page load.

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
