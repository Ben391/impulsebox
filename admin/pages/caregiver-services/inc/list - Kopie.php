<div class="col-md-6 mb-4">
	<h2 class="h4 mb-3">Vorhandene Pflegedienste</h2>
<?php
$where = 'user_id IS NOT NULL AND user_id != ""';					  
if($care_giver_services = getCareGiverServices($mysqli,$where)) { ?>
	<table class="table">
	<?php foreach($care_giver_services AS $care_giver_service) { ?>
		<tr>
			<td>#<?php echo $care_giver_service["id"] ?></td>
			<td>
				<?php echo $care_giver_service["company"] ?><br>
				<?php echo $care_giver_service["street"] ?><br>
				<?php if(!empty($care_giver_service["address_addition"])) echo $care_giver_service["address_addition"] . "<br>" ?>
				<?php echo $care_giver_service["zipcode"] . " " . $care_giver_service["city"] ?><br>
				<?php if(!empty($care_giver_service["phone"])) echo "Tel: " . $care_giver_service["phone"]. "<br>"; ?>
				<?php if(!empty($care_giver_service["email"])) echo "E-Mail: " . $care_giver_service["email"]. "<br>"; ?>
			</td>
		</tr>
	<?php } ?>
	</table>
<?php } ?>
</div>