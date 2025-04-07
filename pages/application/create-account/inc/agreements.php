<div class="row mb-3">
	<div class="col-12 mb-3">
		<div class="form-check">
			<h5 class="h6 mb-1">Zustimmung für Allgemeine Geschäftsbedingungen *</h5>
			<input class="form-check-input" type="checkbox" value="1" <?php if(!empty($user_id)) echo "checked disabled"; ?> required>
			<label class="form-check-label ftsz-0875">
				Ich stimme den <a target="_blank" href="<?php echo BASEHREF."agb/" ?>">Allgemeinen Geschäftsbedingungen</a> der <?php echo $company["company"] ?> zum Produkt <?php echo $company["servicename"] ?> zu und habe die Hinweise zum Widerrufsrecht zur Kenntnis genommen. Sofern ich die oben genannten Einwilligungen und Erklärungen für einen Dritten, z.B. eine pflegebedürftige Person abgebe, versichere ich, dass mich die Dritte Person zur Abgabe der Einwilligungserklärung bevollmächtigt hat und kann der <?php echo $company["company"] ?>, <?php echo $company["street"] ?>, <?php echo $company["zipcode"] . " " . $company["city"] ?> diese Vollmacht jederzeit vorlegen.
			</label>
		</div>
	</div>
	<div class="col-12 mb-3">
		<div class="form-check">
			<h5 class="h6 mb-1">Zustimmung zur Datenschutzerklärung *</h5>
			<input class="form-check-input" type="checkbox" value="1" <?php if(!empty($user_id)) echo "checked disabled"; ?> required>
			<label class="form-check-label ftsz-0875">
				 Ich stimme den <a target="_blank" href="<?php echo BASEHREF."datenschutz/" ?>">Datenschutzhinweisen</a> sowie der Verarbeitung meiner Daten sowie meiner Angaben zu Pflegegrad und Pflege/Krankenkasse zu Bearbeitungs- und Beratungszwecken und der Kontaktaufnahme per Telefon und E-Mail zu. Ein Widerruf ist jederzeit möglich.
			</label>
		</div>
	</div>
	<div class="col-12 mb-3">
		<div class="form-check">
			<h5 class="h6 mb-1">Zustimmung zur Datenübermittlung an Versanddienstleister *</h5>
			<input class="form-check-input" type="checkbox" value="1" <?php if(!empty($user_id)) echo "checked disabled"; ?> required>
			<label class="form-check-label ftsz-0875">
				 Ich bin mit der Weitegabe meiner E-Mail-Adresse an den Versanddienstleister für den Versand von Paketankündigungs-E-Mails einverstanden. Weitere Informationen erhalten Sie in unserer <a target="_blank" href="<?php echo BASEHREF."datenschutz/" ?>">Datenschutzerklärung</a>.
			</label>
		</div>
	</div>
	<div class="col-12 mb-3">
		<div class="form-check">
			<h5 class="h6 mb-1">Zustimmung für Marketingzwecke (optional)</h5>
			<input class="form-check-input" type="checkbox" name="agreement_marketing" value="1" <?php if(!empty($agreement_marketing)) echo "checked"; ?>>
			<label class="form-check-label ftsz-0875">
				 Ich stimme den Datenschutzhinweisen sowie der Verarbeitung meiner Daten zu Marketingzwecken und der Kontaktaufnahme per Telefon und E-Mail zu. Ein Widerruf ist jederzeit möglich.
			</label>
		</div>
	</div>
</div>