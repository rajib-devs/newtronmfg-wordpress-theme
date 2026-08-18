<?php
if(!defined('ABSPATH'))exit;

if(!defined('NEWTRON_RFQ_MAX_FILE_SIZE'))define('NEWTRON_RFQ_MAX_FILE_SIZE',50*1024*1024);

function newtron_rfq_allowed_mimes(){
	return array(
		'step'=>'model/step',
		'stp'=>'model/step',
		'stl'=>'model/stl',
		'iges'=>'model/iges',
		'igs'=>'model/iges',
		'dxf'=>'image/vnd.dxf',
		'dwg'=>'image/vnd.dwg',
		'pdf'=>'application/pdf',
		'zip'=>'application/zip',
		'jpg'=>'image/jpeg',
		'jpeg'=>'image/jpeg',
		'png'=>'image/png',
		'gif'=>'image/gif',
		'webp'=>'image/webp',
	);
}

function newtron_rfq_ensure_protected_dir(){
	$upload_dir=wp_upload_dir();
	$base=trailingslashit($upload_dir['basedir']).'rfq-files';
	if(!file_exists($base))wp_mkdir_p($base);

	$htaccess=$base.'/.htaccess';
	if(!file_exists($htaccess)){
		file_put_contents($htaccess,"<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\nOptions -Indexes\n");
	}
	$index=$base.'/index.php';
	if(!file_exists($index)){
		file_put_contents($index,"<?php\n// Silence is golden.\n");
	}
	return $base;
}

function newtron_rfq_check_filetype_and_ext($data,$file,$filename,$mimes,$real_mime=null){
	if(!empty($data['ext'])&&!empty($data['type']))return $data;
	$filetype=wp_check_filetype($filename,newtron_rfq_allowed_mimes());
	if($filetype['ext']&&$filetype['type']){
		$data['ext']=$filetype['ext'];
		$data['type']=$filetype['type'];
	}
	return $data;
}

function newtron_rfq_handle_uploads($post_id,$field='cad_files',$debug_meta='_rfq_upload_debug'){
	if(empty($_FILES[$field])||empty($_FILES[$field]['name'][0]))return array();

	require_once ABSPATH.'wp-admin/includes/file.php';
	require_once ABSPATH.'wp-admin/includes/image.php';
	require_once ABSPATH.'wp-admin/includes/media.php';
	newtron_rfq_ensure_protected_dir();

	$subdir='rfq-files/'.$post_id;
	$filter=function($dirs)use($subdir){
		$dirs['subdir']='/'.$subdir;
		$dirs['path']=$dirs['basedir'].'/'.$subdir;
		$dirs['url']=$dirs['baseurl'].'/'.$subdir;
		return $dirs;
	};
	add_filter('upload_dir',$filter);
	add_filter('wp_check_filetype_and_ext','newtron_rfq_check_filetype_and_ext',10,5);

	$allowed_exts=array_keys(newtron_rfq_allowed_mimes());
	$files=$_FILES[$field];
	$count=count($files['name']);
	$saved=array();
	$debug=array();

	$allowed_label=strtoupper(implode(', ',$allowed_exts));

	for($i=0;$i<$count;$i++){
		$name=sanitize_file_name($files['name'][$i]);
		if($files['error'][$i]!==UPLOAD_ERR_OK){
			$debug[]=$name.': could not be uploaded. Please try again.';
			continue;
		}
		$ext=strtolower(pathinfo($name,PATHINFO_EXTENSION));
		if(!in_array($ext,$allowed_exts,true)){
			$debug[]=$name.': this file type is not accepted. Allowed types: '.$allowed_label.'.';
			continue;
		}
		if($files['size'][$i]>NEWTRON_RFQ_MAX_FILE_SIZE){
			$debug[]=$name.': file is too large ('.size_format($files['size'][$i]).'). Maximum allowed is '.size_format(NEWTRON_RFQ_MAX_FILE_SIZE).'.';
			continue;
		}

		$file=array(
			'name'=>$name,
			'type'=>$files['type'][$i],
			'tmp_name'=>$files['tmp_name'][$i],
			'error'=>$files['error'][$i],
			'size'=>$files['size'][$i],
		);
		$overrides=array('test_form'=>false,'mimes'=>newtron_rfq_allowed_mimes());
		$result=wp_handle_upload($file,$overrides);
		if(!empty($result['file'])){
			$saved[]=array(
				'name'=>$name,
				'path'=>$subdir.'/'.basename($result['file']),
				'size'=>filesize($result['file']),
				'token'=>wp_generate_password(32,false),
			);
		}else{
			$debug[]=$name.': could not be uploaded ('.(isset($result['error'])?$result['error']:'unknown error').').';
		}
	}

	remove_filter('upload_dir',$filter);
	remove_filter('wp_check_filetype_and_ext','newtron_rfq_check_filetype_and_ext');
	if($debug){
		update_post_meta($post_id,$debug_meta,$debug);
	}else{
		delete_post_meta($post_id,$debug_meta);
	}
	return $saved;
}

function newtron_rfq_send_notification_email($post_id,$values,$files){
	$to=newtron_rfq_notification_email();
	if(!$to)return;

	$who=$values['company_name']?:trim($values['contact_first_name'].' '.$values['contact_last_name']);
	$subject=sprintf('[RFQ] New request from %s',$who);

	$lines=array();
	$lines[]='A new RFQ was submitted on '.get_bloginfo('name').'.';
	$lines[]='';

	foreach(newtron_rfq_field_defs() as $group){
		$lines[]=$group['title'].':';
		foreach($group['fields'] as $key=>$def){
			if($values[$key]==='')continue;
			$lines[]='- '.$def['label'].': '.$values[$key];
		}
		$lines[]='';
	}

	if($files){
		$lines[]='Files:';
		foreach($files as $i=>$file){
			$url=add_query_arg(array('action'=>'newtron_rfq_download','rfq_id'=>$post_id,'file'=>$i,'token'=>$file['token']),admin_url('admin-post.php'));
			$lines[]='- '.$file['name'].' ('.size_format($file['size']).'): '.$url;
		}
		$lines[]='';
	}

	$lines[]='View in dashboard: '.admin_url('admin.php?page=newtron-rfq-view&rfq_id='.$post_id);
	wp_mail($to,$subject,implode("\n",$lines));
}

function newtron_rfq_send_confirmation_email($post_id,$values){
	if(empty($values['contact_email'])||!is_email($values['contact_email']))return;

	$name=trim($values['contact_first_name'].' '.$values['contact_last_name'])?:'there';
	$subject='We received your quote request - '.get_bloginfo('name');
	$project=$values['project_name']?' for "'.$values['project_name'].'"':'';
	$body="Hi {$name},\n\nThanks for your quote request{$project}. Our team has received it and will follow up shortly.\n\nIf you have any questions in the meantime, just reply to this email.\n\n".get_bloginfo('name');
	wp_mail($values['contact_email'],$subject,$body);
}

function newtron_rfq_process_submit(){
	if(empty($_POST['newtron_rfq_nonce'])||!wp_verify_nonce($_POST['newtron_rfq_nonce'],'newtron_rfq_submit')){
		return array('success'=>false,'data'=>array('message'=>'Security check failed. Please refresh the page and try again.'));
	}

	// Honeypot: bots tend to fill every field. Respond as if successful without processing.
	if(!empty($_POST['rfq_website'])){
		return array('success'=>true,'data'=>array('message'=>'Thanks - your request has been submitted. Our team will follow up shortly.'));
	}

	$values=array();
	$errors=array();

	foreach(newtron_rfq_field_defs() as $group){
		foreach($group['fields'] as $key=>$def){
			$raw=isset($_POST[$key])?wp_unslash($_POST[$key]):'';
			if($def['sanitize']==='email'){
				$clean=sanitize_email($raw);
			}elseif($def['sanitize']==='textarea'){
				$clean=sanitize_textarea_field($raw);
			}else{
				$clean=sanitize_text_field($raw);
			}

			if($def['required']&&$clean===''){
				$errors[]=$def['label'].' is required.';
			}elseif($def['sanitize']==='email'&&$clean!==''&&!is_email($clean)){
				$errors[]='Please enter a valid email address.';
			}
			$values[$key]=$clean;
		}
	}

	if($errors){
		return array('success'=>false,'data'=>array('message'=>implode(' ',array_unique($errors))));
	}

	$title=$values['company_name']?:trim($values['contact_first_name'].' '.$values['contact_last_name']);
	$title.=' - '.$values['project_name'];

	$post_id=wp_insert_post(array(
		'post_type'=>'rfq_request',
		'post_status'=>'publish',
		'post_title'=>$title,
	),true);

	if(is_wp_error($post_id)){
		return array('success'=>false,'data'=>array('message'=>'Something went wrong saving your request. Please try again.'));
	}

	foreach($values as $key=>$val){
		update_post_meta($post_id,'_rfq_'.$key,$val);
	}
	wp_set_object_terms($post_id,'New','rfq_status');

	$files=newtron_rfq_handle_uploads($post_id);
	if($files){
		update_post_meta($post_id,'_rfq_files',$files);
	}
	$file_warnings=get_post_meta($post_id,'_rfq_upload_debug',true);

	newtron_rfq_send_notification_email($post_id,$values,$files);
	newtron_rfq_send_confirmation_email($post_id,$values);

	$response=array('message'=>'Thanks - your request has been submitted. Our team will follow up shortly.');
	if(is_array($file_warnings)&&$file_warnings){
		$response['file_warnings']=$file_warnings;
	}
	return array('success'=>true,'data'=>$response);
}

function newtron_rfq_rest_submit($request){
	$result=newtron_rfq_process_submit();
	return new WP_REST_Response($result,200);
}

function newtron_rfq_register_rest_route(){
	register_rest_route('newtron/v1','/rfq-submit',array(
		'methods'=>'POST',
		'callback'=>'newtron_rfq_rest_submit',
		'permission_callback'=>'__return_true',
	));
}
add_action('rest_api_init','newtron_rfq_register_rest_route');

function newtron_rfq_handle_submit(){
	$result=newtron_rfq_process_submit();
	if($result['success']){
		wp_send_json_success($result['data']);
	}
	wp_send_json_error($result['data']);
}
add_action('admin_post_newtron_rfq_submit','newtron_rfq_handle_submit');
add_action('admin_post_nopriv_newtron_rfq_submit','newtron_rfq_handle_submit');

function newtron_rfq_handle_download(){
	if(!is_user_logged_in()||!current_user_can('edit_posts')){
		status_header(403);
		wp_die('You must be logged in to download this file.',403);
	}

	$post_id=isset($_GET['rfq_id'])?absint($_GET['rfq_id']):0;
	$index=isset($_GET['file'])?absint($_GET['file']):-1;

	if(!$post_id||$index<0||get_post_type($post_id)!=='rfq_request'){
		wp_die('Invalid request.',400);
	}
	if(!current_user_can('edit_post',$post_id)){
		status_header(403);
		wp_die('You are not allowed to access this file.',403);
	}

	$type=isset($_GET['type'])&&$_GET['type']==='quote'?'quote':'files';
	$meta_key=$type==='quote'?'_rfq_quote_files':'_rfq_files';

	$files=get_post_meta($post_id,$meta_key,true);
	if(!is_array($files)||!isset($files[$index])){
		wp_die('File not found.',404);
	}

	$file=$files[$index];
	$token=isset($_GET['token'])?sanitize_text_field(wp_unslash($_GET['token'])):'';
	if(empty($file['token'])||!hash_equals($file['token'],$token)){
		status_header(403);
		wp_die('This link is invalid.',403);
	}
	$upload_dir=wp_upload_dir();
	$path=trailingslashit($upload_dir['basedir']).ltrim($file['path'],'/');

	if(!file_exists($path)){
		wp_die('File not found.',404);
	}

	$ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
	$viewable=array('pdf'=>'application/pdf');

	nocache_headers();
	if(isset($viewable[$ext])){
		header('Content-Type: '.$viewable[$ext]);
		header('Content-Disposition: inline; filename="'.basename($file['name']).'"');
	}else{
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file['name']).'"');
	}
	header('Content-Length: '.filesize($path));
	readfile($path);
	exit;
}
add_action('admin_post_newtron_rfq_download','newtron_rfq_handle_download');

function newtron_rfq_download_nopriv(){
	status_header(403);
	wp_die('You must be logged in to download this file.',403);
}
add_action('admin_post_nopriv_newtron_rfq_download','newtron_rfq_download_nopriv');

function newtron_rfq_delete_file_url($post_id,$type,$index){
	$url=add_query_arg(array('action'=>'newtron_rfq_delete_file','type'=>$type,'rfq_id'=>$post_id,'file'=>$index),admin_url('admin-post.php'));
	return wp_nonce_url($url,'newtron_rfq_delete_file_'.$post_id.'_'.$type.'_'.$index);
}

function newtron_rfq_handle_delete_file(){
	if(!is_user_logged_in()||!current_user_can('edit_posts')){
		status_header(403);
		wp_die('You are not allowed to delete this file.',403);
	}

	$post_id=isset($_GET['rfq_id'])?absint($_GET['rfq_id']):0;
	$index=isset($_GET['file'])?absint($_GET['file']):-1;
	$type=isset($_GET['type'])&&$_GET['type']==='quote'?'quote':'files';

	if(!$post_id||$index<0||get_post_type($post_id)!=='rfq_request'){
		wp_die('Invalid request.',400);
	}
	if(!current_user_can('edit_post',$post_id)){
		status_header(403);
		wp_die('You are not allowed to delete this file.',403);
	}
	check_admin_referer('newtron_rfq_delete_file_'.$post_id.'_'.$type.'_'.$index);

	$meta_key=$type==='quote'?'_rfq_quote_files':'_rfq_files';
	$files=get_post_meta($post_id,$meta_key,true);
	if(!is_array($files)||!isset($files[$index])){
		wp_die('File not found.',404);
	}

	$file=$files[$index];
	$upload_dir=wp_upload_dir();
	$base=realpath(trailingslashit($upload_dir['basedir']).'rfq-files');
	$path=realpath(trailingslashit($upload_dir['basedir']).ltrim($file['path'],'/'));
	// Only ever unlink inside the protected RFQ directory, never follow a path outside it.
	if($base&&$path&&strpos($path,$base)===0&&is_file($path)){
		@unlink($path);
	}

	unset($files[$index]);
	$files=array_values($files);
	if($files){
		update_post_meta($post_id,$meta_key,$files);
	}else{
		delete_post_meta($post_id,$meta_key);
	}

	$redirect=add_query_arg('newtron_rfq_deleted',1,get_edit_post_link($post_id,'raw'));
	wp_safe_redirect($redirect);
	exit;
}
add_action('admin_post_newtron_rfq_delete_file','newtron_rfq_handle_delete_file');
