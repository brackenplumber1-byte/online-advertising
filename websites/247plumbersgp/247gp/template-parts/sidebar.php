<?php
$services = unserialize(GP_SERVICES);
$areas    = unserialize(GP_AREAS);
$sb_sent  = isset($_GET['sent']) && $_GET['sent'] === '1';
?>
<aside>
  <div class="sidebar-card">
    <div class="sidebar-card-head"><h3>Book a Plumber Now</h3><p>We call back within 15 minutes</p></div>
    <div class="sidebar-card-body">
      <a href="<?php echo esc_attr(gp_phone_link()); ?>" class="sidebar-phone">
        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
        <div><div class="sidebar-phone-label">Call Now — Free</div><div class="sidebar-phone-num"><?php echo esc_html(gp_phone()); ?></div></div>
      </a>
      <a href="<?php echo esc_url(gp_wa_link()); ?>" target="_blank" class="sidebar-wa">
        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        <span>WhatsApp Us Now</span>
      </a>
      <div class="sidebar-form">
        <?php if ($sb_sent): ?>
          <div class="form-success-msg" style="background:#d1fae5;border:1.5px solid #059669;color:#065f46;padding:16px;border-radius:6px;font-weight:700;font-size:.88rem;text-align:center">✓ Request received! We'll call you back shortly.</div>
          <script>if (window.gpFireFormConversion) window.gpFireFormConversion();</script>
        <?php else: ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
          <input type="hidden" name="action" value="gp_contact">
          <?php wp_nonce_field('gp_contact','gp_nonce'); ?>
          <div class="form-group"><label class="form-label">Name</label><input type="text" name="gp_name" placeholder="Your name" required></div>
          <div class="form-group"><label class="form-label">Phone</label><input type="tel" name="gp_contact" placeholder="Your number" required></div>
          <div class="form-group"><label class="form-label">Service</label>
            <select name="gp_service">
              <?php foreach($services as $k=>$v): ?><option value="<?php echo esc_attr($v); ?>"><?php echo esc_html($v); ?></option><?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="form-submit">Get Free Quote →</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="sidebar-card sidebar-links">
    <h4>Our Services</h4>
    <ul><?php foreach($services as $slug=>$name): $p=get_posts(['name'=>$slug,'post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null; ?>
      <li><a href="<?php echo $p?esc_url(get_permalink($p->ID)):home_url('/services/'.$slug); ?>"><?php echo esc_html($name); ?></a></li>
    <?php endforeach; ?></ul>
    <h4 style="padding-top:4px">Areas We Cover</h4>
    <ul><?php foreach($areas as $slug=>$name): $p=get_posts(['name'=>$slug,'post_type'=>'gp_area','post_status'=>'publish','numberposts'=>1])[0] ?? null; ?>
      <li><a href="<?php echo $p?esc_url(get_permalink($p->ID)):home_url('/areas/'.$slug); ?>"><?php echo esc_html($name); ?></a></li>
    <?php endforeach; ?></ul>
  </div>
  <?php
  // Recent articles — appears on every service/area page, so each article
  // keeps picking up fresh inbound links as the blog grows over time
  // instead of relying solely on the homepage's "latest 3" rotation.
  $sb_articles = new WP_Query(['post_type'=>'post','posts_per_page'=>5,'orderby'=>'date','order'=>'DESC']);
  if ($sb_articles->have_posts()): ?>
  <div class="sidebar-card sidebar-links">
    <h4>Latest Articles</h4>
    <ul>
      <?php while ($sb_articles->have_posts()): $sb_articles->the_post(); ?>
      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </div>
  <?php endif; ?>
</aside>
