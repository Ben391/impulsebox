<?php if(isset($_GET["antrag"]) AND !empty($_GET["antrag"])) { ?>
<div class="row pb-5">
	<div class="col-md-7 px-md-2 px-1 mb-3">
		<div class="p-md-4 p-3 mb-3 bg-light-grey rounded-4">
		<?php 
		include_once "pages/account/inc/change-password.php";
		include_once "views/entry-status.php";
		include_once "views/application-number-pdf.php";
		include_once "views/insured-person-data.php";
		include_once "views/delivery-data.php";
		include_once "views/care-giver-person-data.php";
		include_once "views/care-giver-service-data.php";
		?>
		</div>
	</div>
	<div class="col-md-5 px-md-2 px-1 mb-md-3 mb-2 order-md-last order-first"><?php include_once "views/your-box.php"; ?></div>
</div>
<?php } else { ?>
<div class="row pb-5">
	<div class="col-12">
	<h2 class="h4">Entries</h2>
	<?php $where = " e.user_id = ".$user_id;
	if($total_entries = getTotalEntries($mysqli, $where)) {
		$entries_per_page = 10;
		$total_pages = ceil($total_entries / $entries_per_page);
		$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
		$offset = ($p - 1) * $entries_per_page;
		$keyword = "";
		if(isset($_GET["keyword"]) AND !empty($_GET["keyword"])) {
			$keyword = trim($_GET["keyword"]);
		}
		if($entries = getEntries($mysqli, $where, $entries_per_page, $offset, $keyword)) { ?>
			<table class="table">
			<?php foreach($entries AS $e) { ?>
				<tr>
					<td>
						<a href="<?php echo BASEHREF ?>konto/?antrag=<?php echo $e["entry_id"] ?>"><?php echo $e["entry_id"] ?></a>
					</td>
					<td>

					</td>
				</tr>
			<?php } ?>
			</table>
		<?php } else {
			echo "no";
		}
	} else { echo "no entries"; } ?>
	</div>
</div>	
<?php } ?>