<?php
/**
 * Template Name: Article - Geyser Repair vs Replacement
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
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">Geyser Repair vs Replacement</span><meta itemprop="position" content="3"/></li>
  </ol>
</div></nav>
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h1 class="display">Geyser Repair vs Replacement:<br>How to Decide</h1>
    <p>A practical guide for Gauteng homeowners — covering costs, warning signs, and what a PIRB plumber will recommend.</p>
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

      <h2>The Question Every Gauteng Homeowner Eventually Asks</h2>
      <p>Your geyser has stopped working — or it's leaking, making strange noises, or producing lukewarm water at best. The plumber is on his way. But before he arrives, you're already wondering: is this going to be a repair, or am I looking at a full replacement?</p>
      <p>The honest answer depends on four things: the age of the unit, the nature of the fault, the brand and availability of parts, and what your home insurer requires.</p>

      <h2>When Repair Is the Right Call</h2>
      <p>Most geyser faults — especially in units under 8 years old — are repairable. The most common ones are:</p>
      <ul>
        <li><strong>Failed heating element</strong> — the most frequent fault, usually R500–R900 for parts and labour</li>
        <li><strong>Thermostat failure</strong> — causes overheating or no heat, typically R400–R700 to fix</li>
        <li><strong>Pressure relief valve (PRV) dripping</strong> — a safety device that needs replacement, usually R600–R1,200</li>
        <li><strong>Leaking inlet or outlet connections</strong> — a plumbing fix rather than a geyser fault, often R500–R800</li>
      </ul>
      <p>If your geyser is under 8 years old and the fault is any of the above, repair is almost always the better financial decision. A replacement geyser plus installation in Gauteng typically runs between R8,000 and R18,000 — so a R700 element replacement on a 5-year-old unit makes obvious sense.</p>

      <h2>When Replacement Makes More Sense</h2>
      <ul>
        <li><strong>The unit is over 10 years old</strong> — even a successful repair is likely to be followed by another fault within 12–18 months</li>
        <li><strong>There is visible tank corrosion</strong> — rust-coloured hot water is a sign the inner lining has failed</li>
        <li><strong>The tank itself has cracked or is leaking at the body</strong> — this can't be repaired</li>
        <li><strong>Multiple faults in a short period</strong> — if a unit has needed two or more repairs in the past year, replacement is usually cheaper over 3 years</li>
      </ul>

      <h2>What Your Home Insurer Needs to Know</h2>
      <p>If you're replacing a geyser and want to claim from your home insurance, your insurer will almost certainly require a valid <strong>PIRB Certificate of Compliance (CoC)</strong> — issued only by a registered plumber. An unregistered plumber cannot issue one.</p>

      <h2>What Does a Geyser Replacement Cost in Gauteng?</h2>
      <ul>
        <li><strong>100L electric geyser, supply and install:</strong> R8,000–R11,000</li>
        <li><strong>150L electric geyser, supply and install:</strong> R9,500–R13,000</li>
        <li><strong>200L electric geyser, supply and install:</strong> R11,000–R16,000</li>
        <li><strong>Solar geyser (flat plate), supply and install:</strong> R18,000–R28,000</li>
        <li><strong>Heat pump water heater, supply and install:</strong> R22,000–R35,000</li>
      </ul>
      <p>These figures include the unit, labour, a new drip tray if required, and the PIRB Certificate of Compliance.</p>

      <div class="highlight-box">
        <h3>Need a Geyser Repaired or Replaced in Midrand or Gauteng?</h3>
        <p>Call <strong><a href="<?php echo esc_attr($plink); ?>" style="color:var(--red)"><?php echo esc_html($phone); ?></a></strong> — available 24/7, no call-out fee, PIRB registered.</p>
      </div>

    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>
<?php get_footer(); ?>
