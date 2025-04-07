<section id="faq" class="container-fluid border-bottom px-0 py-xxl-5 py-0">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h2 class="px-2 mb-5">Antworten auf häufig gestellte Fragen</h2>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-10 mb-3">
				<div class="bg-light-grey rounded-4 p-md-5 p-2 h-100">
					<div class="accordion accordion-flush" id="accordionFlush">
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading1">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapseOne">
								Was ist eine <?php echo $company["servicename"] ?>?
								</button>
							</h2>
							<div id="flush-collapse1" class="accordion-collapse collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Eine <?php echo $company["servicename"] ?> enthält eine Auswahl an Pflegehilfsmitteln, die einem Pflegebedürftigen mit anerkanntem Pflegegrad in der häuslichen Pflege per Gesetz kostenlos zustehen.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading2">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
								Kann ich mir eine <?php echo $company["servicename"] ?> individuell zusammenstellen?
								</button>
							</h2>
							<div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Ja, bei uns haben Sie die Möglichkeit Ihre <?php echo $company["servicename"] ?> individuell zusammenzustellen.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading3">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
								Wie ist der Ablauf der Beantragung einer <?php echo $company["servicename"] ?>, wenn ich privat versichert bin?
								</button>
							</h2>
							<div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Als Privatversicherter haben Sie entsprechend Ihrer Vertragsgestaltung die Möglichkeit, Kosten für Pflegehilfsmittel gegenüber Ihrer Krankenkasse geltend zu machen.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading4">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">
								Wie lange dauert die Zustellung meiner <?php echo $company["servicename"] ?>?
								</button>
							</h2>
							<div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Die Lieferzeit hängt davon ab, wie schnell Ihre Pflegekasse die Genehmigung erteilt. Sie erhalten genauso wie wir eine Rückmeldung von deiner Pflegekasse zu dem Antrag auf Pflegehilfsmittel. Dies kann in seltenen Fällen bis zu sechs Wochen dauern. Sobald die Pflegekasse Ihren Antrag auf Pflegehilfsmittel genehmigt hat, senden wir Ihre <?php echo $company["servicename"] ?> schnellstmöglich per Paketdienst zu Ihrem Wunschort. </div>
							</div>
						</div>
						<?php if (isset($products) && !empty($products)) { ?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading5">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse5" aria-expanded="false" aria-controls="flush-collapse5">
								Welche Pflegehilfsmittel stehen mir zur Verfügung?
								</button>
							</h2>
							<div id="flush-collapse5" class="accordion-collapse collapse" aria-labelledby="flush-heading5" data-bs-parent="#accordionFlush">
								<div class="accordion-body">
									In der <?php echo $company["servicename"] ?> stehen Ihnen 
									<?php
									$totalProducts = count($products);
									$currentIndex = 0;
									foreach ($products as $product) {
										echo $product["name"];
										$currentIndex++;
										if ($currentIndex < $totalProducts) {
											echo ", ";
										}
									}
									?> 
									als Pflegehilfsmittel zur Auswahl.
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading6">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse6" aria-expanded="false" aria-controls="flush-collapse6">
								Wie viele Pflegehilfsmittel kann ich mir aussuchen?
								</button>
							</h2>
							<div id="flush-collapse6" class="accordion-collapse collapse" aria-labelledby="flush-heading6" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Bei der Auswahl Ihrer erstattungsfähigen Pflegehilfsmittel kommt es nicht auf die Menge, sondern den Preis an. Sie können Pflegehilfsmittel im Wert von 40,- EUR im Monat auswählen. Diese Kosten trägt Ihre Pflegekasse.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading7">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse7" aria-expanded="false" aria-controls="flush-collapse7">
								Wie viele waschbare Bettschutzeinlagen stehen mir zu?
								</button>
							</h2>
							<div id="flush-collapse7" class="accordion-collapse collapse" aria-labelledby="flush-heading7" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Ihnen stehen kostenlos pro Halbjahr bis zu zwei wiederverwendbare Bettschutzeinlagen zu. Diese können Sie ganz einfach im Antragsprozess Ihrer <?php echo $company["servicename"] ?> hinzubuchen.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading8">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse8" aria-expanded="false" aria-controls="flush-collapse8">
								Kann ich die Pflegehilfsmittel monatlich ändern?
								</button>
							</h2>
							<div id="flush-collapse8" class="accordion-collapse collapse" aria-labelledby="flush-heading8" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Ja, Sie können den Inhalt Ihrer <?php echo $company["servicename"] ?> monatlich anpassen. Rufen Sie uns dazu einfach an oder schicken uns eine E-Mail mit Angabe deiner Kundennummer.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading9">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse9" aria-expanded="false" aria-controls="flush-collapse9">
								Wer verschreibt Pflegehilfsmittel?
								</button>
							</h2>
							<div id="flush-collapse9" class="accordion-collapse collapse" aria-labelledby="flush-heading9" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Pflegehilfsmittel müssen nicht verschrieben werden. Sie benötigen daher kein Rezept Ihres Arztes. Jeder Pflegebedürftige mit anerkanntem Pflegegrad hat in der häuslichen Pflege einen gesetzlichen Anspruch auf kostenlose Pflegehilfsmittel im Wert von 40,- EUR monatlich.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading10">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse10" aria-expanded="false" aria-controls="flush-collapse10">
								Wer kann Pflegehilfsmittel beantragen?
								</button>
							</h2>
							<div id="flush-collapse10" class="accordion-collapse collapse" aria-labelledby="flush-heading10" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Sie können Pflegehilfsmittel im Wert von bis zu 480,- EUR im Jahr beantragen, wenn Sie einen Pflegegrad 1, 2, 3, 4 oder 5 haben und zu Hause oder in einer Wohngemeinschaft leben.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading11">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse11" aria-expanded="false" aria-controls="flush-collapse11">
								Wo kann ich Pflegehilfsmittel beantragen?
								</button>
							</h2>
							<div id="flush-collapse11" class="accordion-collapse collapse" aria-labelledby="flush-heading11" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Ihre Pflegehilfsmittel können Sie ganz einfach über uns beantragen. Entscheiden Sie zunächst, welche Produkte Sie in Ihrer <?php echo $company["servicename"] ?> haben möchten, füllen das Antragsformular aus und senden dieses unterschrieben an uns zurück. Sobald wir Ihren Antrag erhalten haben, kümmern wir uns um die Abwicklung mit Ihrer Pflegekasse. Nach erfolgreicher Genehmigung durch die Pflegekasse versenden wir Ihre persönliche <?php echo $company["servicename"] ?> schnellstmöglich per Paketdienst zum angegebenen Wunschort.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading12">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse12" aria-expanded="false" aria-controls="flush-collapse12">
								Was muss ich tun, wenn ich meine Pflegehilfsmittel bereits über einen anderen Anbieter geliefert bekomme?
								</button>
							</h2>
							<div id="flush-collapse12" class="accordion-collapse collapse" aria-labelledby="flush-heading12" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Wenn Sie bereits Pflegehilfsmittel von einem anderen Anbieter geliefert bekommen, können Sie ganz einfach zu uns wechseln. Wählen Sie hierfür im Bestellprozess „Ich erhalte bereits Pflegehilfsmittel von einem anderen Anbieter“ aus und Sie erhalten von uns die zum Wechsel notwendige Wahlrechtserklärung zusammen mit Ihrem Antrag, entweder zum Herunterladen oder per Post zur Verfügung gestellt. Bitte senden Sie diese einfach zusammen mit deinem Antragsformular unterschrieben an uns zurück – alles Weitere übernehmen wir für Sie.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading13">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse13" aria-expanded="false" aria-controls="flush-collapse13">
								Wer liefert Pflegehilfsmittel?
								</button>
							</h2>
							<div id="flush-collapse13" class="accordion-collapse collapse" aria-labelledby="flush-heading13" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Nach der Beantragung und einer erfolgreichen Genehmigung durch Ihre Pflegekasse liefern wir Ihre <?php echo $company["servicename"] ?> monatlich kostenfrei per Paketversand zu Ihrem Wunschort.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading14">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse14" aria-expanded="false" aria-controls="flush-collapse14">
								Wie werden Pflegehilfsmittel abgerechnet?
								</button>
							</h2>
							<div id="flush-collapse14" class="accordion-collapse collapse" aria-labelledby="flush-heading14" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Wir kümmern uns um die Abrechnung der Pflegehilfsmittel mit Ihrer Pflegekasse.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading15">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse15" aria-expanded="false" aria-controls="flush-collapse15">
								Gibt es eine monatliche Bestellfrist?
								</button>
							</h2>
							<div id="flush-collapse15" class="accordion-collapse collapse" aria-labelledby="flush-heading15" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Nein, es gibt grundsätzlich keine monatliche Bestellfrist. Nach erfolgreicher Genehmigung Ihres Antrags auf Pflegehilfsmittel durch Ihre Pflegekasse beliefern wir Sie automatisch monatlich mit Ihrer gewählten <?php echo $company["servicename"] ?>. Sollten Sie Ihre monatliche Lieferung jedoch anpassen wollen, benötigen wir eine Mitteilung bis spätestens 14 Tage vor Liefertermin.</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading16">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse16" aria-expanded="false" aria-controls="flush-collapse16">
								Wer zahlt die Pflegehilfsmittel?
								</button>
							</h2>
							<div id="flush-collapse16" class="accordion-collapse collapse" aria-labelledby="flush-heading16" data-bs-parent="#accordionFlush">
								<div class="accordion-body">Die Kosten von bis zu 40,- EUR im übernimmt nach erfolgreicher Genehmigung Ihre Pflegekasse.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>