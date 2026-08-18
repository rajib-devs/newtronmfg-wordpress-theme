<?php
if(!defined('ABSPATH'))exit;

function newtron_rfq_register_settings(){
	register_setting('newtron_rfq_settings','newtron_rfq_notification_email',array(
		'type'=>'string',
		'sanitize_callback'=>'sanitize_email',
		'default'=>get_option('admin_email'),
	));
}
add_action('admin_init','newtron_rfq_register_settings');

function newtron_rfq_add_settings_page(){
	add_submenu_page('edit.php?post_type=rfq_request','RFQ Settings','Settings','manage_options','newtron-rfq-settings','newtron_rfq_render_settings_page');
}
add_action('admin_menu','newtron_rfq_add_settings_page');

function newtron_rfq_notification_email(){
	$email=get_option('newtron_rfq_notification_email');
	return $email?:get_option('admin_email');
}

function newtron_rfq_render_settings_page(){
	if(!current_user_can('manage_options'))return;
	if(isset($_GET['settings-updated'])){
		add_settings_error('newtron_rfq_settings_notice','newtron_rfq_settings_saved','Settings saved.','success');
	}
	settings_errors('newtron_rfq_settings_notice');
	?>
	<div class="wrap">
	<h1>RFQ Settings</h1>
	<form method="post" action="options.php">
	<?php settings_fields('newtron_rfq_settings'); ?>
	<table class="form-table">
	<tr>
	<th scope="row"><label for="newtron_rfq_notification_email">Notification Email</label></th>
	<td>
	<input type="email" id="newtron_rfq_notification_email" name="newtron_rfq_notification_email" value="<?php echo esc_attr(newtron_rfq_notification_email()); ?>" class="regular-text" required>
	<p class="description">New RFQ submissions are emailed to this address. Applicants also automatically receive a confirmation email.</p>
	</td>
	</tr>
	</table>
	<?php submit_button(); ?>
	</form>
	</div>
	<?php
}
