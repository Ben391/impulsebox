<div class="row mb-3">
	<div class="col-md-3 col-12 mb-3">
		<label class="form-label">PLZ</label>
		<input 
			   minlength="5" 
			   maxlength="5"
			   pattern="[0-9]+"
			   type="text" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_zipcode_attr_name_value ?>" 
			   id="<?php echo $input_zipcode_attr_id_value ?>" 
			   value="<?php echo $input_zipcode_attr_value_value ?>" 
			   <?php echo $input_zipcode_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_ZIPCODE ?></div>
	</div>
	<div class="col-md-9 col-12 mb-3">
		<label class="form-label">Stadt</label>
		<input 
			   minlength="2"
			   maxlength="30"
			   type="text" 
			   class="form-control form-control-lg" 
			   name="<?php echo $input_city_attr_name_value ?>" 
			   id="<?php echo $input_city_attr_id_value ?>" 
			   value="<?php echo $input_city_attr_value_value ?>" 
			   <?php echo $input_city_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_CITY ?></div>
	</div>
</div>