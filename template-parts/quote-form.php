<form class="card form-grid quote-form" method="post" action="<?php echo esc_url(rest_url('newtron/v1/rfq-submit')); ?>" enctype="multipart/form-data">
<?php wp_nonce_field('newtron_rfq_submit','newtron_rfq_nonce'); ?>
<div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="rfq_website" tabindex="-1" autocomplete="off"></label></div>
<input type="hidden" name="recaptcha_token" class="recaptcha-token" value="">
<div class="full"><h3 class="form-section-title is-first">Contact &amp; Company Information</h3></div>
<div><label>First Name <span class="req">*</span></label><input name="contact_first_name" required></div>
<div><label>Last Name <span class="req">*</span></label><input name="contact_last_name" required></div>
<div><label>Designation</label><input name="contact_designation"></div>
<div><label>Company Name</label><input name="company_name"></div>
<div class="full"><label>Country <span class="req">*</span></label><select class="country-select" disabled><option value="US" selected>United States (US)</option></select><input type="hidden" name="company_country" value="US"></div>
<div class="full"><label>Street Address <span class="req">*</span></label><input name="company_address" required></div>
<div><label>Town / City <span class="req">*</span></label><input name="company_city" required></div>
<div><label>State / Province</label><select name="company_state" class="state-select"><option value="">Select a state…</option></select><input type="text" name="company_state" class="state-text" placeholder="State / Province" style="display:none"></div>
<div class="full"><label>Zip Code <span class="req">*</span></label><input name="company_zip" required></div>
<div><label>Phone Number <span class="req">*</span></label><input type="tel" name="contact_phone" pattern="[0-9+\-\s()]{7,}" title="Enter a valid phone number" required></div>
<div><label>Email Address <span class="req">*</span></label><input type="email" name="contact_email" required></div>

<div class="full"><h3 class="form-section-title">Project Details</h3></div>
<div class="full"><label>Project Name</label><input name="project_name" required></div>
<div><label>Process</label><select name="process"><option>CNC Machining</option><option>CNC Turning</option><option>3D Printing</option><option>Sheet Metal</option></select></div>
<div><label>Material</label><select name="material"><option>Aluminum 6061-T6</option><option>Stainless Steel 304</option><option>Steel 1018</option><option>See Drawing</option></select></div>
<div><label>Finish</label><input name="finish" placeholder="e.g. As Machined, Anodized, Powder Coated"></div>
<div><label>Quantity</label><input type="number" name="quantity" value="10"></div>
<div><label>Start Date</label><input type="date" name="start_date"></div>
<div><label>Estimated Delivery Date</label><input type="date" name="target_delivery_date"></div>
<div><label>Expected MFG Origin</label><select name="mfg_origin_preference"><option value="US Only">US Only</option><option value="Best Time and/or Price">Best Time and/or Price</option></select></div>
<div><label>Exclude Origin</label><input name="exclude_origin" placeholder="Excluded country of MFG"></div>

<div class="full"><label>Lead Time</label><div class="lead-time-options">
<label class="lead-time-option"><input type="radio" name="lead_time" value="express" checked><span class="lt-name">Express</span><span class="lt-desc">2 weeks</span></label>
<label class="lead-time-option"><input type="radio" name="lead_time" value="standard"><span class="lt-name">Standard</span><span class="lt-desc">4 weeks</span></label>
<label class="lead-time-option"><input type="radio" name="lead_time" value="economy"><span class="lt-name">Economy</span><span class="lt-desc">6–8 weeks</span></label>
</div></div>

<div class="full"><label>Project Notes</label><textarea name="project_notes" placeholder="Tell us anything else about the project, tolerances, or special requirements."></textarea></div>

<div class="full"><div class="upload-box"><h3>Drag &amp; Drop Files Here</h3><p>STEP, STP, STL, IGES, DXF, DWG, PDF, ZIP, JPG, PNG, GIF, WEBP</p><input type="file" name="cad_files[]" multiple><ul class="upload-file-list"></ul><p class="upload-file-warning" hidden></p></div></div>
<div class="full"><button class="btn btn-blue">Submit Request</button></div>
<div class="full form-note" hidden><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4f9a1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg><div><strong>Request submitted</strong><span>Thanks - your request has been submitted. Our team will follow up shortly.</span></div></div>
<div class="full form-error" role="alert" hidden></div>
</form>
