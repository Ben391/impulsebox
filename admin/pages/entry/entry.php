<div class="container py-5">
	<div class="row">
		<?php 
		if(isset($_GET["id"])) {
			$entry_id = $_GET["id"];
			$admin_url_addition = "?entry_id=".$entry_id;
			if($e = getEntryData($mysqli,$entry_id)) { 
				//echo "<pre>";print_r($e);echo "</pre>";
				include_once "inc/controller.php"; ?>
				<div class="col-12 mb-md-3 mb-2">
					<h1>Antrag <span class="text-custom-primary"><?php echo $entry_number ?></span> vom <?php echo $entry_create_date_formatted ?></h1>
				</div>
				<div class="col-md-7">
					<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
					<?php
					include_once "../views/entry-status.php";
					include_once "../views/application-number-pdf.php";
					include_once "../views/account-data.php";
					include_once "../views/insured-person-data.php";
					include_once "../views/consultation-data.php";
					include_once "../views/delivery-data.php";
					include_once "../views/care-giver-person-data.php";
					include_once "../views/care-giver-service-data.php";
					?>
					</div>
				</div>
				<div class="col-md-5">
					<?php include_once "../views/your-box.php"; ?>
				</div>
			<?php } ?>
		<?php }	?>
	</div>
</div>