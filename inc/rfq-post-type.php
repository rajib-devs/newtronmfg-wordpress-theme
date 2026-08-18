<?php
if(!defined('ABSPATH'))exit;

function newtron_rfq_is_screen(){
	if(!is_admin()||!function_exists('get_current_screen'))return false;
	$screen=get_current_screen();
	return $screen&&$screen->post_type==='rfq_request'&&in_array($screen->base,array('post','post-new'),true);
}

function newtron_rfq_admin_head(){
	echo '<style>#adminmenu a[href*="page=newtron-rfq-view"]{display:none!important}</style>';
	if(!newtron_rfq_is_screen())return;
	echo '<style>#visibility,.misc-pub-curtime,.misc-pub-post-status,#minor-publishing-actions{display:none}</style>';
}
add_action('admin_head','newtron_rfq_admin_head');

function newtron_rfq_form_enctype($post){
	if(!$post||$post->post_type!=='rfq_request')return;
	echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag','newtron_rfq_form_enctype');

function newtron_rfq_is_list_screen(){
	if(!is_admin()||!function_exists('get_current_screen'))return false;
	$screen=get_current_screen();
	return $screen&&$screen->post_type==='rfq_request'&&$screen->base==='edit';
}

function newtron_rfq_admin_gettext($translated,$text,$domain){
	if($domain!=='default')return $translated;
	if($text==='Publish'&&newtron_rfq_is_screen())return 'Save Quote';
	if($text==='Published'&&newtron_rfq_is_list_screen())return 'Submitted';
	return $translated;
}
add_filter('gettext','newtron_rfq_admin_gettext',10,3);

function newtron_rfq_field_defs(){
	return array(
		'contact'=>array(
			'title'=>'Contact & Company Information',
			'fields'=>array(
				'contact_first_name'=>array('label'=>'First Name','required'=>true,'sanitize'=>'text'),
				'contact_last_name'=>array('label'=>'Last Name','required'=>true,'sanitize'=>'text'),
				'contact_designation'=>array('label'=>'Designation','required'=>false,'sanitize'=>'text'),
				'company_name'=>array('label'=>'Company Name','required'=>false,'sanitize'=>'text'),
				'company_country'=>array('label'=>'Country','required'=>true,'sanitize'=>'text'),
				'company_address'=>array('label'=>'Street Address','required'=>true,'sanitize'=>'text'),
				'company_city'=>array('label'=>'Town / City','required'=>true,'sanitize'=>'text'),
				'company_state'=>array('label'=>'State / Province','required'=>false,'sanitize'=>'text'),
				'company_zip'=>array('label'=>'Zip Code','required'=>true,'sanitize'=>'text'),
				'contact_phone'=>array('label'=>'Phone Number','required'=>true,'sanitize'=>'text'),
				'contact_email'=>array('label'=>'Email Address','required'=>true,'sanitize'=>'email'),
			),
		),
		'project'=>array(
			'title'=>'Project Details',
			'fields'=>array(
				'project_name'=>array('label'=>'Project Name','required'=>true,'sanitize'=>'text'),
				'process'=>array('label'=>'Process','required'=>false,'sanitize'=>'text'),
				'material'=>array('label'=>'Material','required'=>false,'sanitize'=>'text'),
				'finish'=>array('label'=>'Finish','required'=>false,'sanitize'=>'text'),
				'quantity'=>array('label'=>'Quantity','required'=>false,'sanitize'=>'text'),
				'start_date'=>array('label'=>'Start Date','required'=>false,'sanitize'=>'text'),
				'target_delivery_date'=>array('label'=>'Estimated Delivery Date','required'=>false,'sanitize'=>'text'),
				'mfg_origin_preference'=>array('label'=>'Expected MFG Origin','required'=>false,'sanitize'=>'text'),
				'exclude_origin'=>array('label'=>'Exclude Origin','required'=>false,'sanitize'=>'text'),
				'lead_time'=>array('label'=>'Lead Time','required'=>false,'sanitize'=>'text'),
				'project_notes'=>array('label'=>'Project Notes','required'=>false,'sanitize'=>'textarea'),
			),
		),
	);
}

function newtron_rfq_register_post_type(){
	register_post_type('rfq_request',array(
		'labels'=>array(
			'name'=>'RFQ Requests',
			'singular_name'=>'RFQ Request',
			'menu_name'=>'RFQ Requests',
			'all_items'=>'All RFQs',
			'add_new'=>'Add Quote',
			'add_new_item'=>'Add Quote',
			'edit_item'=>'Edit Quote',
			'new_item'=>'New Quote',
			'view_item'=>'View RFQ',
			'search_items'=>'Search RFQs',
			'not_found'=>'No RFQs found',
			'not_found_in_trash'=>'No RFQs found in Trash',
		),
		'public'=>false,
		'publicly_queryable'=>false,
		'exclude_from_search'=>true,
		'show_ui'=>true,
		'show_in_menu'=>true,
		'show_in_nav_menus'=>false,
		'menu_icon'=>'dashicons-clipboard',
		'capability_type'=>'post',
		'supports'=>array('title'),
		'has_archive'=>false,
		'rewrite'=>false,
		'show_in_rest'=>false,
	));
}
add_action('init','newtron_rfq_register_post_type');

function newtron_rfq_register_taxonomy(){
	register_taxonomy('rfq_status','rfq_request',array(
		'labels'=>array('name'=>'Quote Status','singular_name'=>'Quote Status'),
		'public'=>false,
		'show_ui'=>true,
		'show_admin_column'=>true,
		'show_in_quick_edit'=>true,
		'hierarchical'=>false,
		'query_var'=>false,
		'rewrite'=>false,
		'meta_box_cb'=>false,
	));
}
add_action('init','newtron_rfq_register_taxonomy');

function newtron_rfq_status_submitbox($post){
	if(!$post||$post->post_type!=='rfq_request')return;
	wp_nonce_field('newtron_rfq_status_save','newtron_rfq_status_nonce');
	$terms=get_terms(array('taxonomy'=>'rfq_status','hide_empty'=>false));
	$current=wp_get_object_terms($post->ID,'rfq_status',array('fields'=>'ids'));
	$current_id=!empty($current)?$current[0]:0;
	if(!$current_id){
		$default=get_term_by('name','New','rfq_status');
		if($default)$current_id=$default->term_id;
	}
	echo '<div class="misc-pub-section"><p class="description" style="margin:0 0 6px">Update the quote status using the dropdown below. To save this or any other changes made on the form, click Save Quote.</p><label for="rfq_status">Quote Status:</label> <select name="rfq_status" id="rfq_status">';
	foreach($terms as $term){
		echo '<option value="'.esc_attr($term->term_id).'"'.selected($current_id,$term->term_id,false).'>'.esc_html($term->name).'</option>';
	}
	echo '</select></div>';
}
add_action('post_submitbox_misc_actions','newtron_rfq_status_submitbox');

function newtron_rfq_save_status($post_id){
	if(empty($_POST['newtron_rfq_status_nonce'])||!wp_verify_nonce($_POST['newtron_rfq_status_nonce'],'newtron_rfq_status_save'))return;
	if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;
	if(!current_user_can('assign_terms',$post_id))return;
	if(!isset($_POST['rfq_status']))return;
	$term_id=absint($_POST['rfq_status']);
	if($term_id)wp_set_object_terms($post_id,array($term_id),'rfq_status',false);
}
add_action('save_post_rfq_request','newtron_rfq_save_status');

function newtron_rfq_seed_status_terms(){
	if(!taxonomy_exists('rfq_status'))return;
	foreach(array('New','Quoted','Won','Lost') as $term){
		if(!term_exists($term,'rfq_status'))wp_insert_term($term,'rfq_status');
	}
}
add_action('init','newtron_rfq_seed_status_terms',20);

function newtron_rfq_admin_columns($columns){
	unset($columns['date']);
	$columns['rfq_company']='Company';
	$columns['rfq_contact']='Contact';
	$columns['rfq_email']='Email';
	$columns['rfq_process']='Process';
	$columns['rfq_quantity']='Qty';
	$columns['rfq_lead_time']='Lead Time';
	$columns['rfq_files']='Files';
	$columns['rfq_quote']='Quote';
	$columns['date']='Date';
	return $columns;
}
add_filter('manage_rfq_request_posts_columns','newtron_rfq_admin_columns');

function newtron_rfq_row_actions($actions,$post){
	if($post->post_type!=='rfq_request'||!current_user_can('edit_post',$post->ID))return $actions;
	unset($actions['inline hide-if-no-js']);
	$url=admin_url('admin.php?page=newtron-rfq-view&rfq_id='.$post->ID);
	$view=array('view_rfq'=>'<a href="'.esc_url($url).'">View</a>');
	return $view+$actions;
}
add_filter('post_row_actions','newtron_rfq_row_actions',10,2);

function newtron_rfq_register_view_page(){
	add_submenu_page('edit.php?post_type=rfq_request','View RFQ','View RFQ','edit_posts','newtron-rfq-view','newtron_rfq_render_view_page');
}
add_action('admin_menu','newtron_rfq_register_view_page');

function newtron_rfq_render_view_page(){
	$post_id=isset($_GET['rfq_id'])?absint($_GET['rfq_id']):0;
	if(!$post_id||get_post_type($post_id)!=='rfq_request')wp_die('Invalid RFQ.');
	if(!current_user_can('edit_post',$post_id))wp_die('You are not allowed to view this RFQ.');
	$post=get_post($post_id);

	$terms=wp_get_object_terms($post_id,'rfq_status');
	$status=!empty($terms)&&!is_wp_error($terms)?$terms[0]->name:'-';

	echo '<div class="wrap">';
	echo '<h1>'.esc_html($post->post_title).'</h1>';
	echo '<p><a href="'.esc_url(admin_url('edit.php?post_type=rfq_request')).'">&larr; Back to RFQ Requests</a> &nbsp;|&nbsp; <a href="'.esc_url(get_edit_post_link($post_id)).'">Edit this RFQ</a></p>';
	echo '<table class="widefat" style="max-width:600px;margin-bottom:20px"><tbody>';
	echo '<tr><th style="width:220px;text-align:left">Quote Status</th><td>'.esc_html($status).'</td></tr>';
	echo '<tr><th style="text-align:left">Submitted</th><td>'.esc_html(get_the_date('',$post_id)).'</td></tr>';
	echo '</tbody></table>';

	foreach(newtron_rfq_field_defs() as $group){
		echo '<h2 style="margin-top:24px">'.esc_html($group['title']).'</h2><table class="widefat striped"><tbody>';
		foreach($group['fields'] as $key=>$def){
			$val=get_post_meta($post_id,'_rfq_'.$key,true);
			echo '<tr><th style="width:220px;text-align:left">'.esc_html($def['label']).'</th><td>'.($val!==''?nl2br(esc_html($val)):'-').'</td></tr>';
		}
		echo '</tbody></table>';
	}

	echo '<h2 style="margin-top:24px">Uploaded Files</h2>';
	$files=get_post_meta($post_id,'_rfq_files',true);
	if(is_array($files)&&$files){
		echo '<table class="widefat striped"><thead><tr><th>File Name</th><th>Size</th><th>Action</th></tr></thead><tbody>';
		foreach($files as $i=>$file){
			$url=add_query_arg(array('action'=>'newtron_rfq_download','rfq_id'=>$post_id,'file'=>$i,'token'=>isset($file['token'])?$file['token']:''),admin_url('admin-post.php'));
			echo '<tr><td>'.esc_html($file['name']).'</td><td>'.esc_html(size_format($file['size'])).'</td><td><a href="'.esc_url($url).'" class="button button-small" target="_blank" rel="noopener">View / Download</a></td></tr>';
		}
		echo '</tbody></table>';
	}else{
		echo '<p>No files uploaded.</p>';
	}

	$upload_debug=get_post_meta($post_id,'_rfq_upload_debug',true);
	if(is_array($upload_debug)&&$upload_debug){
		echo '<div style="background:#fff3cd;border:1px solid #ffe69c;padding:12px 16px;margin-top:12px;border-radius:6px"><strong>Upload issue detected:</strong><ul style="margin:8px 0 0 20px">';
		foreach($upload_debug as $line)echo '<li>'.esc_html($line).'</li>';
		echo '</ul></div>';
	}

	echo '<h2 style="margin-top:24px">Quote Document</h2>';
	$quote_files=get_post_meta($post_id,'_rfq_quote_files',true);
	if(is_array($quote_files)&&$quote_files){
		echo '<table class="widefat striped"><thead><tr><th>File Name</th><th>Size</th><th>Action</th></tr></thead><tbody>';
		foreach($quote_files as $i=>$file){
			$url=add_query_arg(array('action'=>'newtron_rfq_download','type'=>'quote','rfq_id'=>$post_id,'file'=>$i,'token'=>isset($file['token'])?$file['token']:''),admin_url('admin-post.php'));
			echo '<tr><td>'.esc_html($file['name']).'</td><td>'.esc_html(size_format($file['size'])).'</td><td><a href="'.esc_url($url).'" class="button button-small" target="_blank" rel="noopener">View / Download</a></td></tr>';
		}
		echo '</tbody></table>';
	}else{
		echo '<p>No quote document uploaded yet.</p>';
	}

	$quote_upload_debug=get_post_meta($post_id,'_rfq_quote_upload_debug',true);
	if(is_array($quote_upload_debug)&&$quote_upload_debug){
		echo '<div style="background:#fff3cd;border:1px solid #ffe69c;padding:12px 16px;margin-top:12px;border-radius:6px"><strong>Upload issue detected:</strong><ul style="margin:8px 0 0 20px">';
		foreach($quote_upload_debug as $line)echo '<li>'.esc_html($line).'</li>';
		echo '</ul></div>';
	}
	echo '</div>';
}

function newtron_rfq_admin_column_content($column,$post_id){
	switch($column){
		case 'rfq_company':
			echo esc_html(get_post_meta($post_id,'_rfq_company_name',true)?:'-');
			break;
		case 'rfq_contact':
			$name=trim(get_post_meta($post_id,'_rfq_contact_first_name',true).' '.get_post_meta($post_id,'_rfq_contact_last_name',true));
			echo esc_html($name?:'-');
			break;
		case 'rfq_email':
			$email=get_post_meta($post_id,'_rfq_contact_email',true);
			echo $email?'<a href="mailto:'.esc_attr($email).'">'.esc_html($email).'</a>':'-';
			break;
		case 'rfq_process':
			echo esc_html(get_post_meta($post_id,'_rfq_process',true)?:'-');
			break;
		case 'rfq_quantity':
			echo esc_html(get_post_meta($post_id,'_rfq_quantity',true)?:'-');
			break;
		case 'rfq_lead_time':
			$lt=get_post_meta($post_id,'_rfq_lead_time',true);
			echo esc_html($lt?ucfirst($lt):'-');
			break;
		case 'rfq_files':
			$files=get_post_meta($post_id,'_rfq_files',true);
			echo is_array($files)?count($files):'0';
			break;
		case 'rfq_quote':
			$quote_files=get_post_meta($post_id,'_rfq_quote_files',true);
			$has_quote=is_array($quote_files)&&$quote_files;
			echo $has_quote?'<span style="color:#1a7f37;font-weight:600">&#10003; Uploaded</span>':'<span style="color:#a7aaad">&mdash;</span>';
			break;
	}
}
add_action('manage_rfq_request_posts_custom_column','newtron_rfq_admin_column_content',10,2);

function newtron_rfq_register_meta_box(){
	add_meta_box('newtron_rfq_details','RFQ Details','newtron_rfq_render_meta_box','rfq_request','normal','high');
}
add_action('add_meta_boxes','newtron_rfq_register_meta_box');

function newtron_rfq_render_meta_box($post){
	wp_nonce_field('newtron_rfq_save_meta','newtron_rfq_meta_nonce');

	if(!empty($_GET['newtron_rfq_deleted'])){
		echo '<div style="background:#edfaef;border-left:4px solid #00a32a;padding:10px 14px;margin-bottom:16px"><strong>File deleted.</strong></div>';
	}

	$lead_time_options=array(''=>'- Select -','express'=>'Express (2 weeks)','standard'=>'Standard (4 weeks)','economy'=>'Economy (6–8 weeks)');
	$date_fields=array('start_date','target_delivery_date');

	$defs=newtron_rfq_field_defs();
	foreach($defs as $group){
		echo '<h3 style="margin-top:20px">'.esc_html($group['title']).'</h3><table class="widefat striped"><tbody>';
		foreach($group['fields'] as $key=>$def){
			$val=get_post_meta($post->ID,'_rfq_'.$key,true);
			$id='rfq_'.$key;
			echo '<tr><th style="width:220px;text-align:left"><label for="'.esc_attr($id).'">'.esc_html($def['label']).'</label></th><td>';
			if($def['sanitize']==='textarea'){
				echo '<textarea id="'.esc_attr($id).'" name="'.esc_attr($id).'" rows="4" class="large-text">'.esc_textarea($val).'</textarea>';
			}elseif($key==='lead_time'){
				echo '<select id="'.esc_attr($id).'" name="'.esc_attr($id).'">';
				foreach($lead_time_options as $opt_val=>$opt_label){
					echo '<option value="'.esc_attr($opt_val).'"'.selected($val,$opt_val,false).'>'.esc_html($opt_label).'</option>';
				}
				echo '</select>';
			}else{
				if($def['sanitize']==='email'){$type='email';}
				elseif($key==='quantity'){$type='number';}
				elseif(in_array($key,$date_fields,true)){$type='date';}
				elseif($key==='contact_phone'){$type='tel';}
				else{$type='text';}
				echo '<input type="'.esc_attr($type).'" id="'.esc_attr($id).'" name="'.esc_attr($id).'" value="'.esc_attr($val).'" class="regular-text">';
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	echo '<h3 style="margin-top:20px">Uploaded Files</h3>';
	$files=get_post_meta($post->ID,'_rfq_files',true);
	if(is_array($files)&&$files){
		echo '<ul>';
		foreach($files as $i=>$file){
			$url=add_query_arg(array('action'=>'newtron_rfq_download','rfq_id'=>$post->ID,'file'=>$i,'token'=>isset($file['token'])?$file['token']:''),admin_url('admin-post.php'));
			$confirm='Delete "'.$file['name'].'"?\n\nThis permanently removes the file from the server and cannot be undone.';
			echo '<li><a href="'.esc_url($url).'">'.esc_html($file['name']).'</a> ('.esc_html(size_format($file['size'])).') <a href="'.esc_url(newtron_rfq_delete_file_url($post->ID,'files',$i)).'" style="color:#b32d2e;text-decoration:none" onclick="return confirm(\''.esc_js($confirm).'\')">Delete</a></li>';
		}
		echo '</ul>';
	}else{
		echo '<p>No files uploaded.</p>';
	}

	$upload_debug=get_post_meta($post->ID,'_rfq_upload_debug',true);
	if(is_array($upload_debug)&&$upload_debug){
		echo '<div style="background:#fff3cd;border:1px solid #ffe69c;padding:10px 14px;margin-top:10px;border-radius:6px"><strong>Upload issue detected:</strong><ul style="margin:6px 0 0 20px">';
		foreach($upload_debug as $line)echo '<li>'.esc_html($line).'</li>';
		echo '</ul></div>';
	}

	$exts=strtoupper(implode(', ',array_keys(newtron_rfq_allowed_mimes())));
	echo '<p style="margin-top:12px"><label for="rfq_cad_files"><strong>Add Files</strong></label><br><input type="file" id="rfq_cad_files" name="cad_files[]" multiple></p>';
	echo '<p class="description">Allowed: '.esc_html($exts).'.</p>';

	echo '<h3 style="margin-top:20px">Quote Document</h3>';
	$quote_files=get_post_meta($post->ID,'_rfq_quote_files',true);
	if(is_array($quote_files)&&$quote_files){
		echo '<ul>';
		foreach($quote_files as $i=>$file){
			$url=add_query_arg(array('action'=>'newtron_rfq_download','type'=>'quote','rfq_id'=>$post->ID,'file'=>$i,'token'=>isset($file['token'])?$file['token']:''),admin_url('admin-post.php'));
			$confirm='Delete quote document "'.$file['name'].'"?\n\nThis permanently removes the file from the server and cannot be undone.';
			echo '<li><a href="'.esc_url($url).'">'.esc_html($file['name']).'</a> ('.esc_html(size_format($file['size'])).') <a href="'.esc_url(newtron_rfq_delete_file_url($post->ID,'quote',$i)).'" style="color:#b32d2e;text-decoration:none" onclick="return confirm(\''.esc_js($confirm).'\')">Delete</a></li>';
		}
		echo '</ul>';
	}else{
		echo '<p>No quote document uploaded yet.</p>';
	}
	$quote_upload_debug=get_post_meta($post->ID,'_rfq_quote_upload_debug',true);
	if(is_array($quote_upload_debug)&&$quote_upload_debug){
		echo '<div style="background:#fff3cd;border:1px solid #ffe69c;padding:10px 14px;margin-top:10px;border-radius:6px"><strong>Upload issue detected:</strong><ul style="margin:6px 0 0 20px">';
		foreach($quote_upload_debug as $line)echo '<li>'.esc_html($line).'</li>';
		echo '</ul></div>';
	}
	echo '<p style="margin-top:12px"><label for="rfq_quote_file"><strong>Upload Quote</strong></label><br><input type="file" id="rfq_quote_file" name="quote_file[]" multiple></p>';
	echo '<p class="description">Upload the finished quote to attach it to this request. Allowed: '.esc_html($exts).'.</p>';
}

function newtron_rfq_save_meta($post_id){
	if(empty($_POST['newtron_rfq_meta_nonce'])||!wp_verify_nonce($_POST['newtron_rfq_meta_nonce'],'newtron_rfq_save_meta'))return;
	if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;
	if(!current_user_can('edit_post',$post_id))return;

	foreach(newtron_rfq_field_defs() as $group){
		foreach($group['fields'] as $key=>$def){
			if(!isset($_POST['rfq_'.$key]))continue;
			$raw=wp_unslash($_POST['rfq_'.$key]);
			if($def['sanitize']==='email'){
				$clean=sanitize_email($raw);
			}elseif($def['sanitize']==='textarea'){
				$clean=sanitize_textarea_field($raw);
			}else{
				$clean=sanitize_text_field($raw);
			}
			update_post_meta($post_id,'_rfq_'.$key,$clean);
		}
	}

	if(!empty($_FILES['cad_files'])&&!empty($_FILES['cad_files']['name'][0])){
		$new_files=newtron_rfq_handle_uploads($post_id,'cad_files','_rfq_upload_debug');
		if($new_files){
			$existing=get_post_meta($post_id,'_rfq_files',true);
			if(!is_array($existing))$existing=array();
			update_post_meta($post_id,'_rfq_files',array_merge($existing,$new_files));
		}
	}

	if(!empty($_FILES['quote_file'])&&!empty($_FILES['quote_file']['name'][0])){
		$new_quote_files=newtron_rfq_handle_uploads($post_id,'quote_file','_rfq_quote_upload_debug');
		if($new_quote_files){
			$existing_quote=get_post_meta($post_id,'_rfq_quote_files',true);
			if(!is_array($existing_quote))$existing_quote=array();
			update_post_meta($post_id,'_rfq_quote_files',array_merge($existing_quote,$new_quote_files));
		}
	}
}
add_action('save_post_rfq_request','newtron_rfq_save_meta');
