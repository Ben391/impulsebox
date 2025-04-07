<div class="row mb-3">
	<div class="col mb-3">
		<label class="form-label">Firma</label>
		<input 
			   minlength="5" 
			   maxlength="60" 
			   type="text" 
			   class="form-control form-control-lg" 
			   id="<?php echo $input_company_attr_id_value ?>" 
			   name="<?php echo $input_company_attr_name_value ?>" 
			   value="<?php echo $care_giver_service_company ?>" 
			   <?php echo $input_company_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_COMPANY ?></div>
	</div>
</div>