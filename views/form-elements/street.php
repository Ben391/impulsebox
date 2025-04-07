<div class="row mb-3">
	<div class="col-12 mb-3">
		<label class="form-label">Straße und Hausnummer</label>
		<input 
			   minlength="5" 
			   maxlength="60" 
			   pattern="^[a-zA-ZäöüÄÖÜß\. \-/]+[1-9][0-9]*[a-zA-Z]?$"
			   type="text" 
			   class="form-control form-control-lg"
			   placeholder="Straße und Hausnummer"
			   name="<?php echo $input_street_attr_name_value ?>" 
			   id="<?php echo $input_street_attr_id_value ?>" 
			   value="<?php echo $input_street_attr_value_value ?>" 
			   <?php echo $input_street_required ?>>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_STREET ?></div>
	</div>
	<div class="col-12 mb-3">
		<label class="form-label">Adresszusatz</label>
		<input 
			   minlength="2" 
			   maxlength="40"  
			   type="text" 
			   class="form-control form-control-lg"
			   placeholder="Postfach, Etage, c/o usw."
			   name="<?php echo $input_address_addition_attr_name_value ?>" 
			   id="<?php echo $input_address_addition_attr_id_value ?>" 
			   value="<?php echo $input_address_addition_attr_value_value ?>" 
			   <?php echo $input_address_addition_required ?>>
	</div>
</div>