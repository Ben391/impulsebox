<div class="row mb-3">
	<div class="col-md-4 col-12">
		<label class="form-label">Geburtsdatum</label>
		<input 
			   minlength="10"
			   maxlength="10" 
			   placeholder="TT.MM.JJJJ" 
			   type="text" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_birth_date_attr_name_value ?>" 
			   id="<?php echo $input_birth_date_attr_id_value ?>" 
			   value="<?php echo $insured_person_birth_date ?>" 
			   <?php echo $input_birth_date_required ?>>
		<div id="message_insured_person_birth_date" class="invalid-feedback"><?php echo INVALID_FEEDBACK_BIRTH_DATE ?></div>
	</div>
</div>