<?php /* Template Name: Services */ get_header(); $img = get_template_directory_uri().'/assets/images/'; ?>

<section class="nt-hero">
<div class="nt-hero-media"><img src="<?php echo esc_url($img.'cnc-turning.jpg'); ?>" alt=""></div>
<div class="nt-hero-inner">
<div class="nt-hero-copy">
<span class="eyebrow">Services</span>
<h1>Our Manufacturing Services</h1>
<p>From prototypes to light production, we offer a wide range of manufacturing solutions - each backed by engineering review and independent quality oversight.</p>
</div>
</div>
</section>

<div class="hero-divider"></div>

<section class="section">
<div class="container">
<div class="grid-4">

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'Engineering1.jpg'); ?>" alt="Engineering">
<div class="tex-card-body"><div class="tc-title">Engineering</div><p>3D CAD design and documentation, design-for-manufacturing (DFM).</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'cnc-machining.jpg'); ?>" alt="CNC Machining &amp; Turning">
<div class="tex-card-body"><div class="tc-title">CNC Machining &amp; Turning</div><p>Precision 3, 4 &amp; 5-axis milling and turning for complex, cylindrical parts.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'molding.png'); ?>" alt="Molding">
<div class="tex-card-body"><div class="tc-title">Molding</div><p>Injection and compression molding for production-volume parts.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'sheet-metal.jpg'); ?>" alt="Sheet Metal Fabrication">
<div class="tex-card-body"><div class="tc-title">Sheet Metal Fabrication</div><p>Laser cutting, bending, and metal assembly.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'Proto-low-pro1.jpg'); ?>" alt="Prototype and Production Manufacturing">
<div class="tex-card-body"><div class="tc-title">Prototype and Production Manufacturing</div><p>Prototype, short-run, and production manufacturing with consistent quality throughout the entire order.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'prototype.png'); ?>" alt="Prototype Assembly">
<div class="tex-card-body"><div class="tc-title">Prototype Assembly</div><p>Mechanical and electro-mechanical builds.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'inspection-2.png'); ?>" alt="Quality Inspection">
<div class="tex-card-body"><div class="tc-title">Quality Inspection</div><p>Comprehensive inspection and test reports.</p></div>
</div>

<div class="tex-card"><div class="tex-overlay"></div>
<img class="tex-card-media" src="<?php echo esc_url($img.'offshore-shipping.jpg'); ?>" alt="Offshore Sourcing">
<div class="tex-card-body"><div class="tc-title">Offshore Sourcing</div><p>Cost-effective production with quality oversight.</p></div>
</div>

</div>
</div>
</section>

<section class="mini-cta">
<div class="container">
<h2>The Right Process for Every Part</h2>
<p>From a single prototype to full production runs, our engineering team can help scope the right process, material, and finish for your project.</p>
<p class="tagline">Engineering Review &middot; Prototype to Production &middot; U.S.-Managed Quality</p>
<div class="hero-actions">
<a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-a-quote/')); ?>">Request a Quote</a>
<a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">Speak with a Specialist</a>
</div>
</div>
</section>

<?php get_footer(); ?>
