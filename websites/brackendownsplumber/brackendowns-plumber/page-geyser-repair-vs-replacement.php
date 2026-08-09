<?php
/**
 * Template Name: Article - Is Your Geyser Worth Fixing
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
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">Is Your Geyser Worth Fixing</span><meta itemprop="position" content="3"/></li>
  </ol>
</div></nav>
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h1 class="display">Is Your Geyser Worth Fixing?<br>A 3-Question Test</h1>
    <p>Straight answers for Brackendowns and East Rand homeowners staring at a broken geyser and a decision to make.</p>
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

      <h2>Skip the Guesswork — Ask Yourself These Three Things</h2>
      <p>Most homeowners in Brackendowns, Alberton and the wider East Rand call us with the same underlying question dressed up differently: "is this worth fixing?" Rather than a long list of possible faults, here's the actual test our plumbers use on-site.</p>

      <h3>1. How old is the unit, really?</h3>
      <p>Not how old you think it is — check the manufacture date on the data plate if you can find it. A geyser under 6 years old with a single fault is almost always worth repairing. Past 10 years, you're often paying to delay the inevitable by a few months.</p>

      <h3>2. Is this the first fault, or the third?</h3>
      <p>One failed element on an otherwise sound unit is a normal repair. But if this is your second or third call-out on the same geyser within 18 months, the tank itself is usually the underlying problem — and no amount of element or thermostat replacements fixes a failing tank.</p>

      <h3>3. Is the water coming out discoloured?</h3>
      <p>This one matters more in older East Rand suburbs than newer developments. Established areas like Alberton, Germiston and parts of Boksburg still have plenty of homes running original 1980s-90s plumbing and galvanised pipework — rust-coloured water can mean the geyser tank lining has failed, or it can mean the problem is actually in your pipes, not the geyser at all. Worth having a plumber check both before paying for either repair.</p>

      <div class="highlight-box">
        <h3>What Repairs Actually Cost</h3>
        <ul>
          <li><strong>Element replacement:</strong> R500–R900 — the most common fix, usually done same-day</li>
          <li><strong>Thermostat replacement:</strong> R400–R700</li>
          <li><strong>Pressure relief valve:</strong> R600–R1,200</li>
        </ul>
      </div>

      <h2>The Case for Replacing Instead</h2>
      <p>Full replacement makes more sense once you're looking at visible tank corrosion, a cracked tank body, or that third repair call-out. A supplied-and-installed replacement in Gauteng typically runs R8,000–R18,000 depending on size and type — which is exactly why the 3-question test above matters: a R700 fix on a sound 4-year-old unit is obvious, but so is stopping the cycle of repeated repairs on a tank that's already failing.</p>

      <h2>Worth Considering While You're At It: Backup Water</h2>
      <p>If you're facing a full geyser replacement anyway, it's a natural moment to also think about a water backup tank — particularly relevant here given how often municipal supply interruptions affect parts of the East Rand independently of load shedding. We install both together when it makes sense, so you're not paying for a second visit later.</p>

      <h2>What Your Insurer Will Ask For</h2>
      <p>Any geyser replacement claimed through home insurance requires a valid <strong>PIRB Certificate of Compliance (CoC)</strong>, which only a registered plumber can issue. Every replacement we do includes this as standard — not an optional extra you have to remember to ask for.</p>

      <div class="highlight-box">
        <h3>Not Sure Which Side of the Line You're On?</h3>
        <p>Call <strong><a href="<?php echo esc_attr($plink); ?>" style="color:var(--red)"><?php echo esc_html($phone); ?></a></strong> — we'll give you a straight answer on-site, not an upsell. Available 24/7, no call-out fee, PIRB registered.</p>
      </div>

    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>
<?php get_footer(); ?>
