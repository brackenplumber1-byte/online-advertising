<?php get_header(); ?>
<?php while (have_posts()): the_post();
    $name     = get_the_title();
    $slug     = get_post_field('post_name', get_the_ID());
    $services = unserialize(GP_SERVICES);
    $imgdir   = get_template_directory_uri() . '/assets/images/';
    $svc_photos = [
        'burst-pipe-repairs'       => 'job-underground-pipe.jpg',
        'geyser-replacements'      => 'job-geyser-replacement.jpg',
        'gutters-downpipes'        => 'job-jojo-tank.jpg',
        'plumbing-maintenance'     => 'job-kitchen-tap.jpg',
        'grease-trap-cleaning'     => 'job-drain-manhole.jpg',
        'leak-detection'           => 'job-leak-detection.jpg',
        'drain-specialists'        => 'job-tree-root-drain.jpg',
        'drain-camera-inspections' => 'mondeor-plumber-basin-install.jpg',
        'heat-pumps'               => 'job-geyser-dark-roofspace.jpg',
        'gas-geyser-installations' => 'job-geyser-highpressure.jpg',
        'water-filtration'         => 'mondeor-geyser-installation.jpg',
        'maintenance-contracts'    => 'job-pressure-valve.jpg',
        'industrial-plumbing'      => 'job-geyser-roofspace.jpg',
        'geyser-repair'            => 'job-geyser-dark-roofspace.jpg',
        'water-backup-tanks'       => 'job-jojo-tank.jpg',
        'toilet-repairs'           => 'mondeor-plumber-basin-install.jpg',
        'bathroom-plumbing'        => 'job-kitchen-tap.jpg',
    ];
    $svc_photo = $svc_photos[$slug] ?? '';

    $content_map = [
        'burst-pipe-repairs' => [
            'tagline'  => 'Burst water pipe? We respond fast across Mondeor and Johannesburg South, day or night — no call-out fee.',
            'includes' => ['Burst & leaking pipe repair','Underground pipe bursts','Wall and slab pipe repair','Emergency water shut-off','Storm & rain damage repairs','Copper, PVC and CPVC piping'],
            'reasons'  => ['Fast response across our full service area','Available for genuine emergencies, day or night','No call-out fee — you only pay for the work done','PIRB-registered plumbers on every job','Fully stocked vehicles for same-visit repairs'],
        ],
        'geyser-replacements' => [
            'tagline'  => 'Old or failed geyser? We supply and install replacements — electric, gas and solar — with PIRB compliance certificates issued on completion.',
            'includes' => ['Electric geyser replacement','Solar geyser replacement','Gas geyser replacement','Pressure valve and thermostat replacement','Geyser brackets and drip trays','PIRB compliance certificate (CoC)'],
            'reasons'  => ['All major brands supplied and fitted','PIRB compliance certificate issued on completion','Same-day replacement available in most cases','Full pressure and temperature testing before handover','Workmanship guarantee on every installation'],
        ],
        'gutters-downpipes' => [
            'tagline'  => 'Overflowing gutters and blocked downpipes cause real water damage. We install, repair and clear gutter systems before the next storm.',
            'includes' => ['Gutter installation and replacement','Downpipe installation and repair','Gutter cleaning and unblocking','Leaf guard fitting','Storm damage gutter repair','Fascia and soffit-mounted gutter fixing'],
            'reasons'  => ['Stops water damage before it starts','Neat, weatherproof installation','Free quote and consultation','Workmanship guarantee on all work','Available for both homes and businesses'],
        ],
        'plumbing-maintenance' => [
            'tagline'  => 'Scheduled plumbing maintenance catches small problems before they become expensive ones, for homes and businesses across Johannesburg South.',
            'includes' => ['Routine plumbing inspections','Tap and valve servicing','Geyser servicing and anode checks','Drain flow checks','Pressure testing','Preventative repairs'],
            'reasons'  => ['Catches problems before they become emergencies','Flexible scheduling for homes and businesses','PIRB-registered plumbers on every visit','Detailed report after every inspection','Priority booking for maintenance clients'],
        ],
        'grease-trap-cleaning' => [
            'tagline'  => 'Compliant, scheduled grease trap cleaning for restaurants and commercial kitchens across Johannesburg South.',
            'includes' => ['Grease trap pump-outs','Scheduled cleaning contracts','Compliance-focused servicing','Odour and blockage prevention','Commercial kitchen drain checks','Waste disposal handled correctly'],
            'reasons'  => ['Keeps your kitchen compliant and odour-free','Scheduled contracts available, never miss a service','Minimal disruption to kitchen operations','Experienced with commercial kitchen environments','Proper waste handling and disposal'],
        ],
        'leak-detection' => [
            'tagline'  => 'Hidden leaks cause real damage before you notice them. We find and fix them fast using proper detection equipment, not guesswork.',
            'includes' => ['Water meter leak checks','Underground pipe leaks','Wall and ceiling leaks','Slab leaks','Irrigation system leaks','Roof and gutter leaks'],
            'reasons'  => ['Non-invasive detection, no unnecessary wall breaking','Proper equipment pinpoints leaks accurately','Same-day repair in most cases','Full written report provided','Insurance claim documentation available'],
        ],
        'drain-specialists' => [
            'tagline'  => 'Slow, blocked or smelly drains cleared properly the first time, not just a temporary fix.',
            'includes' => ['Kitchen drain unblocking','Bathroom and shower drains','Blocked toilets','Main sewer line cleaning','Root intrusion removal','High-pressure drain jetting'],
            'reasons'  => ['Proper equipment on every vehicle','Permanent solutions, not temporary clearance','Commercial and residential service','Full cleanup after every job','Experienced with older Johannesburg South drain systems'],
        ],
        'drain-camera-inspections' => [
            'tagline'  => 'See exactly what\'s wrong before any digging starts. Our drain camera inspections find the problem, not just the symptoms.',
            'includes' => ['Full drain line camera inspection','Root intrusion detection','Pipe damage and collapse detection','Blockage location pinpointing','Pre-purchase drain inspections','Recorded footage provided'],
            'reasons'  => ['See the actual problem before quoting a fix','Avoids unnecessary digging or guesswork','Useful for pre-purchase property checks','Recorded footage provided for your records','Experienced reading older clay and PVC drain lines'],
        ],
        'heat-pumps' => [
            'tagline'  => 'Energy-efficient hot water for your home or business — we supply and install heat pump systems built for South African conditions.',
            'includes' => ['Heat pump supply and installation','System sizing and selection advice','Integration with existing geyser plumbing','Electrical isolation and safety compliance','Servicing and maintenance','Warranty support'],
            'reasons'  => ['Genuine energy savings on hot water heating','Correctly sized for your household or business','PIRB-registered installation','Compatible with most existing plumbing setups','Workmanship guarantee on every installation'],
        ],
        'gas-geyser-installations' => [
            'tagline'  => 'Gas geyser supply and installation, done properly and certified, a great option when load shedding makes electric hot water unreliable.',
            'includes' => ['Gas geyser supply and installation','Gas line installation and safety checks','Ventilation and safety compliance','Compliance certificate issued','Servicing and repairs','Conversion from electric to gas'],
            'reasons'  => ['Certified, compliant installation every time','Hot water that is not affected by load shedding','PIRB-registered plumbers on every job','Full safety and pressure testing before handover','Compliance paperwork included'],
        ],
        'water-filtration' => [
            'tagline'  => 'Cleaner water at every tap, we supply and install water filtration and purification systems suited to your home or business.',
            'includes' => ['Whole-house filtration systems','Under-counter filtration units','Water purification systems','Filter servicing and replacement','System sizing advice','Installation and integration with existing plumbing'],
            'reasons'  => ['Genuinely cleaner water, not just marketing claims','Systems sized correctly for your household','Professional installation and integration','Ongoing servicing and filter replacement available','Free quote and consultation'],
        ],
        'maintenance-contracts' => [
            'tagline'  => 'Scheduled plumbing servicing for homes, complexes and businesses, priority call-outs and fewer surprises.',
            'includes' => ['Scheduled plumbing inspections','Priority emergency call-outs','Geyser and drain servicing','Body corporate and complex contracts','Commercial maintenance contracts','Detailed service reports'],
            'reasons'  => ['Priority booking ahead of non-contract clients','Predictable, budgeted maintenance costs','Fewer surprise emergencies over time','Experienced with both residential and commercial clients','Flexible contract terms available'],
        ],
        'industrial-plumbing' => [
            'tagline'  => 'Larger-scale plumbing installations, repairs and compliance work for businesses across Johannesburg South.',
            'includes' => ['Industrial pipe installation and repair','Commercial drainage systems','Grease trap and waste systems','Compliance-focused installations','Large-scale leak detection and repair','Scheduled industrial maintenance'],
            'reasons'  => ['Experienced with commercial and industrial sites','PIRB-registered plumbers on every job','Minimal disruption to business operations','Compliance-focused workmanship','Scheduled and emergency service available'],
        ],
        'geyser-repair' => [
            'tagline'  => 'No hot water? Our geyser specialists diagnose and repair electric, gas and solar geysers — often the same day.',
            'includes' => ['Electric geyser repair','Solar geyser repairs','Gas geyser servicing and repair','Pressure valve replacement','Thermostat and element replacement','PIRB compliance certificates (CoC)'],
            'reasons'  => ['Same-day repair in most cases','All major brands serviced','PIRB compliance certificate issued on completion','Full system testing before sign-off','No call-out fee — upfront quotes'],
        ],
        'water-backup-tanks' => [
            'tagline'  => 'Never run out of water again — complete water backup tank systems, JoJo tanks, pressure pumps and full plumbing integration.',
            'includes' => ['JoJo and plastic storage tank installation','Steel tank installation','Pressure pump installation and wiring','Automatic switchover valves','Tank-to-geyser plumbing integration','Full system pressure testing'],
            'reasons'  => ['Complete supply-and-install service','All tank sizes available','PIRB-registered installation','Compatible with existing plumbing and geyser systems','Workmanship guarantee on all work'],
        ],
        'toilet-repairs' => [
            'tagline'  => 'Running, blocked or leaking toilet fixed fast — we carry parts for all major brands.',
            'includes' => ['Blocked toilet unblocking','Running toilet and cistern repair','Valve and ballcock replacement','Toilet seat replacement','Complete toilet installation','Dual-flush conversions'],
            'reasons'  => ['Same-day response available','No call-out fee — transparent pricing','Parts carried on our vehicles','Neat work with full cleanup after','12-month workmanship guarantee'],
        ],
        'bathroom-plumbing' => [
            'tagline'  => 'From a dripping tap to a full bathroom renovation — installed to SANS standards and guaranteed.',
            'includes' => ['Toilet installation and repair','Tap replacement and repair','Basin and sink installation','Shower fitting and repairs','Bath installation','Full bathroom renovations'],
            'reasons'  => ['Free quote and consultation','All work to SANS plumbing standards','Neat, clean workmanship guaranteed','12-month workmanship guarantee','Supply-and-fit or fit-only options'],
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
    <h1 class="display"><?php echo esc_html($name); ?> in<br>Johannesburg South</h1>
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
  <img src="<?php echo esc_url($imgdir . $svc_photo); ?>" alt="<?php echo esc_attr($name); ?> — Mondeor Plumbing Services" style="width:100%;max-height:420px;object-fit:cover;border-radius:8px">
</div>
<?php endif; ?>

<!-- MAIN CONTENT -->
<div class="container">
  <div class="content-grid">
    <div class="content-body">

      <h2>Professional <?php echo esc_html($name); ?> in Johannesburg South</h2>
      <p>Searching for <?php echo esc_html(strtolower($name)); ?> near me? At Mondeor Plumbing Services, our PIRB-registered team delivers fast, reliable <?php echo esc_html(strtolower($name)); ?> services across Mondeor and the wider Johannesburg South region. We're available 24 hours a day, 7 days a week — including weekends and public holidays.</p>
      <p>When you call us, you speak to a real plumber — not a call centre. We give you an honest, upfront quote before any work starts and stand behind everything we do with a full workmanship guarantee.</p>

      <h2>Our <?php echo esc_html($name); ?> Services Include</h2>
      <ul><?php echo $inc_html; ?></ul>

      <h2>Why Choose Mondeor Plumbing Services for <?php echo esc_html($name); ?>?</h2>
      <ul><?php echo $why_html; ?></ul>

      <?php if (get_the_content()): ?>
      <div><?php the_content(); ?></div>
      <?php endif; ?>

      <h3>How Much Does <?php echo esc_html($name); ?> Cost?</h3>
      <p>Every job is different — which is why we give you a free, no-obligation quote before starting any work. We never charge a call-out fee. Call <a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red);font-weight:700"><?php echo esc_html(gp_phone()); ?></a> for a fast quote now.</p>

      <?php
      $svc_extra_photos = [
        'burst-pipe-repairs'       => ['job-pressure-valve.jpg'],
        'geyser-replacements'      => ['job-geyser-roofspace.jpg', 'job-geyser-dark-roofspace.jpg'],
        'gutters-downpipes'        => [],
        'plumbing-maintenance'     => ['job-pressure-valve.jpg'],
        'grease-trap-cleaning'     => ['job-tree-root-drain.jpg'],
        'leak-detection'           => ['job-underground-pipe.jpg'],
        'drain-specialists'        => ['job-drain-manhole.jpg'],
        'drain-camera-inspections' => ['job-drain-manhole.jpg'],
        'heat-pumps'               => ['job-geyser-highpressure.jpg'],
        'gas-geyser-installations' => ['job-geyser-roofspace.jpg'],
        'water-filtration'         => ['job-jojo-tank.jpg'],
        'maintenance-contracts'    => ['job-kitchen-tap.jpg'],
        'industrial-plumbing'      => ['job-underground-pipe.jpg'],
        'geyser-repair'            => ['job-geyser-highpressure.jpg'],
        'water-backup-tanks'       => ['job-underground-pipe.jpg'],
        'toilet-repairs'           => ['job-kitchen-tap.jpg'],
        'bathroom-plumbing'        => ['mondeor-plumber-basin-install.jpg'],
      ];
      $extras = $svc_extra_photos[$slug] ?? [];
      if ($extras): ?>
      <div class="svc-extras-grid <?php echo count($extras) > 1 ? 'cols-2' : 'cols-1'; ?>">
        <?php foreach ($extras as $ep): ?>
        <img src="<?php echo esc_url($imgdir . $ep); ?>" alt="<?php echo esc_attr($name); ?> job photo — Mondeor Plumbing Services" style="width:100%;height:240px;object-fit:cover;border-radius:8px">
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

      <h2>Frequently Asked Questions — <?php echo esc_html($name); ?></h2>
      <?php
      $svc_faqs = [
          ['Is there ' . strtolower($name) . ' near me?', 'Yes — we cover Mondeor and the surrounding Johannesburg South suburbs directly, so if you\'re searching for "' . strtolower($name) . ' near me," we\'re a local, PIRB-registered option with a 30-minute on-site target for emergencies.'],
          ['How much does ' . strtolower($name) . ' cost?', 'It depends on the scope of the job. We give a free, no-obligation quote before starting, and we never charge a call-out fee.'],
          ['Can I get ' . strtolower($name) . ' the same day?', 'In most cases, yes. Call or WhatsApp us and we\'ll confirm same-day availability — urgent issues are always prioritised.'],
      ];
      ?>
      <div class="faq-list">
        <?php foreach ($svc_faqs as $fq): ?>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><?php echo esc_html($fq[0]); ?><div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a"><?php echo esc_html($fq[1]); ?></div></div>
        <?php endforeach; ?>
      </div>
      <?php
      $svc_faq_schema = ['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>array_map(function($fq){
          return ['@type'=>'Question','name'=>$fq[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$fq[1]]];
      }, $svc_faqs)];
      echo '<script type="application/ld+json">'.wp_json_encode($svc_faq_schema, JSON_UNESCAPED_SLASHES).'</script>'."\n";
      ?>

      <h2>Other Plumbing Services We Offer</h2>
      <ul><?php echo $other_svc; ?></ul>

      <h2><?php echo esc_html($name); ?> Available Across Johannesburg South</h2>
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
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"The best experience I've had with a plumber. Very professional, arrived on time, sorted the issue quickly. Price was fair."</blockquote><div class="mini-reviewer">— Sharral Raman, Local Guide</div></div>
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"Great service! Professional, fixed my leaking kitchen tap quickly and efficiently, and the price was decent."</blockquote><div class="mini-reviewer">— Sherry Sprinkles, Google Review</div></div>
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"Thank you Charles and team for an amazing job done. Highly professional and efficient."</blockquote><div class="mini-reviewer">— Terry-Anne Mohamed, Google Review</div></div>
    </div>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
