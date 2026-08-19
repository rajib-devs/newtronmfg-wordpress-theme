NEWTRON MFG WORDPRESS THEME

Install: Appearance > Themes > Add New > Upload Theme.
Activate the theme, assign a Primary Menu, upload the official logo, and set a static homepage.

Included templates: Homepage, standard page, blog, single post, Upload CAD, Request a Quote, Services, Industries, Materials, About, How It Works, Contact, Quality, Quality Policy, Privacy Policy, Supplier Terms.

For each new page (Services, Industries, Materials, About, How It Works, Contact, Quality, Quality Policy, Privacy Policy, Supplier Terms): create a Page in WordPress with the matching slug (e.g. /services/, /quality-policy/) and select the matching template under Page Attributes. Slugs must match what header.php's fallback menu and footer.php link to, or update those links to match.

The Request a Quote / Upload CAD form (template-parts/quote-form.php) posts to a custom REST route (newtron/v1/rfq-submit) handled by inc/rfq-handler.php. Submissions are saved as an "rfq_request" post type with uploaded CAD files stored in a protected, non-web-indexable uploads subfolder (rfq-files/) with per-file access tokens. The Contact page form uses the Contact Form 7 plugin (shortcode id set in template-contact.php).

------------------------------------------------------------
REQUIRED SERVER CONFIGURATION (wp-config.php)
------------------------------------------------------------

The Request a Quote form uses Google reCAPTCHA v3 (invisible, no user-facing challenge) to block spam/bot submissions. The site key is public and lives in functions.php. The SECRET key must never be committed to this repo — define it only in wp-config.php on each environment (staging and production), above the "/* That's all, stop editing! */" line:

    define('NEWTRON_RECAPTCHA_SECRET_KEY', '<secret key from google.com/recaptcha/admin>');

If this constant is not defined, the quote form's server-side reCAPTCHA check is skipped automatically (form still works, just without bot protection) — it will not error or break submissions. Set it on every environment that should be protected.

The Contact Form 7 reCAPTCHA integration is configured separately in wp-admin under Contact > Integration, and is not stored in theme files or this repo.

------------------------------------------------------------
CHANGELOG / SETUP NOTES
------------------------------------------------------------

2026-08-19: Added invisible reCAPTCHA v3 to the Request a Quote / Upload CAD form (functions.php, template-parts/quote-form.php, assets/js/main.js, inc/rfq-handler.php). Requires NEWTRON_RECAPTCHA_SECRET_KEY in wp-config.php per the section above. Contact form reCAPTCHA was configured directly in Contact Form 7's admin settings (no code change).
