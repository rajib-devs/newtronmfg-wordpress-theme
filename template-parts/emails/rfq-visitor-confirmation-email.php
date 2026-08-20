<?php
/**
 * RFQ visitor confirmation email template.
 *
 * Included (not require_once) from newtron_rfq_send_confirmation_email() via output
 * buffering, so it runs inside that function's scope and has direct access to:
 * $post_id, $values, $name, $rfq_number, $site_name, $logo_url, $site_url, $files.
 */
if(!defined('ABSPATH'))exit;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
	.rfq-header-mobile{display:none}
	@media only screen and (max-width:480px){
		.rfq-header-desktop{display:none!important}
		.rfq-header-mobile{display:block!important}
	}
</style>
</head>
<body style="margin:0;padding:0;background:#f3f4f6">
<div style="font-family:Arial,Helvetica,sans-serif;color:#222;max-width:600px;margin:24px auto 0">

<table cellpadding="0" cellspacing="0" style="width:100%;background:#1f2937;border-radius:6px 6px 0 0"><tr>
<td style="color:#fff;padding:24px">

<table class="rfq-header-desktop" cellpadding="0" cellspacing="0" style="width:100%"><tr>
<td style="vertical-align:middle">
<div style="font-size:13px;letter-spacing:.04em;text-transform:uppercase;color:#9ca3af">Quote Request Received</div>
<div style="font-size:20px;font-weight:bold;margin-top:4px;word-break:break-word;color:#fff">RFQ <?php echo esc_html($rfq_number); ?></div>
</td>
<td style="vertical-align:middle;text-align:right;width:35%;padding-left:12px"><img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo $site_name; ?>" style="max-width:100%;max-height:32px;height:auto;display:inline-block"></td>
</tr></table>

<div class="rfq-header-mobile">
<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo $site_name; ?>" style="max-width:120px;max-height:28px;height:auto;display:block;margin-bottom:14px">
<div style="font-size:13px;letter-spacing:.04em;text-transform:uppercase;color:#9ca3af">Quote Request Received</div>
<div style="font-size:20px;font-weight:bold;margin-top:4px;word-break:break-word;color:#fff">RFQ <?php echo esc_html($rfq_number); ?></div>
</div>

</td>
</tr></table>

<div style="border:1px solid #e5e7eb;border-top:0;padding:20px 24px">
<p style="margin:0 0 8px;font-size:14px;color:#444">Hi <?php echo esc_html($name); ?>,</p>
<p style="margin:0 0 32px;font-size:14px;color:#444">Thanks for your quote request<?php echo $values['project_name']?' for "'.esc_html($values['project_name']).'"':''; ?>. Our team has received it and will follow up shortly. Please reference your RFQ number in any correspondence about this request.</p>
<h3 style="margin:0 0 20px;font-size:13px;text-transform:uppercase;letter-spacing:.03em;color:#374151;border-bottom:2px solid #e5e7eb;padding-bottom:6px">RFQ Number: <span style="color:#222;text-transform:none;letter-spacing:normal"><?php echo esc_html($rfq_number); ?></span></h3>

<?php foreach(newtron_rfq_field_defs() as $group): ?>
	<?php
	$rows='';
	foreach($group['fields'] as $key=>$def){
		if($values[$key]==='')continue;
		$rows.='<tr><td style="width:38%;padding:6px 16px 6px 0;color:#6b7280;font-size:13px;vertical-align:top;border-bottom:1px solid #f3f4f6">'.esc_html($def['label']).'</td><td style="padding:6px 0;font-size:14px;color:#222;border-bottom:1px solid #f3f4f6;word-break:break-word">'.esc_html($values[$key]).'</td></tr>';
	}
	?>
	<?php if($rows): ?>
<h3 style="margin:20px 0 6px;font-size:13px;text-transform:uppercase;letter-spacing:.03em;color:#374151;border-bottom:2px solid #e5e7eb;padding-bottom:6px"><?php echo esc_html($group['title']); ?></h3>
<table cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;table-layout:fixed"><?php echo $rows; ?></table>
	<?php endif; ?>
<?php endforeach; ?>

<?php if($files): ?>
<h3 style="margin:20px 0 6px;font-size:13px;text-transform:uppercase;letter-spacing:.03em;color:#374151;border-bottom:2px solid #e5e7eb;padding-bottom:6px">Attached Files (<?php echo count($files); ?>)</h3>
<p style="margin:0 0 10px;font-size:12px;color:#9ca3af">These files were received with your request and will be reviewed by our team.</p>
	<?php foreach($files as $file): ?>
<div style="padding:8px 0;border-bottom:1px solid #f3f4f6;font-size:14px">
<span style="color:#222;font-weight:bold"><?php echo esc_html($file['name']); ?></span>
<span style="color:#9ca3af;font-size:12px"> &middot; <?php echo esc_html(size_format($file['size'])); ?></span>
</div>
	<?php endforeach; ?>
<?php endif; ?>

<div style="margin-top:24px">
<a href="<?php echo esc_url($site_url); ?>" style="display:inline-block;max-width:100%;box-sizing:border-box;background:#2563eb;color:#fff;text-decoration:none;font-size:14px;font-weight:bold;padding:10px 18px;border-radius:4px">Visit <?php echo $site_name; ?></a>
</div>
</div>

<p style="font-size:12px;color:#9ca3af;margin:16px 4px;text-align:center">This is an automated notification from <?php echo $site_name; ?>. If you have questions, contact us at <a href="mailto:sales@newtronmfg.com" style="color:#9ca3af">sales@newtronmfg.com</a>.</p>
</div>
</body>
</html>
