<?php get_header(); ?>
<?php while(have_posts()): the_post();
  $name     = get_the_title();
  $slug     = get_post_field('post_name', get_the_ID());
  $desc     = get_post_meta(get_the_ID(),'gp_meta_desc',true) ?: get_the_excerpt();
  $services = unserialize(GP_SERVICES);
  $areas    = unserialize(GP_AREAS);
  $svc_links=''; foreach($services as $k=>$v){ $p2=get_posts(['name'=>$k,'post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null; $url=$p2?get_permalink($p2->ID):home_url('/services/'.$k); $svc_links.="<li><a href='".esc_url($url)."'>".esc_html($v)." in ".esc_html($name)."</a></li>"; }
  $nearby_areas = gp_nearby_areas($slug, $areas, 6);
  $other_areas=''; foreach($nearby_areas as $k=>$v){ $p2=get_posts(['name'=>$k,'post_type'=>'gp_area','post_status'=>'publish','numberposts'=>1])[0] ?? null; $url=$p2?get_permalink($p2->ID):home_url('/areas/'.$k); $other_areas.="<li><a href='".esc_url($url)."'>Plumber in ".esc_html($v)."</a></li>"; }
?>

<!-- BREADCRUMB -->
<nav class="breadcrumb" aria-label="Breadcrumb"><div class="container">
  <ol itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/'); ?>" itemprop="item"><span itemprop="name">Home</span></a><meta itemprop="position" content="1"/></li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/#areas'); ?>" itemprop="item"><span itemprop="name">Areas</span></a><meta itemprop="position" content="2"/></li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">Plumber in <?php echo esc_html($name); ?></span><meta itemprop="position" content="3"/></li>
  </ol>
</div></nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumber in <?php echo esc_html($name); ?></div>
    <h1 class="display">Emergency Plumber<br>in <?php echo esc_html($name); ?></h1>
    <p>Fast, reliable, PIRB-registered plumbers serving <?php echo esc_html($name); ?> and surrounding areas. Available 24/7 — no call-out fee, on-site in 30 minutes.</p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr(gp_phone_link()); ?>" class="btn btn--red">📞 Call <?php echo esc_html(gp_phone()); ?> Now</a>
      <a href="<?php echo esc_url(gp_wa_link()); ?>" target="_blank" class="btn btn--ghost">WhatsApp Us</a>
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

<!-- AREA PHOTO -->
<?php
$area_photo_pool = ['geyser-branded.jpg', 'leak-detection-branded.jpg', 'pipe-branded.jpg', 'geyser-solar-roof.jpg', 'bathroom-freestanding-bath.jpg', 'water-tank-1.jpg'];
$area_photo = $area_photo_pool[abs(crc32($slug)) % count($area_photo_pool)];
$imgdir = get_template_directory_uri() . '/assets/images/';
?>
<div class="container" style="padding-top:32px">
  <img src="<?php echo esc_url($imgdir . $area_photo); ?>" alt="247 Plumbers GP — plumber in <?php echo esc_attr($name); ?>" style="width:100%;max-height:380px;object-fit:cover;border-radius:8px">
</div>

<!-- CONTENT -->
<div class="container">
  <div class="content-grid">
    <div class="content-body">
      <h2>Your Local Plumber in <?php echo esc_html($name); ?></h2>
      <p>247 Plumbers GP provides fast, professional plumbing services to residents and businesses in <?php echo esc_html($name); ?>. Based in nearby Midrand, we can reach <?php echo esc_html($name); ?> quickly — making us one of the fastest-responding plumbing companies in the area.</p>
      <p>Our PIRB-registered plumbers handle everything from burst pipe emergencies at 2am to full geyser installations and bathroom renovations. When you call us, you speak to a plumber — not a receptionist.</p>

      <?php
      // Genuine contextual links woven into real sentences, not another
      // boilerplate list — this is deliberately linking to two priority
      // pages (Emergency Plumbing, Geyser Repair) from every area page,
      // concentrating some real internal link weight on them rather than
      // spreading everything perfectly flat across all 47 pages equally.
      $emerg_post = get_posts(['name'=>'emergency-plumbing','post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null;
      $emerg_url  = $emerg_post ? get_permalink($emerg_post->ID) : home_url('/services/emergency-plumbing');
      $geyser_post = get_posts(['name'=>'geyser-repair','post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null;
      $geyser_url  = $geyser_post ? get_permalink($geyser_post->ID) : home_url('/services/geyser-repair');
      ?>
      <p>If you're dealing with a burst pipe or flooding right now, our <a href="<?php echo esc_url($emerg_url); ?>">24/7 emergency plumbing service</a> gets a plumber to you fast, day or night. For a geyser that's stopped heating or started leaking, our <a href="<?php echo esc_url($geyser_url); ?>">geyser repair specialists</a> carry parts for all major brands and often fix it same-day.</p>

      <h2>Plumbing Services Available in <?php echo esc_html($name); ?></h2>
      <ul><?php echo $svc_links; ?></ul>

      <h2>Why <?php echo esc_html($name); ?> Residents Choose Us</h2>
      <ul>
        <li>Based in Midrand — fast response to <?php echo esc_html($name); ?></li>
        <li>Available 24 hours a day, 7 days a week including all public holidays</li>
        <li>No call-out fee — you only pay for work done</li>
        <li>PIRB-registered plumbers with compliance certificates</li>
        <li>Transparent, upfront quotes before any work begins</li>
        <li>Full workmanship guarantee on all jobs</li>
        <li>Over 10 years serving Midrand and Gauteng</li>
      </ul>

      <?php if(get_the_content()): ?>
      <div><?php the_content(); ?></div>
      <?php endif; ?>

      <h3>Emergency Plumber in <?php echo esc_html($name); ?> — Available Right Now</h3>
      <p>Plumbing emergencies don't wait. If you have a burst pipe, blocked drain, or no hot water in <?php echo esc_html($name); ?>, call us immediately on <a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red);font-weight:700"><?php echo esc_html(gp_phone()); ?></a>. We're available right now, 24 hours a day.</p>

      <h3>Geyser Repairs &amp; Installation in <?php echo esc_html($name); ?></h3>
      <p>No hot water in <?php echo esc_html($name); ?>? Our geyser specialists can diagnose and repair your geyser, or supply and install a new one — same day in most cases. We carry PIRB compliance certificates (CoC) as required by your home insurer.</p>

      <h3>Drain Cleaning in <?php echo esc_html($name); ?></h3>
      <p>Blocked drains and toilets are one of the most common plumbing problems in <?php echo esc_html($name); ?>. Our team uses high-pressure jetting equipment to clear blockages completely — not just temporarily.</p>

      <div style="background:var(--off);border-left:4px solid var(--red);padding:20px 24px;margin:28px 0;border-radius:0 4px 4px 0">
        <h3 style="margin:0 0 8px">Need a Plumber in <?php echo esc_html($name); ?> Now?</h3>
        <p style="margin:0">Call <strong><a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red)"><?php echo esc_html(gp_phone()); ?></a></strong> — 24/7, no call-out fee, on-site in 30 minutes.</p>
      </div>

      <h2>Other Areas We Serve Near <?php echo esc_html($name); ?></h2>
      <ul><?php echo $other_areas; ?></ul>
    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<!-- REVIEW STRIP -->
<div class="review-strip">
  <div class="container">
    <h2 style="font-size:1.4rem;font-weight:800;color:var(--navy);margin-bottom:24px">Trusted by <?php echo esc_html($name); ?> Residents</h2>
    <div class="review-strip-grid">
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"Called at midnight with a burst pipe. They were here in 20 minutes. Absolute professionals."</blockquote><div class="mini-reviewer">— Resident, <?php echo esc_html($name); ?></div></div>
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"Best plumber I've used in years. Honest pricing, clean work, and a proper guarantee."</blockquote><div class="mini-reviewer">— Homeowner, <?php echo esc_html($name); ?></div></div>
      <div class="mini-review"><div class="stars">★★★★★</div><blockquote>"Fixed our geyser same day. Very professional. No surprise charges. Will use again."</blockquote><div class="mini-reviewer">— Customer, <?php echo esc_html($name); ?></div></div>
    </div>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
