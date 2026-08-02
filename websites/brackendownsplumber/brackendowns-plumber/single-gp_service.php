<?php get_header(); ?>
<?php while (have_posts()): the_post();
    $name     = get_the_title();
    $slug     = get_post_field('post_name', get_the_ID());
    $services = unserialize(GP_SERVICES);
    $imgdir   = get_template_directory_uri() . '/assets/images/';
    $svc_photos = [
        'emergency-plumbing'  => 'job-kitchen-tap.jpg',
        'leak-detection'      => 'job-water-meter-valve.jpg',
        'geyser-repair'       => 'job-geyser-roofspace.jpg',
        'geyser-installation' => 'job-ariston-install.jpg',
        'drain-cleaning'      => 'job-toilet-drain-snake.jpg',
        'pipe-repair'         => 'job-pipe-excavation.jpg',
        'bathroom-plumbing'   => 'job-geberit-toilet.jpg',
        'toilet-repairs'      => 'job-toilet-drain-snake.jpg',
        'water-backup-tank'   => 'photo-placeholder.svg',
        'gutters-downpipes'        => 'photo-placeholder.svg',
        'grease-trap-cleaning'     => 'photo-placeholder.svg',
        'drain-camera-inspections' => 'photo-placeholder.svg',
        'heat-pumps'               => 'photo-placeholder.svg',
        'water-filtration'         => 'photo-placeholder.svg',
        'maintenance-contracts'    => 'job-multi-geyser-db.jpg',
        'industrial-plumbing'      => 'job-trenching-elbow.jpg',
    ];
    $svc_photo = $svc_photos[$slug] ?? '';

    $content_map = [
        'emergency-plumbing' => [
            'tagline'  => 'Burst pipe? Flooding? No water? We respond within 30 minutes, day or night, every day of the year — no call-out fee.',
            'includes' => ['Burst & leaking pipes','Flooding & water damage','No hot water emergencies','Blocked sewer emergencies','Storm & rain damage plumbing','Gas leak response'],
            'reasons'  => ['On-site within 30 minutes in most areas','Available 24 hours, 7 days including public holidays','No call-out fee — you only pay for the work done','PIRB-registered plumbers on every job','Fully stocked vehicles for same-visit repairs'],
        ],
        'leak-detection' => [
            'tagline'  => 'Hidden leaks cause thousands in damage before you notice them. We find and fix them fast using modern detection equipment.',
            'includes' => ['Water meter leak checks','Underground pipe leaks','Wall and ceiling leaks','Slab leaks','Irrigation system leaks','Roof and gutter leaks'],
            'reasons'  => ['Non-invasive detection — no unnecessary wall breaking','Modern equipment pinpoints leaks accurately','Same-day repair in most cases','Full written report provided','Insurance claim documentation available'],
        ],
        'geyser-repair' => [
            'tagline'  => 'No hot water? Our geyser specialists diagnose and repair all brands — gas, electric and solar — often the same day.',
            'includes' => ['Electric geyser repair and replacement','Solar geyser repairs','Gas geyser servicing','Pressure valve replacement','Thermostat replacement','PIRB compliance certificates (CoC)'],
            'reasons'  => ['All geyser brands and types serviced','PIRB compliance certificate issued on completion','Same-day service available','Full system testing before sign-off','Insurance-approved work and documentation'],
        ],
        'geyser-installation' => [
            'tagline'  => 'Need a new geyser installed? We supply, install, and certify electric, gas, solar, and heat pump geysers — same day in most cases.',
            'includes' => ['Electric geyser installation','Solar geyser systems','Gas geyser installation','Heat pump water heaters','Geyser brackets and drip trays','PIRB compliance certificate (CoC)'],
            'reasons'  => ['All major brands available — we supply or fit-only','PIRB compliance certificate issued on completion','Same-day installation available in most cases','10-year tank warranty on selected brands','Full pressure and temperature testing before handover'],
        ],
        'drain-cleaning' => [
            'tagline'  => 'Slow drains or a total blockage — we clear it completely using high-pressure jetting, not just a temporary patch.',
            'includes' => ['Kitchen drain unblocking','Bathroom and shower drains','Blocked toilets','Main sewer line cleaning','Root intrusion removal','High-pressure hydro jetting'],
            'reasons'  => ['High-pressure water jetting equipment on every vehicle','CCTV camera drain inspection available','Permanent solutions — not just a temporary clearance','Commercial and residential service','Full cleanup after every job'],
        ],
        'pipe-repair' => [
            'tagline'  => 'Old, cracked, corroded, or burst pipes replaced properly — using SABS-approved materials, backed by our workmanship guarantee.',
            'includes' => ['Burst pipe emergency repair','Corroded pipe replacement','PVC, copper and CPVC piping','Underground pipe repair','Complete repiping','Full pressure testing after all repairs'],
            'reasons'  => ['SABS-approved materials only','Workmanship guarantee on all pipework','Minimal disruption to your home','Surface restoration after work completed','Full pressure testing after every repair'],
        ],
        'bathroom-plumbing' => [
            'tagline'  => 'From a dripping tap to a full bathroom renovation — installed to SANS standards and guaranteed for 12 months.',
            'includes' => ['Toilet installation and repair','Tap replacement and repair','Basin and sink installation','Shower fitting and repairs','Bath installation','Full bathroom renovations'],
            'reasons'  => ['Free quote and consultation','All work to SANS plumbing standards','Neat, clean workmanship guaranteed','12-month workmanship guarantee','Supply-and-fit or fit-only options available'],
        ],
        'toilet-repairs' => [
            'tagline'  => 'Running, blocked, or leaking toilet? We fix it fast — same-day service available, no call-out fee.',
            'includes' => ['Blocked toilet unblocking','Running toilet and cistern repair','Valve and ballcock replacement','Toilet seat replacement','Complete toilet installation','Dual-flush conversions'],
            'reasons'  => ['Same-day response available','No call-out fee — transparent pricing','All parts carried on our vehicles','Neat work with full cleanup after','12-month workmanship guarantee'],
        ],
        'water-backup-tank' => [
            'tagline'  => 'Never run out of water again. We install complete water backup tank systems — JoJo tanks, pressure pumps, and full plumbing integration.',
            'includes' => ['JoJo & plastic storage tank installation','Steel tank installation','Pressure pump installation & wiring','Header tank systems','Automatic switchover valves','Rainwater harvesting connections','Tank-to-geyser plumbing','Full system pressure testing'],
            'reasons'  => ['Complete supply-and-install service','All tank sizes available — 500L to 10,000L+','PIRB-registered installation on all plumbing','Pressure pump sizing and selection advice','Compatible with existing geyser and plumbing systems','Minimal disruption to your property','Workmanship guarantee on all work','After-sales support and maintenance available'],
        ],
        'gutters-downpipes' => [
            'tagline'  => 'Overflowing gutters and blocked downpipes cause real water damage. We install, repair and clear gutter systems before the next storm.',
            'includes' => ['Gutter installation and replacement','Downpipe installation and repair','Gutter cleaning and unblocking','Leaf guard fitting','Storm damage gutter repair','Fascia and soffit-mounted gutter fixing'],
            'reasons'  => ['Stops water damage before it starts','Neat, weatherproof installation','Free quote and consultation','Workmanship guarantee on all work','Available for homes, complexes and businesses','No call-out fee'],
        ],
        'grease-trap-cleaning' => [
            'tagline'  => 'Compliant, scheduled grease trap cleaning for restaurants and commercial kitchens across Brackendowns and the East Rand.',
            'includes' => ['Grease trap pump-outs','Scheduled cleaning contracts','Compliance-focused servicing','Odour and blockage prevention','Commercial kitchen drain checks','Correct waste disposal handling'],
            'reasons'  => ['Keeps your kitchen compliant and odour-free','Scheduled contracts available','Minimal disruption to kitchen operations','Experienced with commercial kitchens','Proper waste handling and disposal','No call-out fee'],
        ],
        'drain-camera-inspections' => [
            'tagline'  => 'See exactly what is wrong before any digging starts. Our drain camera inspections find the real problem, not just the symptoms.',
            'includes' => ['Full drain line camera inspection','Root intrusion detection','Pipe damage and collapse detection','Blockage location pinpointing','Pre-purchase drain inspections','Recorded footage provided'],
            'reasons'  => ['See the actual problem before quoting a fix','Avoids unnecessary digging or guesswork','Useful for pre-purchase property checks','Recorded footage provided for your records','Experienced reading older clay and PVC drain lines','No call-out fee'],
        ],
        'heat-pumps' => [
            'tagline'  => 'Energy-efficient hot water for your home or business, we supply and install heat pump systems built for South African conditions.',
            'includes' => ['Heat pump supply and installation','System sizing and selection advice','Integration with existing geyser plumbing','Electrical isolation and safety compliance','Servicing and maintenance','Warranty support'],
            'reasons'  => ['Genuine energy savings on hot water heating','Correctly sized for your household or business','PIRB-registered installation','Compatible with most existing plumbing setups','Workmanship guarantee on every installation','Free site assessment'],
        ],
        'water-filtration' => [
            'tagline'  => 'Cleaner water at every tap, we supply and install water filtration and purification systems suited to your home or business.',
            'includes' => ['Whole-house filtration systems','Under-counter filtration units','Water purification systems','Filter servicing and replacement','System sizing advice','Installation and integration with existing plumbing'],
            'reasons'  => ['Genuinely cleaner water, not just marketing claims','Systems sized correctly for your household','Professional installation and integration','Ongoing servicing and filter replacement available','Free quote and consultation','No call-out fee'],
        ],
        'maintenance-contracts' => [
            'tagline'  => 'Scheduled plumbing servicing for homes, complexes and businesses, priority call-outs and fewer surprises.',
            'includes' => ['Scheduled plumbing inspections','Priority emergency call-outs','Geyser and drain servicing','Body corporate and complex contracts','Commercial maintenance contracts','Detailed service reports'],
            'reasons'  => ['Priority booking ahead of non-contract clients','Predictable, budgeted maintenance costs','Fewer surprise emergencies over time','Experienced with residential and commercial clients','Flexible contract terms available','No call-out fee for contract clients'],
        ],
        'industrial-plumbing' => [
            'tagline'  => 'Larger-scale plumbing installations, repairs and compliance work for businesses across the East Rand.',
            'includes' => ['Industrial pipe installation and repair','Commercial drainage systems','Grease trap and waste systems','Compliance-focused installations','Large-scale leak detection and repair','Scheduled industrial maintenance'],
            'reasons'  => ['Experienced with commercial and industrial sites','PIRB-registered plumbers on every job','Minimal disruption to business operations','Compliance-focused workmanship','Scheduled and emergency service available','No call-out fee'],
        ],
    ];

    $c        = $content_map[$slug] ?? ['tagline'=>get_the_excerpt(),'includes'=>[],'reasons'=>[]];
    $inc_html = implode('', array_map(function($i) { return "<li>$i</li>"; }, $c['includes']));
    $why_html = implode('', array_map(function($r) { return "<li>$r</li>"; }, $c['reasons']));

    $other_svc = '';
    foreach ($services as $k => $v) {
        if ($k === $slug) continue;
        $p2  = get_posts(['name'=>$k,'post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1]);
        $url = $p2 ? get_permalink($p2[0]->ID) : home_url('/services/'.$k);
        $other_svc .= '<li><a href="'.esc_url($url).'">'.esc_html($v).'</a></li>';
    }

    // Cross-link to every area page — closes the gap where service pages
    // previously had no outbound links to the 20 suburb pages at all,
    // which was contributing to those pages showing as orphan pages.
    $areas = unserialize(GP_AREAS);
    $svc_area_links = '';
    foreach ($areas as $k => $v) {
        $p3  = get_posts(['name'=>$k,'post_type'=>'gp_area','post_status'=>'publish','numberposts'=>1]);
        $url = $p3 ? get_permalink($p3[0]->ID) : home_url('/areas/'.$k);
        $svc_area_links .= '<li><a href="'.esc_url($url).'">'.esc_html($name).' in '.esc_html($v).'</a></li>';
    }
?>

<!-- BREADCRUMB -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="<?php echo esc_url(home_url('/')); ?>" itemprop="item"><span itemprop="name">Home</span></a>
        <meta itemprop="position" content="1"/>
      </li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="<?php echo esc_url(home_url('/')); ?>#services" itemprop="item"><span itemprop="name">Services</span></a>
        <meta itemprop="position" content="2"/>
      </li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?php echo esc_html($name); ?></span>
        <meta itemprop="position" content="3"/>
      </li>
    </ol>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow"><?php echo esc_html($name); ?></div>
    <h1 class="display"><?php echo esc_html($name); ?> in<br>Alberton &amp; East Rand</h1>
    <p><?php echo esc_html($c['tagline']); ?> Fast, reliable, PIRB-registered. No call-out fee.</p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr(gp_phone_link()); ?>" class="btn btn--red">📞 Call <?php echo esc_html(gp_phone()); ?> Now</a>
      <a href="<?php echo esc_url(gp_wa_link()); ?>" target="_blank" rel="noopener" class="btn btn--ghost">WhatsApp Us</a>
    </div>
  </div>
</div>

<!-- TRUST BAR -->
<div class="trust-bar"><div class="container">
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>PIRB Registered</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 15h-1.5v-7h1.5v7zm0-9h-1.5V6.5h1.5V8z"/></svg>Available 24/7</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>No Call-Out Fee</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>4.9★ Google Rating</div>
</div></div>

<!-- SERVICE PHOTO -->
<?php if ($svc_photo): ?>
<div class="container" style="padding-top:32px">
  <img src="<?php echo esc_url($imgdir . $svc_photo); ?>" alt="<?php echo esc_attr($name); ?> — Brackendowns Plumber" style="width:100%;max-height:420px;object-fit:cover;border-radius:8px">
</div>
<?php endif; ?>

<!-- MAIN CONTENT -->
<div class="container">
  <div class="content-grid">
    <div class="content-body">

      <h2>Professional <?php echo esc_html($name); ?> in Alberton &amp; Across the East Rand</h2>
      <p>At Brackendowns Plumber, our PIRB-registered team delivers fast, reliable <?php echo esc_html(strtolower($name)); ?> services across Brackendowns, Alberton and the wider East Rand region. We're available 24 hours a day, 7 days a week — including weekends and public holidays.</p>
      <p>When you call us, you speak to a real plumber — not a call centre. We give you an honest, upfront quote before any work starts and stand behind everything we do with a full workmanship guarantee.</p>

      <h2>Our <?php echo esc_html($name); ?> Services Include</h2>
      <ul><?php echo $inc_html; ?></ul>

      <h2>Why Choose Brackendowns Plumber for <?php echo esc_html($name); ?>?</h2>
      <ul><?php echo $why_html; ?></ul>

      <?php if (get_the_content()): ?>
      <div><?php the_content(); ?></div>
      <?php endif; ?>

      <h3>How Much Does <?php echo esc_html($name); ?> Cost?</h3>
      <p>Every job is different — which is why we give you a free, no-obligation quote before starting any work. We never charge a call-out fee. Call <a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red);font-weight:700"><?php echo esc_html(gp_phone()); ?></a> for a fast quote now.</p>

      <?php
      $svc_extra_photos = [
        'emergency-plumbing'  => ['job-water-meter-valve.jpg', 'job-pipe-excavation.jpg'],
        'leak-detection'      => ['job-pipe-excavation.jpg', 'job-trenching-elbow.jpg'],
        'geyser-repair'       => ['job-multi-geyser-db.jpg', 'job-ariston-install.jpg'],
        'geyser-installation' => ['job-geyser-roofspace.jpg', 'job-multi-geyser-db.jpg'],
        'pipe-repair'         => ['job-trenching-elbow.jpg'],
        'bathroom-plumbing'   => ['job-kitchen-tap.jpg'],
        'toilet-repairs'      => ['job-geberit-toilet.jpg', 'job-toilet-drain-snake.jpg'],
        'drain-cleaning'      => ['job-trenching-elbow.jpg'],
      ];
      $extras = $svc_extra_photos[$slug] ?? [];
      if ($extras): ?>
      <div class="svc-extras-grid <?php echo count($extras) > 1 ? 'cols-2' : 'cols-1'; ?>">
        <?php foreach ($extras as $ep): ?>
        <img src="<?php echo esc_url($imgdir . $ep); ?>" alt="<?php echo esc_attr($name); ?> job photo — Brackendowns Plumber" style="width:100%;height:240px;object-fit:cover;border-radius:8px">
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <h3>Areas We Cover for <?php echo esc_html($name); ?></h3>
      <?php
      $areas_full = unserialize(GP_AREAS);
      $areas_full_names = implode(', ', array_values($areas_full));
      ?>
      <p>We provide <?php echo esc_html(strtolower($name)); ?> throughout <?php echo esc_html($areas_full_names); ?> and surrounding areas.</p>

      <div style="background:var(--off);border-left:4px solid var(--red);padding:20px 24px;margin:28px 0;border-radius:0 4px 4px 0">
        <h3 style="margin:0 0 8px">Need <?php echo esc_html($name); ?> Right Now?</h3>
        <p style="margin:0">Call <strong><a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red)"><?php echo esc_html(gp_phone()); ?></a></strong> — available 24/7, no call-out fee, on-site in 30 minutes.</p>
      </div>

      <h2>Other Plumbing Services We Offer</h2>
      <ul><?php echo $other_svc; ?></ul>

      <h2><?php echo esc_html($name); ?> Available Across Gauteng</h2>
      <p>We provide <?php echo esc_html(strtolower($name)); ?> in every area we cover. Find the page for your specific suburb below for local details and direct contact.</p>
      <ul class="svc-area-links-grid"><?php echo $svc_area_links; ?></ul>

    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<!-- REVIEW STRIP -->
<div class="review-strip">
  <div class="container">
    <h2 style="font-size:1.4rem;font-weight:800;color:var(--navy);margin-bottom:24px">What Our Customers Say</h2>
    <div class="review-strip-grid">
      <?php echo gp_review_cards($slug); ?>
    </div>
    <p style="margin-top:16px"><a href="<?php echo esc_url(gp_google()); ?>" target="_blank">Read all our Google reviews →</a></p>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
