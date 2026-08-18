<?php /* Template Name: Contact */ get_header(); $img = get_template_directory_uri().'/assets/images/'; ?>

<section class="nt-hero">
<div class="nt-hero-media"><img src="<?php echo esc_url($img.'3d-printing.jpg'); ?>" alt=""></div>
<div class="nt-hero-inner">
<div class="nt-hero-copy">
<span class="eyebrow">Contact</span>
<h1>Get In Touch</h1>
<p>We're here to help with your next project.</p>
</div>
</div>
</section>

<section class="section">
<div class="container contact-grid">

<div class="contact-info">

<div class="contact-item">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384z"></path></svg>
<div><div class="ci-label">Phone</div>
<div class="ci-rows">
<div><div class="ci-sub">Boston, MA</div><div class="ci-val"><a href="tel:+16179691100">(617) 969-1100</a></div></div>
<div><div class="ci-sub">Orlando, FL</div><div class="ci-val"><a href="tel:+13217324559">(321) 732-4559</a></div></div>
</div>
</div>
</div>

<div class="contact-item">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
<div><div class="ci-label">Email</div><div class="ci-val"><a href="mailto:info@newtronmfg.com">info@newtronmfg.com</a></div></div>
</div>

<div class="contact-item">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
<div><div class="ci-label">Address</div>
<div class="ci-rows">
<div><div class="ci-sub">Admin</div><div class="ci-val">4767 New Broad St, Orlando, FL 32807</div></div>
<div><div class="ci-sub">Warehouse</div><div class="ci-val">1714 N Goldenrod Rd, Unit D6, Orlando, FL 32807</div></div>
</div>
</div>
</div>

<div class="contact-item">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
<div><div class="ci-label">Hours</div><div class="ci-val">Mon &ndash; Fri, 8:00 AM &ndash; 5:00 PM EST</div></div>
</div>

</div>

<div class="card form-grid contact-form">
<?php echo do_shortcode('[contact-form-7 id="9e7b09c" title="Contact form"]'); ?>
</div>

</div>
</section>

<?php get_footer(); ?>
