<div class="row border-bottom mb-4">
	<div class="col">
		<div class="row">
			<h2 class="h3 mb-3">Beratung</h2>
			<?php if(isset($consultation_status)) { ?>
				<div class="mb-3">
				<?php if($consultation_status == 0) { ?>
					<p class="mb-0">Ich bin ausreichend über die Produkte, deren Anwendung und den Zweck der Pflegehilfsmittel zum Verbrauch informiert und möchte keine zusätzliche Beratung wahrnehmen.</p>
				<?php } elseif($consultation_status == 1) { ?>
					<p class="mb-1">
					Ich wurde vor der Übergabe des Pflegehilfsmittels/der Pflegehilfsmittel von <?php echo $company["servicename"] ?> (<?php echo $company["company"] ?>) umfassend beraten, insbesondere darüber</p>
					<ul>
						<li>welche Produkte und Versorgungsmöglichkeiten für meine konkrete Versorgungssituation geeignet und notwendig sind,</li>
						<li>die ich ohne Mehrkosten erhalten kann.</li>
					</ul>
					<h2 class="h5">Form des Beratungsgesprächs</h2>
					<ul>
					<?php 
					if(in_array('1', explode(',', $consultation_form))) { ?>
						<li>Beratung in den Geschäftsräumen</li>
					<?php }
						if(in_array('2', explode(',', $consultation_form))) { ?>
						<li>Individuelle telefonische oder digitale Beratung (z. B. Videochat)</li>
					<?php }
						if(in_array('3', explode(',', $consultation_form))) { ?>
						<li>Beratung in der Häuslichkeit</li>
					<?php } ?>
					</ul>
					<div class="mb-3">
						<h2 class="h5"><?php echo $company["servicename"] ?> (<?php echo $company["company"] ?>) hat </h2>
						<ul class="mb-0">
						<?php 
						if(in_array('1', explode(',', $consultation_partner))) { ?>
							<li>mich persönlich</li>
						<?php }
							if(in_array('2', explode(',', $consultation_partner))) { ?>
							<li>meine Betreuungsperson (ges. Vertreter/Bevollmächtigten oder Angehörigen)</li>
						<?php } ?>
						</ul>
						<div class="h5">beraten.</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<h2 class="h5">Beratende/r Mitarbeiter/in</h2>
							<div><?php echo $consultation_consultant ?></div>
						</div>
						<div class="col-md-4">
							<h2 class="h5">Datum der Beratung</h2>
							<div><?php echo $consultation_date_formatted ?></div>
						</div>
					</div>
				<?php } ?>
				</div>
			<?php } ?>
		</div>
		<?php if($current_page != "konto") { ?>
		<div class="row mb-3">
			<div class="col mb-3">
				<a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY ?>" href="<?php echo BASEHREF ?>beratung/<?php echo $admin_url_addition ?>">Ändern</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
