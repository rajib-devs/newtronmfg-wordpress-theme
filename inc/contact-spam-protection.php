<?php
if(!defined('ABSPATH'))exit;

// Layer 1: Honeypot — bots tend to fill every field, real users never see this one (.hp-field is visually hidden via CSS).
add_filter('wpcf7_validate',function($result,$tags){
	if(!empty($_POST['honeypot-field'])){
		$result->invalidate(new WPCF7_FormTag(array('name'=>'your-name','type'=>'text')),'Submission rejected.');
	}
	return $result;
},10,2);

// Layer 2: Timestamp — the JS below overwrites default:0 with the real load time; bots that don't run JS submit with 0.
add_filter('wpcf7_validate',function($result,$tags){
	$loaded=isset($_POST['form-timestamp'])?intval($_POST['form-timestamp']):0;
	if($loaded===0){
		$result->invalidate(new WPCF7_FormTag(array('name'=>'your-name','type'=>'text')),'Please try again.');
	}
	return $result;
},10,2);

// Layer 3: Block HTML tags and raw URLs in the name/company fields, a common spam pattern.
add_filter('wpcf7_validate',function($result,$tags){
	$fields=array('your-name','your-company');
	foreach($fields as $field){
		if(!isset($_POST[$field]))continue;
		$value=$_POST[$field];
		if($value!==strip_tags($value)||preg_match('/(https?:\/\/|www\.)/i',$value)){
			$result->invalidate(new WPCF7_FormTag(array('name'=>$field,'type'=>'text')),'Invalid content detected.');
			break;
		}
	}
	return $result;
},10,2);

// Layer 2 JS: set the real timestamp once the page has loaded.
add_action('wp_footer',function(){
	if(!is_page_template('template-contact.php'))return;
	echo '<script>document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll("input[name=\'form-timestamp\']").forEach(function(el){el.value=Math.floor(Date.now()/1000);});});</script>';
});
