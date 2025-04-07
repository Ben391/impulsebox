<div id="insurance-company-section" class="mb-5">
	<h3 class="mb-4">Angaben zur Krankenkasse</h3>
	<div class="row mb-3" id="insurance-company-insurance-type-section">
		<div class="col">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="insurance_type" value="1" <?php if(isset($insurance_type) AND $insurance_type == 1) echo "checked"; ?> required>
				<label class="form-check-label">Gesetzlich Versicherter (Kostenübernahme durch die Pflegekasse)</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="insurance_type" value="2" <?php if(isset($insurance_type) AND $insurance_type == 2) echo "checked"; ?>>
				<label class="form-check-label">Privatversicherter</label>
			</div>
			<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_INSURANCE_TYPE ?></div>
		</div>
	</div>
	<div class="row mb-3" id="insurance-company-name-section" <?php if(empty($insurance_type)) { ?>style="display: none"<?php } ?>>
		<div class="col mb-3" id="insurance-company-name-select-section">
			<label class="form-label">Krankenkasse</label>
				<select class="form-select form-select-lg" id="insurance_companies" name="insurance_company_id" required></select>
				<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_INSURANCE_COMPANY ?></div>
		</div>
		<div class="col-md-auto mb-3 d-flex align-items-end">
			<div class="form-check mb-2">
				<input class="form-check-input" type="checkbox" name="custom_insurance_company" value="1" <?php if(isset($custom_insurance_company_name) AND !empty($custom_insurance_company_name)) echo "checked "; ?>>
				<label class="form-check-label">
					Meine Krankenkasse ist nicht dabei
				</label>
			</div>
		</div>
		<div class="col-12" id="custom-insurance-company-name-section" <?php if(empty($custom_insurance_company_name)) { ?>style="display: none"<?php } ?>>
			<label class="form-label">Ihre Krankenkasse</label>
			<input type="text" class="form-control form-control-lg" placeholder="Geben Sie hier den Namen Ihrer Krankenkasse ein" name="custom_insurance_company_name" value="<?php echo $custom_insurance_company_name ?>">
		</div>
	</div>
	<div class="row mb-3" id="insurance-company-number-section" style="display: none">
		<div class="col-md-6 mb-1">
			<label class="form-label">Krankenversichertennummer (KVNR)</label>
			<input 
				   type="text" 
				   maxlength="10" 
				   class="form-control form-control-lg" 
				   placeholder="A123456789" 
				   name="insurance_number" 
				   id="insurance_number" 
				   value="<?php echo $insurance_number ?>" 
				   required>
			<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_INSURANCE_NUMBER ?></div>
		</div>
		<div class="col-12 mb-3">
			<div id="message_insurance_number" class="ftsz-1" style="display: none"></div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col mb-3">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="insurance_aid" value="1" <?php if(isset($insurance_aid) AND ($insurance_aid == 1)) echo "checked"; ?>>
				<label class="form-check-label">
				Die versicherte Person ist beihilfeberechtigt
				</label>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	initializeInsuranceType();
    initializeSelect2();
    handleInsuranceTypeChange();
    handleCustomInsuranceCheckbox();

    // Initialisierung von Select2
    function initializeSelect2() {
        $('#insurance_companies').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    }
	
	function initializeInsuranceType() {
		var selectedType = $("input[name='insurance_type']:checked").val();
		if (selectedType) {
			$('#insurance-company-name-section, #insurance-company-number-section').show();
			updateInsuranceCompanies(selectedType);
		} else {
			$('#insurance-company-name-section, #insurance-company-number-section').hide();
		}
	}

    // Behandlung der Versicherungsart-Änderung
    function handleInsuranceTypeChange() {
        $("input[name='insurance_type']").change(function() {
            var selectedType = $(this).val();
            if (selectedType) {
                $('#insurance-company-name-section, #insurance-company-number-section').show();
            } else {
                $('#insurance-company-name-section, #insurance-company-number-section').hide();
            }
            updateInsuranceCompanies(selectedType);
        });
    }

    // Behandlung der Checkbox-Änderung
    function handleCustomInsuranceCheckbox() {
        var $checkbox = $("input[name='custom_insurance_company']");
        
        if ($checkbox.prop('checked')) {
            handleCheckboxChecked();
        }

        $checkbox.change(function() {
            if ($(this).prop('checked')) {
                handleCheckboxChecked();
            } else {
                handleCheckboxUnchecked();
            }
        });
    }

    function handleCheckboxChecked() {
        $('#insurance-company-name-select-section').hide();
        $('#custom-insurance-company-name-section').show();
        $("input[name='custom_insurance_company_name']").prop('required', true);
        $("select[name='insurance_company_id']").prop('required', false);
    }

    function handleCheckboxUnchecked() {
        $('#insurance-company-name-select-section').show();
        $('#custom-insurance-company-name-section').hide();
        $("input[name='custom_insurance_company_name']").prop('required', false);
        $("select[name='insurance_company_id']").prop('required', true);
    }

	function updateInsuranceCompanies(type) {
		var previousSelectedValue = $('#insurance_companies').val();
		$.ajax({
			url: 'pages/application/insured-person-data/inc/select-insurance-companies.php',
			method: 'POST',
			data: { insurance_type: type },
			success: function(response) {
				var companies = JSON.parse(response);
				var options = '<option value="">Bitte auswählen</option>';
				companies.forEach(function(company) {
					var isSelected = company.id === "<?php echo $insurance_company_id; ?>" ? "selected" : "";
					options += '<option value="' + company.id + '" ' + isSelected + '>' + company.name + '</option>';
				});
				$('#insurance_companies').html(options);
				$('#insurance_companies').val("<?php echo $insurance_company_id; ?>").trigger('change'); // Update the Select2
			}
		});
	}
});
</script>