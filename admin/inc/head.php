<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administration - <?php echo $company["servicename"] ?></title>
	<base href="<?php echo ADMIN_BASEHREF ?>">
	<meta name="robots" content="noindex,nofollow">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASEHREF ?>img/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASEHREF ?>img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASEHREF ?>img/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?php echo BASEHREF ?>img/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?php echo BASEHREF ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo BASEHREF ?>js/bootstrap.bundle.min.js"></script>
	<link href="css/style.css?v2" rel="stylesheet" type="text/css">
	<link href="../css/style.css?v3" rel="stylesheet" type="text/css">
	<link href="../css/buttons-main.css?v2" rel="stylesheet" type="text/css">
	<link href="../css/buttons.css?v2" rel="stylesheet" type="text/css">
	<link href="../css/impulse.css?v2" rel="stylesheet" type="text/css">
	<link href="<?php echo BASEHREF ?>css/evs.css?v25" rel="stylesheet" type="text/css">
	<?php if($current_page == "import") { ?>
		<link rel="stylesheet" href="<?php echo BASEHREF ?>css/select2.min.css" />
		<link rel="stylesheet" href="<?php echo BASEHREF ?>css/select2-bootstrap-5-theme.min.css" />
		<script src="<?php echo BASEHREF ?>js/select2.full.min.js"></script>
	<?php } ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<?php if($current_page == "products" OR $current_page == "compilations") { ?>
	<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
	<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
	<script src="https://unpkg.com/cropperjs"></script>
	<?php } ?>
</head>
