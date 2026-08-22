<?php
if(!defined('ABSPATH'))exit;
function newtron_mfg_setup(){add_theme_support('title-tag');add_theme_support('post-thumbnails');add_theme_support('custom-logo');add_theme_support('html5',array('search-form','gallery','caption','style','script'));add_theme_support('align-wide');register_nav_menus(array('primary'=>'Primary Menu','footer'=>'Footer Menu'));}
add_action('after_setup_theme','newtron_mfg_setup');
function newtron_mfg_assets(){wp_enqueue_style('newtron-fonts','https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',array(),null);wp_enqueue_style('newtron-style',get_stylesheet_uri(),array(),'1.0');wp_enqueue_style('newtron-main',get_template_directory_uri().'/assets/css/main.css',array('newtron-fonts'),'4.6');wp_enqueue_script('newtron-main',get_template_directory_uri().'/assets/js/main.js',array(),'2.6',true);wp_localize_script('newtron-main','NEWTRON_STATES',newtron_states());wp_localize_script('newtron-main','NEWTRON_REST',array('nonce'=>wp_create_nonce('wp_rest')));
	if(is_page_template(array('template-request-quote.php','template-upload-cad.php'))&&defined('NEWTRON_RECAPTCHA_SITE_KEY')){
		wp_enqueue_script('newtron-recaptcha','https://www.google.com/recaptcha/api.js?render='.NEWTRON_RECAPTCHA_SITE_KEY,array(),null,true);
		wp_localize_script('newtron-main','NEWTRON_RECAPTCHA',array('siteKey'=>NEWTRON_RECAPTCHA_SITE_KEY));
	}
}
add_action('wp_enqueue_scripts','newtron_mfg_assets');

// reCAPTCHA v3 site key — public by design (shipped to every visitor's browser), safe to keep here.
// The secret key must be defined in wp-config.php instead — never in a version-controlled theme file.
if(!defined('NEWTRON_RECAPTCHA_SITE_KEY'))define('NEWTRON_RECAPTCHA_SITE_KEY','6Ld7Co4tAAAAAPcxRyNqJQTakDDf-hE4exqgxbb1');

require get_template_directory().'/inc/rfq-post-type.php';
require get_template_directory().'/inc/rfq-settings.php';
require get_template_directory().'/inc/rfq-handler.php';
require get_template_directory().'/inc/login-customizer.php';
require get_template_directory().'/inc/contact-spam-protection.php';
// Prevent CF7 from auto-wrapping form-tag lines in <p>/<br> via wpautop, which was causing extra vertical gaps in the grid layout.
add_filter('wpcf7_autop_or_not','__return_false');
function newtron_default_menu(){
	$items=array('services'=>'Services','materials'=>'Materials','industries'=>'Industries','how-it-works'=>'How It Works','quality'=>'Quality','about'=>'About Us','contact'=>'Contact Us');
	$html='<ul>';
	foreach($items as $slug=>$label){
		$class=is_page($slug)?' class="current-menu-item"':'';
		$html.='<li'.$class.'><a href="'.esc_url(home_url('/'.$slug.'/')).'">'.esc_html($label).'</a></li>';
	}
	$html.='</ul>';
	echo $html;
}

function newtron_decode_names($value){
	if(is_array($value))return array_map('newtron_decode_names',$value);
	return html_entity_decode($value,ENT_QUOTES,'UTF-8');
}
function newtron_countries(){
	static $countries=null;
	if($countries===null){
		$all=newtron_decode_names(include get_template_directory().'/inc/data/countries.php');
		$countries=array('US'=>$all['US'],'CA'=>$all['CA'])+$all;
	}
	return $countries;
}
function newtron_states(){
	static $states=null;
	if($states===null){
		$states=newtron_decode_names(include get_template_directory().'/inc/data/states.php');
	}
	return $states;
}
function newtron_country_options(){
	$html='';
	foreach(newtron_countries() as $code=>$name){$html.='<option value="'.esc_attr($code).'">'.esc_html($name).'</option>';}
	return $html;
}

function newtron_customize_register($wp_customize){
	$wp_customize->add_setting('newtron_footer_logo',array('default'=>'','sanitize_callback'=>'esc_url_raw','transport'=>'refresh'));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'newtron_footer_logo',array('label'=>'Footer Logo','description'=>'Shown in the site footer. Leave blank to reuse the header logo.','section'=>'title_tagline','priority'=>9)));

	$wp_customize->add_section('newtron_login_section',array('title'=>'Login Page','priority'=>110));

	$wp_customize->add_setting('newtron_login_bg_image',array('default'=>get_template_directory_uri().'/assets/images/industrial.jpg','sanitize_callback'=>'esc_url_raw','transport'=>'refresh'));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'newtron_login_bg_image',array('label'=>'Background Image','description'=>'Image shown on the left side of the login page.','section'=>'newtron_login_section')));

	$wp_customize->add_setting('newtron_login_eyebrow',array('default'=>'Newtron MFG Portal','sanitize_callback'=>'sanitize_text_field','transport'=>'refresh'));
	$wp_customize->add_control('newtron_login_eyebrow',array('label'=>'Eyebrow Text','type'=>'text','section'=>'newtron_login_section'));

	$wp_customize->add_setting('newtron_login_heading',array('default'=>'Precision manufacturing, managed in one place.','sanitize_callback'=>'sanitize_text_field','transport'=>'refresh'));
	$wp_customize->add_control('newtron_login_heading',array('label'=>'Heading','type'=>'text','section'=>'newtron_login_section'));

	$wp_customize->add_setting('newtron_login_text',array('default'=>'Track quotes, review orders, and stay in sync with our quality team - sign in to pick up where you left off.','sanitize_callback'=>'sanitize_textarea_field','transport'=>'refresh'));
	$wp_customize->add_control('newtron_login_text',array('label'=>'Description','type'=>'textarea','section'=>'newtron_login_section'));

	$wp_customize->add_setting('newtron_login_points',array('default'=>"Real-time RFQ and order status\nDirect access to your account team\nSecure document and CAD file exchange",'sanitize_callback'=>'sanitize_textarea_field','transport'=>'refresh'));
	$wp_customize->add_control('newtron_login_points',array('label'=>'Bullet Points','description'=>'One per line.','type'=>'textarea','section'=>'newtron_login_section'));
}
add_action('customize_register','newtron_customize_register');

function newtron_footer_logo_html(){
	$footer_logo=get_theme_mod('newtron_footer_logo','');
	if($footer_logo){
		return '<a class="footer-logo" href="'.esc_url(home_url('/')).'"><img src="'.esc_url($footer_logo).'" alt="'.esc_attr(get_bloginfo('name')).'"></a>';
	}
	if(has_custom_logo()){
		ob_start();
		the_custom_logo();
		return ob_get_clean();
	}
	return '<a class="text-logo" href="'.esc_url(home_url('/')).'"><span class="logo-mark"></span><span>NEWTRON<small>MFG</small></span></a>';
}
