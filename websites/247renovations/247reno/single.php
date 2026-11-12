<?php get_header(); ?>
<?php while (have_posts()): the_post(); ?>

<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol>
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo home_url('/#blog'); ?>">Articles</a></li>
      <li><?php the_title(); ?></li>
    </ol>
  </div>
</nav>

<div class="page-hero">
  <div class="container">
    <div class="eyebrow eyebrow--white">Renovation Articles &amp; Guides</div>
    <h1><?php the_title(); ?></h1>
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
      <?php if (has_post_thumbnail()): ?>
      <?php the_post_thumbnail('large', ['style' => 'width:100%;height:340px;object-fit:cover;border-radius:6px;margin-bottom:32px']); ?>
      <?php endif; ?>

      <article>
        <?php the_content(); ?>
      </article>

      <div class="highlight-box">
        <h3>Ready to get started? Get a free quote today.</h3>
        <p>Call <strong><a href="<?php echo esc_attr(rn_plink()); ?>" style="color:var(--orange)"><?php echo esc_html(rn_phone()); ?></a></strong> or WhatsApp us — free site visit, detailed written quotation within 24 hours. Serving all of Johannesburg and Gauteng.</p>
      </div>
    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
