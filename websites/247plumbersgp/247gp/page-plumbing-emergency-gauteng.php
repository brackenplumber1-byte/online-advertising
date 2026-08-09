<?php
/**
 * Template Name: Article - Plumbing Emergency Gauteng
 */
get_header();
$phone = gp_phone();
$plink = gp_phone_link();
$wa    = gp_wa_link();
?>
<nav class="breadcrumb" aria-label="Breadcrumb"><div class="container">
  <ol itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/'); ?>" itemprop="item"><span itemprop="name">Home</span></a><meta itemprop="position" content="1"/></li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/articles/'); ?>" itemprop="item"><span itemprop="name">Articles</span></a><meta itemprop="position" content="2"/></li>
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">Plumbing Emergency in Gauteng</span><meta itemprop="position" content="3"/></li>
  </ol>
</div></nav>
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h1 class="display">Plumbing Emergency in Gauteng?<br>Here's What to Do</h1>
    <p>Burst pipe? Flooding? Geyser burst? Here's exactly what to do in the first 10 minutes — before the plumber arrives.</p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr($plink); ?>" class="btn btn--red">📞 Call <?php echo esc_html($phone); ?> Now</a>
      <a href="<?php echo esc_url($wa); ?>" target="_blank" class="btn btn--ghost">WhatsApp Us</a>
    </div>
  </div>
</div>
<?php get_template_part('template-parts/trust-strip'); ?>
<div class="container">
  <div class="content-grid">
    <div class="content-body article-body">

      <h2>The First 10 Minutes Matter Most</h2>
      <p>A plumbing emergency in Gauteng — a burst pipe flooding a room, a geyser letting go in the ceiling, a sewer backup — can cause thousands of rands of damage in a short time. Most of that damage doesn't happen from the initial failure. It happens in the minutes while people are in shock, not sure what to do, waiting for the plumber.</p>

      <h2>Burst or Leaking Pipe</h2>
      <p><strong>Step 1: Turn off your main water supply immediately.</strong> Your main stopcock is usually at your water meter — outside the house, often near the boundary wall. Turn it clockwise until it stops.</p>
      <p><strong>Step 2: Open a tap inside</strong> to drain the remaining pressure in the pipes. This reduces water that continues leaking after the main is off.</p>
      <p><strong>Step 3: If water is near any electrical points</strong> — switches, plug sockets, or your DB board — switch off the electricity at your main circuit breaker first. Water and live electricity are an extremely dangerous combination.</p>
      <p><strong>Step 4: Call a 24/7 plumber and take photos.</strong> Document the damage before cleaning up — your home insurer will need evidence.</p>

      <h2>Burst Geyser</h2>
      <p><strong>Step 1: Switch off the geyser isolator switch.</strong> This is a small red switch usually on the wall near the geyser cupboard. Switching this off cuts power to the heating element.</p>
      <p><strong>Step 2: Turn off the cold water supply to the geyser</strong> — the geyser has its own isolation valve on the cold water inlet pipe. This stops water continuing to fill a damaged unit.</p>
      <p><strong>Step 3: Check whether water is coming through your ceiling.</strong> If it is, move furniture and valuables out immediately. Place buckets and towels, and take photos for your insurance claim.</p>
      <p><strong>Step 4: Don't try to drain the geyser yourself</strong> unless you know exactly what you're doing. A pressurised geyser contains very hot water.</p>

      <h2>Blocked or Overflowing Drain</h2>
      <p><strong>Step 1: Stop using all water in that section of the house</strong> — no flushing, running taps, or using basins that drain into the blocked line. Using water upstream forces sewage to back up through the nearest lower outlet.</p>
      <p><strong>Step 2: Don't use chemical drain cleaners</strong> on a fully blocked main line — they're ineffective and can damage older pipes. This needs professional hydro-jetting equipment.</p>

      <h2>No Water at All</h2>
      <p>Check two things first. One: do your neighbours also have no water? If so, it's a council supply issue — call your municipality. Two: is your water account up to date? If both check out and you still have no water, you likely have a burst supply pipe between the meter and the house.</p>

      <div class="highlight-box">
        <h3>Emergency Plumber in Gauteng — Call Now</h3>
        <p>Save our number before you need it: <strong><a href="<?php echo esc_attr($plink); ?>" style="color:var(--red)"><?php echo esc_html($phone); ?></a></strong>. Available 24/7 across Midrand, Johannesburg, Centurion, Sandton, Pretoria, Kempton Park, Benoni, Soweto and all of Gauteng. No call-out fee.</p>
      </div>

    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>
<?php get_footer(); ?>
