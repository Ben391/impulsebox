<div class="row mb-3">
	<div class="col-md col-12 mb-3">
		<label class="form-label">Vorname</label>
		<input 
			   minlength="1" 
			   maxlength="60" 
			   pattern="[a-zA-ZäöüÄÖÜß- ]+"
			   type="text" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_first_name_attr_name_value ?>" 
			   id="<?php echo $input_first_name_attr_id_value ?>" 
			   value="<?php echo $input_first_name_attr_value_value ?>" 
			   required>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_FIRST_NAME ?></div>
	</div>
	<div class="col-md col-12 mb-3">
		<label class="form-label">Nachname</label>
		<input 
			   minlength="1" 
			   pattern="[a-zA-ZäöüÄÖÜß- ]+"
			   maxlength="60" 
			   type="text" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_last_name_attr_name_value ?>" 
			   id="<?php echo $input_last_name_attr_value_value ?>" 
			   value="<?php echo $input_last_name_attr_value_value ?>" 
			   required>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_LAST_NAME ?></div>
	</div>
</div>