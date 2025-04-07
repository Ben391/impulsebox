<div class="container">
	<div class="row py-md-5 py-0 justify-content-center">
		<div class="col-md-7 py-md-5 py-0">
			<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="text-center mb-md-4 mb-3">Vielen Dank für Ihr Vertrauen!</h1>
				<div class="row mb-3">
				<?php 
				$requested_by_post = false;
				foreach ($entry_status_data as $entry) {
					if ($entry['status_id'] == 20) {
						$requested_by_post = true;
						break;
					}
				}
				// wenn per Post angefordert
				if($requested_by_post === true) { ?>
					<div class="">
						<p>Ihr angefragtes Formular wird Ihnen per Post zugesendet.</p>
						<p>So kommen Sie jetzt schnellstmöglich an Ihre Pflegemittel:</p>
						<ol>
							<li class="mb-3">
								Sie erhalten das Formular per Post.
							</li>
							<li class="mb-3">
								Nachdem Sie das von Ihnen ausgefüllte Formular bekommen haben, müssen sie es nur noch unterschreiben.
							</li>
							<li class="mb-3">
								Anschließend können Sie es portofrei mittels einer kostenlosen Rücksendeantwort an uns zurücksenden.
							</li>
							<li class="mb-3">
								Sobald das Bestellformular bei uns eingegangen ist, leiten wir die weiteren Schritte bei Ihrer Pflegekasse für Sie ein – Sie brauchen sich um nichts weiter zu kümmern.
							</li>
							<li class="mb-3">
								Nach Genehmigung der Pflegekasse erhalten Sie monatlich Ihre <?php echo $company["servicename"] ?> kostenfrei direkt nach Hause geschickt.
							</li>
						</ol>
					</div>
				<?php } else { ?>
					<div class="">
					<?php // falls gesetzlich
					if($insurance_type == 1) { ?>
					<p>Ihr Antrag wird derzeit bearbeitet und in Kürze an die Pflegekasse weitergeleitet.</p>
					<p>Nach Genehmigung der Pflegekasse erhalten Sie monatlich Ihre <?php echo $company["servicename"] ?> kostenfrei direkt nach Hause.</p>

					<p>
						Für Ihre Unterlagen können Sie Ihr vollständig ausgefülltes Formular entweder in Ihrem <a href="<?php echo BASEHREF ?>konto/">Konto</a> oder unter dem folgenden Link abrufen: <a target="_blank" href="<?php echo BASEHREF ?>inc/show.php?file_id=<?php echo $entry_id ?>">Formular ansehen</a>
					</p>
						
					<?php } elseif($insurance_type == 2) { ?>
						
					<p>
						Ihr Antrag wird derzeit bearbeitet und in Kürze an die Pflegekasse weitergeleitet.
					</p>
					<p>
						Der Privatversicherte erhält einige Wochen nach Erhalt der Lieferung eine Rechnung, die nach Begleichen wie gewohnt bei der zuständigen Kasse eingereicht werden kann. Nach § 40 Abs. 2 SGB XI besteht Anspruch auf volle Rückerstattung.
						</p>
						
					<p class="mb-4">
						In Ihrem Konto können Sie Ihre angegebenen Daten abrufen.
					</p>
						
					<?php } ?>
					</div>
				<?php } ?>
				</div>
				<div class="row justify-content-center">
					<?php // falls gesetzlich (bei privaten wird kein pdf generiert)
					if($insurance_type == 1) {
						if(!empty($entry_data["entry_data"]["entry_number"])) {
							$pdf_file_name = $_SERVER['DOCUMENT_ROOT'] . "/pdf/" . $entry_data["entry_data"]["entry_number"] . ".pdf";
							if(file_exists($pdf_file_name)) { ?>
								<div class="col text-center">
									<a class="custom-btn custom-btn-md <?php echo BTN_PRIMARY ?> w-100" target="_blank" href="<?php echo BASEHREF ?>inc/show.php?file_id=<?php echo $entry_id ?>">
										<i class="fa-regular fa-file-pdf fa-lg me-3"></i>
										Formular ansehen
									</a>
								</div>
							<?php }
					}} ?>
					<div class="col text-center">
						<a class="custom-btn custom-btn-md <?php echo BTN_GRADIENT ?> w-100" href="<?php echo BASEHREF ?>konto/">
							<i class="fa-regular fa-user fa-lg me-3"></i>
							Zum Konto
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>