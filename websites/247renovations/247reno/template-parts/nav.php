<?php
$services = unserialize(RN_SERVICES);
$areas    = unserialize(RN_AREAS);
$is_home  = is_front_page() || is_home();
$anc = function($id) use ($is_home){ return $is_home ? '#'.$id : home_url('/').'#'.$id; };
?>
<nav class="site-nav" id="site-nav">
  <div class="nav-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
      <img src="<?php echo esc_url(rn_imgdir() . 'logo.png'); ?>" alt="247 Renovations — Johannesburg construction and renovation company" class="logo-img">
      <div class="logo-tag-wrap">
        <div class="logo-tag">Johannesburg &amp; Gauteng</div>
      </div>
    </a>
    <button class="hamburger" aria-label="Toggle menu"><span></span><span></span><span></span></button>
    <ul class="nav-menu">
      <!-- SERVICES DROPDOWN -->
      <li class="nav-item">
        <a href="<?php echo esc_url($anc('services')); ?>">
          Services
          <svg class="chev" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
        </a>
        <div class="dropdown">
          <?php foreach ($services as $slug => $data):
            $p = get_posts(['name'=>$slug,'post_type'=>'rn_service','post_status'=>'publish','numberposts'=>1]);
            $url = $p ? get_permalink($p[0]->ID) : home_url('/services/'.$slug);
          ?>
          <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($data[1]); ?></a>
          <?php endforeach; ?>
        </div>
      </li>
      <!-- AREAS DROPDOWN -->
      <li class="nav-item">
        <a href="<?php echo esc_url($anc('areas')); ?>">
          Areas
          <svg class="chev" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
        </a>
        <div class="dropdown">
          <?php foreach ($areas as $slug => $name):
            $p = get_posts(['name'=>$slug,'post_type'=>'rn_area','post_status'=>'publish','numberposts'=>1]);
            $url = $p ? get_permalink($p[0]->ID) : home_url('/areas/'.$slug);
          ?>
          <a href="<?php echo esc_url($url); ?>">Renovations <?php echo esc_html($name); ?></a>
          <?php endforeach; ?>
        </div>
      </li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('gallery')); ?>">Our Work</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('reviews')); ?>">Reviews</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('process')); ?>">How We Work</a></li>
      <li class="nav-item"><a href="<?php echo esc_url($anc('contact')); ?>">Contact</a></li>
      <li class="nav-item"><a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" rel="noopener" class="nav-wa-btn">WhatsApp</a></li>
      <li class="nav-item"><a href="<?php echo esc_attr(rn_plink()); ?>" class="nav-cta">📞 <?php echo esc_html(rn_phone()); ?></a></li>
    </ul>
  </div>
</nav>
<div class="embar">
  <div class="container">
    <p>🏗️ Free quotes on all renovation projects in Johannesburg — <a href="<?php echo esc_attr(rn_plink()); ?>"><?php echo esc_html(rn_phone()); ?></a> · Workmanship guaranteed</p>
    <a href="<?php echo esc_attr(rn_plink()); ?>" class="embar-btn">Get Free Quote</a>
  </div>
</div>
