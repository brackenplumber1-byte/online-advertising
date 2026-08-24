<?php
/**
 * 247 Renovations — functions.php v1.0
 * Construction & Home Renovation · Johannesburg & Gauteng
 * Phone/Email: SET VIA CUSTOMIZER after activation
 */

// ── CONSTANTS ──────────────────────────────────────────────────────────────────
define('RN_PHONE',    '073 537 6298');
define('RN_EMAIL',    'info@247renovations.co.za');
define('RN_WA_NUM',   '27735376298');
define('RN_DOMAIN',   'https://247renovations.co.za');
define('RN_BRAND',    '247 Renovations');

// Services: slug => [Page Title, Nav Label, Short description]
define('RN_SERVICES', serialize([
  'kitchen-renovations'   => ['Kitchen Renovations Johannesburg | 247 Renovations',  'Kitchen Renovations',   'Transform your kitchen with custom cabinetry, countertops, tiling and full kitchen remodels across Johannesburg.'],
  'bathroom-renovations'  => ['Bathroom Renovations Johannesburg | 247 Renovations',  'Bathroom Renovations',  'Full bathroom renovations — wet rooms, tiling, vanities, showers and complete bathroom makeovers in Johannesburg.'],
  'home-renovations'      => ['Home Renovations Johannesburg | 247 Renovations',      'Home Renovations',      'Full-home renovations and alterations. Open-plan conversions, extensions and complete interior transformations.'],
  'building-extensions'   => ['Building Extensions Johannesburg | 247 Renovations',   'Building Extensions',   'Add value to your property with professionally planned and built home extensions and additions.'],
  'roof-repairs-waterproofing' => ['Roof Repairs & Waterproofing Johannesburg | 247 Renovations', 'Roof & Waterproofing', 'Professional roof repairs, torch-on waterproofing, flat roof sealing and damp-proofing services in Johannesburg.'],
  'painting-plastering'   => ['Painting & Plastering Johannesburg | 247 Renovations', 'Painting & Plastering', 'Interior and exterior painting, plastering, skim coating and texture finishes by skilled contractors.'],
  'tiling-flooring'       => ['Tiling & Flooring Johannesburg | 247 Renovations',     'Tiling & Flooring',     'Professional tiling, wooden flooring, laminate, vinyl and polished concrete across Johannesburg.'],
  'paving-driveways'      => ['Paving & Driveways Johannesburg | 247 Renovations',    'Paving & Driveways',    'Concrete paving, brick paving, driveway resurfacing and landscaping paving services in Gauteng.'],
  'palisade-fencing'      => ['Palisade & Security Fencing Johannesburg | 247 Renovations', 'Palisade Fencing', 'Steel palisade fencing, electric fencing installation, palisade repairs and perimeter security solutions.'],
  'garage-conversions'    => ['Garage Conversions Johannesburg | 247 Renovations',    'Garage Conversions',    'Convert your garage into a living space, flat, office or entertainment area with full building compliance.'],
  'garden-flats'          => ['Garden Flats & Wendy Houses Johannesburg | 247 Renovations', 'Garden Flats',    'Build a garden flat, granny flat, or wendy house to add rental income and property value.'],
  'maintenance-repairs'   => ['General Building Maintenance Johannesburg | 247 Renovations', 'Maintenance & Repairs', 'General building maintenance, crack repairs, plaster repairs, gutters, ceiling repairs and handyman services.'],
  'granite-quartz-countertops' => ['Granite, Quartz &amp; Marble Countertops Johannesburg | 247 Renovations', 'Granite &amp; Quartz Countertops', 'Granite, quartz, marble and Caesarstone countertop supply and installation for kitchens and bathrooms across Johannesburg.'],
]));

// Areas: slug => Area Name
define('RN_AREAS', serialize([
  'renovations-sandton'           => 'Sandton',
  'renovations-randburg'          => 'Randburg',
  'renovations-fourways'          => 'Fourways',
  'renovations-midrand'           => 'Midrand',
  'renovations-roodepoort'        => 'Roodepoort',
  'renovations-honeydew'          => 'Honeydew',
  'renovations-northcliff'        => 'Northcliff',
  'renovations-bryanston'         => 'Bryanston',
  'renovations-lonehill'          => 'Lonehill',
  'renovations-greenside'         => 'Greenside',
  'renovations-parkhurst'         => 'Parkhurst',
  'renovations-melville'          => 'Melville',
  'renovations-florida'           => 'Florida',
  'renovations-constantia-kloof'  => 'Constantia Kloof',
  'renovations-krugersdorp'       => 'Krugersdorp',
  'renovations-weltevreden-park'  => 'Weltevreden Park',
  'renovations-strubensvalley'    => 'Strubensvalley',
  'renovations-little-falls'      => 'Little Falls',
  'renovations-wilgeheuwel'       => 'Wilgeheuwel',
  'renovations-radiokop'          => 'Radiokop',
  'renovations-helderkruin'       => 'Helderkruin',
  'renovations-ruimsig'           => 'Ruimsig',
]));

// ── HELPERS ────────────────────────────────────────────────────────────────────
function rn_phone()  { return get_theme_mod('rn_phone', RN_PHONE); }
function rn_email()  { return get_theme_mod('rn_email', RN_EMAIL); }
function rn_wa_num() { return get_theme_mod('rn_wa_num', RN_WA_NUM); }
function rn_review() { return get_theme_mod('rn_review', 'https://share.google/xuPZry4vooP7X08ak'); }
function rn_maps()   { return get_theme_mod('rn_maps', ''); }
function rn_plink()  {
    $p = preg_replace('/[^0-9]/', '', rn_phone());
    if (substr($p, 0, 1) === '0') $p = '27' . substr($p, 1);
    return 'tel:+' . $p;
}
function rn_wa_link($msg = 'Hi%2C+I%27d+like+a+free+quote+from+247+Renovations') {
    return 'https://wa.me/' . rn_wa_num() . '?text=' . $msg;
}
function rn_imgdir() { return get_template_directory_uri() . '/assets/images/'; }

// ── THEME SETUP ────────────────────────────────────────────────────────────────
function rn_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'rn_setup');

// ── ENQUEUE ASSETS ─────────────────────────────────────────────────────────────
function rn_assets() {
    wp_enqueue_style('rn-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0.0');
    wp_enqueue_script('rn-js',  get_template_directory_uri() . '/assets/js/main.js',  [], '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'rn_assets');

// ── FAVICON ────────────────────────────────────────────────────────────────────
function rn_favicon() {
    $imgdir = rn_imgdir();
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($imgdir . 'favicon-32.png') . '">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($imgdir . 'favicon-180.png') . '">' . "\n";
}
add_action('wp_head', 'rn_favicon', 0);

// ── SEO META + SCHEMA ──────────────────────────────────────────────────────────
function rn_seo_head() {
    $services = unserialize(RN_SERVICES);
    $areas    = unserialize(RN_AREAS);

    if (is_singular('rn_service')) {
        $post = get_post();
        $slug = get_post_field('post_name', $post->ID);
        $svc  = $services[$slug] ?? [get_the_title(), get_the_title(), ''];
        $desc = $svc[2] . ' Free quotes, workmanship guaranteed. Call ' . rn_phone() . '.';
        $kw   = str_replace('Johannesburg', '', $svc[0]) . ', johannesburg, gauteng, contractors, free quote';
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr($kw) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
        $schema = [
            '@context' => 'https://schema.org', '@type' => 'HomeAndConstructionBusiness',
            'name' => RN_BRAND . ' — ' . $svc[1],
            'provider' => ['@type' => 'HomeAndConstructionBusiness', 'name' => RN_BRAND, 'telephone' => '+27' . ltrim(rn_wa_num(), '27'), 'url' => home_url('/')],
            'areaServed' => ['@type' => 'City', 'name' => 'Johannesburg'],
            'description' => $desc,
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";

    } elseif (is_singular('rn_area')) {
        $area = get_post_meta(get_the_ID(), 'rn_area_name', true) ?: get_the_title();
        $desc = "247 Renovations offers professional renovation and building services in $area, Johannesburg. Kitchen renovations, bathroom renovations, roof repairs, extensions and more. Free quotes. Workmanship guaranteed.";
        echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta name="keywords" content="renovations ' . esc_attr(strtolower($area)) . ', builders ' . esc_attr(strtolower($area)) . ', kitchen bathroom renovations ' . esc_attr(strtolower($area)) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";

    } else {
        echo '<meta name="description" content="247 Renovations — Johannesburg\'s trusted renovation and building contractors. Kitchen renovations, bathroom renovations, home extensions, roofing, painting, tiling and more across Gauteng. Free quotes, workmanship guaranteed.">' . "\n";
        echo '<meta name="keywords" content="renovations johannesburg, home renovations johannesburg, kitchen renovations johannesburg, bathroom renovations johannesburg, building contractors johannesburg, renovation company gauteng">' . "\n";
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
        // LocalBusiness schema
        $schema = [
            '@context' => 'https://schema.org', '@type' => 'HomeAndConstructionBusiness',
            'name' => RN_BRAND,
            'url' => home_url('/'),
            'telephone' => '+27' . ltrim(rn_wa_num(), '27'),
            'email' => rn_email(),
            'priceRange' => '$$',
            'description' => 'Professional renovation and construction company serving all of Johannesburg and Gauteng. Kitchen and bathroom renovations, home extensions, roof repairs, painting, tiling and building maintenance.',
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Johannesburg', 'addressRegion' => 'Gauteng', 'addressCountry' => 'ZA'],
            'geo' => ['@type' => 'GeoCoordinates', 'latitude' => -26.2041, 'longitude' => 28.0473],
            'openingHoursSpecification' => [['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'], 'opens' => '07:00', 'closes' => '17:00'], ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Saturday', 'opens' => '08:00', 'closes' => '13:00']],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Johannesburg'], ['@type' => 'City', 'name' => 'Sandton'],
                ['@type' => 'City', 'name' => 'Randburg'],     ['@type' => 'City', 'name' => 'Fourways'],
                ['@type' => 'City', 'name' => 'Midrand'],      ['@type' => 'City', 'name' => 'Roodepoort'],
            ],
            'hasOfferCatalog' => ['@type' => 'OfferCatalog', 'name' => 'Renovation Services Johannesburg', 'itemListElement' => array_map(function($k, $v) {
                return ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $v[1] . ' Johannesburg']];
            }, array_keys($services), array_values($services))],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:locale" content="en_ZA">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
    echo '<meta name="geo.region" content="ZA-GP">' . "\n";
    echo '<meta name="geo.placename" content="Johannesburg, Gauteng">' . "\n";
    echo '<meta name="robots" content="index, follow, max-image-preview:large">' . "\n";
    if (is_singular(['rn_service', 'rn_area'])) {
        $type = is_singular('rn_service') ? 'Services' : 'Areas';
        $bc = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $type, 'item' => home_url('/') . '#' . strtolower($type)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => get_the_title(), 'item' => get_permalink()],
        ]];
        echo '<script type="application/ld+json">' . wp_json_encode($bc, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'rn_seo_head', 1);

// ── REGISTER CPTs ──────────────────────────────────────────────────────────────
function rn_register_cpts() {
    register_post_type('rn_service', [
        'labels'      => ['name' => 'Services', 'singular_name' => 'Service', 'add_new_item' => 'Add Service'],
        'public'      => true, 'has_archive' => true,
        'rewrite'     => ['slug' => 'services', 'with_front' => false],
        'supports'    => ['title', 'editor', 'excerpt', 'thumbnail'],
        'show_in_rest' => true, 'menu_icon' => 'dashicons-hammer',
    ]);
    register_post_type('rn_area', [
        'labels'      => ['name' => 'Areas', 'singular_name' => 'Area', 'add_new_item' => 'Add Area'],
        'public'      => true, 'has_archive' => true,
        'rewrite'     => ['slug' => 'areas', 'with_front' => false],
        'supports'    => ['title', 'editor', 'excerpt', 'thumbnail'],
        'show_in_rest' => true, 'menu_icon' => 'dashicons-location',
    ]);
}
add_action('init', 'rn_register_cpts');

// ── FLUSH REWRITE ──────────────────────────────────────────────────────────────
function rn_flush() {
    if (!get_option('rn_flushed_v1')) {
        rn_register_cpts();
        flush_rewrite_rules(false);
        update_option('rn_flushed_v1', true);
    }
}
add_action('init', 'rn_flush', 20);

// ── AUTO CREATE SERVICE + AREA PAGES ──────────────────────────────────────────
function rn_create_pages() {
    if (get_option('rn_pages_v1')) return;
    $services = unserialize(RN_SERVICES);
    $areas    = unserialize(RN_AREAS);

    foreach ($services as $slug => $data) {
        $exists = get_posts(['name' => $slug, 'post_type' => 'rn_service', 'post_status' => 'publish', 'numberposts' => 1]);
        if (empty($exists)) {
            $id = wp_insert_post(['post_title' => $data[0], 'post_name' => $slug, 'post_status' => 'publish', 'post_type' => 'rn_service', 'post_excerpt' => $data[2]]);
            if ($id) update_post_meta($id, 'rn_svc_slug', $slug);
        }
    }
    foreach ($areas as $slug => $name) {
        $exists = get_posts(['name' => $slug, 'post_type' => 'rn_area', 'post_status' => 'publish', 'numberposts' => 1]);
        if (empty($exists)) {
            $id = wp_insert_post([
                'post_title'   => "Renovations $name | 247 Renovations Johannesburg",
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'rn_area',
                'post_excerpt' => "247 Renovations provides professional renovation and building services in $name, Johannesburg. Kitchen renovations, bathroom renovations, roof repairs, painting, tiling and home extensions. Free quotes. Call us today.",
            ]);
            if ($id) update_post_meta($id, 'rn_area_name', $name);
        }
    }
    update_option('rn_pages_v1', true);
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'rn_create_pages');
add_action('init', 'rn_create_pages', 30);

// ── CUSTOMIZER ─────────────────────────────────────────────────────────────────
function rn_customizer($wp_customize) {
    $wp_customize->add_panel('rn_panel', ['title' => 'Business Details', 'priority' => 30]);
    $wp_customize->add_section('rn_contact', ['title' => 'Contact & Settings', 'panel' => 'rn_panel']);
    $fields = [
        'rn_phone'   => ['Phone Number',           RN_PHONE],
        'rn_wa_num'  => ['WhatsApp Number (intl)',  RN_WA_NUM],
        'rn_email'   => ['Email Address',           RN_EMAIL],
        'rn_review'  => ['Google Review Link',      '#'],
        'rn_maps'    => ['Google Maps Embed URL',   ''],
    ];
    foreach ($fields as $id => $cfg) {
        $wp_customize->add_setting($id, ['default' => $cfg[1], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $cfg[0], 'section' => 'rn_contact', 'type' => 'text']);
    }
}
add_action('customize_register', 'rn_customizer');

// ── CONTACT FORM ───────────────────────────────────────────────────────────────
function rn_handle_form() {
    if (!isset($_POST['rn_nonce']) || !wp_verify_nonce($_POST['rn_nonce'], 'rn_contact')) return;
    $name    = sanitize_text_field($_POST['rn_name']    ?? '');
    $phone   = sanitize_text_field($_POST['rn_phone']   ?? '');
    $service = sanitize_text_field($_POST['rn_service'] ?? '');
    $area    = sanitize_text_field($_POST['rn_area']    ?? '');
    $msg     = sanitize_textarea_field($_POST['rn_msg'] ?? '');
    wp_mail(rn_email(), "Renovation Quote Request — $name", "Name: $name\nPhone: $phone\nService: $service\nArea: $area\nMessage:\n$msg");
    wp_redirect(add_query_arg('sent', '1', wp_get_referer())); exit;
}
add_action('admin_post_nopriv_rn_contact', 'rn_handle_form');
add_action('admin_post_rn_contact',        'rn_handle_form');

// Admin reset: /wp-admin/?rn_reset=1
function rn_admin_reset() {
    if (is_admin() && isset($_GET['rn_reset']) && current_user_can('manage_options')) {
        delete_option('rn_pages_v1'); delete_option('rn_flushed_v1');
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'rn_admin_reset');
