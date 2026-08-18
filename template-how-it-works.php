<?php /* Template Name: How It Works */ get_header(); $img = get_template_directory_uri().'/assets/images/';
$check = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5L20 7"></path></svg>';
function nt_wave($fill){ return '<svg aria-hidden="true" viewBox="0 0 1440 48" preserveAspectRatio="none" class="feat-wave"><path d="M0,24 C220,4 340,44 620,26 C900,8 1040,44 1440,20 L1440,0 L0,0 Z" fill="'.$fill.'"></path></svg>'; }
?>

<section class="nt-hero">
<div class="nt-hero-media"><img src="<?php echo esc_url($img.'industrial.jpg'); ?>" alt=""></div>
<div class="nt-hero-inner">
<div class="nt-hero-copy">
<span class="eyebrow">How It Works</span>
<h1>Newtron Manufacturing Platform</h1>
<p>Manufacturing projects move more efficiently when pricing, production updates, documentation, and quality information are organized in one central system.</p>
</div>
</div>
</section>

<section class="section" style="padding-bottom:0">
<div class="container" style="max-width:760px;text-align:center">
<p style="font-size:18px;line-height:1.65;color:var(--muted);margin:0">Whether you are ordering a prototype, a low-volume production run, or ongoing manufactured parts, our platform helps keep every stage visible, documented, and accountable.</p>
</div>
</section>

<section class="feat-section"><?php echo nt_wave('#ffffff'); ?>
<div class="feat-row">
<span class="feat-num" aria-hidden="true">01</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div><h2>Fast and Organized Quoting</h2></div>
<p>Submit your drawings, CAD files, material requirements, quantities, tolerances, finishes, and delivery expectations directly through the platform. Our team reviews your project and prepares a detailed quote based on your manufacturing requirements.</p>
<div class="feat-callout"><p>Customers can review project details, ask questions, approve pricing, and move the job into production from one organized location.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">The Quoting Process Includes</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>Part pricing</span></div>
<div class="fl-item"><?php echo $check; ?><span>Tooling charges</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material costs</span></div>
<div class="fl-item"><?php echo $check; ?><span>Production lead times</span></div>
<div class="fl-item"><?php echo $check; ?><span>Finishing options</span></div>
<div class="fl-item"><?php echo $check; ?><span>Inspection requirements</span></div>
<div class="fl-item"><?php echo $check; ?><span>Packaging requirements</span></div>
<div class="fl-item"><?php echo $check; ?><span>Shipping estimates</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="feat-section alt"><?php echo nt_wave('#f6f8fa'); ?>
<div class="feat-row reverse">
<span class="feat-num" aria-hidden="true">02</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg></div><h2>Centralized Project Tracking</h2></div>
<p>Once a project is approved, the Newtron Manufacturing Platform provides a central location for tracking its progress.</p>
<div class="feat-callout"><p>This gives customers greater visibility while helping reduce missed messages, lost files, and uncertainty about where a project stands.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">Project Information Includes</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>Quote status</span></div>
<div class="fl-item"><?php echo $check; ?><span>Purchase order information</span></div>
<div class="fl-item"><?php echo $check; ?><span>Engineering review</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material procurement</span></div>
<div class="fl-item"><?php echo $check; ?><span>Tooling progress</span></div>
<div class="fl-item"><?php echo $check; ?><span>Production status</span></div>
<div class="fl-item"><?php echo $check; ?><span>Inspection status</span></div>
<div class="fl-item"><?php echo $check; ?><span>Packaging</span></div>
<div class="fl-item full"><?php echo $check; ?><span>Delivery confirmation</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="feat-section"><?php echo nt_wave('#ffffff'); ?>
<div class="feat-row">
<span class="feat-num" aria-hidden="true">03</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path><path d="M10 9H8"></path></svg></div><h2>Secure File and Document Management</h2></div>
<p>Manufacturing projects often involve multiple drawings, revisions, specifications, inspection reports, and approvals. The platform keeps important project documents connected to the correct job, including:</p>
<div class="feat-callout"><p>This organized approach helps ensure the production team is working from the correct and approved information.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">Documents Connected to the Job</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>2D drawings</span></div>
<div class="fl-item"><?php echo $check; ?><span>3D CAD files</span></div>
<div class="fl-item"><?php echo $check; ?><span>Revision-controlled documents</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material specifications</span></div>
<div class="fl-item"><?php echo $check; ?><span>Purchase orders</span></div>
<div class="fl-item"><?php echo $check; ?><span>Inspection reports</span></div>
<div class="fl-item"><?php echo $check; ?><span>Certificates of compliance</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material certifications</span></div>
<div class="fl-item"><?php echo $check; ?><span>Packing lists</span></div>
<div class="fl-item full"><?php echo $check; ?><span>Shipping documents</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="feat-section alt"><?php echo nt_wave('#f6f8fa'); ?>
<div class="feat-row reverse">
<span class="feat-num" aria-hidden="true">04</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg></div><h2>Quality Control Throughout Production</h2></div>
<p>Quality control is built into the manufacturing process, not added at the end.</p>
<div class="feat-callout"><p>Customers can review available quality records and maintain a documented history of each production run.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">Quality Documentation May Include</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>First Article Inspection Reports</span></div>
<div class="fl-item"><?php echo $check; ?><span>Dimensional inspection reports</span></div>
<div class="fl-item"><?php echo $check; ?><span>In-process inspection results</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material certifications</span></div>
<div class="fl-item"><?php echo $check; ?><span>Surface finish verification</span></div>
<div class="fl-item"><?php echo $check; ?><span>Functional testing</span></div>
<div class="fl-item"><?php echo $check; ?><span>Assembly verification</span></div>
<div class="fl-item"><?php echo $check; ?><span>Nonconformance documentation</span></div>
<div class="fl-item"><?php echo $check; ?><span>Corrective action records</span></div>
<div class="fl-item full"><?php echo $check; ?><span>Final inspection approval</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="feat-section"><?php echo nt_wave('#ffffff'); ?>
<div class="feat-row">
<span class="feat-num" aria-hidden="true">05</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg></div><h2>Revision and Approval Control</h2></div>
<p>Changes during manufacturing can create costly delays when they are not properly managed. The Newtron Manufacturing Platform helps organize approvals and revisions so that customers, engineers, project managers, and production partners remain aligned.</p>
<div class="feat-callout"><p>No revised manufacturing file should be released for production without the proper review and approval.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">The Platform Documents</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>Drawing revisions</span></div>
<div class="fl-item"><?php echo $check; ?><span>Engineering changes</span></div>
<div class="fl-item"><?php echo $check; ?><span>Material substitutions</span></div>
<div class="fl-item"><?php echo $check; ?><span>Tolerance approvals</span></div>
<div class="fl-item"><?php echo $check; ?><span>Finish approvals</span></div>
<div class="fl-item"><?php echo $check; ?><span>Sample approvals</span></div>
<div class="fl-item full"><?php echo $check; ?><span>Production release authorization</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="feat-section alt"><?php echo nt_wave('#f6f8fa'); ?>
<div class="feat-row reverse">
<span class="feat-num" aria-hidden="true">06</span>
<div class="feat-copy" data-reveal>
<div class="feat-head"><div class="feat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></div><h2>Better Communication</h2></div>
<p>Project communication is connected directly to the job, helping customers and the Newtron team keep questions, decisions, and updates organized. Instead of searching through multiple email chains, customers can maintain a clearer record of:</p>
<div class="feat-callout"><p>This creates better accountability and helps prevent important details from being overlooked.</p></div>
</div>
<div class="tex-card feat-list-card" data-reveal><div class="tex-overlay"></div>
<div style="position:relative">
<span class="feat-list-label">A Clearer Record Of</span>
<div class="feat-list-grid">
<div class="fl-item"><?php echo $check; ?><span>Engineering questions</span></div>
<div class="fl-item"><?php echo $check; ?><span>Quote discussions</span></div>
<div class="fl-item"><?php echo $check; ?><span>Production updates</span></div>
<div class="fl-item"><?php echo $check; ?><span>Approval requests</span></div>
<div class="fl-item"><?php echo $check; ?><span>Quality concerns</span></div>
<div class="fl-item"><?php echo $check; ?><span>Delivery information</span></div>
</div>
</div>
</div>
</div>
</section>

<section class="section" style="border-top:1px solid var(--line)">
<div class="container">
<div style="max-width:680px;margin:0 0 36px">
<span class="eyebrow">Every Stage of Production</span>
<h2>From Prototype to Production</h2>
<p class="entry-content" style="margin:14px 0 0">The platform supports projects across the full manufacturing cycle:</p>
</div>
<div class="grid-4">

<div class="tex-card mat-card"><div class="tex-overlay"></div>
<div style="position:relative"><div class="tc-title" style="font-size:13px">PROTOTYPE DEVELOPMENT</div><p class="mat-apps" style="font-size:14.5px;color:var(--ink)">Submit new designs, review manufacturing feedback, approve pricing, and track prototype production.</p></div>
</div>

<div class="tex-card mat-card"><div class="tex-overlay"></div>
<div style="position:relative"><div class="tc-title" style="font-size:13px">PILOT PRODUCTION</div><p class="mat-apps" style="font-size:14.5px;color:var(--ink)">Manage small production runs used for testing, validation, market introduction, or process development.</p></div>
</div>

<div class="tex-card mat-card"><div class="tex-overlay"></div>
<div style="position:relative"><div class="tc-title" style="font-size:13px">PRODUCTION MANUFACTURING</div><p class="mat-apps" style="font-size:14.5px;color:var(--ink)">Track repeat orders, revisions, quality records, production status, and delivery schedules.</p></div>
</div>

<div class="tex-card mat-card"><div class="tex-overlay"></div>
<div style="position:relative"><div class="tc-title" style="font-size:13px">ONGOING SUPPLY</div><p class="mat-apps" style="font-size:14.5px;color:var(--ink)">Maintain part history, previous quotes, approved files, and repeat-order information for continued production.</p></div>
</div>

</div>
</div>
</section>

<section class="section-light">
<div class="container" style="display:grid;grid-template-columns:1fr 1fr;gap:clamp(32px,5vw,64px);align-items:center;padding:clamp(56px,7vw,88px) 0">
<div>
<span class="eyebrow">Global Reach, U.S. Accountability</span>
<h2>Designed for U.S.-Managed and Global Manufacturing</h2>
<p class="entry-content">Newtron MFG combines domestic engineering and project management with qualified manufacturing resources in the United States and abroad.</p>
<p class="entry-content">The platform helps provide the structure needed to manage global production while maintaining U.S.-based communication, documentation, quality oversight, and accountability.</p>
<p class="entry-content">Customers gain access to competitive manufacturing options without losing visibility or control over their projects.</p>
</div>
<figure style="margin:0"><img src="<?php echo esc_url($img.'offshore-shipping.jpg'); ?>" alt="Offshore manufacturing and shipping" style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:12px"></figure>
</div>
</section>

<section class="mini-cta">
<div class="container">
<h2>One Platform. Complete Manufacturing Visibility.</h2>
<p>From the first uploaded drawing to the final inspection report, customers have a clearer view of their manufacturing projects and a dependable team managing the process.</p>
<p class="tagline">Submit. Quote. Approve. Track. Inspect. Deliver.</p>
<div class="hero-actions">
<a class="btn btn-primary" href="<?php echo esc_url(home_url('/request-a-quote/')); ?>">Request a Quote</a>
<a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">Speak with a Specialist</a>
</div>
</div>
</section>

<?php get_footer(); ?>
