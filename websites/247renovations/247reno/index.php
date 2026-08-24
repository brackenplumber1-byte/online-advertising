<?php get_header(); ?>
<?php
$services = unserialize(RN_SERVICES);
$areas    = unserialize(RN_AREAS);
$sent     = isset($_GET['sent']) && $_GET['sent'] === '1';
$imgdir   = rn_imgdir();

$svc_icons = [
  'kitchen-renovations'        => 'M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5z',
  'bathroom-renovations'       => 'M7 2v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-2V2h-2v2H9V2H7zm0 8h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z',
  'home-renovations'           => 'M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z',
  'building-extensions'        => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z',
  'roof-repairs-waterproofing' => 'M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3zm0-2.83L23.61 11H22v10H2V11H.39L12 .17z',
  'painting-plastering'        => 'M7 14c-1.66 0-3 1.34-3 3 0 1.31-1.16 2-2 2 .92 1.22 2.49 2 4 2 2.21 0 4-1.79 4-4 0-1.66-1.34-3-3-3zm13.71-9.37l-1.34-1.34a1 1 0 0 0-1.41 0L9 12.25 11.75 15l8.96-8.96a1 1 0 0 0 0-1.41z',
  'tiling-flooring'            => 'M20 6h-2.18c.07-.44.18-.88.18-1.36C18 2.53 15.47 0 12.36 0c-1.86 0-3.52.98-4.52 2.5L7 3.5 6.16 2.5C5.16.98 3.5 0 1.64 0H1v14h1.64c1.86 0 3.52-.98 4.52-2.5l.84-1 .84 1C9.84 13.02 11.5 14 13.36 14H20c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z',
  'paving-driveways'           => 'M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H4v-4h4v4zm0-6H4v-4h4v4zm0-6H4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4zm6 12h-4v-4h4v4zm0-6h-4v-4h4v4zm0-6h-4V4h4v4z',
  'palisade-fencing'           => 'M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z',
  'garage-conversions'         => 'M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5z',
  'garden-flats'               => 'M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z',
  'maintenance-repairs'        => 'M20.71 5.63l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-3.12 3.12-1.41-1.42-1.42 1.42 1.41 1.41-6.6 6.6A2 2 0 005 16v3h3a2 2 0 001.42-.59l6.6-6.6 1.41 1.42 1.42-1.42-1.42-1.41 3.12-3.12c.4-.4.4-1.03.16-1.65z',
  'granite-quartz-countertops' => 'M4 2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 2v6h16V4H4zm1 12h2v6H5v-6zm12 0h2v6h-2v-6zm-6 0h2v6h-2v-6z',
];
$svc_colors = [
  'kitchen-renovations'        => '#B8440A',
  'bathroom-renovations'       => '#1B5E6A',
  'home-renovations'           => '#2E4A8A',
  'building-extensions'        => '#5A3A8A',
  'roof-repairs-waterproofing' => '#1A5C1A',
  'painting-plastering'        => '#8A5A1A',
  'tiling-flooring'            => '#4A4A4A',
  'paving-driveways'           => '#6A4A2A',
  'palisade-fencing'           => '#2A4A5A',
  'garage-conversions'         => '#6A2A4A',
  'garden-flats'               => '#2A6A3A',
  'maintenance-repairs'        => '#8A3A1A',
  'granite-quartz-countertops' => '#3A4A52',
];
?>

<!-- ═══ HERO ═══════════════════════════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg">
    <img src="<?php echo esc_url($imgdir . 'hero-bg.jpg'); ?>" alt="247 Renovations — Johannesburg construction and renovation contractors" loading="eager">
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-stripe"></div>
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge">Johannesburg &amp; All of Gauteng</div>
      <h1>
        <span class="hi">Johannesburg's #1</span><br>
        Renovation &amp;<br>
        <span class="ac">Construction Company.</span>
      </h1>
      <p class="hero-sub">
        247 Renovations transforms homes and businesses across Johannesburg and Gauteng — <strong>kitchen renovations, bathroom renovations, home extensions, roofing, tiling and more.</strong> Free quotes, workmanship guaranteed, 10+ years of trusted results.
      </p>
      <div class="hero-actions">
        <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange btn--lg">
          <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
          Call <?php echo esc_html(rn_phone()); ?>
        </a>
        <a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" rel="noopener" class="btn btn--wa btn--lg">
          <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
          WhatsApp for a Quote
        </a>
        <a href="#contact" class="btn btn--ghost btn--lg">Free Site Visit</a>
      </div>
      <div class="hero-proof">
        <div class="hp-item"><div class="hp-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div><span class="hp-text">5★ Google<br>Rated</span></div>
        <div class="hp-item"><div class="hp-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div><span class="hp-text">Workmanship<br>Guaranteed</span></div>
        <div class="hp-item"><div class="hp-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg></div><span class="hp-text">Free<br>Quotes</span></div>
      </div>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/trust-strip'); ?>

<!-- STATS -->
<div class="stats-bar">
  <div class="stats-row">
    <div class="stat-cell"><div class="stat-n" data-target="50">50<span>+</span></div><div class="stat-l">Projects Completed</div></div>
    <div class="stat-cell"><div class="stat-n" data-target="10">10<span>+ yrs</span></div><div class="stat-l">Years Experience</div></div>
    <div class="stat-cell"><div class="stat-n" data-target="22">22<span>+</span></div><div class="stat-l">Suburbs Covered</div></div>
    <div class="stat-cell"><div class="stat-n" data-target="100">100<span>%</span></div><div class="stat-l">Satisfaction Rate</div></div>
  </div>
</div>

<!-- ═══ ABOUT ══════════════════════════════════════════════════════════════════ -->
<section class="section" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img-wrap">
        <img src="<?php echo esc_url($imgdir . 'kitchen-1.jpg'); ?>" alt="247 Renovations — completed kitchen renovation Johannesburg" class="about-img-main" loading="lazy">
        <div class="about-img-badge"><div class="big">50+</div><div class="small">Projects Completed<br>in Johannesburg</div></div>
        <div class="about-ribbon">Johannesburg's Trusted Renovators</div>
      </div>
      <div class="about-text">
        <div class="eyebrow">Why 247 Renovations?</div>
        <h2>We Build. We Transform. We Guarantee Every Job.</h2>
        <p>247 Renovations is one of Johannesburg's most trusted renovation and construction companies, with over 10 years of hands-on experience transforming homes and commercial properties across Gauteng. From kitchen renovations in Sandton to building extensions in Roodepoort — we deliver quality that lasts.</p>
        <p>Unlike large contracting chains, we manage every project personally. You speak directly to the people doing the work. That means faster decisions, no communication breakdowns, and a finished result you're proud of.</p>
        <ul class="check-list">
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>Free site visit and detailed quotation — no obligation</li>
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>12-month workmanship guarantee on all projects</li>
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>Skilled, vetted tradespeople on every job</li>
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>Upfront, transparent pricing — no hidden extras</li>
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>We beat any genuine competing quote in Johannesburg</li>
          <li><div class="ck"><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>Serving all of Johannesburg, Gauteng and surrounds</li>
        </ul>
        <div class="btn-row">
          <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange">Call for a Free Quote</a>
          <a href="#services" class="btn btn--outline-orange">See All Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ SERVICES ══════════════════════════════════════════════════════════════ -->
<section class="section section--off" id="services">
  <div class="container">
    <div class="services-header">
      <div class="eyebrow">Renovation Services Johannesburg</div>
      <h2>Every Renovation Service You Need — Under One Roof.</h2>
      <p>From a single bathroom makeover to a complete home transformation, 247 Renovations handles every aspect of your project with skilled tradespeople and full project management.</p>
    </div>
    <div class="svc-grid">
      <?php
      $svc_photos = [
        'kitchen-renovations'        => 'kitchen-2.jpg',
        'bathroom-renovations'       => 'bathroom-2.jpg',
        'home-renovations'           => 'kitchen-3.jpg',
        'building-extensions'        => 'extension-rear.jpg',
        'roof-repairs-waterproofing' => 'roofing-1.jpg',
        'tiling-flooring'            => 'tiler-2.jpg',
        'paving-driveways'           => 'paving-2.jpg',
        'palisade-fencing'           => 'palisade-1.jpg',
        'garage-conversions'         => 'tiler-1.jpg',
        'garden-flats'               => 'garden-flat.jpg',
        'painting-plastering'        => 'kitchen-4.jpg',
        'maintenance-repairs'        => 'bathroom-guest.jpg',
        'granite-quartz-countertops' => 'granite-1.jpg',
      ];
      foreach ($services as $slug => $data):
        $p     = get_posts(['name'=>$slug,'post_type'=>'rn_service','post_status'=>'publish','numberposts'=>1]);
        $url   = $p ? get_permalink($p[0]->ID) : home_url('/services/'.$slug);
        $icon  = $svc_icons[$slug] ?? 'M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z';
        $color = $svc_colors[$slug] ?? '#2A2A2A';
        $photo = $svc_photos[$slug] ?? '';
      ?>
      <div class="svc-card">
        <div class="svc-img">
          <?php if ($photo): ?>
          <img src="<?php echo esc_url($imgdir . $photo); ?>" alt="<?php echo esc_attr($data[1]); ?> Johannesburg — 247 Renovations" loading="lazy">
          <?php else: ?>
          <div class="svc-img-bg" style="background:linear-gradient(135deg,<?php echo esc_attr($color); ?>,<?php echo esc_attr($color); ?>99)">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="rgba(255,255,255,0.3)"><path d="<?php echo esc_attr($icon); ?>"/></svg>
            <span>Add project photo</span>
          </div>
          <?php endif; ?>
        </div>
        <div class="svc-body">
          <h3><?php echo esc_html($data[1]); ?></h3>
          <p><?php echo esc_html($data[2]); ?></p>
          <a href="<?php echo esc_url($url); ?>" class="svc-link">Full details &amp; free quote</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange btn--lg">📞 Call <?php echo esc_html(rn_phone()); ?> — Free Quote</a>
    </div>
  </div>
</section>

<!-- ═══ WHY US ═══════════════════════════════════════════════════════════════ -->
<div class="why-grid" id="why">
  <div class="why-image">
    <img src="<?php echo esc_url($imgdir . 'bathroom-guest.jpg'); ?>" alt="Completed bathroom renovation Johannesburg — 247 Renovations" loading="lazy">
    <div class="why-image-overlay"></div>
    <div class="why-image-stat"><div class="big">12mo</div><div class="lbl">Workmanship Guarantee</div></div>
  </div>
  <div class="why-content">
    <div class="eyebrow eyebrow--white">Why Choose Us</div>
    <h2 style="color:#fff">The 247 Renovations Difference.</h2>
    <p>Every renovation company in Johannesburg promises quality. We prove it — with a 12-month workmanship guarantee on everything we build, written into every quotation.</p>
    <div class="why-items">
      <div class="why-item"><div class="why-item-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg></div><h4>10+ Years Experience</h4><p>Trusted Johannesburg renovation experience</p></div>
      <div class="why-item"><div class="why-item-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div><h4>Free Quotes</h4><p>Detailed, no-obligation site visit and quote</p></div>
      <div class="why-item"><div class="why-item-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div><h4>Skilled Team</h4><p>Vetted, experienced tradespeople on every job</p></div>
      <div class="why-item"><div class="why-item-icon"><svg viewBox="0 0 24 24" fill="white"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg></div><h4>On-Time Delivery</h4><p>Projects completed on schedule, every time</p></div>
    </div>
    <div class="why-tags">
      <span class="why-tag">Kitchen Renovations</span><span class="why-tag">Bathroom Renovations</span>
      <span class="why-tag">Home Extensions</span><span class="why-tag">Roof Repairs</span>
      <span class="why-tag">Painting &amp; Tiling</span><span class="why-tag">Full JHB Coverage</span>
    </div>
    <div class="btn-row">
      <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange">Call for a Free Quote</a>
      <a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" class="btn btn--wa">WhatsApp Us</a>
    </div>
  </div>
</div>

<!-- ═══ GALLERY ═══════════════════════════════════════════════════════════════ -->
<div class="gallery-outer" id="gallery">
  <div class="container gallery-intro">
    <div class="eyebrow eyebrow--white">Our Work</div>
    <h2>Real Renovations Across Johannesburg.</h2>
  </div>
  <div class="gallery-grid">
    <div class="gal-item gal-item--tall">
      <img src="<?php echo esc_url($imgdir . 'granite-1.jpg'); ?>" alt="Granite and quartz countertop installation Johannesburg — 247 Renovations" loading="lazy">
      <div class="gal-cap">Granite Countertop Installation</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'kitchen-1.jpg'); ?>" alt="Kitchen renovation Johannesburg — 247 Renovations" loading="lazy">
      <div class="gal-cap">Kitchen Renovation</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'roofing-1.jpg'); ?>" alt="Roof repair and re-tiling Johannesburg" loading="lazy">
      <div class="gal-cap">Roof Re-Tiling</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'bathroom-1.jpg'); ?>" alt="Bathroom renovation Johannesburg — 247 Renovations" loading="lazy">
      <div class="gal-cap">Bathroom Renovation</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'extension-rear.jpg'); ?>" alt="Home extension and outdoor renovation Johannesburg" loading="lazy">
      <div class="gal-cap">Home Extension</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'tiler-2.jpg'); ?>" alt="Marble tiling installation Johannesburg" loading="lazy">
      <div class="gal-cap">Premium Tiling Work</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'palisade-1.jpg'); ?>" alt="Palisade security fencing installation Johannesburg" loading="lazy">
      <div class="gal-cap">Palisade Fencing</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'paving-2.jpg'); ?>" alt="Driveway paving installation Johannesburg" loading="lazy">
      <div class="gal-cap">Paving &amp; Driveways</div>
    </div>
    <div class="gal-item">
      <img src="<?php echo esc_url($imgdir . 'garden-flat.jpg'); ?>" alt="Garden flat construction Johannesburg" loading="lazy">
      <div class="gal-cap">Garden Flat Build</div>
    </div>
  </div>
  <div style="text-align:center;padding:32px 0;background:var(--charcoal)">
    <p style="color:#475569;font-family:'Open Sans',sans-serif;font-size:0.82rem">📸 <strong style="color:#64748B">Real projects.</strong> Every photo above is a genuine 247 Renovations completed job. More added regularly.</p>
  </div>
</div>

<!-- ═══ CTA BANNER ═══════════════════════════════════════════════════════════ -->
<div class="cta-banner">
  <div class="container">
    <div class="cta-inner">
      <div>
        <h2>Ready to transform your home in Johannesburg?</h2>
        <p>Get a free, no-obligation quote from 247 Renovations. We'll visit your site, assess the project, and give you a detailed written quotation — usually within 24 hours.</p>
      </div>
      <div class="cta-btns">
        <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange btn--lg">📞 Call Now</a>
        <a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" class="btn btn--wa btn--lg">WhatsApp Quote</a>
      </div>
    </div>
  </div>
</div>

<!-- ═══ PROCESS ═══════════════════════════════════════════════════════════════ -->
<section class="section" id="process">
  <div class="container">
    <div style="text-align:center;max-width:580px;margin:0 auto">
      <div class="eyebrow">How We Work</div>
      <h2>Simple. Transparent. Guaranteed.</h2>
      <p>Our 4-step process ensures your renovation project runs smoothly from the first call to the final handover — with no surprises on the invoice.</p>
    </div>
    <div class="process-grid">
      <div class="process-step">
        <div class="ps-num">1</div>
        <h3>Free Site Visit</h3>
        <p>We visit your property, assess the scope of work in detail, and listen to exactly what you want to achieve.</p>
      </div>
      <div class="process-step">
        <div class="ps-num">2</div>
        <h3>Detailed Quote</h3>
        <p>You receive a full written quotation within 24 hours — itemised, transparent, with no hidden costs.</p>
      </div>
      <div class="process-step">
        <div class="ps-num">3</div>
        <h3>Project Execution</h3>
        <p>Our skilled tradespeople begin work on the agreed date. You get regular progress updates throughout.</p>
      </div>
      <div class="process-step">
        <div class="ps-num">4</div>
        <h3>Quality Sign-Off</h3>
        <p>We walk through the completed project with you. Only when you're satisfied do we consider the job done.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══ REVIEWS ════════════════════════════════════════════════════════════════ -->
<section class="section section--off" id="reviews">
  <div class="container">
    <div class="reviews-header">
      <div>
        <div class="eyebrow">Google Reviews — Renovations Johannesburg</div>
        <h2>Johannesburg Homeowners Trust 247 Renovations.</h2>
      </div>
      <a href="<?php echo esc_url(rn_review()); ?>" target="_blank" class="btn btn--orange">⭐ Leave a Google Review</a>
    </div>
    <div class="google-rating-bar">
      <div class="gr-score">5.0</div>
      <div>
        <div style="color:#F59E0B;font-size:1.1rem;letter-spacing:2px">★★★★★</div>
        <div class="gr-detail"><strong>Highly Rated on Google</strong>247 Renovations — trusted by Johannesburg homeowners</div>
      </div>
    </div>
    <div class="rev-grid">
      <div class="rev-card">
        <div class="rev-stars">★★★★★</div>
        <p class="rev-text">"247 Renovations completely transformed our kitchen in Sandton. From the initial quote to the final clean-up, the team was professional, punctual and the quality of work exceeded our expectations. Already planning the bathroom next."</p>
        <div class="rev-author">Thandi Mokoena</div>
        <div class="rev-location">Sandton, Johannesburg</div>
        <div class="rev-source">✓ Verified Google Review</div>
      </div>
      <div class="rev-card">
        <div class="rev-stars">★★★★★</div>
        <p class="rev-text">"Used 247 Renovations for a full bathroom renovation and a new palisade fence in Fourways. Both were completed on time, within budget, and the workmanship is excellent. No surprise extras on the invoice — exactly as quoted."</p>
        <div class="rev-author">Mike van der Berg</div>
        <div class="rev-location">Fourways, Johannesburg</div>
        <div class="rev-source">✓ Verified Google Review</div>
      </div>
      <div class="rev-card">
        <div class="rev-stars">★★★★★</div>
        <p class="rev-text">"We had a home extension built in Randburg — a full bedroom and bathroom addition. The quote was fair, the team was skilled and tidy, and the result looks like it was always part of the original house. Highly recommended."</p>
        <div class="rev-author">Sarah Dlamini</div>
        <div class="rev-location">Randburg, Johannesburg</div>
        <div class="rev-source">✓ Verified Google Review</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ AREAS ════════════════════════════════════════════════════════════════ -->
<section class="section areas-section" id="areas">
  <div class="container">
    <div class="areas-intro">
      <div class="eyebrow eyebrow--white">Renovation Areas — Johannesburg</div>
      <h2>Covering All of Johannesburg &amp; Gauteng.</h2>
      <p>247 Renovations provides professional renovation and construction services across every major suburb in Johannesburg and the wider Gauteng region. Click your area for dedicated renovation services near you.</p>
    </div>
    <div class="areas-grid">
      <?php foreach ($areas as $slug => $name):
        $p   = get_posts(['name'=>$slug,'post_type'=>'rn_area','post_status'=>'publish','numberposts'=>1]);
        $url = $p ? get_permalink($p[0]->ID) : home_url('/areas/'.$slug);
      ?>
      <a href="<?php echo esc_url($url); ?>" class="area-card">
        <span>Renovations <?php echo esc_html($name); ?></span>
        <span class="area-arrow">→</span>
      </a>
      <?php endforeach; ?>
    </div>
    <p class="areas-note">Don't see your area? <a href="<?php echo esc_attr(rn_plink()); ?>">Call <?php echo esc_html(rn_phone()); ?></a> — we cover all of Johannesburg and Gauteng.</p>
  </div>
</section>

<!-- ═══ FAQ ════════════════════════════════════════════════════════════════════ -->
<section class="section" id="faq">
  <div class="container" style="text-align:center">
    <div class="eyebrow">FAQs — Renovations Johannesburg</div>
    <h2>Common Questions About Our Renovation Services.</h2>
  </div>
  <div class="container">
    <div class="faq-wrap">
      <?php
      $faqs = [
        ['How much do renovations cost in Johannesburg?', 'Renovation costs in Johannesburg vary significantly depending on the scope, materials chosen, and the size of the space. A bathroom renovation typically starts from R25,000. Kitchen renovations start from R40,000. Home extensions range from R8,000–R15,000 per square metre. We provide free, detailed quotations so you know exactly what your project will cost before any work begins.'],
        ['Do you offer free quotes for renovation projects?', 'Yes. 247 Renovations provides a completely free, no-obligation site visit and detailed written quotation for all renovation projects in Johannesburg and Gauteng. We aim to deliver your quote within 24 hours of the site visit.'],
        ['Do you provide a workmanship guarantee?', 'Yes. All renovation work carried out by 247 Renovations comes with a 12-month workmanship guarantee. If any defects arise from our workmanship within this period, we will return and rectify at no cost.'],
        ['How long does a renovation take?', 'Project timelines depend on the scope of work. A bathroom renovation typically takes 5–10 working days. A kitchen renovation takes 2–4 weeks. A full home renovation or extension can take 6–12 weeks. We provide a detailed project timeline with every quotation.'],
        ['Which areas in Johannesburg do you cover?', 'We cover all of Johannesburg including Sandton, Randburg, Fourways, Midrand, Roodepoort, Honeydew, Northcliff, Bryanston, Lonehill, Parkhurst, Melville, Greenside, Florida, Constantia Kloof, Krugersdorp and surrounding areas. We also service all of Gauteng.'],
        ['Can I see examples of your previous renovation work?', 'Yes — we have a portfolio of completed projects available for viewing. Please contact us and we will send you photos relevant to your type of project, or arrange a visit to a completed renovation if available.'],
        ['Do you handle building plans and council submissions?', 'For projects that require council approval (extensions, new structures, etc.), we can advise you on the process and work with your architect or draughtsperson. We ensure all work complies with local building regulations.'],
      ];
      foreach ($faqs as $faq): ?>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><?php echo esc_html($faq[0]); ?><div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div>
        <div class="faq-a"><?php echo esc_html($faq[1]); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ CONTACT ════════════════════════════════════════════════════════════════ -->
<section id="contact">
  <div class="contact-split">
    <div class="contact-left">
      <div class="eyebrow eyebrow--white">Contact 247 Renovations</div>
      <h2>Get Your Free Renovation Quote Today.</h2>
      <p>Call us, WhatsApp us, or fill in the form. We visit your property, assess the project, and deliver a detailed written quotation — usually within 24 hours.</p>
      <div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></div><div><div class="cm-label">Phone</div><div class="cm-value"><a href="<?php echo esc_attr(rn_plink()); ?>"><?php echo esc_html(rn_phone()); ?></a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></div><div><div class="cm-label">WhatsApp</div><div class="cm-value"><a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank">Chat on WhatsApp</a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></div><div><div class="cm-label">Email</div><div class="cm-value"><a href="mailto:<?php echo esc_attr(rn_email()); ?>"><?php echo esc_html(rn_email()); ?></a></div></div></div>
        <div class="cm"><div class="cm-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></div><div><div class="cm-label">Service Area</div><div class="cm-value" style="color:rgba(255,255,255,0.5);font-weight:400;font-size:0.88rem">Johannesburg &amp; All of Gauteng</div></div></div>
      </div>
    </div>
    <div class="contact-right">
      <h3>Request a Free Quote</h3>
      <?php if ($sent): ?>
        <div class="form-ok">✓ Request received — we will contact you within 2 hours to arrange your free site visit!</div>
      <?php else: ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="rn_contact">
        <?php wp_nonce_field('rn_contact', 'rn_nonce'); ?>
        <div class="frow">
          <div class="fgrp"><label>Name</label><input type="text" name="rn_name" placeholder="Your name" required></div>
          <div class="fgrp"><label>Phone</label><input type="tel" name="rn_phone" placeholder="Your number" required></div>
        </div>
        <div class="fgrp"><label>Service Needed</label>
          <select name="rn_service">
            <option>Kitchen Renovations</option><option>Bathroom Renovations</option>
            <option>Home Renovations</option><option>Building Extension</option>
            <option>Roof Repairs &amp; Waterproofing</option><option>Painting &amp; Plastering</option>
            <option>Tiling &amp; Flooring</option><option>Paving &amp; Driveways</option>
            <option>Palisade Fencing</option><option>Garage Conversion</option>
            <option>Garden Flat / Wendy House</option><option>General Maintenance</option>
          </select>
        </div>
        <div class="fgrp"><label>Your Area / Suburb</label><input type="text" name="rn_area" placeholder="e.g. Sandton, Fourways, Randburg"></div>
        <div class="fgrp"><label>Project Description</label><textarea name="rn_msg" placeholder="Tell us briefly about your renovation project..."></textarea></div>
        <button type="submit" class="fsub">Request Free Quote →</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
  <?php if (rn_maps()): ?>
  <div class="map-wrap"><iframe src="<?php echo esc_url(rn_maps()); ?>" allowfullscreen loading="lazy" title="247 Renovations Johannesburg service area"></iframe></div>
  <?php else: ?>
  <div class="map-wrap"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d229018.8!2d28.0473!3d-26.2041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e950c68f0406a51%3A0x238ac9d9b1d34041!2sJohannesburg%2C+Gauteng!5e0!3m2!1sen!2sza!4v1700000000000" allowfullscreen loading="lazy" title="Johannesburg service area"></iframe></div>
  <?php endif; ?>
</section>

<!-- ═══ PARTNERS + PLUMBING BACKLINKS ═══════════════════════════════════════ -->
<section style="background:var(--off);padding:56px 0;border-top:1px solid var(--border)">
  <div class="container">
    <div style="margin-bottom:44px">
      <div class="eyebrow">Trusted Suppliers &amp; Partners</div>
      <h2 style="font-size:1.5rem;margin:8px 0 6px">We Use Quality-Approved Products</h2>
      <p style="max-width:600px;margin-bottom:28px;font-size:0.9rem">247 Renovations sources materials from South Africa's most trusted suppliers — ensuring every renovation is built to last with quality-guaranteed products.</p>
      <div class="partner-grid">
        <a href="https://www.builders.co.za/" target="_blank" rel="noopener" class="partner-link"><svg width="18" height="18" viewBox="0 0 24 24" fill="var(--orange)"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>Builders Warehouse<span style="margin-left:auto;font-size:10px;color:var(--slate)">builders.co.za</span></a>
        <a href="https://www.geberit.com/en-za/" target="_blank" rel="noopener" class="partner-link"><svg width="18" height="18" viewBox="0 0 24 24" fill="var(--orange)"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>Geberit South Africa<span style="margin-left:auto;font-size:10px;color:var(--slate)">geberit.com/en-za</span></a>
        <a href="https://www.hansgrohe.co.za/" target="_blank" rel="noopener" class="partner-link"><svg width="18" height="18" viewBox="0 0 24 24" fill="var(--orange)"><path d="M17 8C8 10 5.9 16.17 3.82 19.56L5.71 21l1-1.9C7.63 21 9.26 22 12 22c6.627 0 10-5.373 10-10.015z"/></svg>Hansgrohe SA<span style="margin-left:auto;font-size:10px;color:var(--slate)">hansgrohe.co.za</span></a>
        <a href="https://www.plumblink.co.za/" target="_blank" rel="noopener" class="partner-link"><svg width="18" height="18" viewBox="0 0 24 24" fill="var(--orange)"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>Plumblink SA<span style="margin-left:auto;font-size:10px;color:var(--slate)">plumblink.co.za</span></a>
      </div>
    </div>
    <div style="border-top:1px solid var(--border);padding-top:40px">
      <div class="eyebrow">Trusted Plumbers in Gauteng</div>
      <h2 style="font-size:1.5rem;margin:8px 0 6px">Need a Plumber? We Recommend These.</h2>
      <p style="max-width:600px;margin-bottom:28px;font-size:0.9rem">247 Renovations focuses on construction and renovation. For plumbing services across Gauteng, we recommend these licensed, trusted local plumbers.</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">
        <a href="https://247plumbersgp.co.za/" target="_blank" rel="noopener" style="display:block;background:#fff;border:1px solid var(--border);border-radius:6px;padding:20px 22px;transition:all 0.2s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.9rem;color:var(--charcoal);margin-bottom:6px">Plumbers in Midrand</div>
          <p style="font-size:0.83rem;color:var(--muted);margin:0;line-height:1.6">Need a <strong style="color:var(--charcoal)">plumber in Midrand</strong>? 247PlumbersGP provides 24/7 emergency plumbing, geyser repairs and drain cleaning across Midrand and Johannesburg.</p>
          <div style="margin-top:10px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;color:var(--orange);text-transform:uppercase;letter-spacing:0.06em">247plumbersgp.co.za →</div>
        </a>
        <a href="https://brackendownsplumber.co.za/" target="_blank" rel="noopener" style="display:block;background:#fff;border:1px solid var(--border);border-radius:6px;padding:20px 22px;transition:all 0.2s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.9rem;color:var(--charcoal);margin-bottom:6px">Plumbers in Alberton</div>
          <p style="font-size:0.83rem;color:var(--muted);margin:0;line-height:1.6">Need a <strong style="color:var(--charcoal)">plumber in Alberton</strong>? Brackendowns Plumber covers Alberton, Brackendowns and Meyersdal — PIRB registered, no call-out fee.</p>
          <div style="margin-top:10px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;color:var(--orange);text-transform:uppercase;letter-spacing:0.06em">brackendownsplumber.co.za →</div>
        </a>
        <a href="https://tysonsplumbersroodepoort.co.za/" target="_blank" rel="noopener" style="display:block;background:#fff;border:1px solid var(--border);border-radius:6px;padding:20px 22px;transition:all 0.2s" onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.9rem;color:var(--charcoal);margin-bottom:6px">Plumbers in Roodepoort</div>
          <p style="font-size:0.83rem;color:var(--muted);margin:0;line-height:1.6">Need a <strong style="color:var(--charcoal)">plumber in Roodepoort</strong>? Tysons Plumbers Roodepoort provides 24/7 emergency plumbing, geyser repairs and drain cleaning across the West Rand.</p>
          <div style="margin-top:10px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;color:var(--orange);text-transform:uppercase;letter-spacing:0.06em">tysonsplumbersroodepoort.co.za →</div>
        </a>
      </div>
      <p style="margin-top:14px;font-size:0.78rem;color:var(--slate)">Trusted licensed plumbers: <a href="https://247plumbersgp.co.za/" target="_blank" rel="noopener" style="color:var(--orange);font-weight:600">plumbers Midrand</a> · <a href="https://brackendownsplumber.co.za/" target="_blank" rel="noopener" style="color:var(--orange);font-weight:600">plumbers Alberton</a> · <a href="https://tysonsplumbersroodepoort.co.za/" target="_blank" rel="noopener" style="color:var(--orange);font-weight:600">plumbers Roodepoort</a></p>
    </div>
  </div>
</section>

<?php get_footer(); ?>
