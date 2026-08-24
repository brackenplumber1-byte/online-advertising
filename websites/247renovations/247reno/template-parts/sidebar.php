<?php
$services = unserialize(RN_SERVICES);
$areas    = unserialize(RN_AREAS);
$sent     = isset($_GET['sent']) && $_GET['sent'] === '1';
?>
<aside>
  <div class="sidebar-box">
    <div class="sidebar-head"><h3>Get a Free Quote</h3><p>We respond within 2 hours</p></div>
    <div class="sidebar-body">
      <a href="<?php echo esc_attr(rn_plink()); ?>" class="sidebar-call">
        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
        <div><div class="sidebar-call-label">Call Now — Free Quote</div><div class="sidebar-call-num"><?php echo esc_html(rn_phone()); ?></div></div>
      </a>
      <a href="<?php echo esc_url(rn_wa_link()); ?>" target="_blank" class="sidebar-wa">
        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        <span>WhatsApp for a Quick Quote</span>
      </a>
      <?php if ($sent): ?>
        <div class="form-ok" style="margin-top:10px">✓ Request received!</div>
      <?php else: ?>
      <div class="sidebar-form">
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
          <input type="hidden" name="action" value="rn_contact">
          <?php wp_nonce_field('rn_contact', 'rn_nonce'); ?>
          <input type="text" name="rn_name" placeholder="Your name" required>
          <input type="tel" name="rn_phone" placeholder="Your phone number" required>
          <select name="rn_service">
            <option>Kitchen Renovations</option>
            <option>Bathroom Renovations</option>
            <option>Home Renovations</option>
            <option>Building Extensions</option>
            <option>Roof Repairs & Waterproofing</option>
            <option>Painting & Plastering</option>
            <option>Tiling & Flooring</option>
            <option>Paving & Driveways</option>
            <option>Palisade Fencing</option>
            <option>Garage Conversion</option>
            <option>Garden Flat</option>
            <option>General Maintenance</option>
          </select>
          <button type="submit" class="sidebar-fsub">Get Free Quote →</button>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="sidebar-links" style="margin-bottom:20px">
    <h4>Our Services</h4>
    <ul>
      <?php foreach ($services as $slug => $data):
        $p   = get_posts(['name'=>$slug,'post_type'=>'rn_service','post_status'=>'publish','numberposts'=>1]);
        $url = $p ? get_permalink($p[0]->ID) : home_url('/services/'.$slug);
      ?>
      <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($data[1]); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="sidebar-links">
    <h4>Areas We Cover</h4>
    <ul>
      <?php foreach (array_slice($areas, 0, 10, true) as $slug => $name):
        $p   = get_posts(['name'=>$slug,'post_type'=>'rn_area','post_status'=>'publish','numberposts'=>1]);
        $url = $p ? get_permalink($p[0]->ID) : home_url('/areas/'.$slug);
      ?>
      <li><a href="<?php echo esc_url($url); ?>">Renovations <?php echo esc_html($name); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>
