<?php
if($current_page == "versichertendaten") {
	$input_phone_label = "Telefonnummer <br>des Versicherten";
	$input_email_label = "E-Mail-Adresse <br>des Versicherten";
} else {
	$input_phone_label = "Telefonnummer";
	$input_email_label = "E-Mail-Adresse";
}
?>
<div class="row mb-3">
	<div class="col-md-5 col-12 mb-3">
		<label class="form-label"><?php echo $input_phone_label." ".$input_phone_required_asterisk ?></label>
		<input 
			   minlength="5"
			   maxlength="50"
			   type="phone" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_phone_attr_name_value ?>" 
			   id="<?php echo $input_phone_attr_id_value ?>" 
			   value="<?php echo $input_phone_attr_value_value ?>" 
			   <?php echo $input_phone_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_PHONE ?></div>
	</div>
	<div class="col-md-7 col-12 mb-3">
		<label class="form-label"><?php echo $input_email_label." ".$input_email_required_asterisk ?></label>
		<input 
			   minlength="5"
			   maxlength="50"
			   type="email" 
			   class="form-control form-control-lg" 			   
			   name="<?php echo $input_email_attr_name_value ?>" 
			   id="<?php echo $input_email_attr_id_value ?>" 
			   value="<?php echo $input_email_attr_value_value ?>" 
			   <?php echo $input_email_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_EMAIL ?></div>
	</div>
</div>