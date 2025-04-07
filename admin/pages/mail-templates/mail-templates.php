<div class="container py-4">
	<div class="row">
		<h1 class="h2 mb-3">E-Mail-Vorlagen</h1>
		<div class="col mb-3">
			<?php
			$templates = [
				[
					'id' => 2,
					'title' => 'Footer',
					'description' => 'Dieser Textblock wird jeder Vorlage (für Kunden) an unterster Stelle eingefügt.',
					'userType' => 'user',
					'templateType' => 'footer',
					'rows' => '4'
				],
				[
					'id' => 5,
					'title' => 'Konto erstellt',
					'description' => 'Diese Nachricht wird nach der Erstellung eines Kontos an Kunden geschickt.',
					'userType' => 'user',
					'templateType' => 'create_account',
					'rows' => '8',
					'vars' => [
						"Passwort" => '{password}'
					]
				],
				[
					'id' => 6,
					'title' => 'Bestellung gesetzlich',
					'description' => 'Diese Nachricht wird an gesetzlich Versicherter verschickt.',
					'userType' => 'user',
					'templateType' => 'order_gesetzlich',
					'rows' => '6'
				],
				[
					'id' => 7,
					'title' => 'Bestellung privat',
					'description' => 'Diese Nachricht wird an privat Versicherter verschickt.',
					'userType' => 'user',
					'templateType' => 'order_privat',
					'rows' => '6'
				],
				[
					'id' => 8,
					'title' => 'Bestellung gesetzlich oder privat',
					'description' => 'Diese Nachricht wird bei Bestellung an Administrator verschickt.',
					'userType' => 'admin',
					'templateType' => 'new_application_received',
					'rows' => '3'
				],
				[
					'id' => 9,
					'title' => 'Antragsformular per Post angefordert',
					'description' => 'Diese Nachricht wird an Kunden verschickt, falls dieser das Antragsformular per Post angefordert hat.',
					'userType' => 'user',
					'templateType' => 'request_by_post',
					'rows' => '10'
				],
				[
					'id' => 10,
					'title' => 'Antragsformular per Post angefordert',
					'description' => 'Diese Nachricht wird an den Administrator verschickt, falls ein Antragsformular per Post angefordert wurde.',
					'userType' => 'admin',
					'templateType' => 'request_by_post',
					'rows' => '3'
				],
				[
					'id' => 11,
					'title' => 'Antragsformular per Post verschickt',
					'description' => 'Diese Nachricht wird an den Kunden verschickt, falls das angeforderte Antragsformular per Post an ihn verschickt wurde.',
					'userType' => 'user',
					'templateType' => 'application_form_has_been_sent',
					'rows' => '10'
				],
				[
					'id' => 12,
					'title' => 'Antrag eingegangen',
					'description' => 'Diese Nachricht wird an den Kunden als Bestätigung des Eingangs seines Antrags verschickt.',
					'userType' => 'user',
					'templateType' => 'application_received',
					'rows' => '6',
				],
				[
					'id' => 13,
					'title' => 'Antrag genehmigt',
					'description' => 'Diese Nachricht wird an den Kunden verschickt, falls sein Antrag von der Pflegekasse genehmigt wurde.',
					'userType' => 'user',
					'templateType' => 'application_approved',
					'rows' => '6'
				],
				[
					'id' => 14,
					'title' => 'Antrag nicht genehmigt',
					'description' => 'Diese Nachricht wird an den Kunden verschickt, falls sein Antrag von der Pflegekasse nicht genehmigt wurde.',
					'userType' => 'user',
					'templateType' => 'application_not_approved',
					'rows' => '6'
				],
				[
					'id' => 15,
					'title' => 'Passwort vergessen',
					'description' => 'Diese Nachricht wird an den Kunden verschickt, falls er das Passwort vergessen hat.',
					'userType' => 'user',
					'templateType' => 'reset_password',
					'rows' => '6',
					'vars' => [
						'URL zum Zurücksetzen von Passwort' => '{reset_password_url}'
					]
				],
			];
			?>
			<div class="accordion accordion-flush">
			<?php foreach ($templates as $template): ?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="flush-<?php echo $template['id'] ?>">
						<button class="accordion-button pb-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $template['id'] ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $template['id'] ?>">
							<div class="d-flex align-items-end">
								<div class="me-2"><?= $template['title'] ?></div>| 
								<div class="ms-2 font-weght-normal">
									E-Mail an <span class="<?php if($template['userType'] == "user") { echo "bg-success "; } else { echo "bg-danger "; } ?> text-white p-1"><?php echo $template['userType'] ?></span>
								</div>
							</div>
						</button>
					</h2>
					<?php if(!empty($template["description"])) { ?>
					<div class="ftsz-0875 px-4">
						<?php echo $template["description"] ?>
					</div>
					<?php } ?>
					<div id="flush-collapse<?php echo $template['id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-<?php echo $template['id'] ?>" data-bs-parent="#accordionFlush<?php echo $template['id'] ?>">
				<div class="p-md-4 p-3 mb-4 bg-light-grey rounded-4">
					<h2 class="h4 mb-3"><?= $template['title'] ?></h2>
					<label class="form-label me-2">E-Mail an <span class="<?php if($template['userType'] == "user") { echo "bg-success "; } else { echo "bg-danger "; } ?> text-white p-1"><?php echo $template['userType'] ?></span></label>
					<div class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1 mb-3">
						<?php
						$template_file_subject = "../email-templates/{$template['userType']}/{$template['userType']}_{$template['templateType']}_subject.html";
						if(file_exists($template_file_subject)) {
							$template_content_subject = file_get_contents($template_file_subject); ?>
							<span class="me-2"><span class="text-muted me-1">subject:</span> <?php echo $template_file_subject ?></span>
						<?php }	?>
						<?php
						$template_file = "../email-templates/{$template['userType']}/{$template['userType']}_{$template['templateType']}.html";
						$template_content = file_get_contents($template_file);
						?>
						<span><span class="text-muted me-1">message:</span> <?php echo $template_file ?></span>
					</div>
					<?php if(!empty($template['vars'])) { ?>
					<div class="mb-3">
						<div>Variablen</div>
						<div class="ftsz-1">
						<?php foreach($template['vars'] as $key => $value) { ?>
						<div>
							<div class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1 mb-3 d-inline-block me-2">
							<?php echo $value ?>
							</div>
							<div class="d-inline-block">
							<?php echo $key ?>
							</div>
						</div>
						<?php } ?>
						</div>
					</div>
					<?php } ?>
					<?php if(file_exists($template_file_subject)) { ?>
					<div class="mb-3">
						<label class="form-label">Betreff</label>
						<input 
							class="form-control" 
							type="text" 
							name="subject" 
							data-user-type="<?= $template['userType'] ?>" 
							data-template-type="<?= $template['templateType'] ?>" 
							value="<?php echo htmlspecialchars($template_content_subject) ?>"
						>
					</div>
					<?php } ?>
					<div class="mb-3">
						<label class="form-label">Nachricht</label>
						<textarea class="form-control mb-3" data-user-type="<?= $template['userType'] ?>" data-template-type="<?= $template['templateType'] ?>" rows="<?= $template['rows'] ?>"><?= $template_content ?></textarea>
					</div>
					<button class="custom-btn <?php echo BTN_OUTLINE_PRIMARY ?>" data-user-type="<?= $template['userType'] ?>" data-template-type="<?= $template['templateType'] ?>">Template speichern</button>
				</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
			<script>
				$('button[data-template-type]').click(function() {
					var userType = $(this).data('user-type');
					var templateType = $(this).data('template-type');
					var newTemplateContent = $('textarea[data-user-type="' + userType + '"][data-template-type="' + templateType + '"]').val();
					var newTemplateSubject = $('input[data-user-type="' + userType + '"][data-template-type="' + templateType + '"]').val();
					saveTemplate(userType, templateType, newTemplateContent, newTemplateSubject);
				});

				function saveTemplate(userType, templateType, newTemplateContent, newTemplateSubject) {
					$.ajax({
						url: 'pages/mail-templates/save_template.php',
						method: 'POST',
						data: {
							userType: userType,
							templateType: templateType,
							templateContent: newTemplateContent,
							templateSubject: newTemplateSubject
						},
						success: function(response) {
							alert(response);
						}
					});
				}
			</script>
		</div>
		<div class="col-12 ftsz-1 mb-3">
			<h5 class="mb-1">Variablen</h6>
			<p class="ftsz-0875">Variablen, welche in Textblöcken verwendet werden können.</p>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{user}</span> - E-Mail-Adresse des Benutzers<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{account_url}</span> - Link zum Konto<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{entry_id}</span> - ID des Antrages<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{entry_number}</span> - Nummer des Antrages<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{insured_person_first_name}</span> - Vorname des Versicherten<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{insured_person_last_name}</span> - Nachname des Versicherten<br>
			<span class="bg-dark text-white d-inline-block ftsz-0875 px-2 py-1 mb-1">{insured_person_salutation_full_salutation}</span> - Anrede inkl. Vorname und Nachname des Versicherten (z. B. Sehr geehrter Herr Max Mustermann)<br>
		</div>
	</div>
</div>
