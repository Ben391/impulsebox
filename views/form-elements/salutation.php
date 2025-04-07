<div class="mb-md-3 mb-2">
	<div class="form-check form-check-inline">
		<input 
			   class="form-check-input" 
			   type="radio" 
			   name="<?php echo $input_salutation_attr_name_value ?>" 
			   value="1" 
			   <?php if($input_salutation_attr_value_value == 1) echo "checked"; ?> 
			   <?php echo $input_salutation_required ?>>
		<label class="form-check-label">Herr</label>
	</div>
	<div class="form-check form-check-inline">
		<input 
			   class="form-check-input" 
			   type="radio" 
			   name="<?php echo $input_salutation_attr_name_value ?>" 
			   value="2" 
			   <?php if($input_salutation_attr_value_value == 2) echo "checked"; ?> 
			   <?php echo $input_salutation_required ?>>
		<label class="form-check-label">Frau</label>
	</div>
	<div class="form-check form-check-inline">
		<input 
			   class="form-check-input" 
			   type="radio" 
			   name="<?php echo $input_salutation_attr_name_value ?>" 
			   value="3" 
			   <?php if($input_salutation_attr_value_value == 3) echo "checked"; ?> 
			   <?php echo $input_salutation_required ?>>
		<label class="form-check-label">Divers</label>
	</div>
	<div class="invalid-feedback salutation-feedback"><?php echo INVALID_FEEDBACK_SALUTATION ?></div>
</div>
