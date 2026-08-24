<?php get_header(); ?>
<?php while (have_posts()): the_post();
  $area  = get_post_meta(get_the_ID(), 'rn_area_name', true) ?: get_the_title();
  $slug  = get_post_field('post_name', get_the_ID());
  $svcs  = unserialize(RN_SERVICES);
  $areas = unserialize(RN_AREAS);

  $svc_links = '';
  foreach ($svcs as $s_slug => $s_data) {
    $sp  = get_posts(['name'=>$s_slug,'post_type'=>'rn_service','post_status'=>'publish','numberposts'=>1]);
    $url = $sp ? get_permalink($sp[0]->ID) : home_url('/services/'.$s_slug);
    $svc_links .= '<li><a href="'.esc_url($url).'">'.$s_data[1].' in '.esc_html($area).'</a></li>';
  }
  $other_areas = '';
  foreach ($areas as $a_slug => $a_name) {
    if ($a_slug === $slug) continue;
    $ap  = get_posts(['name'=>$a_slug,'post_type'=>'rn_area','post_status'=>'publish','numberposts'=>1]);
    $url = $ap ? get_permalink($ap[0]->ID) : home_url('/areas/'.$a_slug);
    $other_areas .= '<li><a href="'.esc_url($url).'">Renovations '.esc_html($a_name).'</a></li>';
  }
?>

<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol>
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo home_url('/#areas'); ?>">Areas</a></li>
      <li>Renovations <?php echo esc_html($area); ?></li>
    </ol>
  </div>
</nav>

<div class="page-hero">
  <div class="container">
    <div class="eyebrow eyebrow--white">Renovation Contractors in <?php echo esc_html($area); ?></div>
    <h1>Home Renovations in <?php echo esc_html($area); ?> — 247 Renovations Johannesburg</h1>
    <p>247 Renovations provides professional renovation and construction services in <?php echo esc_html($area); ?>, Johannesburg. Kitchen renovations, bathroom renovations, home extensions, roof repairs, tiling, painting and building maintenance. Free quotes, 12-month guarantee.</p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr(rn_plink()); ?>" class="btn btn--orange btn--lg">📞 Call <?php echo esc_html(rn_phone()); ?></a>
      <a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" class="btn btn--wa">WhatsApp for a Quote</a>
    </div>
  </div>
</div>
<?php get_template_part('template-parts/trust-strip'); ?>

<div class="container">
  <div class="content-layout">
    <div class="content-body">

      <div style="width:100%;height:320px;background:linear-gradient(135deg,#2A2A2A,#3A3A3A);border-radius:6px;margin-bottom:32px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px">
        <svg width="52" height="52" viewBox="0 0 24 24" fill="rgba(232,96,10,0.35)"><path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/></svg>
        <p style="color:rgba(255,255,255,0.25);font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;text-align:center;padding:0 24px">Add a project photo from <?php echo esc_html($area); ?> here</p>
      </div>

      <h2>Your Local Renovation Contractor in <?php echo esc_html($area); ?></h2>
      <p>247 Renovations has been serving <?php echo esc_html($area); ?> and surrounding Johannesburg suburbs with professional, reliable renovation and construction services for over 10 years. Whether you need a kitchen makeover, bathroom renovation, home extension, or building maintenance — we deliver quality work backed by a 12-month guarantee.</p>
      <p>When you contact 247 Renovations in <?php echo esc_html($area); ?>, you deal directly with the people doing the work — not a call centre. We provide a free site visit, a detailed written quotation, and a clear project timeline before any work begins.</p>

      <h2>Renovation Services Available in <?php echo esc_html($area); ?></h2>
      <ul><?php echo $svc_links; ?></ul>

      <h2>Why <?php echo esc_html($area); ?> Residents Choose 247 Renovations</h2>
      <ul>
        <li>Based in Johannesburg — fast response to <?php echo esc_html($area); ?></li>
        <li>10+ years of renovation experience across Gauteng</li>
        <li>Free site visit and detailed written quotation within 24 hours</li>
        <li>12-month workmanship guarantee on all renovation work</li>
        <li>Transparent pricing — no hidden extras after quotation</li>
        <li>Skilled, vetted tradespeople on every project</li>
        <li>We beat any genuine competitor quote in <?php echo esc_html($area); ?></li>
      </ul>

      <h3>Kitchen Renovations in <?php echo esc_html($area); ?></h3>
      <p>Looking for a kitchen renovation in <?php echo esc_html($area); ?>? 247 Renovations designs and builds custom kitchens across Johannesburg — from cupboard upgrades to complete kitchen redesigns. We handle cabinetry, countertops, tiling, plumbing, and electrical as one team. Call us for a free kitchen renovation quote in <?php echo esc_html($area); ?>.</p>

      <h3>Bathroom Renovations in <?php echo esc_html($area); ?></h3>
      <p>Transform your bathroom in <?php echo esc_html($area); ?> with 247 Renovations. We complete full bathroom renovations including tiling, waterproofing, plumbing, vanities, showers and all fixtures. Most bathroom renovations in <?php echo esc_html($area); ?> are completed within 5–10 working days. Free quote included.</p>

      <h3>Home Extensions in <?php echo esc_html($area); ?></h3>
      <p>Need more space in <?php echo esc_html($area); ?>? 247 Renovations builds professional home extensions — bedrooms, bathrooms, entertainment areas, garden flats and more. We handle building plans, council submissions, and full construction in <?php echo esc_html($area); ?>.</p>

      <div class="highlight-box">
        <h3>Get a Free Renovation Quote in <?php echo esc_html($area); ?> Today</h3>
        <p>Call <strong><a href="<?php echo esc_attr(rn_plink()); ?>" style="color:var(--orange)"><?php echo esc_html(rn_phone()); ?></a></strong> — free site visit, detailed quotation within 24 hours. 12-month workmanship guarantee. Serving <?php echo esc_html($area); ?> and all of Johannesburg.</p>
      </div>

      <?php if (get_the_content()): ?><div><?php the_content(); ?></div><?php endif; ?>

      <h2>Other Areas We Serve Near <?php echo esc_html($area); ?></h2>
      <ul><?php echo $other_areas; ?></ul>
    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<!-- MINI REVIEWS -->
<div style="background:var(--off);padding:56px 0;border-top:1px solid var(--border)">
  <div class="container">
    <h2 style="margin-bottom:28px;font-size:1.6rem">What <?php echo esc_html($area); ?> Residents Say</h2>
    <div class="mini-rev-grid">
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"247 Renovations did our kitchen in <?php echo esc_html($area); ?> — professional from start to finish. Quality work, on time, on budget."</blockquote><div class="mini-rev-author">— Homeowner, <?php echo esc_html($area); ?></div></div>
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Best renovation company I've used in Johannesburg. Honest pricing, great workmanship, clean workers. Highly recommended."</blockquote><div class="mini-rev-author">— Client, <?php echo esc_html($area); ?></div></div>
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"The 12-month guarantee and free quote made the decision easy. The finished result exceeded our expectations."</blockquote><div class="mini-rev-author">— Resident, <?php echo esc_html($area); ?></div></div>
    </div>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
