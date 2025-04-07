<div class="row mb-3">
	<h2 class="h3 mb-3">Angaben zum Pflegegrad</h2>
	<div class="col-md col-12 mb-3">
		<label class="form-label mb-4">Pflegegrad</label>
		<div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="0" <?php if($care_level == 0) echo "checked"; ?> required>
				<label class="form-check-label">kein</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="1" <?php if($care_level == 1) echo "checked"; ?>>
				<label class="form-check-label">1</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="2" <?php if($care_level == 2) echo "checked"; ?>>
				<label class="form-check-label">2</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="3" <?php if($care_level == 3) echo "checked"; ?>>
				<label class="form-check-label">3</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="4" <?php if($care_level == 4) echo "checked"; ?>>
				<label class="form-check-label">4</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="care_level" value="5" <?php if($care_level == 5) echo "checked"; ?>>
				<label class="form-check-label">5</label>
			</div>
		</div>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_CARE_LEVEL ?></div>
	</div>
	<div class="col-md-4 col-12 mb-3" id="care_level_since_section" style="display: none">
		<label class="form-label">Pflegegrad seit</label>
		<input 
			   minlength="7" 
			   maxlength="7" 
			   pattern=".{7}|^$"
			   type="text" 
			   class="form-control form-control-lg" 
			   name="care_level_since" 
			   id="care_level_since" 
			   placeholder="MM.JJJJ" 
			   value="<?php echo $care_level_since ?>">
		<div class="invalid-feedback" id="care_level_since_field_message"><?php echo INVALID_FEEDBACK_CARE_LEVEL_SINCE ?></div>
	</div>
</div>
<script>
  // Funktion, um die Sichtbarkeit des Pflegegrad-seit Abschnitts zu steuern
  function toggleCareLevelSection() {
    const careLevelOptions = document.querySelectorAll("input[name='care_level']");
    let selectedCareLevel = null;

    // Durch alle care_level Optionen iterieren, um die ausgewählte zu finden
    careLevelOptions.forEach(option => {
      if (option.checked) {
        selectedCareLevel = parseInt(option.value);
      }
    });

    const careLevelSinceSection = document.getElementById("care_level_since_section");

    // Wenn der ausgewählte Pflegegrad 1, 2, 3, 4 oder 5 ist, blenden wir den Abschnitt ein
    if (selectedCareLevel > 0) {
      careLevelSinceSection.style.display = "block";
    } else {
      careLevelSinceSection.style.display = "none";
    }
  }

  // Event Listener für alle care_level Radio-Buttons
  document.querySelectorAll("input[name='care_level']").forEach(option => {
    option.addEventListener("change", toggleCareLevelSection);
  });

  // Aufruf der Funktion beim Laden der Seite, um den aktuellen Status zu berücksichtigen
  toggleCareLevelSection();
</script>