<?php
$services = unserialize(TP_SERVICES);
$areas    = unserialize(TP_AREAS);
$is_home  = is_front_page() || is_home();
$anc = function($id) use ($is_home) { return $is_home ? '#'.$id : home_url('/').'#'.$id; };
?>
<nav class="site-nav" id="site-nav">
  <div class="nav-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
      <div class="logo-icon">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/tysons-logo.webp'); ?>" alt="Tysons Plumbers Roodepoort" style="width:100%;height:100%;object-fit:cover;border-radius:8px">
      </div>
      <div>
        <div class="logo-name"><?php bloginfo('name'); ?></div>
        <div class="logo-tag">Roodepoort &amp; West Rand</div>
      </div>
    </a>
    <button class="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
    <ul class="nav-menu">
      <!-- SERVICES DROPDOWN -->
      <li class="nav-item">
        <a href="<?php echo esc_url($anc('services')); ?>">
          Services
          <svg class="chevron" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
        </a>
        <div class="dropdown">
          <?php foreach ($services as $slug => $name): ?>
            <?php $p = get_posts(['name'=>$slug,'post_type'=>'tp_service','post_status'=>'publish','numberposts'=>1]); ?>
            <a href="<?php echo $p ? esc_url(get_permalink($p[0]->ID)) : home_url('/services/'.$slug); ?>">
              <?php echo esc_html($name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </li>
      <!-- AREAS DROPDOWN -->
      <li class="nav-item">
        <a href="<?php echo esc_url($anc('areas')); ?>">
          Areas
          <svg class="chevron" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
        </a>
        <div class="dropdown">
          <?php foreach ($areas as $slug => $name): ?>
            <?php $p = get_posts(['name'=>$slug,'post_type'=>'tp_area','post_status'=>'publish','numberposts'=>1]); ?>
            <a href="<?php echo $p ? esc_url(get_permalink($p[0]->ID)) : home_url('/areas/'.$slug); ?>">
              Plumbers <?php echo esc_html($name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('process')); ?>">Our Process</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('gallery')); ?>">Our Work</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('reviews')); ?>">Reviews</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('faq')); ?>">FAQ</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('contact')); ?>">Contact</a></li>
      <li class="nav-item"><a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank" rel="noopener" class="nav-wa">WhatsApp</a></li>
      <li class="nav-item"><a href="<?php echo esc_attr(tp_plink()); ?>" class="nav-cta">📞 <?php echo esc_html(tp_phone()); ?></a></li>
    </ul>
  </div>
</nav>
<div class="embar">
  <div class="container">
    <p>🚨 24/7 Emergency Plumbers Roodepoort — <a href="<?php echo esc_attr(tp_plink()); ?>"><?php echo esc_html(tp_phone()); ?></a> — On-site in 45 minutes</p>
    <a href="<?php echo esc_attr(tp_plink()); ?>" class="embar-cta">Call Now</a>
  </div>
</div>
