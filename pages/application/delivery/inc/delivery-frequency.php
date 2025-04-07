<div class="row mb-3">
	<div class="col-md-8">
		<h2 class="h4 mb-3">Häufigkeit der Lieferung</h2>
		<select class="form-select form-select-lg mb-3" name="delivery_frequency" required>
			<option value="" disabled <?php if (!isset($delivery_frequency)) echo "selected"; ?>>Bitte auswählen</option>
			<option value="0" <?php if (isset($delivery_frequency) && $delivery_frequency == 0) echo " selected"; ?>>monatlich</option>
			<option value="1" <?php if (isset($delivery_frequency) && $delivery_frequency == 1) echo " selected"; ?>>jeden 2. Monat</option>
			<option value="2" <?php if (isset($delivery_frequency) && $delivery_frequency == 2) echo " selected"; ?>>jeden 3. Monat</option>
		</select>
		<div class="invalid-feedback"><?php echo INVALID_FEEDBACK_DELIVERY_FREQUENCY ?></div>
	</div>
</div>