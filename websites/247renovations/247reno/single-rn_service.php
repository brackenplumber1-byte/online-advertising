<?php get_header(); ?>
<?php while (have_posts()): the_post();
  $slug  = get_post_field('post_name', get_the_ID());
  $svcs  = unserialize(RN_SERVICES);
  $areas = unserialize(RN_AREAS);
  $svc   = $svcs[$slug] ?? [get_the_title(), get_the_title(), ''];

  // Rich content per service
  $content = [
    'kitchen-renovations' => [
      'h1'    => 'Kitchen Renovations Johannesburg | Transform Your Kitchen — Free Quote',
      'intro' => '247 Renovations is one of Johannesburg\'s most trusted kitchen renovation companies, with 10+ years of experience transforming kitchens across Sandton, Randburg, Fourways, Roodepoort and all of Gauteng. From custom cabinetry to complete kitchen redesigns — we deliver quality that lasts.',
      'h2_1'  => 'Our Kitchen Renovation Services in Johannesburg',
      'list1' => ['Full kitchen redesign and layout optimisation','Custom kitchen cabinetry and cupboards','Stone, quartz and laminate countertops','Kitchen tiling — floors, walls and splashbacks','Kitchen plumbing — sink, dishwasher, appliance connections','Electrical for kitchen appliances and lighting','Open-plan kitchen conversions','Kitchen island installation','Built-in appliance integration'],
      'h2_2'  => 'Why Choose 247 Renovations for Your Johannesburg Kitchen?',
      'list2' => ['10+ years of kitchen renovation experience across Johannesburg','Free site visit and detailed written quotation within 24 hours','12-month workmanship guarantee on all kitchen work','We beat any genuine competitor quote in Johannesburg','Skilled in-house team — no unreliable subcontractors','Full project management from design to final clean-up'],
      'h3'    => 'How Much Does a Kitchen Renovation Cost in Johannesburg?',
      'body'  => "Kitchen renovation costs in Johannesburg depend on the size of the kitchen, materials chosen, and scope of work. A basic kitchen update starts from R40,000. A mid-range renovation with new cabinetry and countertops typically costs R80,000–R180,000. A premium designer kitchen can range from R200,000 upward.\n\nAt 247 Renovations, we work with all budgets. Our free quotation is fully itemised so you can see exactly where every rand is spent — and make informed choices about materials and finishes.",
    ],
    'bathroom-renovations' => [
      'h1'    => 'Bathroom Renovations Johannesburg | Complete Makeovers — Free Quote',
      'intro' => '247 Renovations transforms bathrooms across Johannesburg into beautiful, functional spaces. From a simple refresh to a complete wet room conversion — our skilled team handles everything from tiling and plumbing to fixtures and waterproofing. Free quotes, fully insured, 12-month guarantee.',
      'h2_1'  => 'Our Bathroom Renovation Services in Johannesburg',
      'list1' => ['Complete bathroom renovation and redesign','Wet room and shower conversion','Bath-to-shower conversion','Custom tiling — walls and floors','Vanity, basin and toilet installation','Shower enclosure and glass installation','Bathroom waterproofing','Towel rail and accessory fitting','Full bathroom plumbing and electrical'],
      'h2_2'  => 'Why Johannesburg Homeowners Choose 247 Renovations',
      'list2' => ['Complete service — one team handles all trades','Free, detailed quotation within 24 hours of site visit','12-month workmanship guarantee included','All waterproofing professionally applied before tiling','Fully insured for your peace of mind','Clean, tidy worksite — protected from dust and damage daily','Available across all of Johannesburg and Gauteng'],
      'h3'    => 'How Much Does a Bathroom Renovation Cost in Johannesburg?',
      'body'  => "Bathroom renovation costs in Johannesburg start from R25,000 for a basic refresh. A standard full bathroom renovation typically costs R50,000–R120,000. Luxury wet rooms with high-end finishes can range from R150,000 upward.\n\nThe biggest variables are tile selection, fixture quality, and whether structural changes are needed. Our free site visit allows us to give you an accurate, itemised quote tailored to your exact bathroom.",
    ],
    'home-renovations' => [
      'h1'    => 'Home Renovations Johannesburg | Full Home Makeovers — Free Quote',
      'intro' => 'Planning a home renovation in Johannesburg? 247 Renovations manages complete home renovations from start to finish — from single-room makeovers to full-home transformations. Skilled tradespeople, single point of contact, full project management across all of Gauteng.',
      'h2_1'  => 'Home Renovation Services We Offer in Johannesburg',
      'list1' => ['Full home renovation and interior transformation','Living room and bedroom renovations','Open-plan layout conversions','Interior doors and built-in wardrobes','Ceiling installation and repair','Painting and plastering throughout','Flooring — tiles, wood, laminate, vinyl','Kitchen and bathroom upgrades as part of full home reno','Exterior painting and rendering'],
      'h2_2'  => 'Why Choose 247 Renovations for Your Home Renovation?',
      'list2' => ['Single point of contact for your entire project','Skilled tradespeople across all building disciplines','Transparent quotation — no hidden extras','12-month workmanship guarantee on every job','Serving all of Johannesburg and Gauteng','Free site visit and detailed proposal within 24 hours'],
      'h3'    => 'Planning Your Home Renovation in Johannesburg',
      'body'  => "A successful home renovation in Johannesburg starts with a clear brief and a reliable contractor. At 247 Renovations, we begin every project with a free site visit where we listen to your vision, assess the current condition of your home, and advise on the most practical and cost-effective approach.\n\nWe then provide a detailed written quotation, a project timeline, and a single point of contact for the entire renovation. No chasing multiple contractors. No communication breakdowns. Just a well-managed renovation delivered to specification.",
    ],
    'building-extensions' => [
      'h1'    => 'Building Extensions Johannesburg | Home Additions — Free Quote',
      'intro' => 'Need more space? 247 Renovations builds professional home extensions across Johannesburg — bedrooms, bathrooms, garages, entertainment areas and more. Full council compliance, 12-month workmanship guarantee. Free site visit and quote.',
      'h2_1'  => 'Building Extension Services in Johannesburg',
      'list1' => ['Single and double storey home extensions','Bedroom and bathroom additions','Kitchen extensions and open-plan conversions','Entertainment room and braai room additions','Garage to living space conversions','Carport and garage additions','Covered patio and entertainment area','Garden flat and granny flat construction','Council plan submission and approval assistance'],
      'h2_2'  => 'Why Choose 247 Renovations for Building Extensions?',
      'list2' => ['10+ years of extension and addition projects across JHB','Full project management from plans to final sign-off','12-month workmanship guarantee','We work with your architect or can recommend one','All building materials sourced from trusted SA suppliers','Serving all of Johannesburg and Gauteng'],
      'h3'    => 'Do You Need Building Plans for a Home Extension in Johannesburg?',
      'body'  => "In most cases, yes. Any structural addition to your home — including new rooms, a second storey, or a garage conversion — requires approved building plans submitted to your local municipality. 247 Renovations can guide you through this process and work with your architect or draughtsperson to ensure full compliance.\n\nThe approval process typically takes 4–8 weeks. We advise starting your planning early to avoid delays. Contact us for a free consultation on your extension project.",
    ],
    'roof-repairs-waterproofing' => [
      'h1'    => 'Roof Repairs & Waterproofing Johannesburg | Stop Leaks Fast — Free Quote',
      'intro' => 'Leaking roof or damp problems in Johannesburg? 247 Renovations provides professional roof repairs, torch-on waterproofing, flat roof sealing, damp-proofing and gutter services across all of Gauteng. Fast response, quality materials, 5-year waterproofing guarantee.',
      'h2_1'  => 'Roof Repair & Waterproofing Services in Johannesburg',
      'list1' => ['Roof leak detection and repair','Torch-on bitumen waterproofing (flat roofs)','Acrylic waterproofing systems','Damp-proofing — walls and floors','Parapet and balcony waterproofing','IBR and corrugated roof repairs','Tile roof repairs and ridge cap replacement','Gutter installation and repairs','Ceiling repairs after roof leaks'],
      'h2_2'  => 'Why Choose 247 Renovations for Roof Repairs in Johannesburg?',
      'list2' => ['Fast response — we inspect within 24 hours','5-year guarantee on all waterproofing work','Quality-approved waterproofing products only','Serving all of Johannesburg and Gauteng','Free site inspection and detailed quote','Permanent solutions — not temporary patches'],
      'h3'    => 'Signs You Need Roof Repairs or Waterproofing in Johannesburg',
      'body'  => "Common signs of roof problems in Johannesburg homes include: water stains on ceilings, visible damp patches on internal walls, peeling paint, musty smells in rooms, or water pooling on flat roofs after rain. Johannesburg\'s summer thunderstorm season puts significant stress on roofs — particularly flat roofs and older IBR sheeting.\n\nDon\'t wait for a leak to become a flood. Call 247 Renovations for a free roof inspection across Johannesburg and Gauteng.",
    ],
    'painting-plastering' => [
      'h1'    => 'Painting & Plastering Johannesburg | Interior & Exterior — Free Quote',
      'intro' => '247 Renovations provides professional painting and plastering services across Johannesburg. From a single room to a full exterior repaint — our skilled painters and plasterers deliver a flawless finish that lasts. Quality materials, competitive pricing, free quotes across Gauteng.',
      'h2_1'  => 'Painting & Plastering Services in Johannesburg',
      'list1' => ['Interior painting — all rooms and finishes','Exterior painting — full property repaints','Plastering and skim coat finishing','Crack repair and plaster patch','Texture and Polycell finishes','Damp-proofing paint applications','Ceiling painting and repairs','Colour consultation and advice','Preparation and primer — proper surface treatment'],
      'h2_2'  => 'Why Choose 247 Renovations for Painting in Johannesburg?',
      'list2' => ['Skilled painters with 10+ years of Johannesburg experience','Quality paints — Plascon, Dulux and approved brands','Full surface preparation before any paint is applied','Clean, tidy workers — furniture protected daily','Free, itemised quotation within 24 hours','12-month workmanship guarantee on all painting','Serving all of Johannesburg and Gauteng'],
      'h3'    => 'How to Choose the Right Paint for Johannesburg\'s Climate',
      'body'  => "Johannesburg\'s climate — hot summers, cold dry winters, and intense UV exposure — requires exterior paints that can handle thermal expansion, UV resistance, and water repellency. We recommend Plascon Weatherguard or Dulux Weathershield for all Johannesburg exterior surfaces.\n\nFor interior work, a quality PVA with a wipeable finish is practical for kitchens and bathrooms. Our team will advise you on the right products for each area of your home during the free site visit.",
    ],
    'tiling-flooring' => [
      'h1'    => 'Tiling & Flooring Johannesburg | Professional Installation — Free Quote',
      'intro' => '247 Renovations installs all types of tiles and flooring across Johannesburg — from bathroom tiling to full-home wooden flooring. Our skilled tilers deliver precise, long-lasting results with quality materials sourced from South Africa\'s top suppliers. Free quotes across Gauteng.',
      'h2_1'  => 'Tiling & Flooring Services in Johannesburg',
      'list1' => ['Floor tiling — all tile types and sizes','Wall tiling — kitchen, bathroom, feature walls','Wooden flooring — solid wood and engineered','Laminate flooring installation','Luxury vinyl and LVP flooring','Polished concrete screeds','Tile removal and surface preparation','Grouting and sealing','Underfloor heating installation'],
      'h2_2'  => 'Why Choose 247 Renovations for Tiling in Johannesburg?',
      'list2' => ['Precise, level installation on every job','Experience with all tile types — large format to mosaic','Full surface preparation including screeding if required','Quality tile adhesive and grout — waterproof in wet areas','12-month workmanship guarantee','Free site visit and detailed quotation','Serving all of Johannesburg and Gauteng'],
      'h3'    => 'Choosing the Right Tiles for Johannesburg Homes',
      'body'  => "Porcelain tiles are the most popular choice for Johannesburg homes — they\'re durable, easy to clean, and available in a huge range of styles. For bathrooms and wet areas, a slip-resistant finish is important. Large-format tiles (600x600 or 600x1200) are trending in Johannesburg\'s modern homes and create a sense of space.\n\nFor flooring throughout living areas, engineered wood or quality laminate offers warmth and style at a more affordable price point than solid wood. Our team can advise on the best option for your space and budget during the free site visit.",
    ],
    'paving-driveways' => [
      'h1'    => 'Paving & Driveways Johannesburg | Brick & Concrete Paving — Free Quote',
      'intro' => '247 Renovations installs and repairs all types of paving and driveways across Johannesburg. Brick paving, concrete paving, exposed aggregate, and paving repairs — professional installation with quality materials. Free quotes across all of Gauteng.',
      'h2_1'  => 'Paving & Driveway Services in Johannesburg',
      'list1' => ['Brick paving driveways and pathways','Concrete paving installation','Exposed aggregate driveways','Paving repairs and re-levelling','Permeable paving systems','Garden paving and pathways','Pool surrounds and entertainment areas','Kerbing and edging','Driveway resurfacing and sealing'],
      'h2_2'  => 'Why Choose 247 Renovations for Paving in Johannesburg?',
      'list2' => ['Proper sub-base preparation — the foundation of lasting paving','Quality bricks and concrete from trusted South African suppliers','Proper drainage and grading on every project','12-month workmanship guarantee','Free site visit and detailed quotation','Serving all of Johannesburg and Gauteng'],
      'h3'    => 'Brick vs Concrete Paving — Which is Better for Johannesburg?',
      'body'  => "Both brick paving and concrete paving are popular in Johannesburg. Brick paving is more aesthetically flexible, easier to repair if individual bricks crack, and adds a premium finish to driveways and entertainment areas. Concrete paving is more cost-effective for large areas and is extremely durable.\n\nThe right choice depends on your budget, the size of the area, and your aesthetic preference. Our team will advise you on the best option during your free site visit.",
    ],
    'palisade-fencing' => [
      'h1'    => 'Palisade Fencing Johannesburg | Security Fencing Installation — Free Quote',
      'intro' => '247 Renovations installs and repairs palisade fencing, security fencing and electric fencing across Johannesburg and Gauteng. Professional steel palisade installation, competitive pricing, and a 12-month workmanship guarantee. Free quotes for residential and commercial properties.',
      'h2_1'  => 'Palisade & Security Fencing Services in Johannesburg',
      'list1' => ['Steel palisade fencing installation','Galvanised and powder-coated palisade','Palisade fence repairs and modifications','Electric fence installation','Slam-lock gate installation','Driveway gates — manual and automated','Clearview fencing','Palisade painting and maintenance','Commercial perimeter security fencing'],
      'h2_2'  => 'Why Choose 247 Renovations for Palisade Fencing in Johannesburg?',
      'list2' => ['Quality galvanised steel — resistant to corrosion','Professional installation with proper concrete footings','SABS-approved materials on all fencing projects','12-month workmanship guarantee','Free site measurement and detailed quote','Serving all of Johannesburg and Gauteng','Competitive pricing — we beat any genuine JHB quote'],
      'h3'    => 'What is the Best Type of Palisade Fencing for Johannesburg Homes?',
      'body'  => "For most Johannesburg residential properties, 1.8m or 2.1m galvanised powder-coated steel palisade is the most popular and cost-effective security fencing option. It provides a strong visual deterrent, is difficult to cut without specialist tools, and requires minimal maintenance.\n\nFor high-security applications, electric fencing on top of palisade provides an additional layer of deterrence. Our team will assess your property\'s perimeter during the free site visit and recommend the most appropriate fencing solution.",
    ],
    'garage-conversions' => [
      'h1'    => 'Garage Conversions Johannesburg | Convert to Living Space — Free Quote',
      'intro' => '247 Renovations converts garages into usable living spaces across Johannesburg — bedrooms, home offices, flatlets, entertainment rooms and more. Full building compliance, 12-month guarantee. Free site visit and quote across all of Gauteng.',
      'h2_1'  => 'Garage Conversion Services in Johannesburg',
      'list1' => ['Garage to bedroom conversion','Garage to flatlet / rental unit','Garage to home office or study','Garage to entertainment room / man cave','Adding windows and doors','Insulation — ceiling, walls and floor','Electrical and lighting installation','Flooring — tiles, laminate, polished concrete','Plumbing additions if required'],
      'h2_2'  => 'Why Convert Your Garage in Johannesburg?',
      'list2' => ['Add living space without building a new structure','Create a rental income flatlet — high demand in Johannesburg','Increase your property value significantly','More cost-effective than a full building extension','Full building compliance and plans if required','12-month workmanship guarantee'],
      'h3'    => 'Do You Need Plans for a Garage Conversion in Johannesburg?',
      'body'  => "In most cases, a garage-to-living-space conversion requires municipal approval, particularly if you\'re adding a kitchen, bathroom, or permanent habitation. 247 Renovations can guide you through the approval process and work with a draughtsperson to submit plans to your local municipality.\n\nContact us for a free consultation on your garage conversion project. We\'ll assess the space, advise on planning requirements, and provide a detailed quotation.",
    ],
    'garden-flats' => [
      'h1'    => 'Garden Flats & Wendy Houses Johannesburg | Build & Install — Free Quote',
      'intro' => '247 Renovations builds garden flats, granny flats, and wendy houses across Johannesburg. Create a rental income stream or additional living space for family. Full building compliance, free site visit and quote across all of Gauteng.',
      'h2_1'  => 'Garden Flat & Wendy House Services in Johannesburg',
      'list1' => ['Full garden flat construction — brick and mortar','Prefab wendy house supply and installation','Granny flat with kitchen and bathroom','Staff quarters construction','Garden office / studio','Full electrical, plumbing and data connections','Building plans and council submission assistance','Interior finishing — tiling, painting, built-ins'],
      'h2_2'  => 'Why Build a Garden Flat in Johannesburg?',
      'list2' => ['Generate rental income — high demand across Johannesburg','Add significant value to your property','House a family member with independence','Full building compliance ensures insurability','12-month workmanship guarantee','Free site visit and detailed quotation'],
      'h3'    => 'How Much Does a Garden Flat Cost in Johannesburg?',
      'body'  => "A basic wendy house starts from R30,000. A properly built brick garden flat with kitchen and bathroom in Johannesburg typically costs R120,000–R250,000 depending on size and finishes. A high-spec garden flat can cost R300,000 or more.\n\nThe rental income potential in Johannesburg is strong — garden flats in suburbs like Sandton, Fourways, Randburg, and Roodepoort typically rent for R5,000–R12,000 per month, offering a strong return on investment. Call us for a free site visit and detailed quotation.",
    ],
    'maintenance-repairs' => [
      'h1'    => 'Building Maintenance Johannesburg | Repairs & Handyman Services — Free Quote',
      'intro' => '247 Renovations provides general building maintenance and repair services across Johannesburg — from crack repairs and ceiling work to general handyman jobs. Skilled tradespeople, competitive pricing, 12-month guarantee. Free quotes across all of Gauteng.',
      'h2_1'  => 'Building Maintenance Services in Johannesburg',
      'list1' => ['Plaster crack repairs and skim coating','Ceiling board repairs and replacement','Door and window frame repairs','Damp treatment and moisture barrier application','Gutter cleaning and repairs','Fence and gate repairs','Tile replacements and regrouting','General handyman services','Property maintenance contracts for body corporates'],
      'h2_2'  => 'Why Choose 247 Renovations for Building Maintenance?',
      'list2' => ['Experienced across all building maintenance disciplines','Reliable, skilled tradespeople — not random handymen','Free site visit and itemised quotation','12-month guarantee on all repair work','Serving all of Johannesburg and Gauteng','Competitive pricing — transparent and fair','Available for once-off jobs and ongoing contracts'],
      'h3'    => 'Property Maintenance Contracts in Johannesburg',
      'body'  => "247 Renovations offers scheduled property maintenance contracts for body corporates, estate managers, and property management companies across Johannesburg. A regular maintenance schedule protects your property\'s value and prevents small issues from becoming expensive repairs.\n\nContact us to discuss a tailored maintenance programme for your property portfolio in Johannesburg or Gauteng.",
    ],
    'granite-quartz-countertops' => [
      'h1'    => 'Granite, Quartz & Marble Countertops Johannesburg | Supply & Install — Free Quote',
      'intro' => '247 Renovations supplies and installs granite, quartz, marble and Caesarstone countertops across Johannesburg. From kitchen islands to bathroom vanities, our team templates, fabricates and fits natural stone and engineered surfaces to a precise, lasting finish. Free quotes, professional templating, full installation.',
      'h2_1'  => 'Countertop Services in Johannesburg',
      'list1' => ['Granite countertop supply and installation','Quartz and engineered stone countertops','Marble countertop and feature surfaces','Caesarstone supply and fitting','Kitchen island and waterfall-edge countertops','Bathroom vanity tops in stone or quartz','On-site templating for a precise fit','Sink and hob cut-outs to exact specification','Old countertop removal and disposal','Sealing and finishing for natural stone'],
      'h2_2'  => 'Why Choose 247 Renovations for Countertops in Johannesburg?',
      'list2' => ['Professional on-site templating before fabrication','Wide range of granite, quartz, marble and Caesarstone finishes','Precise cut-outs for sinks, hobs and appliances','Experienced installers — no chips, no uneven joins','12-month workmanship guarantee on every installation','Free site visit and detailed written quotation','Serving all of Johannesburg and Gauteng','Competitive pricing — we beat any genuine quote'],
      'h3'    => 'Granite vs Quartz vs Marble — Which Is Right for Your Johannesburg Kitchen?',
      'body'  => "Granite is a natural stone prized for its durability and unique veining — no two slabs are identical, making it a popular choice for kitchen islands and feature countertops in Johannesburg homes. It handles heat well and resists scratching, though it does require periodic sealing.\n\nQuartz and Caesarstone are engineered surfaces that offer a more uniform appearance, excellent stain resistance, and require no sealing — a popular low-maintenance choice for busy households. Marble brings a luxurious, classic look, often chosen for bathroom vanities and statement kitchen islands, though it is softer and more prone to etching from acidic substances than granite or quartz.\n\nOur team will bring sample slabs to your free site visit and advise on the best material for your kitchen or bathroom renovation, your budget, and how the space will be used.",
    ],
  ];
  $c = $content[$slug] ?? ['h1'=>get_the_title(),'intro'=>$svc[2],'h2_1'=>'Our Services','list1'=>[],'h2_2'=>'Why Choose Us','list2'=>[],'h3'=>'','body'=>''];
  $other_svcs = '';
  foreach ($svcs as $s_slug => $s_data) {
    if ($s_slug === $slug) continue;
    $sp  = get_posts(['name'=>$s_slug,'post_type'=>'rn_service','post_status'=>'publish','numberposts'=>1]);
    $url = $sp ? get_permalink($sp[0]->ID) : home_url('/services/'.$s_slug);
    $other_svcs .= '<li><a href="'.esc_url($url).'">'.esc_html($s_data[1]).' Johannesburg</a></li>';
  }
?>

<nav class="breadcrumb" aria-label="Breadcrumb">
  <div class="container">
    <ol>
      <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
      <li><a href="<?php echo home_url('/#services'); ?>">Services</a></li>
      <li><?php echo esc_html($c['h1']); ?></li>
    </ol>
  </div>
</nav>

<div class="page-hero">
  <div class="container">
    <div class="eyebrow eyebrow--white">Renovation Services Johannesburg</div>
    <h1><?php echo esc_html($c['h1']); ?></h1>
    <p><?php echo esc_html($c['intro']); ?></p>
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
      <?php
      $imgdir = rn_imgdir();
      $page_photos = [
        'kitchen-renovations'        => ['kitchen-1.jpg','kitchen-3.jpg','kitchen-4.jpg'],
        'bathroom-renovations'       => ['bathroom-1.jpg','bathroom-guest.jpg'],
        'home-renovations'           => ['kitchen-3.jpg','bathroom-1.jpg'],
        'building-extensions'        => ['extension-rear.jpg'],
        'roof-repairs-waterproofing' => ['roofing-1.jpg','roofing-2.jpg'],
        'tiling-flooring'            => ['tiler-2.jpg','tiler-3.jpg','tiler-4.jpg'],
        'paving-driveways'           => ['paving-2.jpg','paving-1.jpg'],
        'palisade-fencing'           => ['palisade-1.jpg','palisade-2.jpg'],
        'garage-conversions'         => ['tiler-1.jpg'],
        'garden-flats'               => ['garden-flat.jpg'],
        'painting-plastering'        => ['kitchen-4.jpg'],
        'maintenance-repairs'        => ['bathroom-guest.jpg'],
        'granite-quartz-countertops' => ['granite-1.jpg','granite-2.jpg'],
      ];
      $photos = $page_photos[$slug] ?? [];
      ?>
      <?php if (count($photos) > 1): ?>
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:8px;margin-bottom:32px;height:340px">
        <img src="<?php echo esc_url($imgdir . $photos[0]); ?>" alt="<?php echo esc_attr($svc[1]); ?> Johannesburg — 247 Renovations" style="width:100%;height:100%;object-fit:cover;border-radius:6px" loading="lazy">
        <div style="display:grid;grid-template-rows:1fr 1fr;gap:8px">
          <?php for ($i = 1; $i < min(3, count($photos)); $i++): ?>
          <img src="<?php echo esc_url($imgdir . $photos[$i]); ?>" alt="<?php echo esc_attr($svc[1]); ?> Johannesburg project" style="width:100%;height:100%;object-fit:cover;border-radius:6px" loading="lazy">
          <?php endfor; ?>
        </div>
      </div>
      <?php elseif (count($photos) === 1): ?>
      <img src="<?php echo esc_url($imgdir . $photos[0]); ?>" alt="<?php echo esc_attr($svc[1]); ?> Johannesburg — 247 Renovations" style="width:100%;height:340px;object-fit:cover;border-radius:6px;margin-bottom:32px" loading="lazy">
      <?php else: ?>
      <div style="width:100%;height:340px;background:linear-gradient(135deg,#2A2A2A,#3A3A3A);border-radius:6px;margin-bottom:32px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px">
        <svg width="52" height="52" viewBox="0 0 24 24" fill="rgba(232,96,10,0.35)"><path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/></svg>
        <p style="color:rgba(255,255,255,0.25);font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;text-align:center;padding:0 24px">Add a <?php echo esc_html($svc[1]); ?> project photo via WordPress Media Library</p>
      </div>
      <?php endif; ?>

      <h2><?php echo esc_html($c['h2_1']); ?></h2>
      <p><?php echo esc_html($c['intro']); ?></p>
      <ul>
        <?php foreach ($c['list1'] as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
      </ul>

      <h2><?php echo esc_html($c['h2_2']); ?></h2>
      <ul>
        <?php foreach ($c['list2'] as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
      </ul>

      <?php if ($c['h3'] && $c['body']): ?>
      <h3><?php echo esc_html($c['h3']); ?></h3>
      <?php foreach (explode("\n\n", $c['body']) as $para): if(trim($para)): ?>
      <p><?php echo esc_html(trim($para)); ?></p>
      <?php endif; endforeach; ?>
      <?php endif; ?>

      <div class="highlight-box">
        <h3>Ready to get started? Get a free quote today.</h3>
        <p>Call <strong><a href="<?php echo esc_attr(rn_plink()); ?>" style="color:var(--orange)"><?php echo esc_html(rn_phone()); ?></a></strong> or WhatsApp us — free site visit, detailed written quotation within 24 hours. Serving all of Johannesburg and Gauteng.</p>
      </div>

      <?php if (get_the_content()): ?><div><?php the_content(); ?></div><?php endif; ?>

      <h2 style="margin-top:40px">Areas We Cover in Johannesburg</h2>
      <p>247 Renovations provides <?php echo esc_html(strtolower($svc[1])); ?> services across all major suburbs in Johannesburg and Gauteng including Sandton, Randburg, Fourways, Midrand, Roodepoort, Honeydew, Northcliff, Bryanston, Parkhurst, Melville, Florida and surrounding areas.</p>

      <h2>Other Renovation Services in Johannesburg</h2>
      <ul><?php echo $other_svcs; ?></ul>

      <div class="mini-rev-grid">
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Professional, punctual and quality work. Highly recommended for any renovation in Johannesburg."</blockquote><div class="mini-rev-author">— Homeowner, Sandton</div></div>
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"Great workmanship and fair pricing. No surprise extras on the invoice — exactly as quoted."</blockquote><div class="mini-rev-author">— Client, Fourways</div></div>
        <div class="mini-rev"><div class="rev-stars">★★★★★</div><blockquote>"The 12-month guarantee gave us confidence. The team was clean, tidy and finished on time."</blockquote><div class="mini-rev-author">— Homeowner, Randburg</div></div>
      </div>
    </div>
    <?php get_template_part('template-parts/sidebar'); ?>
  </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
