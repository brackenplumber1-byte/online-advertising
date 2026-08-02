<?php get_header(); ?>
<?php while (have_posts()): the_post();
    $title = get_the_title();
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
        <a href="<?php echo esc_url(home_url('/articles/')); ?>" itemprop="item"><span itemprop="name">Articles</span></a>
        <meta itemprop="position" content="2"/>
      </li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?php echo esc_html($title); ?></span>
        <meta itemprop="position" content="3"/>
      </li>
    </ol>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-stripe"></div>
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h1 class="display"><?php echo esc_html($title); ?></h1>
    <p style="opacity:.85"><?php echo esc_html(get_the_date('j F Y')); ?> &middot; <?php echo esc_html(get_the_author()); ?></p>
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
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>4.9★ Google Rating</div>
</div></div>

<?php if (has_post_thumbnail()): ?>
<div class="container" style="padding-top:32px">
  <?php the_post_thumbnail('large', ['style' => 'width:100%;max-height:420px;object-fit:cover;border-radius:8px']); ?>
</div>
<?php endif; ?>

<!-- MAIN CONTENT -->
<div class="container">
  <div class="content-grid">
    <div class="content-body article-body">
      <?php the_content(); ?>

      <div class="highlight-box" style="margin-top:32px">
        <h3>Need a Plumber in Midrand or Johannesburg Right Now?</h3>
        <p>Call <strong><a href="<?php echo esc_attr(gp_phone_link()); ?>" style="color:var(--red)"><?php echo esc_html(gp_phone()); ?></a></strong> — available 24/7, no call-out fee, fast response across Gauteng.</p>
      </div>
    </div>

    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<!-- MORE ARTICLES -->
<?php
$more_articles = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
if ($more_articles->have_posts()):
?>
<section class="section" style="background:var(--off);padding:56px 0">
  <div class="container">
    <div class="eyebrow">Keep Reading</div>
    <h2 class="display" style="font-size:clamp(1.6rem,3vw,2.2rem);color:var(--navy);margin:6px 0 24px">More Plumbing Articles</h2>
    <div class="related-articles-grid">
      <?php while ($more_articles->have_posts()): $more_articles->the_post(); ?>
        <a href="<?php the_permalink(); ?>" style="display:block;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);text-decoration:none">
          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:160px;object-fit:cover']); ?>
          <?php else: ?>
            <div style="width:100%;height:160px;background:var(--navy)"></div>
          <?php endif; ?>
          <div style="padding:18px">
            <h3 style="font-size:1rem;color:var(--navy);margin-bottom:8px"><?php the_title(); ?></h3>
            <p style="font-size:.85rem;color:var(--muted);margin:0"><?php echo esc_html(get_the_date('j F Y')); ?></p>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>
