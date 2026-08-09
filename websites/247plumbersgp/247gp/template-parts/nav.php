<?php
$is_home    = is_front_page() || is_home();
$home_url   = home_url('/');
$phone      = gp_phone();
$phone_link = gp_phone_link();

// If on homepage use pure #hash — browser scrolls instantly
// If on inner page use full URL + #hash — browser navigates home then scrolls
function gp_anchor($id) {
    if (is_front_page() || is_home()) {
        return '#' . $id;
    }
    return home_url('/') . '#' . $id;
}
?>

<!-- Pass homepage URL to JS so scroll detection works on any page -->
<script>window.gp_home = '<?php echo esc_js(home_url('/')); ?>';</script>

<nav id="site-nav">
  <div class="nav-inner">

    <!-- LOGO -->
    <a href="<?php echo esc_url($home_url); ?>" class="logo" aria-label="247 Plumbers GP Home">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="247 Plumbers GP" class="logo-img">
      <div class="logo-sub-wrap">
        <div class="logo-sub">Midrand · Gauteng · 24/7</div>
      </div>
    </a>

    <!-- HAMBURGER (mobile) -->
    <button class="hamburger" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <!-- NAV LINKS -->
    <ul class="nav-links" role="list">
      <li><a href="<?php echo esc_url(gp_anchor('services')); ?>">Services</a></li>
      <li><a href="<?php echo esc_url(gp_anchor('areas')); ?>">Areas</a></li>
      <li><a href="<?php echo esc_url(gp_anchor('reviews')); ?>">Reviews</a></li>
      <li><a href="<?php echo esc_url(gp_anchor('faq')); ?>">FAQ</a></li>
      <li><a href="<?php echo esc_url(home_url('/articles/')); ?>">Articles</a></li>
      <li><a href="<?php echo esc_url(gp_anchor('contact')); ?>">Contact</a></li>
      <li><a href="<?php echo esc_attr($phone_link); ?>" class="nav-call">📞 <?php echo esc_html($phone); ?></a></li>
    </ul>

  </div>
</nav>

<!-- EMERGENCY BAR -->
<div class="emergency-bar">
  <p>🚨 Plumbing Emergency?
    <a href="<?php echo esc_attr($phone_link); ?>">Call <?php echo esc_html($phone); ?> now</a>
    — On-site in 30 minutes, 24/7
  </p>
</div>
