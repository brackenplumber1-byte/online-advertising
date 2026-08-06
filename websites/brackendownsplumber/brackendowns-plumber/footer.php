<?php $services = unserialize(GP_SERVICES); $areas = unserialize(GP_AREAS); ?>
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-compact.png'); ?>" alt="Brackendowns Plumber" style="height:52px;width:auto;max-width:180px;margin-bottom:14px">
        <div class="footer-brand">Brackendowns Plumber</div>
        <p class="footer-desc">PIRB-registered plumbers based in Brackendowns, serving Alberton and the East Rand. Available 24/7 — no call-out fee, workmanship guaranteed.</p>
        <div class="footer-badges"><span class="footer-badge">PIRB Registered</span><span class="footer-badge">24/7 Emergency</span><span class="footer-badge">No Call-Out Fee</span><span class="footer-badge">Guaranteed Work</span></div>
        <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap">
          <a href="<?php echo esc_url(gp_fb()); ?>" target="_blank" style="color:#64748B;font-size:.82rem;font-weight:600">Facebook</a>
          <a href="<?php echo esc_url(gp_ig()); ?>" target="_blank" style="color:#64748B;font-size:.82rem;font-weight:600">Instagram</a>
          <a href="<?php echo esc_url(gp_tiktok()); ?>" target="_blank" style="color:#64748B;font-size:.82rem;font-weight:600">TikTok</a>
          <a href="<?php echo esc_url(GP_YT); ?>" target="_blank" style="color:#64748B;font-size:.82rem;font-weight:600">YouTube</a>
          <a href="<?php echo esc_url(gp_google()); ?>" target="_blank" style="color:#64748B;font-size:.82rem;font-weight:600">Google Business</a>
          <a href="<?php echo esc_url(gp_review()); ?>" target="_blank" style="color:#F87171;font-size:.82rem;font-weight:600">⭐ Leave a Review</a>
        </div>
      </div>
      <div>
        <h4>Services</h4>
        <ul><?php foreach($services as $slug=>$name): $p=get_posts(['name'=>$slug,'post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null; ?>
          <li><a href="<?php echo $p?esc_url(get_permalink($p->ID)):home_url('/services/'.$slug); ?>"><?php echo esc_html($name); ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?php echo esc_url(home_url('/services/')); ?>" style="font-weight:700">See All Services →</a></li>
        </ul>
      </div>
      <div>
        <h4>Areas We Serve</h4>
        <ul><?php foreach(array_slice($areas,0,8,true) as $slug=>$name): $p=get_posts(['name'=>$slug,'post_type'=>'gp_area','post_status'=>'publish','numberposts'=>1])[0] ?? null; ?>
          <li><a href="<?php echo $p?esc_url(get_permalink($p->ID)):home_url('/areas/'.$slug); ?>"><?php echo esc_html($name); ?></a></li>
        <?php endforeach; ?>
        <li><a href="<?php echo esc_url(home_url('/areas/')); ?>" style="font-weight:700">See All <?php echo count($areas); ?> Areas →</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact</h4>
        <ul>
          <li><a href="<?php echo esc_attr(gp_phone_link()); ?>"><?php echo esc_html(gp_phone()); ?></a></li>
          <li><a href="mailto:<?php echo esc_attr(gp_email()); ?>"><?php echo esc_html(gp_email()); ?></a></li>
          <li><a href="<?php echo esc_url(gp_wa_link()); ?>" target="_blank">WhatsApp Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/articles/')); ?>">Plumbing Articles</a></li>
          <li><a href="<?php echo esc_url(home_url('/geyser-repair-vs-replacement/')); ?>">Geyser Repair vs Replacement</a></li>
          <li><a href="<?php echo esc_url(home_url('/plumbing-emergency-gauteng/')); ?>">Plumbing Emergency Guide</a></li>
          <li><a href="<?php echo esc_url(gp_review()); ?>" target="_blank">Leave a Google Review ⭐</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> Brackendowns Plumber · Brackendowns, Gauteng</p>
      <div class="footer-soc">
        <a href="<?php echo esc_url(gp_fb()); ?>" target="_blank"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
        <a href="<?php echo esc_url(gp_ig()); ?>" target="_blank"><svg viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="#475569" stroke="none"/></svg></a>
        <a href="<?php echo esc_url(gp_tiktok()); ?>" target="_blank"><svg viewBox="0 0 24 24"><path d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48z" fill="#475569"/></svg></a>
        <a href="<?php echo esc_url(GP_YT); ?>" target="_blank"><svg viewBox="0 0 24 24"><path d="M21.582 7.186a2.506 2.506 0 0 0-1.768-1.768C18.254 5 12 5 12 5s-6.254 0-7.814.418a2.506 2.506 0 0 0-1.768 1.768C2 8.746 2 12 2 12s0 3.254.418 4.814a2.506 2.506 0 0 0 1.768 1.768C5.746 19 12 19 12 19s6.254 0 7.814-.418a2.506 2.506 0 0 0 1.768-1.768C22 15.254 22 12 22 12s0-3.254-.418-4.814zM10 15.5v-7l6 3.5-6 3.5z" fill="#475569"/></svg></a>
        <a href="<?php echo esc_url(gp_google()); ?>" target="_blank"><svg viewBox="0 0 24 24"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133C17.293 20.473 15.1 22 12 22 6.477 22 2 17.523 2 12S6.477 2 12 2c2.6 0 4.507 1.027 5.907 2.347l-2.307 2.307C14.507 5.527 13.4 5 12 5 8.686 5 6 7.686 6 11s2.686 6 6 6c2.6 0 4.507-1.027 5.507-2.6H12.48v-3.48z" fill="#475569"/></svg></a>
      </div>
    </div>
  </div>
</footer>
<div class="float-cta">
  <a href="<?php echo esc_url(gp_wa_link()); ?>" target="_blank" class="float-btn float-wa"><svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg><span>WhatsApp</span></a>
  <a href="<?php echo esc_attr(gp_phone_link()); ?>" class="float-btn float-call"><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg><span>Call Now</span></a>
</div>
<?php wp_footer(); ?>
</body></html>
