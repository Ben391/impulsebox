<style>
	#application-progress-bar{
		font-size: 0.875rem;
	}
	.application-progress-bar-circle-last::after{
		content: none;
		position: static;
		top: auto;
		left: auto;
		height: auto;
		background: none;
		width: auto;
		z-index: auto;
	}
	@media (min-width: 768px) {
		#application-progress-bar{
			
		}
		.application-progress-bar-circle{
			width: 36px;
			height: 36px;
			border-width: 3px;
		}
		.application-progress-bar-circle::after{
			width: 500%;
			height: 4px;
		}
	}
</style>
<div id="application-progress-bar" class="container mb-xxl-2 mb-1">
	<div class="row d-flex justify-content-center text-center py-xxl-3 py-1">
		<a href="<?php echo BASEHREF ?>auswahl/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if($current_page == "auswahl") echo "application-progress-bar-point-active "; if(isset($_SESSION["product_data"]) OR isset($entry_data["product_data"])) echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle shadow-sm mb-1">
				<span>1</span>
			</div>
			<span class="d-md-block d-none">Produkte wählen</span>
		</a>
		<a href="<?php echo BASEHREF ?>versichertendaten/<?php echo $admin_url_addition ?>" class="px-1 col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($_SESSION["product_data"]) AND !isset($entry_data["product_data"])) echo "application-progress-bar-point-disabled "; if($current_page == "versichertendaten") echo "application-progress-bar-point-active "; if(isset($_SESSION["insured_person_data"]) OR isset($entry_data["insured_person_data"])) echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>2</span>
			</div>
			<span class="d-md-block d-none">Versicherter / Pflegebedürftiger</span>
		</a>
		<a href="<?php echo BASEHREF ?>konto-erstellen/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($_SESSION["insured_person_data"]) AND !isset($entry_data["insured_person_data"])) echo "application-progress-bar-point-disabled"; if($current_page == "konto-erstellen") echo "application-progress-bar-point-active "; if(isset($entry_data["user_data"])) echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>3</span>
			</div>
			<span class="d-md-block d-none">Konto erstellen</span>
		</a>
		<a href="<?php echo BASEHREF ?>pflegeperson/<?php echo $admin_url_addition ?>" class="px-1 col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($entry_data)) echo "application-progress-bar-point-disabled"; ?><?php if($current_page == "pflegeperson") echo "application-progress-bar-point-active "; if(isset($care_giver_person_id)) echo "application-progress-bar-point-done "; ?><?php if($user_type == 2 AND !isset($care_giver_person_id)) echo "application-progress-bar-point-required "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>4</span>
			</div>
			<span class="d-md-block d-none">Pflegeperson / Angehöriger</span>
		</a>
		<a href="<?php echo BASEHREF ?>pflegedienst/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($entry_data)) echo "application-progress-bar-point-disabled"; ?><?php if($current_page == "pflegedienst") echo "application-progress-bar-point-active "; if(isset($care_giver_service_id)) echo "application-progress-bar-point-done "; if($user_type == 3 AND !isset($care_giver_service_id)) echo "application-progress-bar-point-required "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>5</span>
			</div>
			<span class="d-md-block d-none">Pflegedienst</span>
		</a>
		<a href="<?php echo BASEHREF ?>beratung/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($entry_data) OR ($user_type == 2 AND !isset($care_giver_person_id)) OR ($user_type == 3 AND !isset($care_giver_service_id))) echo "application-progress-bar-point-disabled "; if($current_page == "beratung") echo "application-progress-bar-point-active "; if(isset($consultation_status)) echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>6</span>
			</div>
			<span class="d-md-block d-none">Beratung</span>
		</a>
		<a href="<?php echo BASEHREF ?>lieferung/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($entry_data) OR ($user_type == 2 AND !isset($care_giver_person_id)) OR ($user_type == 3 AND !isset($care_giver_service_id))) echo "application-progress-bar-point-disabled "; if($current_page == "lieferung") echo "application-progress-bar-point-active "; if(!empty($delivery)) echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle mb-1">
				<span>7</span>
			</div>
			<span class="d-md-block d-none">Lieferung</span>
		</a>
		<a href="<?php echo BASEHREF ?>zusammenfassung/<?php echo $admin_url_addition ?>" class="px-1 col-md col-auto d-flex align-items-center application-progress-bar-point flex-column <?php if(!isset($entry_data) OR empty($delivery) OR !isset($consultation_status)) echo "application-progress-bar-point-disabled"; if($current_page == "zusammenfassung") echo "application-progress-bar-point-active "; if($current_page == "unterschrift" OR $current_page == "per-post-erhalten") echo "application-progress-bar-point-done "; ?>">
			<div class="application-progress-bar-circle application-progress-bar-circle-last mb-1">
				<span>8</span>
			</div>
			<span class="d-md-block d-none">Zusammenfassung</span>
		</a>
	</div>
</div>