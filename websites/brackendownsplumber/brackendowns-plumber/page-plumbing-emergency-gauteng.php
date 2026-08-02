<?php
/**
 * Template Name: Article - East Rand Plumbing Emergency Prevention
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
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">East Rand Plumbing Emergency Prevention</span><meta itemprop="position" content="3"/></li>
  </ol>
</div></nav>
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h1 class="display">The East Rand Plumbing<br>Emergency Checklist</h1>
    <p>Most plumbing emergencies here follow a handful of predictable patterns. Know them, and you can catch most before they become a real crisis.</p>
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

      <h2>Why East Rand Homes See Certain Emergencies More Than Others</h2>
      <p>After years of call-outs across Brackendowns, Alberton, Germiston and Boksburg, the same handful of emergency patterns come up again and again — mostly tied to the age of the area's housing stock and the mix of residential, commercial and light-industrial properties nearby. Knowing what to watch for catches most of these before they become genuine emergencies.</p>

      <h2>Watch For These Warning Signs</h2>
      <ul>
        <li><strong>A geyser isolator switch that's been tripping repeatedly</strong> — often the first sign before a full burst, especially in units over 8 years old</li>
        <li><strong>Damp patches on ceilings below bathrooms</strong> — slow leaks in older homes' pipework rarely announce themselves suddenly</li>
        <li><strong>Water pressure that's dropped noticeably over a few weeks</strong> — can indicate a slow underground leak rather than a municipal supply issue</li>
        <li><strong>Gurgling drains when you flush</strong> — usually means a partial blockage that will become a full one within days, not weeks</li>
        <li><strong>Discoloured water after any period without use</strong> — common where original galvanised piping is still in place</li>
      </ul>
      <p>Catching any of these early is almost always cheaper and less disruptive than the emergency call-out that follows if they're ignored.</p>

      <h2>If It's Already an Emergency: The First Two Things</h2>
      <p>Whatever the specific problem, two actions matter more than anything else in the first few minutes:</p>
      <p><strong>1. Find your main stopcock and know how to use it before you need to.</strong> It's usually at your water meter near the boundary wall. Knowing exactly where it is now saves critical minutes during an actual flood.</p>
      <p><strong>2. If water is anywhere near electrical points or your DB board, cut power at the main breaker first.</strong> Everything else — mopping, moving furniture, calling us — comes after that.</p>

      <h2>A Quick Reference for the Most Common Call-Outs</h2>
      <ul>
        <li><strong>Burst geyser:</strong> isolator switch off, cold water inlet valve off, don't attempt to drain it yourself</li>
        <li><strong>Burst pipe:</strong> main stopcock off, open an inside tap to relieve pressure, photograph the damage for insurance</li>
        <li><strong>Blocked drain backing up:</strong> stop using water in that part of the house immediately — using it upstream forces the backup further</li>
        <li><strong>No water at all:</strong> check with a neighbour first — if it's just your property, it's likely a supply pipe issue between the meter and your home, not a municipal fault</li>
      </ul>

      <div class="highlight-box">
        <h3>Save This Number Before You Need It</h3>
        <p><strong><a href="<?php echo esc_attr($plink); ?>" style="color:var(--red)"><?php echo esc_html($phone); ?></a></strong> — available 24/7 across Brackendowns, Alberton, Germiston, Boksburg, Springs, Brakpan, Benoni and the wider East Rand. No call-out fee.</p>
      </div>

    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>
<?php get_footer(); ?>
