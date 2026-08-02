<?php
/**
 * Template Name: Ads Landing Page (Distraction-Free)
 * 247 Plumbers GP — minimal page for Google Ads traffic.
 * No nav, no footer links, no dropdowns — just the offer, phone, WhatsApp, form.
 *
 * To use: create ONE WordPress Page, set its Template to
 * "Ads Landing Page (Distraction-Free)" in the Page Attributes panel,
 * then point each campaign's Final URL at that same page with a
 * ?camp=<slug> query parameter (see $variants below) — one page, five
 * message-matched headlines, so Quality Score doesn't take a message-match
 * hit from every campaign landing on the same generic copy.
 *
 * Example Final URLs:
 *   https://www.247plumbersgp.co.za/get-a-quote/?camp=emergency-plumbing
 *   https://www.247plumbersgp.co.za/get-a-quote/?camp=geyser
 *   https://www.247plumbersgp.co.za/get-a-quote/?camp=leak-detection
 *   https://www.247plumbersgp.co.za/get-a-quote/?camp=drain-unblocking
 *   https://www.247plumbersgp.co.za/get-a-quote/?camp=general-plumbing
 *
 * This template intentionally does NOT call get_header()/get_footer() —
 * it builds its own complete, minimal <html> document so no nav,
 * dropdowns, or footer links can distract someone who just clicked an ad.
 */

$variants = [
    'emergency-plumbing' => [
        'topbar'   => '🚨 Plumbing Emergency? Call %s now — available 24/7',
        'h1_plain' => 'Emergency Plumber,',
        'h1_red'   => 'On-Site Fast, Day or Night.',
        'sub'      => 'Burst pipes, blocked drains, geyser failures — PIRB registered, no call-out fee, fast response across Gauteng.',
        'preselect'=> 'Emergency Plumbing',
    ],
    'general-plumbing' => [
        'topbar'   => '📞 Need a plumber? Call %s — no call-out fee',
        'h1_plain' => 'Trusted Local Plumbers,',
        'h1_red'   => 'Anywhere in Gauteng.',
        'sub'      => 'Reliable plumbing repairs and maintenance — PIRB registered, upfront quotes, quality workmanship guaranteed.',
        'preselect'=> 'General Plumbing',
    ],
    'geyser' => [
        'topbar'   => '🔥 No hot water? Call %s — same-day service',
        'h1_plain' => 'Geyser Repairs &amp;',
        'h1_red'   => 'Installations, Same Day.',
        'sub'      => 'Electric and solar geyser specialists — PIRB compliance certificates issued, no call-out fee.',
        'preselect'=> 'Geyser Repair',
    ],
    'leak-detection' => [
        'topbar'   => '💧 Hidden water leak? Call %s now',
        'h1_plain' => 'Leak Detection,',
        'h1_red'   => 'Fast &amp; Non-Invasive.',
        'sub'      => 'No unnecessary digging or wall-breaking — accurate leak detection with a full written report.',
        'preselect'=> 'Leak Detection',
    ],
    'drain-unblocking' => [
        'topbar'   => '🚽 Blocked drain? Call %s — same-day service',
        'h1_plain' => 'Drain Unblocking,',
        'h1_red'   => 'Cleared For Good.',
        'sub'      => 'High-pressure jetting clears blockages completely — a permanent fix, not a temporary patch.',
        'preselect'=> 'Drain Cleaning',
    ],
];
$camp = isset($_GET['camp']) && isset($variants[$_GET['camp']]) ? $_GET['camp'] : null;
$v = $camp ? $variants[$camp] : [
    'topbar'   => '🚨 Plumbing Emergency? Call %s now — available 24/7',
    'h1_plain' => 'Plumber Near You,',
    'h1_red'   => 'Anywhere in Gauteng.',
    'sub'      => '24/7 emergency plumbing, geyser repairs, drain cleaning and leak detection — PIRB registered, no call-out fee, fast response.',
    'preselect'=> '',
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<?php wp_head(); ?>
<style>
  /* Scoped, self-contained styles so this page never depends on the main theme layout */
  body.ads-landing { margin:0; font-family:'Inter',sans-serif; background:var(--off,#F6F5F1); color:var(--navy,#0B1526); }
  .al-wrap { max-width: 720px; margin: 0 auto; padding: 32px 24px 64px; }
  .al-topbar { background:var(--navy,#0B1526); color:#fff; text-align:center; padding:12px 16px; font-size:.85rem; font-weight:700; }
  .al-topbar a { color:#5EEAD4; }
  .al-logo { display:flex; align-items:center; justify-content:center; gap:10px; margin:28px 0 20px; }
  .al-logo img { width:48px; height:48px; border-radius:6px; }
  .al-logo span { font-weight:800; font-size:1.2rem; }
  .al-hero { text-align:center; margin-bottom:32px; }
  .al-hero h1 { font-family:'Big Shoulders Display',sans-serif; font-weight:800; font-size:clamp(2.1rem,6vw,3rem); line-height:1.02; color:var(--navy,#0B1526); margin-bottom:12px; }
  .al-hero h1 span { color:var(--red,#D2233C); }
  .al-hero p { color:#5C6474; font-size:1.05rem; max-width:520px; margin:0 auto; }
  .al-trust { display:flex; flex-wrap:wrap; justify-content:center; gap:10px; margin:24px 0 32px; }
  .al-trust span { background:#fff; border:1px solid #E7E4DC; border-radius:20px; padding:7px 16px; font-size:.78rem; font-weight:700; color:#0B1526; }
  .al-cta-row { display:flex; flex-wrap:wrap; justify-content:center; gap:12px; margin-bottom:40px; }
  .al-btn { display:inline-flex; align-items:center; gap:10px; padding:18px 32px; border-radius:4px; font-weight:800; font-size:1.05rem; text-decoration:none; }
  .al-btn svg { width:22px; height:22px; fill:#fff; }
  .al-btn-call { background:var(--red,#D2233C); color:#fff; }
  .al-btn-wa { background:#25D366; color:#fff; }
  .al-form-card { background:#fff; border-radius:8px; box-shadow:0 8px 30px rgba(0,0,0,.08); padding:32px; }
  .al-form-card h2 { font-size:1.3rem; margin-bottom:6px; }
  .al-form-card > p { color:#5C6474; font-size:.9rem; margin-bottom:20px; }
  .al-form-group { margin-bottom:14px; }
  .al-form-group label { display:block; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#0B1526; margin-bottom:5px; }
  .al-form-group input, .al-form-group select { width:100%; padding:12px 14px; border:1.5px solid #E7E4DC; border-radius:4px; font-size:.92rem; font-family:inherit; }
  .al-form-submit { width:100%; background:var(--red,#D2233C); color:#fff; border:none; padding:16px; border-radius:4px; font-weight:800; font-size:1rem; cursor:pointer; letter-spacing:.02em; text-transform:uppercase; }
  .al-form-success { background:#d1fae5; border:1.5px solid #059669; color:#065f46; padding:20px; border-radius:6px; font-weight:700; text-align:center; }
  .al-reviews { margin-top:40px; text-align:center; }
  .al-reviews .stars { color:#F59E0B; font-size:1.3rem; letter-spacing:3px; margin-bottom:8px; }
  .al-reviews p { color:#64748B; font-size:.85rem; }
  .al-footer-note { text-align:center; margin-top:32px; font-size:.75rem; color:#94A3B8; }
</style>
</head>
<body class="ads-landing">
<?php
$phone      = gp_phone();
$phone_link = gp_phone_link();
$wa_link    = gp_wa_link();
$sent       = isset($_GET['sent']) && $_GET['sent'] === '1';
$imgdir     = get_template_directory_uri() . '/assets/images/';
?>

<div class="al-topbar"><?php
  $topbar_text = sprintf($v['topbar'], esc_html($phone));
  // sprintf already escaped $phone above; topbar template text itself is
  // trusted (defined in $variants above), not user input.
  echo $topbar_text;
?> — <a href="<?php echo esc_attr($phone_link); ?>">tap to call</a></div>

<div class="al-wrap">

  <div class="al-logo">
    <img src="<?php echo esc_url($imgdir . 'logo.png'); ?>" alt="247 Plumbers GP">
    <span>247 Plumbers GP</span>
  </div>

  <div class="al-hero">
    <h1><?php echo $v['h1_plain']; ?> <span><?php echo $v['h1_red']; ?></span></h1>
    <p><?php echo esc_html($v['sub']); ?></p>
  </div>

  <div class="al-trust">
    <span>✓ PIRB Registered</span>
    <span>✓ No Call-Out Fee</span>
    <span>✓ 24/7 Availability</span>
    <span>✓ Workmanship Guaranteed</span>
  </div>

  <div class="al-cta-row">
    <a href="<?php echo esc_attr($phone_link); ?>" class="al-btn al-btn-call">
      <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
      Call <?php echo esc_html($phone); ?>
    </a>
    <a href="<?php echo esc_url($wa_link); ?>" target="_blank" class="al-btn al-btn-wa">
      <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
      WhatsApp Us
    </a>
  </div>

  <div class="al-form-card">
    <?php if ($sent): ?>
      <div class="al-form-success">✓ Request received — we'll call you back within 15 minutes!</div>
      <script>if (window.gpFireFormConversion) window.gpFireFormConversion();</script>
    <?php else: ?>
      <h2>Get a Free Quote</h2>
      <p>Fill in your details and we'll call you back within 15 minutes.</p>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="gp_contact">
        <input type="hidden" name="gp_campaign" value="<?php echo esc_attr($camp ?: 'generic'); ?>">
        <?php wp_nonce_field('gp_contact', 'gp_nonce'); ?>
        <div class="al-form-group"><label>Name</label><input type="text" name="gp_name" placeholder="Your name" required></div>
        <div class="al-form-group"><label>Phone Number</label><input type="tel" name="gp_contact" placeholder="Your phone number" required></div>
        <div class="al-form-group">
          <label>Service Needed</label>
          <select name="gp_service">
            <?php
            // Renamed loop var to $svc_name — this file previously reused
            // $v here, which silently clobbered the $v variant array set
            // up above once this loop ran.
            $services = unserialize(GP_SERVICES);
            foreach ($services as $svc_name):
              $is_selected = ($v['preselect'] !== '' && $svc_name === $v['preselect']);
            ?>
            <option value="<?php echo esc_attr($svc_name); ?>" <?php selected($is_selected, true); ?>><?php echo esc_html($svc_name); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="al-form-submit">Get My Free Quote →</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="al-reviews">
    <div class="stars">★★★★★</div>
    <p>4.9★ rated on Google — trusted by homeowners across Midrand and Gauteng</p>
  </div>

  <p class="al-footer-note">247 Plumbers GP · Silkwood Complex, Berger Rd, Vorna Valley, Midrand · PIRB Registered</p>

</div>

<?php wp_footer(); ?>
</body>
</html>
