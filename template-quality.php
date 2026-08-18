<?php /* Template Name: Quality */ get_header(); $img = get_template_directory_uri().'/assets/images/'; ?>

<section class="nt-hero">
<div class="nt-hero-media nt-hero-media-quality"><img src="<?php echo esc_url($img.'inspection-2.png'); ?>" alt=""></div>
<div class="nt-hero-inner">
<div class="nt-hero-copy">
<span class="eyebrow">Quality</span>
<h1>Offshore Manufacturing. U.S.-Managed Accountability.</h1>
<p>Global manufacturing offers significant cost advantages - but only when quality, communication, and accountability are never compromised. At Newtron, we bridge that gap by combining competitive offshore production with U.S.-based engineering oversight and project management.</p>
</div>
</div>
</section>

<?php get_template_part('template-parts/quality-journey'); ?>

<section class="gain-band">
<div class="container" style="padding:clamp(56px,7vw,88px) 0">
<div class="section-head" style="max-width:680px">
<span class="eyebrow">The Best of Both Worlds</span>
<h2 style="color:#fff">What our customers gain</h2>
</div>
<div class="grid-5">

<div class="gain-card">
<div class="gain-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8bc53f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div>
<h4>Lower Manufacturing Costs</h4><p>Competitive global production without sacrificing quality.</p>
</div>

<div class="gain-card">
<div class="gain-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8bc53f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></div>
<h4>U.S.-Based Communication</h4><p>Work directly with an American team that understands your requirements.</p>
</div>

<div class="gain-card">
<div class="gain-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8bc53f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg></div>
<h4>Quality Assurance</h4><p>Multiple checkpoints help ensure every component meets specification.</p>
</div>

<div class="gain-card">
<div class="gain-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8bc53f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"></path></svg></div>
<h4>Faster Problem Resolution</h4><p>Engineering questions and revisions are handled quickly through our U.S. team.</p>
</div>

<div class="gain-card">
<div class="gain-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8bc53f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 2 10 6-10 6L2 8z"></path><path d="m2 14 10 6 10-6"></path></svg></div>
<h4>Flexible Production</h4><p>From a single prototype to full-scale production, we scale to meet your needs.</p>
</div>

</div>
</div>
</section>

<section class="section-light">
<div class="container" style="max-width:900px;padding:clamp(56px,7vw,88px) clamp(20px,5vw,48px);text-align:center">
<span class="eyebrow">Your Manufacturing Partner</span>
<p style="font-size:16px;line-height:1.65;color:var(--muted);margin:0 0 14px">Choosing Newtron means more than finding a lower-cost supplier. It means gaining a manufacturing partner committed to protecting your investment through engineering expertise, proactive communication, and dependable quality oversight.</p>
<p style="font-size:16px;line-height:1.65;color:var(--muted);margin:0">We combine the economic advantages of offshore manufacturing with the accountability, responsiveness, and quality standards expected from a U.S.-managed manufacturing partner.</p>
</div>
</section>

<section class="mini-cta">
<div class="container">
<h2>Competitive Global Manufacturing. Complete Confidence.</h2>
<p>American quality oversight backed by dependable, U.S.-managed manufacturing partnerships.</p>
<p class="tagline">Trusted Quality Oversight &middot; Confidence in Every Shipment</p>
<div class="hero-actions">
<a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-a-quote/')); ?>">Request a Quote</a>
<a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">Speak with a Specialist</a>
</div>
<a href="<?php echo esc_url(home_url('/quality-policy/')); ?>" style="display:inline-block;margin-top:24px;font-size:13.5px;color:var(--muted);text-decoration:none;border-bottom:1px solid var(--line-2);padding-bottom:2px">Read our full Quality Assurance &amp; Manufacturing Policy &rarr;</a>
</div>
</section>

<?php get_footer(); ?>
