<?php get_header(); ?>
<?php
$imgdir = get_template_directory_uri() . '/assets/images/';
$sent   = isset($_GET['sent']) && $_GET['sent']==='1';
$services = unserialize(TP_SERVICES);
$areas    = unserialize(TP_AREAS);

$svc_imgs = [
    'emergency-plumbing'  => 'job-underground-valve.webp',
    'geyser-repair'       => 'job-geyser-dark-roofspace.webp',
    'geyser-installation' => 'job-geyser-replacement.webp',
    'drain-cleaning'      => 'job-blocked-drain.webp',
    'pipe-repair'         => 'job-underground-pipe.webp',
    'leak-detection'      => 'job-leak-detection.webp',
    'toilet-repairs'      => 'job-toilet-installation.webp',
    'bathroom-plumbing'   => 'job-kitchen-tap.webp',
    'water-backup-tanks'  => 'job-jojo-tank.webp',
    'gutters-downpipes'    => 'job-tree-root-drain.webp',
    'grease-trap-cleaning' => 'job-drain-manhole.webp',
    'drain-camera'         => 'job-geyser-roofspace.webp',
    'heat-pumps'           => 'job-geyser-roofspace.webp',
    'water-filtration'     => 'job-jojo-tank.webp',
    'maintenance-contracts'=> 'job-pressure-valve.webp',
];
$svc_descs = [
    'emergency-plumbing'  => 'Burst pipes, flooding, no water — we\'re on-site in 45 minutes across Roodepoort, any hour, every day of the year.',
    'geyser-repair'       => 'No hot water? Our geyser specialists diagnose and repair electric, gas, and solar geysers — same day in most cases.',
    'geyser-installation' => 'New geyser supplied and installed by PIRB-registered plumbers. Compliance certificates issued on completion.',
    'drain-cleaning'      => 'Blocked drain cleared completely with high-pressure hydro jetting — a permanent fix, not a temporary patch.',
    'pipe-repair'         => 'Burst, cracked, or corroded pipes excavated and replaced with SABS-approved materials. Fully guaranteed.',
    'leak-detection'      => 'Hidden leaks behind walls or underground found fast — before they cause serious water damage to your home.',
    'toilet-repairs'      => 'Running, blocked, or leaking toilet fixed fast. We carry parts for all brands and complete most repairs in one visit.',
    'bathroom-plumbing'   => 'Taps, basins, showers, baths, and full bathroom renovations installed to SANS standards.',
    'water-backup-tanks'  => 'JoJo tanks, pressure pumps, and filtration systems — full supply and install for Roodepoort homes and businesses.',
    'gutters-downpipes'    => 'Gutter and downpipe installation and repair — stop water damage before the next storm.',
    'grease-trap-cleaning' => 'Compliant, scheduled grease trap cleaning for restaurants and commercial kitchens across Roodepoort.',
    'drain-camera'         => 'CCTV drain camera inspections — see exactly what\'s wrong before any digging starts.',
    'heat-pumps'           => 'Energy-efficient hot water systems — genuine savings on your electricity bill.',
    'water-filtration'     => 'Water filtration and purification systems for cleaner water at every tap.',
    'maintenance-contracts'=> 'Scheduled plumbing servicing for homes, complexes and businesses — priority call-outs, fewer surprises.',
];
?>

<!-- ═══ HERO ═══════════════════════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg">
    <img src="<?php echo esc_url($imgdir.'job-pressure-valve.webp'); ?>" alt="Plumbers Roodepoort — Tysons Plumbers" loading="eager">
  </div>

  <!-- Decorative, purely CSS liquid/particle background — no JS, no impact
       on markup, headings, links or LCP image above. Hidden from assistive
       tech since it carries no content. -->
  <div class="hero-liquid" aria-hidden="true">
    <span class="hero-liquid__blob hero-liquid__blob--1"></span>
    <span class="hero-liquid__blob hero-liquid__blob--2"></span>
    <span class="hero-liquid__blob hero-liquid__blob--3"></span>
  </div>
  <div class="hero-particles" aria-hidden="true">
    <?php
    // Fixed (not runtime-random) so the layout is stable across requests —
    // [size px, left %, delay s, duration s, horizontal drift px]
    $tp_bubbles = [
      [6,4,0,18,-22],  [9,12,3,22,18],  [5,20,1,16,-14], [8,29,5,24,26],
      [4,37,2,15,-18], [10,46,6,26,20], [6,55,0,19,-24], [7,63,4,21,16],
      [5,71,2,17,-12], [9,79,5,25,22],  [4,86,1,16,-16], [8,92,3,23,18],
    ];
    foreach ($tp_bubbles as $b):
      list($size, $left, $delay, $dur, $drift) = $b;
    ?>
    <span class="hero-particle" style="--size:<?php echo (int)$size; ?>px;--left:<?php echo (int)$left; ?>%;--delay:<?php echo (int)$delay; ?>s;--dur:<?php echo (int)$dur; ?>s;--drift:<?php echo (int)$drift; ?>px"></span>
    <?php endforeach; ?>
  </div>

  <div class="hero-overlay"></div>
  <div class="container" style="padding-top:80px;padding-bottom:80px">
    <div class="hero-content">
      <div class="hero-badge">Roodepoort &amp; West Rand — Available 24/7</div>
      <h1>
        <span class="highlight">#1 Plumbers</span> in<br>
        Roodepoort.<br>
        <span class="accent">On-Site in 45 Min.</span>
      </h1>
      <p class="hero-sub">Searching for a plumber near me in Roodepoort? You've found Roodepoort's most trusted plumbing team — <strong>available 24 hours a day</strong> for emergencies, geyser repairs, blocked drains, pipe repairs and more. No call-out fee. Beat any competitor quote.</p>
      <div class="hero-actions">
        <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire btn--lg">
          <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
          Call <?php echo esc_html(tp_phone()); ?>
        </a>
        <a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank" rel="noopener" class="btn btn--wa btn--lg">
          <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
          WhatsApp Us
        </a>
        <a href="#contact" class="btn btn--ghost btn--lg">Free Quote</a>
      </div>
      <div class="hero-trust">
        <div class="htrust"><div class="htrust-icon"><svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg></div><span class="htrust-text">Licensed &amp;<br>Insured</span></div>
        <div class="htrust"><div class="htrust-icon"><svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg></div><span class="htrust-text">45-Min<br>Response</span></div>
        <div class="htrust"><div class="htrust-icon"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div><span class="htrust-text">5★ Google<br>Rated</span></div>
        <div class="htrust"><div class="htrust-icon"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div><span class="htrust-text">No Call-Out<br>Fee</span></div>
      </div>
    </div>
  </div>
  <a href="#about" class="hero-scroll" aria-label="Scroll down to learn more about Tysons Plumbers Roodepoort">
    <svg viewBox="0 0 24 24"><path d="M12 16.5l-7-7 1.41-1.41L12 13.67l5.59-5.58L19 9.5z"/></svg>
  </a>
</section>

<?php get_template_part('template-parts/trust-strip'); ?>

<!-- STATS -->
<div class="stats-bar">
  <div class="stats-row">
    <div class="stat-cell reveal" style="--i:0"><div class="stat-n"><span class="stat-num" data-count="45">45</span><span>min</span></div><div class="stat-l">Emergency Response</div></div>
    <div class="stat-cell reveal" style="--i:1"><div class="stat-n"><span class="stat-num" data-count="24">24</span><span>/7</span></div><div class="stat-l">Always Available</div></div>
    <div class="stat-cell reveal" style="--i:2"><div class="stat-n">R<span class="stat-num" data-count="0">0</span><span> fee</span></div><div class="stat-l">No Call-Out Charge</div></div>
    <div class="stat-cell reveal" style="--i:3"><div class="stat-n"><span class="stat-num" data-count="15">15</span><span>+</span></div><div class="stat-l">Services Offered</div></div>
  </div>
</div>

<!-- ═══ ABOUT ══════════════════════════════════════════════════════════════ -->
<section class="section" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-imgwrap reveal">
        <img class="about-main-img" src="<?php echo esc_url($imgdir.'job-geyser-roofspace.webp'); ?>" alt="Plumbers Roodepoort — Tysons Plumbers geyser installation" loading="lazy">
        <img class="about-inset" src="<?php echo esc_url($imgdir.'job-tree-root-drain.webp'); ?>" alt="Drain repair Roodepoort" loading="lazy">
        <div class="about-ribbon">PIRB Registered</div>
      </div>
      <div class="about-text reveal" style="--i:1">
        <div class="eyebrow">Why Tysons Plumbers Roodepoort?</div>
        <h2>Direct Access to a Licensed Plumber — No Call Centre.</h2>
        <p>Tysons Plumbers Roodepoort serves Honeydew, Wilgeheuwel, Florida, Constantia Kloof and the wider West Rand. We're not a call centre — when you call us, you speak directly to a licensed, PIRB-registered plumber.</p>
        <p>We keep our overheads low and pass the savings directly to you. Our fast emergency response and zero call-out fee policy means straightforward, honest pricing on every job.</p>
        <ul class="check-list">
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>Licensed and insured — every plumber on our team</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>No call-out fee — ever. Zero. Nothing.</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>On-site in 45 minutes for emergencies across Roodepoort</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>Upfront quotes before any work begins — no surprises</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>12-month workmanship guarantee on all repairs</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>Available 24 hours, 7 days — including public holidays</li>
          <li><span><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></span>We beat any genuine competitor quote in Roodepoort</li>
        </ul>
        <div class="btn-group">
          <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire">Call Now — Free</a>
          <a href="#services" class="btn btn--outline-fire">View All Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ SERVICES ══════════════════════════════════════════════════════════ -->
<section class="section section--light" id="services">
  <div class="container">
    <div class="services-intro reveal">
      <div class="eyebrow">Plumbing Services Roodepoort</div>
      <h2>Everything Plumbing in Roodepoort — Fixed Right.</h2>
      <p>From emergency call-outs to full installations, our plumbers in Roodepoort handle every job with professional care and a guaranteed result.</p>
    </div>
    <div class="svc-grid">
      <?php $i=0; foreach ($services as $slug => $name):
        $p = get_posts(['name'=>$slug,'post_type'=>'tp_service','post_status'=>'publish','numberposts'=>1]);
        $url = $p ? get_permalink($p[0]->ID) : home_url('/services/'.$slug);
        $img = $svc_imgs[$slug] ?? '';
        $desc = $svc_descs[$slug] ?? '';
        $i++;
        $is_emerg = ($slug === 'emergency-plumbing');
      ?>
      <div class="svc-card reveal <?php echo $is_emerg ? 'svc-card-emerg' : ''; ?>" style="--i:<?php echo ($i-1)%3; ?>">
        <div class="svc-card-img">
          <img src="<?php echo esc_url($imgdir.$img); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy">
          <?php if ($is_emerg): ?><div class="svc-badge">24/7 Live</div><?php endif; ?>
        </div>
        <div class="svc-body">
          <h3><?php echo esc_html($name); ?></h3>
          <p><?php echo esc_html($desc); ?></p>
          <a href="<?php echo esc_url($url); ?>" class="svc-cta">Full details &amp; pricing</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire btn--lg">📞 Call <?php echo esc_html(tp_phone()); ?> — No Call-Out Fee</a>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="cta-banner">
  <div class="container">
    <div class="cta-banner-inner reveal">
      <div>
        <h2>Plumbing emergency in Roodepoort right now?</h2>
        <p>Don't wait. Our plumbers are standing by and can be at your door in 45 minutes — any time, any day, including weekends and public holidays.</p>
      </div>
      <div class="cta-actions">
        <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire btn--lg">📞 Call Now</a>
        <a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank" class="btn btn--wa btn--lg">WhatsApp</a>
      </div>
    </div>
  </div>
</div>

<!-- ═══ GALLERY ════════════════════════════════════════════════════════════ -->
<div class="gallery-section" id="gallery">
  <div class="container gallery-intro reveal">
    <div class="eyebrow eyebrow--white">Real Work in Roodepoort</div>
    <h2 style="color:#fff">Our Jobs. Your Neighbourhood.</h2>
  </div>
  <div class="gallery-grid">
    <div class="gal-item gal-item--tall reveal" style="--i:0">
      <img src="<?php echo esc_url($imgdir.'job-jojo-tank.webp'); ?>" alt="Water backup tank installation Roodepoort — Tysons Plumbers" loading="lazy">
      <div class="gal-cap">Water Backup Tank Installation</div>
    </div>
    <div class="gal-item reveal" style="--i:1">
      <img src="<?php echo esc_url($imgdir.'job-geyser-highpressure.webp'); ?>" alt="Geyser repair Roodepoort" loading="lazy">
      <div class="gal-cap">Geyser Replacement</div>
    </div>
    <div class="gal-item reveal" style="--i:2">
      <img src="<?php echo esc_url($imgdir.'job-toilet-installation.webp'); ?>" alt="Toilet installation Roodepoort" loading="lazy">
      <div class="gal-cap">Toilet Installation</div>
    </div>
    <div class="gal-item reveal" style="--i:3">
      <img src="<?php echo esc_url($imgdir.'job-underground-valve.webp'); ?>" alt="Pipe repair Roodepoort underground" loading="lazy">
      <div class="gal-cap">Underground Pipe Repair</div>
    </div>
    <div class="gal-item reveal" style="--i:4">
      <img src="<?php echo esc_url($imgdir.'job-blocked-drain.webp'); ?>" alt="Drain cleaning Roodepoort — high pressure hydro jetting" loading="lazy">
      <div class="gal-cap">Drain Cleaning Service</div>
    </div>
  </div>
</div>

<!-- ═══ OUR PROCESS ════════════════════════════════════════════════════════ -->
<section class="section" id="process">
  <div class="container">
    <div class="services-intro reveal">
      <div class="eyebrow">How We Work</div>
      <h2>What Happens When You Call Tysons Plumbers Roodepoort.</h2>
      <p>No call centre, no guesswork — here's exactly what to expect from first call to finished job.</p>
    </div>
    <div class="svc-grid">
      <div class="svc-card reveal" style="--i:0">
        <div class="svc-body">
          <h3>1. Fast Response</h3>
          <p>Call, WhatsApp, or fill in our form. We dispatch a plumber to your Roodepoort location as quickly as possible — emergencies prioritised, day or night.</p>
        </div>
      </div>
      <div class="svc-card reveal" style="--i:1">
        <div class="svc-body">
          <h3>2. Proper Assessment</h3>
          <p>We diagnose the actual problem on-site — not just the symptoms — whether it's a residential leak, blocked drain, or geyser failure.</p>
        </div>
      </div>
      <div class="svc-card reveal" style="--i:2">
        <div class="svc-body">
          <h3>3. Upfront Quote</h3>
          <p>You get a clear, written quote before any work starts. No hidden fees, no surprises on the invoice.</p>
        </div>
      </div>
      <div class="svc-card reveal" style="--i:0">
        <div class="svc-body">
          <h3>4. Quality Workmanship</h3>
          <p>The job gets done properly the first time, using SABS-approved materials and PIRB-compliant methods — with a workmanship guarantee.</p>
        </div>
      </div>
      <div class="svc-card reveal" style="--i:1">
        <div class="svc-body">
          <h3>5. Clean Finish & Follow-Up</h3>
          <p>We clean up after every job and make sure you're satisfied before we leave. Compliance certificates issued where applicable.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ REVIEWS ════════════════════════════════════════════════════════════ -->
<?php if (tp_review()): ?>
<section class="section section--light" id="reviews">
  <div class="container">
    <div class="reviews-header reveal">
      <div>
        <div class="eyebrow">Google Reviews — Plumbers Roodepoort</div>
        <h2>Roodepoort Residents Trust Tysons.</h2>
      </div>
      <a href="<?php echo esc_url(tp_review()); ?>" target="_blank" class="btn btn--fire">⭐ Leave a Google Review</a>
    </div>
    <!--
      NOTE: Once a Google Business Profile exists and has real reviews,
      replace this comment block with actual review cards — real customer
      names, real quotes, real star ratings. Never fabricate reviews or
      claim "Verified Google Review" status on content that isn't real;
      this was removed from the previous version of this site for exactly
      that reason.
    -->
  </div>
</section>
<?php endif; ?>

<!-- ═══ AREAS ═══════════════════════════════════════════════════════════════ -->
<section class="section areas-section" id="areas">
  <div class="container">
    <div class="areas-intro reveal">
      <div class="eyebrow eyebrow--white">Plumbers in Every Part of Roodepoort</div>
      <h2>We Cover All of Roodepoort &amp; the West Rand.</h2>
      <p>Tysons Plumbers Roodepoort serves every suburb across Roodepoort, Honeydew, Wilgeheuwel, Florida and the West Rand. Click your area for dedicated plumbing services near you.</p>
    </div>
    <div class="areas-grid">
      <?php foreach ($areas as $slug => $name):
        $p = get_posts(['name'=>$slug,'post_type'=>'tp_area','post_status'=>'publish','numberposts'=>1]);
        $url = $p ? get_permalink($p[0]->ID) : home_url('/areas/'.$slug);
      ?>
      <a href="<?php echo esc_url($url); ?>" class="area-card reveal">
        <span>Plumbers <?php echo esc_html($name); ?></span>
        <span class="arr">→</span>
      </a>
      <?php endforeach; ?>
    </div>
    <p class="area-note">Don't see your area? <a href="<?php echo esc_attr(tp_plink()); ?>">Call <?php echo esc_html(tp_phone()); ?></a> — we likely cover you too.</p>
  </div>
</section>

<!-- ═══ FAQ ════════════════════════════════════════════════════════════════ -->
<section class="section" id="faq">
  <div class="container" style="text-align:center">
    <div class="eyebrow">FAQs — Plumbers Roodepoort</div>
    <h2>Your Questions About Our Plumbing Services Answered.</h2>
  </div>
  <div class="container">
    <div class="faq-wrap">
      <?php
      $faqs = [
        ['Are you the best plumbers in Roodepoort?', 'We\'re one of the highest-rated plumbing companies in Roodepoort, with a 5-star Google rating and hundreds of satisfied customers across Honeydew, Wilgeheuwel, Florida, Constantia Kloof and the West Rand. We back this up with a price match guarantee — if you find a cheaper quote from a licensed Roodepoort plumber, we\'ll beat it.'],
        ['How quickly can your plumbers get to me in Roodepoort?', 'For plumbing emergencies in Roodepoort, we aim to be on-site within 45 minutes. We\'re based locally, so we know the fastest routes to every neighbourhood across the West Rand.'],
        ['Do you charge a call-out fee for plumbing in Roodepoort?', 'No. Tysons Plumbers Roodepoort never charges a call-out fee. You only pay for the work carried out. We always provide a clear, upfront quote before any work starts.'],
        ['Are your Roodepoort plumbers licensed?', 'Yes. All our plumbers are fully licensed and insured. We issue PIRB Certificates of Compliance for geyser installations — required by your home insurer. Ask for proof of certification on every job.'],
        ['Do you offer 24/7 emergency plumbing in Roodepoort?', 'Yes — 24 hours a day, 7 days a week, 365 days a year. Whether it\'s 2am on a Sunday or Christmas Day, our emergency plumbers in Roodepoort are available and will be at your door in 45 minutes.'],
        ['What areas around Roodepoort do you service?', 'We cover all of Roodepoort including Honeydew, Wilgeheuwel, Florida, Constantia Kloof, Weltevreden Park, Ruimsig, Little Falls, Helderkruin, Northcliff, Radiokop, Poortview, Strubensvalley, Krugersdorp, Randfontein, and extending to Randburg and Fourways.'],
        ['Can you fix a burst pipe in Roodepoort same day?', 'Yes. Burst pipe repair is one of our most common emergency calls in Roodepoort. We carry the most common pipe fittings and materials on our vehicles, so we can repair most burst pipes in a single visit.'],
        ['How much does geyser repair cost in Roodepoort?', 'Geyser repair costs in Roodepoort depend on the fault and geyser type. We provide a free, upfront quote before starting. Common repairs like thermostat or element replacement are affordable and completed same day. We never charge a call-out fee.'],
        ['Is there a plumber near me right now in Roodepoort?', 'Very likely, yes — we\'re based in Roodepoort and cover the West Rand directly, so if you\'re searching "plumber near me" from Roodepoort or a nearby suburb, we\'re typically one of the fastest-responding options with a 45-minute on-site target.'],
        ['Do you cover Randburg and Fourways too?', 'Yes, alongside our core Roodepoort and West Rand coverage. These are a longer drive than our core area, so response times there are realistically further out than our 45-minute Roodepoort target — ask us for a specific estimate when you call.'],
        ['Can I book a same-day plumber in Roodepoort?', 'In most cases, yes. Call or WhatsApp us and we\'ll confirm same-day availability for your suburb — emergencies are always prioritised.'],
      ];
      foreach ($faqs as $faq): ?>
      <div class="faq-item reveal">
        <div class="faq-q" onclick="toggleFaq(this)"><?php echo esc_html($faq[0]); ?><div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div>
        <div class="faq-a"><?php echo esc_html($faq[1]); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php
  $home_faq_schema = ['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>array_map(function($faq){
      return ['@type'=>'Question','name'=>$faq[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$faq[1]]];
  }, $faqs)];
  echo '<script type="application/ld+json">'.wp_json_encode($home_faq_schema, JSON_UNESCAPED_SLASHES).'</script>'."\n";
  ?>
</section>

<!-- ═══ CONTACT ════════════════════════════════════════════════════════════ -->
<section id="contact">
  <div class="contact-split">
    <div class="contact-left reveal">
      <div class="eyebrow eyebrow--white">Contact Plumbers Roodepoort</div>
      <h2>Get Roodepoort's Best Plumber to Your Door.</h2>
      <p>Call, WhatsApp, or fill in the form. We respond within 15 minutes — because a plumbing problem in Roodepoort rarely waits.</p>
      <div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></div><div><div class="cm-label">Phone — 24/7</div><div class="cm-value"><a href="<?php echo esc_attr(tp_plink()); ?>"><?php echo esc_html(tp_phone()); ?></a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></div><div><div class="cm-label">WhatsApp</div><div class="cm-value"><a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank">Chat with us now</a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></div><div><div class="cm-label">Email</div><div class="cm-value"><a href="mailto:<?php echo esc_attr(tp_email()); ?>"><?php echo esc_html(tp_email()); ?></a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></div><div><div class="cm-label">Location</div><div class="cm-value" style="color:rgba(255,255,255,0.5);font-weight:400;font-size:0.88rem">Jim Fouche, Roodepoort, Gauteng</div></div></div>
      </div>
    </div>
    <div class="contact-right reveal" style="--i:1">
      <h3>Request a Free Quote</h3>
      <?php if ($sent): ?>
        <div class="form-ok">✓ Request received — we will call you back within 15 minutes!</div>
      <?php else: ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="tp_contact">
        <?php wp_nonce_field('tp_contact','tp_nonce'); ?>
        <div class="frow">
          <div class="fgrp"><label>Name</label><input type="text" name="tp_name" placeholder="Your name" required></div>
          <div class="fgrp"><label>Phone</label><input type="tel" name="tp_phone" placeholder="Your number" required></div>
        </div>
        <div class="fgrp"><label>Service Needed</label>
          <select name="tp_service">
            <option>Emergency Plumbing Roodepoort</option>
            <option>Geyser Repair Roodepoort</option>
            <option>Geyser Installation Roodepoort</option>
            <option>Drain Cleaning Roodepoort</option>
            <option>Pipe Repair Roodepoort</option>
            <option>Leak Detection Roodepoort</option>
            <option>Toilet Repairs Roodepoort</option>
            <option>Water Backup Tank Installation</option>
            <option>Other Plumbing Service</option>
          </select>
        </div>
        <div class="fgrp"><label>Message</label><textarea name="tp_msg" placeholder="Describe the problem..."></textarea></div>
        <button type="submit" class="fsub">Send My Request →</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
  <?php if (tp_maps()): ?>
  <div class="map-wrap"><iframe src="<?php echo esc_url(tp_maps()); ?>" allowfullscreen loading="lazy" title="Tysons Plumbers Roodepoort"></iframe></div>
  <?php else: ?>
  <div class="map-wrap"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57307.8!2d27.8727!3d-26.1625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e959cdb6e78a3b1%3A0xb1c9b64f7b1f6a8d!2sRoodepoort%2C+Gauteng!5e0!3m2!1sen!2sza!4v1700000000000" allowfullscreen loading="lazy" title="Plumbers Roodepoort service area"></iframe></div>
  <?php endif; ?>
</section>


<!-- ═══ PARTNER LINKS & RELATED PLUMBERS ═══════════════════════════════════ -->
<section style="background:var(--light);padding:56px 0;border-top:1px solid var(--border)">
  <div class="container">

    <!-- TRUSTED SUPPLIERS -->
    <div style="margin-bottom:48px">
      <div class="eyebrow">Our Trusted Suppliers &amp; Partners</div>
      <h2 style="font-size:1.5rem;margin:8px 0 6px">We Use Quality-Approved Products</h2>
      <p style="max-width:620px;margin-bottom:28px;font-size:0.9rem">Tysons Plumbers Roodepoort sources materials and products exclusively from reputable South African suppliers and internationally recognised brands — so every repair and installation is built to last.</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px">

        <a href="https://www.plumblink.co.za/" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:14px 18px;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-size:0.82rem;font-weight:700;color:var(--navy)" onmouseover="this.style.borderColor='var(--fire)';this.style.color='var(--fire)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--navy)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--fire)"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.36C18 2.53 15.47 0 12.36 0 10.5 0 8.84.98 7.84 2.5L7 3.5 6.16 2.5A4.49 4.49 0 0 0 3.64 0C.53 0-2 2.53-2 4.64c0 .48.11.92.18 1.36H-2C-3.1 6-4 6.9-4 8v12c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM8.73 2.97A2.51 2.51 0 0 1 12.36 2c1.38 0 2.5 1.12 2.5 2.5 0 .48-.14.93-.38 1.5H9.28c-.19-.55-.32-1.01-.32-1.5a2.45 2.45 0 0 1 .77-1.53z"/></svg>
          Plumblink SA
          <span style="margin-left:auto;font-size:0.7rem;color:var(--muted);font-weight:400">plumblink.co.za</span>
        </a>

        <a href="https://www.builders.co.za/" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:14px 18px;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-size:0.82rem;font-weight:700;color:var(--navy)" onmouseover="this.style.borderColor='var(--fire)';this.style.color='var(--fire)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--navy)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--fire)"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
          Builders Warehouse
          <span style="margin-left:auto;font-size:0.7rem;color:var(--muted);font-weight:400">builders.co.za</span>
        </a>

        <a href="https://www.geberit.com/en-za/" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:14px 18px;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-size:0.82rem;font-weight:700;color:var(--navy)" onmouseover="this.style.borderColor='var(--fire)';this.style.color='var(--fire)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--navy)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--fire)"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
          Geberit
          <span style="margin-left:auto;font-size:0.7rem;color:var(--muted);font-weight:400">geberit.com</span>
        </a>

        <a href="https://www.hansgrohe.co.za/" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:6px;padding:14px 18px;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-size:0.82rem;font-weight:700;color:var(--navy)" onmouseover="this.style.borderColor='var(--fire)';this.style.color='var(--fire)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--navy)'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--fire)"><path d="M17 8C8 10 5.9 16.17 3.82 19.56L5.71 21l1-1.9C7.63 21 9.26 22 12 22c6.627 0 10-5.373 10-10.015C22 7.455 19.603 5.07 17 8z"/></svg>
          Hansgrohe SA
          <span style="margin-left:auto;font-size:0.7rem;color:var(--muted);font-weight:400">hansgrohe.co.za</span>
        </a>

      </div>
      <p style="margin-top:14px;font-size:0.78rem;color:var(--muted)">We source geysers, pipes, fittings, and sanware from trusted suppliers including <a href="https://www.plumblink.co.za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">Plumblink</a>, <a href="https://www.builders.co.za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">Builders Warehouse</a>, <a href="https://www.geberit.com/en-za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">Geberit</a>, and <a href="https://www.hansgrohe.co.za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">Hansgrohe</a> — ensuring every installation meets the highest quality standards.</p>
    </div>

    <!-- RELATED PLUMBERS (BACKLINKS) -->
    <div style="border-top:1px solid var(--border);padding-top:40px">
      <div class="eyebrow">Trusted Plumbers Across Gauteng</div>
      <h2 style="font-size:1.5rem;margin:8px 0 6px">Recommended Plumbers in Other Areas</h2>
      <p style="max-width:620px;margin-bottom:28px;font-size:0.9rem">Tysons Plumbers Roodepoort specialises in Roodepoort and the West Rand. For plumbing services in other parts of Gauteng, we recommend these trusted, licensed plumbers:</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">

        <!-- BACKLINK 1: 247PlumbersGP — Midrand -->
        <a href="https://247plumbersgp.co.za/" target="_blank" rel="noopener" style="display:block;background:#fff;border:1px solid var(--border);border-radius:6px;padding:20px 22px;transition:all 0.2s;text-decoration:none" onmouseover="this.style.borderColor='var(--fire)';this.style.boxShadow='0 4px 16px rgba(255,107,53,0.1)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
            <div style="width:36px;height:36px;background:var(--fire);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <div>
              <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.9rem;color:var(--navy)">Plumbers in Midrand</div>
              <div style="font-size:0.7rem;color:var(--muted);font-family:'Open Sans',sans-serif">247PlumbersGP</div>
            </div>
          </div>
          <p style="font-family:'Open Sans',sans-serif;font-size:0.83rem;color:var(--muted);margin:0;line-height:1.6">Need a reliable <strong style="color:var(--navy)">plumber in Midrand</strong>? 247PlumbersGP provides 24/7 emergency plumbing, geyser repairs, drain cleaning and more across Midrand and Johannesburg North.</p>
          <div style="margin-top:12px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;color:var(--fire);text-transform:uppercase;letter-spacing:0.06em">247plumbersgp.co.za →</div>
        </a>

        <!-- BACKLINK 2: Brackendowns Plumber — Alberton -->
        <a href="https://brackendownsplumber.co.za/" target="_blank" rel="noopener" style="display:block;background:#fff;border:1px solid var(--border);border-radius:6px;padding:20px 22px;transition:all 0.2s;text-decoration:none" onmouseover="this.style.borderColor='var(--fire)';this.style.boxShadow='0 4px 16px rgba(255,107,53,0.1)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
            <div style="width:36px;height:36px;background:var(--navy);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <div>
              <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.9rem;color:var(--navy)">Plumbers in Alberton</div>
              <div style="font-size:0.7rem;color:var(--muted);font-family:'Open Sans',sans-serif">Brackendowns Plumber</div>
            </div>
          </div>
          <p style="font-family:'Open Sans',sans-serif;font-size:0.83rem;color:var(--muted);margin:0;line-height:1.6">Need a trusted <strong style="color:var(--navy)">plumber in Alberton</strong>? Brackendowns Plumber serves Alberton, Brackendowns, Brackenhurst, Meyersdal and surrounding areas — PIRB registered, no call-out fee.</p>
          <div style="margin-top:12px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;color:var(--fire);text-transform:uppercase;letter-spacing:0.06em">brackendownsplumber.co.za →</div>
        </a>

      </div>
      <p style="margin-top:14px;font-size:0.78rem;color:var(--muted)">Outside Roodepoort? Find a trusted licensed plumber near you: <a href="https://247plumbersgp.co.za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">plumbers in Midrand</a> · <a href="https://brackendownsplumber.co.za/" target="_blank" rel="noopener" style="color:var(--fire);font-weight:600">plumbers in Alberton</a></p>
    </div>

  </div>
</section>

<?php get_footer(); ?>
