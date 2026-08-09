<?php
/**
 * Template Name: Articles / Blog
 * Brackendowns Plumber — articles listing page.
 * Create a WordPress Page titled "Articles", set its slug to "articles",
 * and set its Template (Page Attributes panel) to "Articles / Blog".
 */
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$articles = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
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
        <span itemprop="name">Articles</span>
        <meta itemprop="position" content="2"/>
      </li>
    </ol>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles &amp; Guides</div>
    <h1 class="display">Plumbing Tips for Brackendowns<br>&amp; East Rand Homeowners</h1>
    <p>Practical advice on geysers, leaks, drains and everything plumbing — written by the team at Brackendowns Plumber.</p>
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
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>4.8★ Google Rating</div>
</div></div>

<!-- FEATURED GUIDES (separate WordPress Pages, not part of the Posts query below) -->
<section class="section" style="padding-bottom:0">
  <div class="container">
    <div class="eyebrow">Featured Guides</div>
    <div class="articles-grid" style="margin-bottom:12px">
      <a href="<?php echo esc_url(home_url('/geyser-repair-vs-replacement/')); ?>" style="display:block;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.07);text-decoration:none">
        <div style="width:100%;height:200px;background:var(--navy);display:flex;align-items:center;justify-content:center">
          <svg width="40" height="40" fill="rgba(255,255,255,.3)" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 19.56L5.71 21l1-1.9C7.63 21 9.26 22 12 22c6.627 0 10-5.373 10-10.015C22 7.455 19.603 5.07 17 8z"/></svg>
        </div>
        <div style="padding:22px">
          <h2 style="font-size:1.15rem;color:var(--navy);margin-bottom:10px;line-height:1.3">Is Your Geyser Worth Fixing?</h2>
          <p style="font-size:.88rem;color:var(--muted);margin:0">Not sure whether to repair or replace? Here's how to decide based on age, damage and cost.</p>
        </div>
      </a>
      <a href="<?php echo esc_url(home_url('/plumbing-emergency-gauteng/')); ?>" style="display:block;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.07);text-decoration:none">
        <div style="width:100%;height:200px;background:var(--navy);display:flex;align-items:center;justify-content:center">
          <svg width="40" height="40" fill="rgba(255,255,255,.3)" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 19.56L5.71 21l1-1.9C7.63 21 9.26 22 12 22c6.627 0 10-5.373 10-10.015C22 7.455 19.603 5.07 17 8z"/></svg>
        </div>
        <div style="padding:22px">
          <h2 style="font-size:1.15rem;color:var(--navy);margin-bottom:10px;line-height:1.3">The East Rand Plumbing Emergency Checklist</h2>
          <p style="font-size:.88rem;color:var(--muted);margin:0">Warning signs to catch early, and exactly what to do if it's already too late.</p>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ARTICLES GRID -->
<section class="section">
  <div class="container">
    <div class="eyebrow">Latest Articles</div>
    <?php if ($articles->have_posts()): ?>
      <div class="articles-grid">
        <?php while ($articles->have_posts()): $articles->the_post(); ?>
          <a href="<?php the_permalink(); ?>" style="display:block;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.07);text-decoration:none;transition:transform .2s">
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('medium_large', ['style' => 'width:100%;height:200px;object-fit:cover']); ?>
            <?php else: ?>
              <div style="width:100%;height:200px;background:var(--navy);display:flex;align-items:center;justify-content:center">
                <svg width="40" height="40" fill="rgba(255,255,255,.3)" viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 19.56L5.71 21l1-1.9C7.63 21 9.26 22 12 22c6.627 0 10-5.373 10-10.015C22 7.455 19.603 5.07 17 8z"/></svg>
              </div>
            <?php endif; ?>
            <div style="padding:22px">
              <p style="font-size:.74rem;color:var(--red);font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px"><?php echo esc_html(get_the_date('j F Y')); ?></p>
              <h2 style="font-size:1.15rem;color:var(--navy);margin-bottom:10px;line-height:1.3"><?php the_title(); ?></h2>
              <p style="font-size:.88rem;color:var(--muted);margin:0"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>

      <!-- PAGINATION -->
      <div style="display:flex;justify-content:center;gap:10px;margin-top:44px">
        <?php
        echo paginate_links([
            'total'     => $articles->max_num_pages,
            'current'   => $paged,
            'prev_text' => '← Newer',
            'next_text' => 'Older →',
        ]);
        ?>
      </div>
      <?php wp_reset_postdata(); ?>
    <?php else: ?>
      <p style="text-align:center;color:var(--muted)">No articles published yet — check back soon.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
