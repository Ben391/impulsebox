<div class="container">
	<div class="row">
		<div class="col-md-7 px-md-2 px-1 mb-3">
			<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
				<h1 class="h2 mb-md-4 mb-2">Zusammenfassung</h1>
				<?php 
				include_once "views/account-data.php";
				include_once "views/insured-person-data.php";
				include_once "views/consultation-data.php";
				include_once "views/delivery-data.php";
				include_once "views/care-giver-person-data.php";
				include_once "views/care-giver-service-data.php";
				if(!isLoggedInAsAdmin()) {
					include_once "pages/application/summary/inc/submit.php";
				}
				?>
			</div>
		</div>
		<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first">
			<?php include_once "views/your-box.php" ?>
		</div>
	</div>
</div>