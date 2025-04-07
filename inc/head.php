<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page_title . " - " . $company["servicename"] ?></title>
	<base href="<?php echo BASEHREF ?>">
	<meta http-equiv="content-language" content="de">
	<meta name="robots" content="<?php echo $meta_robots ?>">
	<meta name="description" content="<?php echo $page_meta_description ?>">
	<!--<link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASEHREF ?>img/favicon/apple-touch-icon.png">-->
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASEHREF ?>img/favicon/favicon-32.png">
	<!--<link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASEHREF ?>img/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?php echo BASEHREF ?>img/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?php echo BASEHREF ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5">-->
	<script src="<?php echo BASEHREF ?>js/jquery-3.7.1.min.js"></script>
	<link href="<?php echo BASEHREF ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo BASEHREF ?>js/bootstrap.bundle.min.js"></script>
	<link href="<?php echo BASEHREF ?>css/style.css?v55" rel="stylesheet" type="text/css">
	<link href="<?php echo BASEHREF ?>css/impulse.css?v25" rel="stylesheet" type="text/css">
	<link href="<?php echo BASEHREF ?>css/buttons-main.css?v11" rel="stylesheet" type="text/css">
	<link href="<?php echo BASEHREF ?>css/buttons.css?v12" rel="stylesheet" type="text/css">
	<?php if($current_page == "versichertendaten") { ?>
		<link rel="stylesheet" href="<?php echo BASEHREF ?>css/select2.min.css" />
		<link rel="stylesheet" href="<?php echo BASEHREF ?>css/select2-bootstrap-5-theme.min.css" />
		<script src="<?php echo BASEHREF ?>js/select2.full.min.js"></script>
	<?php } ?>
	<?php if($current_page == "unterschrift") { ?>
		<link rel="stylesheet" href="<?php echo BASEHREF ?>css/smoothness_jquery-ui.css">
		<script src="<?php echo BASEHREF ?>js/jquery-ui.min.js"></script>
		<link type="text/css" href="<?php echo BASEHREF ?>css/jquery.signature.css" rel="stylesheet">
		<script type="text/javascript" src="<?php echo BASEHREF ?>js/jquery.signature.min.js"></script>
	<?php } ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>