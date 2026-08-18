<?php
if(!defined('ABSPATH'))exit;

/**
 * Restyles the native wp-login.php into a split layout (image+copy on the
 * left, the untouched core login form on the right) without replacing any
 * of WordPress's own form markup/handling.
 */

function newtron_login_enqueue(){
	wp_enqueue_style('newtron-fonts','https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',array(),null);
	wp_enqueue_style('newtron-login',get_template_directory_uri().'/assets/css/login.css',array('newtron-fonts'),'1.3');
	$logo=get_template_directory_uri().'/assets/images/logo.png';
	echo '<style>#login h1 a,.login h1 a{background-image:url('.esc_url($logo).');width:220px;height:56px;background-size:contain;background-position:center;background-repeat:no-repeat}</style>';
	echo '<script>if(!("ontouchstart" in window)&&!(navigator.maxTouchPoints>0)){document.documentElement.classList.add("has-hover");}</script>';
}
add_action('login_enqueue_scripts','newtron_login_enqueue');

add_filter('login_headerurl',function(){return home_url('/');});
add_filter('login_headertext',function(){return get_bloginfo('name');});

function newtron_login_buffer_start(){
	if(defined('DOING_AJAX')&&DOING_AJAX)return;
	ob_start();
}
add_action('login_init','newtron_login_buffer_start');

function newtron_login_buffer_render(){
	if(defined('DOING_AJAX')&&DOING_AJAX)return;
	$html=ob_get_clean();
	if($html===false)return;

	$img=get_theme_mod('newtron_login_bg_image',get_template_directory_uri().'/assets/images/industrial.jpg');
	$eyebrow=get_theme_mod('newtron_login_eyebrow','Newtron MFG Portal');
	$heading=get_theme_mod('newtron_login_heading','Precision manufacturing, managed in one place.');
	$text=get_theme_mod('newtron_login_text','Track quotes, review orders, and stay in sync with our quality team - sign in to pick up where you left off.');
	$points_raw=get_theme_mod('newtron_login_points',"Real-time RFQ and order status\nDirect access to your account team\nSecure document and CAD file exchange");
	$points='';
	foreach(preg_split('/\r\n|\r|\n/',(string)$points_raw) as $point){
		$point=trim($point);
		if($point!=='')$points.='<li>'.esc_html($point).'</li>';
	}

	$left='<div class="nt-login-visual"><img src="'.esc_url($img).'" alt=""><div class="nt-login-visual-overlay"></div><div class="nt-login-visual-copy">'
		.'<span class="eyebrow">'.esc_html($eyebrow).'</span>'
		.'<h2>'.esc_html($heading).'</h2>'
		.'<p>'.esc_html($text).'</p>'
		.($points?'<ul class="nt-login-points">'.$points.'</ul>':'')
		.'</div></div>'
		.'<div class="nt-login-panel">';

	$html=preg_replace('/(<body[^>]*>)/i','$1<div class="nt-login-wrap">'.$left,$html,1);
	$html.='</div></div>';

	echo $html;
}
add_action('login_footer','newtron_login_buffer_render',0);
