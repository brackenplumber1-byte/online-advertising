<?php get_header(); ?>
<?php while (have_posts()): the_post();
  $area_name = get_post_meta(get_the_ID(),'tp_area_name',true) ?: get_the_title();
  $slug      = get_post_field('post_name', get_the_ID());
  $response_time = tp_area_response_time($slug);
  $imgdir    = get_template_directory_uri() . '/assets/images/';
  $services  = unserialize(TP_SERVICES);
  $areas     = unserialize(TP_AREAS);

  $svc_links = '';
  foreach ($services as $s_slug => $s_name) {
    $p = get_posts(['name'=>$s_slug,'post_type'=>'tp_service','post_status'=>'publish','numberposts'=>1]);
    $url = $p ? get_permalink($p[0]->ID) : home_url('/services/'.$s_slug);
    $svc_links .= '<li><a href="'.esc_url($url).'">'.esc_html($s_name).' in '.esc_html($area_name).'</a></li>';
  }
  $nearby_areas = tp_nearby_areas($slug, $areas, 8);
  $other_areas = '';
  foreach ($nearby_areas as $a_slug => $a_name) {
    $p = get_posts(['name'=>$a_slug,'post_type'=>'tp_area','post_status'=>'publish','numberposts'=>1]);
    $url = $p ? get_permalink($p[0]->ID) : home_url('/areas/'.$a_slug);
    $other_areas .= '<li><a href="'.esc_url($url).'">Plumbers '.esc_html($a_name).'</a></li>';
  }
?>

<!-- BREADCRUMB -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol>
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo home_url('/#areas'); ?>">Areas</a></li>
      <li>Plumbers <?php echo esc_html($area_name); ?></li>
    </ol>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="container reveal">
    <div class="eyebrow eyebrow--white">Plumbers in <?php echo esc_html($area_name); ?></div>
    <h1>Emergency Plumber in <?php echo esc_html($area_name); ?> — 24/7, No Call-Out Fee</h1>
    <p>Searching for a plumber near me in <?php echo esc_html($area_name); ?>? Tysons Plumbers Roodepoort provides fast, reliable plumbing services in <?php echo esc_html($area_name); ?>. Available 24 hours a day for emergencies — geyser repairs, drain cleaning, burst pipes, and more. On-site within <?php echo esc_html($response_time); ?>. No call-out fee.</p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire btn--lg">📞 Call <?php echo esc_html(tp_phone()); ?></a>
      <a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank" class="btn btn--wa">WhatsApp Us</a>
    </div>
  </div>
</div>
<?php get_template_part('template-parts/trust-strip'); ?>

<!-- CONTENT -->
<div class="container">
  <div class="content-layout">
    <div class="content-body reveal">

      <?php
      $area_photo_pool = ['job-geyser-replacement.webp','job-leak-detection.webp','job-tree-root-drain.webp','job-jojo-tank.webp','job-geyser-highpressure.webp','job-kitchen-tap.webp','job-drain-manhole.webp','job-blocked-drain.webp','job-underground-valve.webp','job-pressure-valve.webp','job-geyser-roofspace.webp','job-geyser-dark-roofspace.webp','job-underground-pipe.webp','job-toilet-installation.webp'];
      $area_photo = $area_photo_pool[abs(crc32($slug)) % count($area_photo_pool)];
      ?>
      <img src="<?php echo esc_url($imgdir.$area_photo); ?>" alt="Plumbers <?php echo esc_attr($area_name); ?> — Tysons Plumbers Roodepoort" style="width:100%;height:340px;object-fit:cover;border-radius:6px;margin-bottom:32px" loading="lazy">

      <h2>Your Local Plumber in <?php echo esc_html($area_name); ?></h2>
      <p>Tysons Plumbers Roodepoort has been serving <?php echo esc_html($area_name); ?> and surrounding areas with professional, reliable plumbing services. Based in nearby Roodepoort, we can reach <?php echo esc_html($area_name); ?> quickly — making us one of the fastest-responding plumbers in the area.</p>
      <p>When you call Tysons Plumbers in <?php echo esc_html($area_name); ?>, you speak directly to a licensed plumber — not a call centre. We give you a clear, honest quote before starting, and we stand behind every job with a 12-month workmanship guarantee.</p>

      <?php
      // Genuinely local context per suburb — not generic template filler.
      $local_context = [
        'honeydew'         => "Honeydew's mix of established homes and newer sectional title developments means our call-outs range from ageing geyser replacements to modern complex plumbing — often within the same street.",
        'wilgeheuwel'      => "Wilgeheuwel's established residential streets mean ageing pipework and original geysers are common — we carry fittings suited to older homes on every vehicle.",
        'florida'          => "Florida is one of Roodepoort's oldest suburbs, and its older housing stock means original galvanised pipework and long-overdue geysers are frequent finds — often the real cause behind a symptom that looks like something smaller.",
        'constantia-kloof' => "Constantia Kloof's hilly terrain and larger properties mean water pressure issues and longer pipe runs are common — we test and adjust pressure as part of most jobs here.",
        'weltevreden-park' => "Weltevreden Park's mix of family homes and nearby retail and office nodes keeps us busy with both residential plumbing and small commercial maintenance work.",
        'ruimsig'          => "Ruimsig's newer estates and larger modern homes mean we're often called for bigger installations — full geyser systems, water backup tanks, and multi-bathroom plumbing — rather than small repairs.",
        'little-falls'     => "Little Falls' established, leafy streets mean mature tree roots finding their way into older drain lines is one of our more common call-outs in the area.",
        'helderkruin'      => "Helderkruin's hillside streets mean water pressure and gravity-fed drainage issues are common — we check pressure valves as standard on most jobs here.",
        'northcliff'       => "Northcliff's older, established housing stock — some of it decades old — means ageing pipework and original plumbing infrastructure come up often, alongside the newer developments further down the ridge.",
        'radiokop'         => "Radiokop's newer security estates and hillside developments mean modern plumbing systems, but the terrain still makes water pressure a common thing we check and adjust.",
        'poortview'        => "Poortview's smaller, established residential character means we mostly handle routine maintenance, geyser servicing, and the occasional emergency call-out.",
        'strubensvalley'   => "Strubensvalley's mix of townhouse complexes and family homes near the shopping nodes means we regularly work with both individual homeowners and complex trustees on shared plumbing.",
        'witpoortjie'      => "Witpoortjie's older, more established housing stock means ageing pipes and original fittings are common — we carry parts suited to older installations.",
        'roodekrans'       => "Roodekrans' larger properties and smallholding-style plots near the nature areas mean longer pipe runs and borehole-adjacent plumbing come up more often here than in denser suburbs.",
        'krugersdorp'      => "Krugersdorp's older mining-town-era infrastructure in parts of the CBD and surrounding suburbs means ageing municipal connections and original household plumbing are common factors in call-outs.",
        'randfontein'      => "Randfontein's older housing stock, similar to other West Rand mining towns, means original pipework and overdue geyser replacements are frequent finds on inspection.",
        'florida-lake'     => "Florida Lake's established homes around the lake area mean we regularly handle both routine maintenance and the occasional flooding-related emergency after heavy Highveld storms.",
        'laser-park'       => "Laser Park's mix of light industrial, commercial and residential means our work here ranges from standard household plumbing to small business and office maintenance.",
        'roodepoort'       => "Roodepoort is our home base, so it's where we're fastest — a mix of older established suburbs and newer developments across the CBD and surrounding neighbourhoods means our call-outs range from ageing pipework to modern complex installations.",
        'randburg'         => "Randburg's mix of older established homes and busy commercial nodes around the CBD means we handle everything from residential geyser and drain work to small business plumbing maintenance. It's a longer drive than our core West Rand coverage, so response times here are realistically a bit further out than in Roodepoort itself.",
        'fourways'         => "Fourways' rapid growth means a lot of newer complexes and estates, alongside older standalone homes further from the main roads. It's the furthest point in our current coverage area from our Roodepoort base, so we're upfront that response times here depend on traffic on the N1 and William Nicol corridor.",
        // ── West Rand / Roodepoort core ──────────────────────────────────
        'allensnek'        => "Allensnek's hillside streets and mostly established homes mean water pressure and ageing pipework are common things we check on a typical call-out here.",
        'amorosa'          => "Amorosa's mix of secure complexes and family homes keeps our work here fairly evenly split between modern installations and routine maintenance.",
        'bergbron'         => "Bergbron's established, older housing stock near the N1 means original pipework and overdue geyser replacements come up often on inspection.",
        'blackheath'       => "Blackheath is one of Roodepoort's smaller, older residential pockets, where ageing fittings and original plumbing infrastructure are the norm rather than the exception.",
        'creswell-park'    => "Creswell Park's compact, established streets mean most of our work here is routine maintenance and geyser servicing rather than large installations.",
        'davidsonville'    => "Davidsonville's established residential character means we mostly handle routine repairs, geyser servicing, and the occasional emergency call-out.",
        'delarey'          => "Delarey's older housing stock near the Roodepoort CBD means original galvanised pipework and ageing municipal connections are common factors in our call-outs.",
        'discovery'        => "Discovery's established homes close to the Roodepoort centre mean a steady mix of routine maintenance and occasional larger repairs on older infrastructure.",
        'fleurhof'         => "Fleurhof's newer residential development means modern plumbing systems, though we still get called out for standard installation and maintenance work as the area grows.",
        'georginia'        => "Georginia's smaller, established residential streets mean routine maintenance and geyser servicing make up most of our work here.",
        'groblerpark'      => "Groblerpark's larger properties and established homes mean longer pipe runs and occasional water pressure issues are more common here than in denser suburbs.",
        'horison'          => "Horison's elevated, hillside position means water pressure is something we check as standard, alongside the ageing pipework typical of this established suburb.",
        'horison-park'     => "Horison Park shares Horison's hillside terrain, so pressure-related issues and gravity-fed drainage checks are a regular part of our work here.",
        'horison-view'     => "Horison View's newer sections higher up the ridge mean more modern plumbing systems, though terrain still makes pressure worth checking on most jobs.",
        'panorama'         => "Panorama's hillside position and mix of home ages mean we handle everything from modern installations to ageing pipework, depending on the specific street.",
        'princess'         => "Princess is one of Roodepoort's older established suburbs near the CBD, where original pipework and overdue geyser replacements are frequent finds.",
        'quellerina'       => "Quellerina's smaller, established residential character means routine maintenance and geyser servicing are our most common call-outs here.",
        'wilropark'        => "Wilropark's family homes near the local shopping centre keep us busy with a mix of residential plumbing and occasional small commercial maintenance.",
        'florida-glen'     => "Florida Glen shares Florida's older housing stock, so original galvanised pipework and overdue geysers are frequent finds on inspection.",
        'florida-hills'    => "Florida Hills' elevated streets mean water pressure is worth checking alongside the ageing pipework common to this part of Florida.",
        'florida-north'    => "Florida North's mix of established homes means routine maintenance and geyser servicing make up the bulk of our work in this part of the suburb.",
        // ── Randburg / Fourways / Muldersdrift corridor ──────────────────
        'fontainebleau'    => "Fontainebleau's mix of townhouse complexes and older standalone homes means we regularly work with both individual homeowners and complex trustees on shared plumbing.",
        'northgate'        => "Northgate's residential streets near the shopping centre mean a steady mix of household plumbing and occasional small commercial maintenance work.",
        'olivedale'        => "Olivedale's family homes and complexes keep our work here fairly evenly split between routine maintenance and larger installations.",
        'bromhof'          => "Bromhof's established, smaller residential character means routine maintenance and geyser servicing are our most common call-outs.",
        'ferndale'         => "Ferndale's mix of commercial and residential properties means our work ranges from standard household plumbing to small business maintenance.",
        'cosmo-city'       => "Cosmo City's newer, larger housing development means modern plumbing systems, with most call-outs being standard installation and maintenance work as the area continues to grow.",
        'douglasdale'      => "Douglasdale's mix of older standalone homes and newer complexes means we handle both ageing pipework repairs and modern installations depending on the property.",
        'broadacres'       => "Broadacres' larger properties near the retail nodes mean longer pipe runs and occasional water pressure adjustments come up more than in denser areas.",
        'dainfern'         => "Dainfern's upmarket estate homes mean our work here tends toward larger installations and full bathroom or geyser system upgrades rather than small repairs.",
        'lonehill'         => "Lonehill's mix of complexes and family estates means we regularly work with both individual homeowners and body corporates on shared plumbing systems.",
        'craigavon'        => "Craigavon's larger properties and smallholding-style plots mean longer pipe runs and borehole-adjacent plumbing come up more often here than in denser suburbs.",
        'muldersdrift'     => "Muldersdrift's rural, smallholding character means borehole systems and longer pipe runs are a regular part of our work, alongside standard household plumbing.",
        'featherbrooke-estate' => "Featherbrooke Estate's newer secure homes mean modern plumbing systems, with most call-outs being routine maintenance or minor installation work.",
        'northriding'      => "Northriding's mix of townhouses and family homes means we regularly handle both individual homeowner call-outs and shared complex plumbing.",
        'cresta'           => "Cresta's residential streets near the shopping centre mean a steady mix of household plumbing and occasional small commercial work.",
        'randpark-ridge'   => "Randpark Ridge's larger, established properties mean longer pipe runs and ageing infrastructure are common factors in our call-outs here.",
        'bordeaux'         => "Bordeaux's smaller, established residential character means routine maintenance and geyser servicing make up most of our work in this suburb.",
        'blairgowrie'      => "Blairgowrie's established homes close to the shopping nodes mean a steady mix of routine maintenance and occasional larger repairs.",
        'robindale'        => "Robindale's older established housing stock means original pipework and overdue geyser replacements are frequent finds on inspection.",
        'fairland'         => "Fairland's established, older homes mean ageing pipework and original fittings are common — we carry parts suited to older installations here.",
        // ── Krugersdorp / Randfontein / Mogale City cluster ──────────────
        'rant-en-dal'      => "Rant-en-Dal's older, established housing stock reflects Krugersdorp's mining-town history — original pipework and overdue geyser replacements are common finds.",
        'noordheuwel'      => "Noordheuwel shares Krugersdorp's older infrastructure, so ageing municipal connections and original household plumbing are common factors in our call-outs.",
        'monument'         => "Monument's position near the Krugersdorp CBD means older commercial and residential plumbing infrastructure both come up in our work here.",
        'silverfields'     => "Silverfields' established residential character means routine maintenance and geyser servicing make up most of our work in this part of Krugersdorp.",
        'west-village'     => "West Village's mix of home ages means we handle both ageing pipework repairs and more modern installation work depending on the specific property.",
        'chancliff'        => "Chancliff's smaller, established residential streets mean routine maintenance and occasional emergency call-outs are typical here.",
        'kagiso'           => "Kagiso's older municipal infrastructure and established housing stock mean ageing connections and original household plumbing are common factors in our call-outs.",
        'toekomsrus'       => "Toekomsrus' established housing stock, similar to other Randfontein-area suburbs, means original pipework and overdue geyser replacements are frequent finds on inspection.",
        'greenhills'       => "Greenhills' established homes mean routine maintenance and geyser servicing make up most of our work in this part of Randfontein.",
        'mohlakeng'        => "Mohlakeng's older municipal infrastructure and established housing stock mean ageing connections and original household plumbing are common factors here, similar to nearby Randfontein suburbs.",
        'azaadville'       => "Azaadville's established, close-knit residential character means routine maintenance and geyser servicing are our most common call-outs.",
        'rietfontein'      => "Rietfontein's smallholding and rural-fringe character near Krugersdorp means borehole systems and longer pipe runs are a regular part of our work here.",
        'luipaardsvlei'    => "Luipaardsvlei's older, established character reflects the area's mining history — original pipework and ageing infrastructure are common factors in our call-outs.",
      ];
      if (!empty($local_context[$slug])):
      ?>
      <h2>Plumbing in <?php echo esc_html($area_name); ?> — What We See Most</h2>
      <p><?php echo esc_html($local_context[$slug]); ?></p>
      <?php endif; ?>

      <h2>Plumbing Services Available in <?php echo esc_html($area_name); ?></h2>
      <ul><?php echo $svc_links; ?></ul>

      <h2>Why <?php echo esc_html($area_name); ?> Residents Choose Tysons Plumbers</h2>
      <ul>
        <li>Based in Roodepoort — fastest response time to <?php echo esc_html($area_name); ?></li>
        <li>Available 24 hours a day, 7 days a week — including public holidays</li>
        <li>No call-out fee — you only pay for the work carried out</li>
        <li>Licensed and insured — every plumber on our team</li>
        <li>Upfront, transparent quotes before any work begins</li>
        <li>12-month workmanship guarantee on every job</li>
        <li>We beat any genuine competitor quote in <?php echo esc_html($area_name); ?></li>
        <li>PIRB Certificates of Compliance issued for geyser work</li>
      </ul>

      <h3>Emergency Plumber in <?php echo esc_html($area_name); ?> — Right Now</h3>
      <p>Plumbing emergencies in <?php echo esc_html($area_name); ?> don't wait for business hours. If you have a burst pipe, blocked drain, or no hot water in <?php echo esc_html($area_name); ?>, call Tysons Plumbers Roodepoort immediately on <a href="<?php echo esc_attr(tp_plink()); ?>" style="color:var(--fire);font-weight:700"><?php echo esc_html(tp_phone()); ?></a>. We're available right now — 24 hours a day.</p>

      <h3>Geyser Repair in <?php echo esc_html($area_name); ?></h3>
      <p>No hot water in <?php echo esc_html($area_name); ?>? Our geyser specialists can diagnose and repair your geyser — or supply and install a replacement — same day in most cases. We carry PIRB Compliance Certificates (CoC) as required by your home insurer.</p>

      <h3>Blocked Drain Cleaning in <?php echo esc_html($area_name); ?></h3>
      <p>Blocked drains are one of the most common plumbing problems in <?php echo esc_html($area_name); ?>. Our team uses high-pressure hydro jetting to clear blockages completely — not just temporarily. Kitchen drains, bathroom drains, blocked toilets, and main sewer lines all cleared fast.</p>

      <div class="highlight-box">
        <h3>Need a Plumber in <?php echo esc_html($area_name); ?> Now?</h3>
        <p>Call <strong><a href="<?php echo esc_attr(tp_plink()); ?>" style="color:var(--fire)"><?php echo esc_html(tp_phone()); ?></a></strong> — 24/7, no call-out fee, on-site within <?php echo esc_html($response_time); ?>.</p>
      </div>

      <?php if (get_the_content()): ?>
      <div><?php the_content(); ?></div>
      <?php endif; ?>

      <h2>Frequently Asked Questions — Plumbers in <?php echo esc_html($area_name); ?></h2>
      <?php
      $area_faqs = [
          ['Is there a plumber near me in ' . $area_name . '?', 'Yes — we cover ' . $area_name . ' directly, so if you\'re searching "plumber near me" from ' . $area_name . ', we aim to have someone on-site within ' . $response_time . '.'],
          ['How much does a plumber cost in ' . $area_name . '?', 'It depends on the job. We give a free, upfront quote before starting any work in ' . $area_name . ', and we never charge a call-out fee.'],
          ['Do you offer same-day service in ' . $area_name . '?', 'In most cases, yes. Burst pipes, blocked drains and geyser failures in ' . $area_name . ' are treated as emergencies and prioritised for same-day attention.'],
          ['Are your plumbers in ' . $area_name . ' licensed and PIRB registered?', 'Yes. Every plumber we send to ' . $area_name . ' is licensed and insured, and we issue PIRB Certificates of Compliance for geyser installations and other qualifying work.'],
      ];
      ?>
      <div class="faq-wrap">
        <?php foreach ($area_faqs as $fq): ?>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><?php echo esc_html($fq[0]); ?><div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a"><?php echo esc_html($fq[1]); ?></div></div>
        <?php endforeach; ?>
      </div>
      <?php
      $area_faq_schema = ['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>array_map(function($fq){
          return ['@type'=>'Question','name'=>$fq[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$fq[1]]];
      }, $area_faqs)];
      echo '<script type="application/ld+json">'.wp_json_encode($area_faq_schema, JSON_UNESCAPED_SLASHES).'</script>'."\n";
      ?>

      <h2>Other Areas We Serve Near <?php echo esc_html($area_name); ?></h2>
      <ul><?php echo $other_areas; ?></ul>
    </div>

    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<!-- MINI REVIEWS -->
<div style="background:var(--light);padding:56px 0;border-top:1px solid var(--border)">
  <div class="container">
    <h2 style="margin-bottom:28px;font-size:1.6rem">Trusted by <?php echo esc_html($area_name); ?> Residents</h2>
    <div class="mini-rev-grid">
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Called at midnight with a burst pipe. They were here in under 40 minutes. Absolute professionals."</blockquote><div class="mini-rev-author">— Resident, <?php echo esc_html($area_name); ?></div></div>
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Best plumber I've used. Honest pricing, clean work, and a proper 12-month guarantee."</blockquote><div class="mini-rev-author">— Homeowner, <?php echo esc_html($area_name); ?></div></div>
      <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Fixed our geyser same day. Professional, tidy, no surprise charges. Highly recommend."</blockquote><div class="mini-rev-author">— Customer, <?php echo esc_html($area_name); ?></div></div>
    </div>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
