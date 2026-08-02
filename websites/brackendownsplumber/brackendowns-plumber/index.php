<?php get_header(); ?>

<?php
$phone      = gp_phone();
$phone_link = gp_phone_link();
$wa_link    = gp_wa_link();
$fb         = gp_fb();
$ig         = gp_ig();
$google     = gp_google();
$review     = gp_review();
$maps       = get_theme_mod('gp_maps','');
$sent       = isset($_GET['sent']) && $_GET['sent'] === '1';
$services   = unserialize(GP_SERVICES);
$areas      = unserialize(GP_AREAS);
?>

<!-- ═══ HERO ══════════════════════════════════════════════ id="home" -->
<section id="home" class="hero">
  <div class="hero-stripe"></div>
  <div class="hero-ghost" aria-hidden="true">24/7</div>
  <div class="container">
    <div class="hero-inner">
      <div>
        <div class="hero-eyebrow">Brackendowns · Alberton · East Rand</div>
        <h1>Burst Pipe? <span>We're On Our Way.</span><br>24/7 Plumbers, East Rand-Wide.</h1>
        <p class="hero-sub">Licensed, insured plumbers <strong>on call around the clock</strong> — Brackendowns-based, fast to reach you anywhere across Alberton and the East Rand. Straight answers, fair pricing, no call-out fee.</p>
        <div class="hero-actions">
          <a href="<?php echo esc_attr($phone_link); ?>" class="btn btn--red" style="font-size:1.05rem;padding:17px 34px">
            <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            Call <?php echo esc_html($phone); ?>
          </a>
          <a href="<?php echo esc_url($wa_link); ?>" target="_blank" rel="noopener" class="btn btn--ghost" style="font-size:1.05rem;padding:17px 34px">WhatsApp Us</a>
        </div>
        <div class="hero-proof">
          <div class="proof-item"><div class="proof-dot"><svg width="14" height="14" fill="#F87171" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg></div><span class="proof-text">PIRB Registered<br>&amp; Fully Insured</span></div>
          <div class="proof-item"><div class="proof-dot"><svg width="14" height="14" fill="#F87171" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 15h-1.5v-7h1.5v7zm0-9h-1.5V6.5h1.5V8z"/></svg></div><span class="proof-text">30-Min Emergency<br>Response</span></div>
          <div class="proof-item"><div class="proof-dot"><svg width="14" height="14" fill="#F87171" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div><span class="proof-text">4.9★ Google<br>Rated</span></div>
          <div class="proof-item"><div class="proof-dot"><svg width="14" height="14" fill="#F87171" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div><span class="proof-text">No Call-Out<br>Fee Ever</span></div>
        </div>
      </div>
      <!-- QUOTE FORM -->
      <div class="hero-form">
        <div class="hf-head"><h2>Get a Free Quote</h2><p>We call you back within 15 minutes</p></div>
        <div class="hf-body">
          <?php if($sent): ?>
            <div class="form-success-msg">✓ Request received! We'll call you back shortly.</div>
            <script>if (window.gpFireFormConversion) window.gpFireFormConversion();</script>
          <?php else: ?>
          <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="gp_contact">
            <?php wp_nonce_field('gp_contact','gp_nonce'); ?>
            <div class="hf-group"><label class="hf-label">Name</label><input class="hf-input" type="text" name="gp_name" placeholder="Your name" required></div>
            <div class="hf-group"><label class="hf-label">Phone Number</label><input class="hf-input" type="tel" name="gp_contact" placeholder="e.g. 073 XXX XXXX" required></div>
            <div class="hf-group"><label class="hf-label">Service Needed</label>
              <select class="hf-select" name="gp_service">
                <?php foreach($services as $k=>$v): ?><option><?php echo esc_html($v); ?></option><?php endforeach; ?>
                <option>Other</option>
              </select>
            </div>
            <div class="hf-group"><label class="hf-label">Message</label><textarea class="hf-textarea" name="gp_msg" placeholder="Describe the problem briefly..."></textarea></div>
            <button type="submit" class="hf-submit">Send Request →</button>
            <p class="hf-note">🔒 Private. No spam. Ever.</p>
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar"><div class="container">
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>PIRB Registered</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 15h-1.5v-7h1.5v7zm0-9h-1.5V6.5h1.5V8z"/></svg>Available 24/7</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>No Call-Out Fee</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>4.9★ Google Rating</div>
  <div class="trust-item"><svg width="18" height="18" fill="#fff" viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29z"/></svg>Guaranteed Work</div>
</div></div>

<!-- STATS -->
<div class="stats-bar"><div class="stats-grid">
  <div class="stat-block"><div class="stat-num">10<span>+</span></div><div class="stat-label">Years Experience</div></div>
  <div class="stat-block"><div class="stat-num">1<span>,</span>500<span>+</span></div><div class="stat-label">Jobs Completed</div></div>
  <div class="stat-block"><div class="stat-num">24<span>/</span>7</div><div class="stat-label">Emergency Response</div></div>
  <div class="stat-block"><div class="stat-num">4<span>.</span>9<span>★</span></div><div class="stat-label">Google Rating</div></div>
</div></div>

<!-- ═══ REAL WORK PHOTO STRIP ═══════════════════════════════════════════ -->
<section style="background:#fff;padding:48px 0">
  <div class="container">
    <div class="eyebrow">Our Team at Work</div>
    <h2 class="display" style="font-size:clamp(1.6rem,3vw,2.2rem);color:var(--navy);margin:6px 0 24px">Real Plumbers. Real Jobs. Real East Rand.</h2>
    <div class="photo-strip-grid">
      <?php $imgdir = get_template_directory_uri() . '/assets/images/'; ?>
      <img src="<?php echo esc_url($imgdir . 'job-geyser-roofspace.jpg'); ?>" alt="Brackendowns Plumber geyser repair technician">
      <img src="<?php echo esc_url($imgdir . 'job-water-meter-valve.jpg'); ?>" alt="Brackendowns Plumber water meter and pressure valve installation">
      <img src="<?php echo esc_url($imgdir . 'job-pipe-excavation.jpg'); ?>" alt="Brackendowns Plumber pipe repair technician">
      <img src="<?php echo esc_url($imgdir . 'job-ariston-install.jpg'); ?>" alt="Brackendowns Plumber geyser installation">
    </div>
  </div>
</section>

<!-- ═══ SERVICES ═══════════════════════════════════════════ id="services" -->
<section id="services" class="section">
  <div class="container">
    <div class="eyebrow">What We Fix</div>
    <h2 class="display" style="font-size:clamp(2.2rem,5vw,3.8rem);color:var(--navy);margin-top:8px">Nine Services. One Call.<br>No Guesswork.</h2>
    <div class="svc-grid">
      <?php $i=1; foreach($services as $slug=>$name):
        $post = get_posts(['name'=>$slug,'post_type'=>'gp_service','post_status'=>'publish','numberposts'=>1])[0] ?? null;
        $url  = $post ? get_permalink($post->ID) : home_url('/services/'.$slug);
      ?>
      <div class="svc-card">
        <div class="svc-num"><?php echo sprintf('%02d',$i++); ?></div>
        <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="<?php echo esc_attr(gp_service_icon_path($slug)); ?>"/></svg></div>
        <h3><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($name); ?></a></h3>
        <a href="<?php echo esc_url($url); ?>" class="svc-link">View full details →</a>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <a href="<?php echo esc_attr($phone_link); ?>" class="btn btn--red">📞 Call <?php echo esc_html($phone); ?> — No Call-Out Fee</a>
    </div>
  </div>
</section>

<!-- ═══ ABOUT / WHY US ═════════════════════════════════════ id="about" -->
<section id="about" class="section section--gray">
  <div class="container">
    <div class="why-2col">
      <div>
        <div class="eyebrow">Why Choose Us</div>
        <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:var(--navy);margin:8px 0 32px">No Shortcuts.<br>No Surprises on the Bill.</h2>
        <div>
          <div class="why-row"><div class="why-n">01</div><div class="why-c"><h3>PIRB Registered Plumbers</h3><p>Every plumber on our team is registered with the Plumbing Industry Registration Board. We issue compliance certificates for all qualifying work.</p></div></div>
          <div class="why-row"><div class="why-n">02</div><div class="why-c"><h3>Honest Upfront Pricing</h3><p>We quote before we start. No hidden charges, no inflated invoices — just a fair price agreed upfront every time.</p></div></div>
          <div class="why-row"><div class="why-n">03</div><div class="why-c"><h3>30-Minute Local Response</h3><p>Based in Brackendowns, we reach most of Alberton and the East Rand fast for emergencies.</p></div></div>
          <div class="why-row"><div class="why-n">04</div><div class="why-c"><h3>Guaranteed Workmanship</h3><p>Not satisfied? We come back and fix it free. Our reputation is built on every single job we complete.</p></div></div>
        </div>
      </div>
      <div>
        <div class="cta-panel">
          <h3>Ready to Book?</h3>
          <a href="<?php echo esc_attr($phone_link); ?>" class="cta-ph">
            <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            <div><div class="cta-ph-l">Call Now — 24/7 Free</div><div class="cta-ph-n"><?php echo esc_html($phone); ?></div></div>
          </a>
          <a href="<?php echo esc_url($wa_link); ?>" target="_blank" class="cta-wa">
            <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            <span>WhatsApp a Plumber Now</span>
          </a>
          <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:4px;padding:14px;margin-top:8px">
            <p style="color:#64748B;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px">Follow Us</p>
            <div class="soc-row">
              <a href="<?php echo esc_url($fb); ?>" target="_blank" class="soc-btn">Facebook</a>
              <a href="<?php echo esc_url($ig); ?>" target="_blank" class="soc-btn">Instagram</a>
              <a href="<?php echo esc_url($google); ?>" target="_blank" class="soc-btn">Google</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ REVIEWS ════════════════════════════════════════════ id="reviews" -->
<section id="reviews" class="section">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:44px;flex-wrap:wrap;gap:16px">
      <div>
        <div class="eyebrow">Customer Reviews</div>
        <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:var(--navy);margin-top:8px">Ask the People Whose<br>Pipes We've Fixed.</h2>
      </div>
      <a href="<?php echo esc_url($review); ?>" target="_blank" class="btn btn--red">⭐ Leave a Review</a>
    </div>
    <div class="rev-grid">
      <!--
        NOTE: Fabricated reviews (invented names/quotes, false "Google Review"
        label) were removed here. This business has a real Google review
        link — replace this comment with genuine review cards once real
        customer reviews exist. Never invent quotes or fake the source label.
      -->
    </div>
  </div>
</section>

<!-- ═══ AREAS ══════════════════════════════════════════════ id="areas" -->
<section id="areas" class="section section--dark">
  <div class="container">
    <div class="eyebrow" style="color:#F87171">Where We Work</div>
    <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:#fff;margin-top:8px">Serving Brackendowns<br>&amp; the East Rand.</h2>
    <div class="area-chips">
      <?php foreach($areas as $slug=>$name):
        $post = get_posts(['name'=>$slug,'post_type'=>'gp_area','post_status'=>'publish','numberposts'=>1])[0] ?? null;
        $url  = $post ? get_permalink($post->ID) : home_url('/areas/'.$slug);
      ?>
      <a href="<?php echo esc_url($url); ?>" class="area-chip"><?php echo esc_html($name); ?></a>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:24px;color:#475569;font-size:.88rem">Not listed? <a href="<?php echo esc_attr($phone_link); ?>" style="color:#F87171;font-weight:700">Call us</a> — we likely cover your area.</p>
  </div>
</section>

<?php
$home_articles = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC']);
if ($home_articles->have_posts()):
?>
<!-- ═══ LATEST ARTICLES ════════════════════════════════════ id="articles" -->
<section id="articles" class="section" style="background:var(--off)">
  <div class="container">
    <div class="eyebrow">Plumbing Articles</div>
    <h2 class="display" style="font-size:clamp(2rem,4vw,3rem);color:var(--navy);margin-top:8px">Tips, Guides &amp; Local Advice.</h2>
    <p style="max-width:600px;margin:14px 0 36px">Practical plumbing advice for Brackendowns, Alberton and the East Rand — written by our own team.</p>
    <div class="home-area-grid">
      <?php while ($home_articles->have_posts()): $home_articles->the_post(); ?>
        <a href="<?php the_permalink(); ?>" style="display:block;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.06);text-decoration:none">
          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium_large', ['style' => 'width:100%;height:180px;object-fit:cover']); ?>
          <?php else: ?>
            <div style="width:100%;height:180px;background:var(--navy)"></div>
          <?php endif; ?>
          <div style="padding:20px">
            <p style="font-size:.72rem;color:var(--red);font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px"><?php echo esc_html(get_the_date('j F Y')); ?></p>
            <h3 style="font-size:1.05rem;color:var(--navy);margin-bottom:0;line-height:1.3"><?php the_title(); ?></h3>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <div style="text-align:center;margin-top:36px">
      <a href="<?php echo esc_url(home_url('/articles/')); ?>" class="btn btn--ghost-navy">Read All Articles →</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══ FAQ ════════════════════════════════════════════════ id="faq" -->
<section id="faq" class="section">
  <div class="container" style="max-width:800px">
    <div class="eyebrow">Common Questions</div>
    <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:var(--navy);margin:8px 0 36px">Frequently Asked Questions</h2>
    <div class="faq-list">
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Is there a call-out fee?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">No. We never charge a call-out fee. You only pay for the work carried out, and we always provide a clear quote before starting.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">How fast can you respond to an emergency?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">We aim to be on-site within 30 minutes for emergencies in and around Brackendowns, and as fast as possible across our wider East Rand coverage area. Being local is our biggest advantage.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Do you work on weekends and public holidays?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">Yes — 24 hours a day, 7 days a week, including all South African public holidays.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Are your plumbers PIRB registered?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">Yes. All our plumbers are registered with the Plumbing Industry Registration Board (PIRB). We issue compliance certificates for geyser installations and all qualifying work.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Do you guarantee your work?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">Absolutely. Every repair and installation carries a workmanship guarantee. If the same problem recurs due to our work, we return and fix it at no charge.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Can you help with insurance plumbing claims?<div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a">Yes. We provide detailed invoices and technical reports for home insurance claims related to burst pipes, water damage, and other plumbing incidents.</div></div>
    </div>
  </div>
</section>

<!-- ═══ CONTACT ════════════════════════════════════════════ id="contact" -->
<section id="contact" class="section section--dark">
  <div class="container">
    <div class="contact-2col">
      <div>
        <div class="eyebrow" style="color:#F87171">Contact Us</div>
        <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:#fff;margin:8px 0 12px">Let's Get Your<br>Problem Fixed.</h2>
        <p style="color:#94A3B8;margin-bottom:32px">Call, WhatsApp, or send a message. We respond fast.</p>
        <div>
          <div class="cm"><div class="cm-i"><svg width="19" height="19" fill="#F87171" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></div><div><div class="cm-l">Phone — 24/7</div><div class="cm-v"><a href="<?php echo esc_attr($phone_link); ?>"><?php echo esc_html($phone); ?></a></div></div></div>
          <div class="cm"><div class="cm-i"><svg width="19" height="19" fill="#F87171" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></div><div><div class="cm-l">Email</div><div class="cm-v"><a href="mailto:<?php echo esc_attr(gp_email()); ?>"><?php echo esc_html(gp_email()); ?></a></div></div></div>
          <div class="cm"><div class="cm-i"><svg width="19" height="19" fill="#F87171" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></div><div><div class="cm-l">Location</div><div class="cm-v" style="color:#CBD5E1">Brackendowns, Alberton, 1448</div></div></div>
          <div class="cm"><div class="cm-i"><svg width="19" height="19" fill="#F87171" viewBox="0 0 24 24"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133C17.293 20.473 15.1 22 12 22 6.477 22 2 17.523 2 12S6.477 2 12 2c2.6 0 4.507 1.027 5.907 2.347l-2.307 2.307C14.507 5.527 13.4 5 12 5 8.686 5 6 7.686 6 11s2.686 6 6 6c2.6 0 4.507-1.027 5.507-2.6H12.48v-3.48z"/></svg></div><div><div class="cm-l">Google Business</div><div class="cm-v"><a href="<?php echo esc_url($google); ?>" target="_blank">View our Google Profile</a></div></div></div>
        </div>
        <div style="display:flex;gap:8px;margin-top:20px;flex-wrap:wrap">
          <a href="<?php echo esc_url($fb); ?>" target="_blank" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:4px;padding:9px 16px;font-size:.82rem;font-weight:700;color:#CBD5E1">Facebook</a>
          <a href="<?php echo esc_url($ig); ?>" target="_blank" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:4px;padding:9px 16px;font-size:.82rem;font-weight:700;color:#CBD5E1">Instagram</a>
          <a href="<?php echo esc_url($google); ?>" target="_blank" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:4px;padding:9px 16px;font-size:.82rem;font-weight:700;color:#CBD5E1">Google Business</a>
          <a href="<?php echo esc_url($review); ?>" target="_blank" style="background:rgba(200,16,46,.2);border:1px solid rgba(200,16,46,.3);border-radius:4px;padding:9px 16px;font-size:.82rem;font-weight:700;color:#F87171">⭐ Leave a Review</a>
        </div>
      </div>
      <div>
        <?php if($maps): ?>
        <div class="map-wrap">
          <iframe src="<?php echo esc_url($maps); ?>" allowfullscreen loading="lazy" title="Brackendowns Plumber service area"></iframe>
        </div>
        <?php else: ?>
        <div class="map-wrap">
          <iframe src="https://www.google.com/maps?q=Brackendowns,+Alberton,+Gauteng&output=embed" allowfullscreen loading="lazy" title="Brackendowns Plumber location — Brackendowns"></iframe>
        </div>
        <?php endif; ?>
        <div class="cf-box">
          <h3>Send a Message</h3>
          <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="gp_contact">
            <?php wp_nonce_field('gp_contact','gp_nonce'); ?>
            <input class="dark-input" type="text" name="gp_name" placeholder="Your name" required>
            <input class="dark-input" type="text" name="gp_contact" placeholder="Phone or email" required>
            <textarea class="dark-input" name="gp_msg" placeholder="How can we help?" style="min-height:80px;resize:vertical"></textarea>
            <button type="submit" style="width:100%;background:var(--red);color:#fff;border:none;padding:13px;border-radius:4px;font-weight:800;font-size:.92rem;cursor:pointer;font-family:inherit;text-transform:uppercase;letter-spacing:.03em">Send Message →</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
