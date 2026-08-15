<?php get_header(); ?>
<?php while (have_posts()): the_post();
  $slug  = get_post_field('post_name', get_the_ID());
  $name  = get_the_title();
  $desc  = get_post_meta(get_the_ID(),'tp_meta_desc',true) ?: get_the_excerpt();
  $imgdir = get_template_directory_uri() . '/assets/images/';
  $services = unserialize(TP_SERVICES);
  // $name is the full SEO title (with the " | ..." suffix) — not fit for
  // dropping into a sentence. Use the clean TP_SERVICES display name instead.
  $clean_name = $services[$slug] ?? $name;

  $content = [
    'emergency-plumbing' => [
      'h1'      => 'Emergency Plumber Roodepoort — On-Site in 45 Minutes, 24/7',
      'intro'   => 'When a plumbing emergency strikes in Roodepoort, every minute matters. Tysons Plumbers Roodepoort is your fastest local emergency plumber — available 24 hours a day, 7 days a week, including weekends and public holidays. We aim to be on-site within 45 minutes across all of Roodepoort and the West Rand.',
      'h2_1'   => 'Emergency Plumbing Services in Roodepoort',
      'list1'  => ['Burst and leaking pipe repair','Flooding and water damage response','No hot water emergencies','Blocked sewer emergencies','Gas leak plumbing response','Storm and rain damage plumbing'],
      'h2_2'   => 'Why Tysons is Roodepoort\'s #1 Emergency Plumber',
      'list2'  => ['On-site in 45 minutes across Roodepoort and the West Rand','No call-out fee — you only pay for the work done','Licensed and insured emergency plumbers','Available 24/7/365 including all public holidays','Fully stocked vehicles for first-visit repairs','Upfront quotes before any work begins'],
      'h3'     => 'What to Do in a Plumbing Emergency in Roodepoort',
      'body'   => "If you have a burst pipe in Roodepoort, turn off your main water supply immediately — usually near your water meter. Then call Tysons Plumbers Roodepoort on ".TP_PHONE." and we'll guide you through the next steps while we're on our way.\n\nFor flooding, turn off your electricity at the mains if water is near electrical points, and call us immediately. Do not walk through standing water near electrical outlets.",
      'img'    => 'job-underground-valve.webp',
    ],
    'geyser-repair' => [
      'h1'    => 'Geyser Repair Roodepoort | No Hot Water? We Fix It Same Day',
      'intro' => 'No hot water in Roodepoort? Tysons Plumbers Roodepoort\'s geyser repair specialists diagnose and fix all geyser problems same day. We service all major brands — electric, gas, and solar — and provide PIRB Certificates of Compliance on completion. No call-out fee.',
      'h2_1' => 'Geyser Repair Services in Roodepoort',
      'list1' => ['Electric geyser repairs and replacements','Solar geyser fault diagnosis and repairs','Gas geyser servicing and repairs','Pressure valve (TPR valve) replacement','Thermostat and element replacement','Geyser leak detection and repair'],
      'h2_2' => 'Why Choose Tysons for Geyser Repairs in Roodepoort?',
      'list2' => ['Same-day geyser repair in most cases','All major brands serviced — Kwikot, Ariston, Solar Industries and more','PIRB Certificate of Compliance issued on completion','Your home insurer requires a CoC — we provide it','No call-out fee — upfront quotes before work starts','12-month workmanship guarantee on all repairs'],
      'h3'   => 'Signs Your Geyser Needs Repair in Roodepoort',
      'body' => "Common signs your geyser needs repair include: no hot water, lukewarm water that runs out quickly, unusual noises from the geyser, rust-coloured water, or visible leaks around the unit. If you notice water dripping from the pressure relief valve, this is an urgent sign — call Tysons Plumbers Roodepoort immediately on ".TP_PHONE.".",
      'img'  => 'job-geyser-dark-roofspace.webp',
    ],
    'geyser-installation' => [
      'h1'    => 'Geyser Installation Roodepoort | Supply & Install — Same Day',
      'intro' => 'Need a new geyser installed in Roodepoort? Tysons Plumbers Roodepoort supplies and installs electric, gas, solar, and heat pump geysers — with PIRB Certificates of Compliance issued on the day. Competitive pricing, no call-out fee.',
      'h2_1' => 'Geyser Installation Options in Roodepoort',
      'list1' => ['Electric geyser installation (all sizes)','Solar geyser installation — save on electricity','Gas geyser installation — instant hot water','Heat pump water heater installation','Geyser brackets, drip trays, and overflow kits','PIRB Certificate of Compliance (CoC) issued'],
      'h2_2' => 'Why Choose Tysons for Geyser Installation in Roodepoort?',
      'list2' => ['Same-day installation in most cases across Roodepoort','All major brands supplied — Kwikot, Ariston, Kwikhot and more','PIRB compliance certificate issued on completion','10-year tank warranty on selected brands','We remove and dispose of your old geyser','No call-out fee — upfront, transparent quotes'],
      'h3'   => 'Which Geyser Is Right for Your Roodepoort Home?',
      'body' => "Choosing the right geyser for your Roodepoort home depends on your hot water usage, budget, and electricity costs. Electric geysers are the most affordable to install. Solar geysers save significantly on electricity. Gas geysers provide instant hot water without storage. Our plumbers in Roodepoort will assess your home and recommend the best option — at no charge.",
      'img'  => 'job-geyser-replacement.webp',
    ],
    'drain-cleaning' => [
      'h1'    => 'Drain Cleaning Roodepoort | Blocked Drains Cleared Permanently',
      'intro' => 'Blocked drain in Roodepoort? Tysons Plumbers Roodepoort uses professional high-pressure hydro jetting equipment to clear any blockage permanently — not just temporarily. From blocked kitchen drains to main sewer line blockages, we fix it properly first time.',
      'h2_1' => 'Drain Cleaning Services in Roodepoort',
      'list1' => ['Kitchen drain cleaning and unblocking','Bathroom and shower drain unblocking','Blocked toilet clearing','Main sewer line cleaning and jetting','Root intrusion removal from drains','CCTV drain camera inspection available'],
      'h2_2' => 'Why Our Drain Cleaning in Roodepoort is Better',
      'list2' => ['High-pressure hydro jetting — clears blockages completely','Not a temporary fix — a permanent solution','CCTV drain camera to find the root cause','Commercial and residential drain cleaning','No mess — we clean up completely after every job','No call-out fee — upfront quotes before we start'],
      'h3'   => 'Why Is My Drain Blocked in Roodepoort?',
      'body' => "Blocked drains in Roodepoort are commonly caused by fat and grease buildup in kitchen drains, hair and soap in bathroom drains, tree root intrusion into outdoor pipes, or flushing items that shouldn't be flushed. If your drain is slow or completely blocked, call Tysons Plumbers Roodepoort on ".TP_PHONE." for same-day drain cleaning.",
      'img'  => 'job-blocked-drain.webp',
    ],
    'pipe-repair' => [
      'h1'    => 'Pipe Repair Roodepoort | Burst & Leaking Pipes Fixed Fast',
      'intro' => 'Burst or leaking pipe in Roodepoort? Tysons Plumbers Roodepoort repairs and replaces burst, cracked, and corroded pipes using SABS-approved materials. Underground and internal pipe repairs fully guaranteed with a 12-month workmanship warranty.',
      'h2_1' => 'Pipe Repair Services in Roodepoort',
      'list1' => ['Burst pipe emergency repair','Cracked and corroded pipe replacement','PVC, copper, and CPVC pipe repairs','Underground pipe excavation and repair','Complete pipe replacement (full repipe)','Pressure testing after all repairs'],
      'h2_2' => 'Why Choose Tysons for Pipe Repairs in Roodepoort?',
      'list2' => ['SABS-approved materials on every repair','12-month workmanship guarantee','On-site for emergencies within 45 minutes','Surface restoration after underground repairs','Minimal disruption to your property','No call-out fee — clear upfront quotes'],
      'h3'   => 'Signs You Have a Burst or Leaking Pipe in Roodepoort',
      'body' => "Signs of a burst or leaking pipe in your Roodepoort home include: a sudden drop in water pressure, wet patches on walls or ceilings, the sound of running water when all taps are off, unusually high water bills, or damp patches in your garden. If you notice any of these signs, call Tysons Plumbers Roodepoort immediately on ".TP_PHONE.".",
      'img'  => 'job-underground-pipe.webp',
    ],
    'leak-detection' => [
      'h1'    => 'Leak Detection Roodepoort | Find Hidden Water Leaks Fast',
      'intro' => 'Hidden water leaks in Roodepoort can cause thousands of rands in damage before you notice them. Tysons Plumbers Roodepoort uses modern leak detection equipment to find leaks behind walls, under floors, and underground — without unnecessary destruction.',
      'h2_1' => 'Leak Detection Services in Roodepoort',
      'list1' => ['Water meter leak detection','Underground pipe leak detection','Wall and ceiling leak detection','Slab leak detection','Roof and gutter leak assessment','Water leak reporting for insurance claims'],
      'h2_2' => 'Why Professional Leak Detection in Roodepoort Matters',
      'list2' => ['Non-invasive detection — no unnecessary breaking of walls','Modern equipment pinpoints leaks accurately','Same-day repair once the leak is found','Full written report provided','Insurance claim documentation available','No call-out fee — upfront quotes'],
      'h3'   => 'Signs of a Hidden Water Leak in Roodepoort',
      'body' => "Signs of a hidden water leak in your Roodepoort home include: a water meter that continues running when all taps are off, unexpectedly high water bills, damp patches on walls or ceilings, mould or mildew in unusual places, or the smell of damp in rooms that should be dry. Early detection saves significant money — call Tysons Plumbers Roodepoort now.",
      'img'  => 'job-leak-detection.webp',
    ],
    'toilet-repairs' => [
      'h1'    => 'Toilet Repairs Roodepoort | Blocked, Running & Leaking Toilets Fixed',
      'intro' => 'Blocked, running, or leaking toilet in Roodepoort? Tysons Plumbers Roodepoort repairs all toilet problems fast — same-day service available. We carry parts for all major toilet brands and complete most repairs in a single visit. No call-out fee.',
      'h2_1' => 'Toilet Repair Services in Roodepoort',
      'list1' => ['Blocked toilet unblocking','Running toilet and cistern repair','Cistern valve and ballcock replacement','Toilet seat replacement','Complete toilet installation','Dual-flush conversion and upgrade'],
      'h2_2' => 'Why Choose Tysons for Toilet Repairs in Roodepoort?',
      'list2' => ['Same-day toilet repairs across Roodepoort','Parts for all major toilet brands carried on our vehicles','12-month workmanship guarantee','Neat work — full cleanup after every job','No call-out fee — upfront, transparent pricing','Available 24/7 for urgent toilet blockages'],
      'h3'   => 'Common Toilet Problems in Roodepoort Homes',
      'body' => "The most common toilet problems we fix in Roodepoort homes are: blocked toilets (usually caused by flushing wipes or foreign objects), running toilets (a worn cistern valve or float that wastes water and increases your bill), leaking toilets at the base (a worn wax seal or loose bolts), and constantly filling cisterns. Most can be fixed same day.",
      'img'  => 'job-toilet-installation.webp',
    ],
    'bathroom-plumbing' => [
      'h1'    => 'Bathroom Plumbing Roodepoort | Taps, Basins, Showers & Renovations',
      'intro' => 'Full bathroom plumbing services in Roodepoort — from a dripping tap to a complete bathroom renovation. Tysons Plumbers Roodepoort installs and repairs all bathroom plumbing to SANS standards, with a 12-month workmanship guarantee.',
      'h2_1' => 'Bathroom Plumbing Services in Roodepoort',
      'list1' => ['Tap repair and replacement','Basin and vanity installation','Shower fitting and repairs','Bath installation and repair','Toilet installation and repair','Full bathroom plumbing renovations'],
      'h2_2' => 'Why Choose Tysons for Bathroom Plumbing in Roodepoort?',
      'list2' => ['All work to SANS plumbing standards','12-month workmanship guarantee','Supply-and-fit or fit-only options','Neat, clean workmanship on every job','Free quote and consultation','No call-out fee — upfront pricing'],
      'h3'   => 'Planning a Bathroom Renovation in Roodepoort?',
      'body' => "If you're planning a bathroom renovation in Roodepoort, getting your plumbing right from the start is critical. Tysons Plumbers Roodepoort works with homeowners and contractors across Roodepoort, Honeydew, Wilgeheuwel, Florida and the West Rand to deliver professional bathroom plumbing on time and within budget. Call us for a free consultation.",
      'img'  => 'job-kitchen-tap.webp',
    ],
    'water-backup-tanks' => [
      'h1'    => 'Water Backup Tanks Roodepoort | JoJo Tank Installation — Never Run Dry',
      'intro' => 'Water outages in Roodepoort are a growing problem. Tysons Plumbers Roodepoort installs complete water backup systems — JoJo tanks, pressure pumps, filtration, and full plumbing integration. Supply and install from one team. No call-out fee.',
      'h2_1' => 'Water Backup Tank Services in Roodepoort',
      'list1' => ['JoJo plastic storage tanks (all sizes — 500L to 10,000L+)','Steel water storage tanks','Pressure pump installation and wiring','Header tank systems','Automatic switchover valve installation','Rainwater harvesting connections','Water filtration systems','Full system pressure testing and commissioning'],
      'h2_2' => 'Why Install a Water Backup Tank in Roodepoort?',
      'list2' => ['Never run out of water during municipal outages','Water security for your family and business','Complete supply-and-install from one team','Pressure pump ensures normal water pressure','Compatible with your existing geyser and plumbing','Minimal disruption — most installs completed in one day','12-month workmanship guarantee on all plumbing','No call-out fee — free site assessment and quote'],
      'h3'   => 'Which Water Tank Is Right for Your Roodepoort Home?',
      'body' => "For most Roodepoort homes, a 2,500L or 5,000L JoJo tank with a pressure pump provides enough water storage for 3–5 days during an outage. Larger households or businesses may need 10,000L or more. Our plumbers will assess your household water usage and recommend the right system. Call Tysons Plumbers Roodepoort for a free site assessment.",
      'img'  => 'job-jojo-tank.webp',
    ],
    'gutters-downpipes' => [
      'h1'    => 'Gutters & Downpipe Systems Roodepoort | Installation & Repair',
      'intro' => 'Overflowing gutters and blocked downpipes cause real water damage to Roodepoort homes and businesses. Tysons Plumbers Roodepoort installs, repairs and clears gutter systems before the next storm. No call-out fee.',
      'h2_1' => 'Gutter & Downpipe Services in Roodepoort',
      'list1' => ['Gutter installation and replacement','Downpipe installation and repair','Gutter cleaning and unblocking','Leaf guard fitting','Storm damage gutter repair','Fascia and soffit-mounted gutter fixing'],
      'h2_2' => 'Why Choose Tysons for Gutters in Roodepoort?',
      'list2' => ['Stops water damage before it starts','Neat, weatherproof installation','Free quote and consultation','Workmanship guarantee on all work','Available for homes, complexes and businesses','No call-out fee — upfront pricing'],
      'h3'   => 'Roodepoort\'s Rainy Season Puts Gutters to the Test',
      'body' => "Roodepoort's summer storms put real strain on ageing or undersized gutter systems, especially in established suburbs like Florida and Constantia Kloof. A blocked or damaged gutter can send water straight into your walls or foundation. Tysons Plumbers Roodepoort inspects, repairs and installs gutter systems built to handle West Rand storm conditions. Call for a free assessment.",
      'img'  => 'job-tree-root-drain.webp',
    ],
    'grease-trap-cleaning' => [
      'h1'    => 'Grease Trap Cleaning Roodepoort | Commercial Kitchens',
      'intro' => 'Compliant, scheduled grease trap cleaning for restaurants and commercial kitchens across Roodepoort. Tysons Plumbers Roodepoort keeps your kitchen compliant and odour-free. No call-out fee.',
      'h2_1' => 'Grease Trap Services in Roodepoort',
      'list1' => ['Grease trap pump-outs','Scheduled cleaning contracts','Compliance-focused servicing','Odour and blockage prevention','Commercial kitchen drain checks','Correct waste disposal handling'],
      'h2_2' => 'Why Choose Tysons for Grease Trap Cleaning?',
      'list2' => ['Keeps your kitchen compliant and odour-free','Scheduled contracts available — never miss a service','Minimal disruption to kitchen operations','Experienced with commercial kitchen environments','Proper waste handling and disposal','No call-out fee — upfront pricing'],
      'h3'   => 'Serving Roodepoort\'s Restaurants and Commercial Kitchens',
      'body' => "Restaurants and commercial kitchens across Roodepoort, Wilgeheuwel and the wider West Rand rely on properly maintained grease traps to stay compliant and avoid costly blockages. Tysons Plumbers Roodepoort offers scheduled grease trap cleaning contracts so you never have to think about it — call for a free quote.",
      'img'  => 'job-drain-manhole.webp',
    ],
    'drain-camera' => [
      'h1'    => 'Drain Camera Inspections Roodepoort | CCTV Diagnostics',
      'intro' => 'See exactly what\'s wrong before any digging starts. Tysons Plumbers Roodepoort\'s drain camera inspections find the real problem, not just the symptoms. No call-out fee.',
      'h2_1' => 'Drain Camera Services in Roodepoort',
      'list1' => ['Full drain line camera inspection','Root intrusion detection','Pipe damage and collapse detection','Blockage location pinpointing','Pre-purchase drain inspections','Recorded footage provided'],
      'h2_2' => 'Why Choose Tysons for Drain Camera Inspections?',
      'list2' => ['See the actual problem before quoting a fix','Avoids unnecessary digging or guesswork','Useful for pre-purchase property checks','Recorded footage provided for your records','Experienced reading older clay and PVC drain lines','No call-out fee — upfront pricing'],
      'h3'   => 'Why Older Roodepoort Homes Benefit Most',
      'body' => "Established suburbs like Florida, Witpoortjie and Roodekrans often still run on original clay drainpipes, which are especially prone to root intrusion and joint failure. A drain camera inspection shows exactly where the problem is before anyone starts digging up your garden. Call Tysons Plumbers Roodepoort to book an inspection.",
      'img'  => 'job-drain-manhole.webp',
    ],
    'heat-pumps' => [
      'h1'    => 'Heat Pumps Roodepoort | Energy-Efficient Hot Water',
      'intro' => 'Energy-efficient hot water for your Roodepoort home or business. Tysons Plumbers Roodepoort supplies and installs heat pump systems built for South African conditions. No call-out fee.',
      'h2_1' => 'Heat Pump Services in Roodepoort',
      'list1' => ['Heat pump supply and installation','System sizing and selection advice','Integration with existing geyser plumbing','Electrical isolation and safety compliance','Servicing and maintenance','Warranty support'],
      'h2_2' => 'Why Choose Tysons for Heat Pumps in Roodepoort?',
      'list2' => ['Genuine energy savings on hot water heating','Correctly sized for your household or business','PIRB-registered installation','Compatible with most existing plumbing setups','Workmanship guarantee on every installation','No call-out fee — free site assessment'],
      'h3'   => 'Is a Heat Pump Right for Your Roodepoort Home?',
      'body' => "With Roodepoort's electricity costs and load shedding both on the rise, a heat pump can cut your hot water heating costs significantly compared to a standard electric geyser. Tysons Plumbers Roodepoort will assess your household's hot water needs and recommend the right system. Call for a free consultation.",
      'img'  => 'job-geyser-roofspace.webp',
    ],
    'water-filtration' => [
      'h1'    => 'Water Filtration & Purification Roodepoort | Clean Water Systems',
      'intro' => 'Cleaner water at every tap. Tysons Plumbers Roodepoort supplies and installs water filtration and purification systems suited to your home or business. Free quote and consultation.',
      'h2_1' => 'Water Filtration Services in Roodepoort',
      'list1' => ['Whole-house filtration systems','Under-counter filtration units','Water purification systems','Filter servicing and replacement','System sizing advice','Installation and integration with existing plumbing'],
      'h2_2' => 'Why Choose Tysons for Water Filtration?',
      'list2' => ['Genuinely cleaner water, not just marketing claims','Systems sized correctly for your household','Professional installation and integration','Ongoing servicing and filter replacement available','Free quote and consultation','No call-out fee — upfront pricing'],
      'h3'   => 'Hard Water Is a Real Issue in Parts of Roodepoort',
      'body' => "Hard water and limescale buildup affect geysers, pipes and appliances over time in parts of Roodepoort and the West Rand. A properly sized filtration system protects your plumbing and improves water quality at every tap. Call Tysons Plumbers Roodepoort for a free assessment.",
      'img'  => 'job-jojo-tank.webp',
    ],
    'maintenance-contracts' => [
      'h1'    => 'Maintenance Contracts Roodepoort | Scheduled Plumbing Servicing',
      'intro' => 'Scheduled plumbing servicing for homes, complexes and businesses across Roodepoort. Priority call-outs, fewer surprises. Tysons Plumbers Roodepoort.',
      'h2_1' => 'Maintenance Contract Services in Roodepoort',
      'list1' => ['Scheduled plumbing inspections','Priority emergency call-outs','Geyser and drain servicing','Body corporate and complex contracts','Commercial maintenance contracts','Detailed service reports'],
      'h2_2' => 'Why Choose Tysons for a Maintenance Contract?',
      'list2' => ['Priority booking ahead of non-contract clients','Predictable, budgeted maintenance costs','Fewer surprise emergencies over time','Experienced with both residential and commercial clients','Flexible contract terms available','No call-out fee for contract clients'],
      'h3'   => 'Built for Roodepoort Complexes and Body Corporates',
      'body' => "Complexes and body corporates across Roodepoort, Constantia Kloof and Weltevreden Park benefit most from a scheduled maintenance contract — catching small plumbing issues before they become expensive shared-cost emergencies. Call Tysons Plumbers Roodepoort to discuss a contract tailored to your property.",
      'img'  => 'job-pressure-valve.webp',
    ],
  ];

  $c    = $content[$slug] ?? ['h1'=>$name,'intro'=>$desc,'h2_1'=>'Our Services','list1'=>[],'h2_2'=>'Why Choose Us','list2'=>[],'h3'=>'','body'=>'','img'=>''];
  $img  = $c['img'] ? $imgdir . $c['img'] : '';
  $other = '';
  foreach ($services as $s_slug => $s_name) {
    if ($s_slug === $slug) continue;
    $p2 = get_posts(['name'=>$s_slug,'post_type'=>'tp_service','post_status'=>'publish','numberposts'=>1]);
    $url2 = $p2 ? get_permalink($p2[0]->ID) : home_url('/services/'.$s_slug);
    $other .= '<li><a href="'.esc_url($url2).'">'.esc_html($s_name).'</a></li>';
  }
?>

<!-- BREADCRUMB -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/'); ?>" itemprop="item"><span itemprop="name">Home</span></a><meta itemprop="position" content="1"/></li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo home_url('/#services'); ?>" itemprop="item"><span itemprop="name">Services</span></a><meta itemprop="position" content="2"/></li>
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name"><?php echo esc_html($c['h1']); ?></span><meta itemprop="position" content="3"/></li>
    </ol>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="container reveal">
    <div class="eyebrow eyebrow--white">Plumbers Roodepoort</div>
    <h1><?php echo esc_html($c['h1']); ?></h1>
    <p><?php echo esc_html($c['intro']); ?></p>
    <div class="page-hero-actions">
      <a href="<?php echo esc_attr(tp_plink()); ?>" class="btn btn--fire btn--lg">📞 Call <?php echo esc_html(tp_phone()); ?></a>
      <a href="<?php echo esc_url(tp_wa_link()); ?>" target="_blank" class="btn btn--wa">WhatsApp Now</a>
    </div>
  </div>
</div>
<?php get_template_part('template-parts/trust-strip'); ?>

<!-- CONTENT -->
<div class="container">
  <div class="content-layout">
    <div class="content-body reveal">

      <?php if ($img): ?>
      <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($c['h1']); ?>" style="width:100%;height:360px;object-fit:cover;border-radius:6px;margin-bottom:32px" loading="lazy">
      <?php endif; ?>

      <h2><?php echo esc_html($c['h2_1']); ?></h2>
      <p>Searching for <?php echo esc_html(strtolower($clean_name)); ?> near me? <?php echo esc_html($c['intro']); ?></p>
      <ul>
        <?php foreach ($c['list1'] as $item): ?>
        <li><?php echo esc_html($item); ?></li>
        <?php endforeach; ?>
      </ul>

      <h2><?php echo esc_html($c['h2_2']); ?></h2>
      <ul>
        <?php foreach ($c['list2'] as $item): ?>
        <li><?php echo esc_html($item); ?></li>
        <?php endforeach; ?>
      </ul>

      <?php if ($c['h3'] && $c['body']): ?>
      <h3><?php echo esc_html($c['h3']); ?></h3>
      <?php foreach (explode("\n\n", $c['body']) as $para): if(trim($para)): ?>
      <p><?php echo esc_html(trim($para)); ?></p>
      <?php endif; endforeach; ?>
      <?php endif; ?>

      <div class="highlight-box">
        <h3>Need <?php echo esc_html($clean_name); ?> in Roodepoort Right Now?</h3>
        <p>Call <strong><a href="<?php echo esc_attr(tp_plink()); ?>" style="color:var(--fire)"><?php echo esc_html(tp_phone()); ?></a></strong> — available 24/7, no call-out fee, on-site in 45 minutes across Roodepoort and the West Rand.</p>
      </div>

      <?php if (get_the_content()): ?>
      <div class="wp-content"><?php the_content(); ?></div>
      <?php endif; ?>

      <h2>Frequently Asked Questions — <?php echo esc_html($clean_name); ?></h2>
      <?php
      $svc_faqs = [
          ['Is there ' . strtolower($clean_name) . ' near me?', 'Yes — we cover Roodepoort and the surrounding West Rand suburbs directly, so if you\'re searching for "' . strtolower($clean_name) . ' near me," we\'re a local option with a 45-minute on-site target for emergencies in our core coverage area.'],
          ['How much does ' . strtolower($clean_name) . ' cost?', 'It depends on the scope of the job. We give a free, no-obligation quote before starting, and we never charge a call-out fee.'],
          ['Can I get ' . strtolower($clean_name) . ' the same day?', 'In most cases, yes. Call or WhatsApp us and we\'ll confirm same-day availability — urgent issues are always prioritised.'],
      ];
      ?>
      <div class="faq-wrap">
        <?php foreach ($svc_faqs as $fq): ?>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><?php echo esc_html($fq[0]); ?><div class="faq-icon"><svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg></div></div><div class="faq-a"><?php echo esc_html($fq[1]); ?></div></div>
        <?php endforeach; ?>
      </div>
      <?php
      $svc_faq_schema = ['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>array_map(function($fq){
          return ['@type'=>'Question','name'=>$fq[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$fq[1]]];
      }, $svc_faqs)];
      echo '<script type="application/ld+json">'.wp_json_encode($svc_faq_schema, JSON_UNESCAPED_SLASHES).'</script>'."\n";
      ?>

      <h2>Other Plumbing Services in Roodepoort</h2>
      <ul><?php echo $other; ?></ul>

      <!-- MINI REVIEWS -->
      <h2 style="margin-top:40px">What Roodepoort Customers Say</h2>
      <div class="mini-rev-grid">
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Fast, professional, and fixed it properly. No call-out fee and a fair price."</blockquote><div class="mini-rev-author">— T. Mokoena, Wilgeheuwel</div></div>
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Called on a public holiday and they were here within an hour. Outstanding."</blockquote><div class="mini-rev-author">— K. van der Berg, Honeydew</div></div>
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"The best plumbers in Roodepoort. Honest, skilled, and clean workers."</blockquote><div class="mini-rev-author">— D. Okonkwo, Constantia Kloof</div></div>
      </div>
    </div>

    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
