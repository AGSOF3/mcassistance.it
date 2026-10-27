<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
protetta_session_start(); // avvio un SessioneProtetta
?>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link
	href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
	rel="stylesheet">
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/bootstrap4.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/mainStyle.css">
</head>

<body>

	<div class="container-fluid">


		<div class="row justify-content-center text-center">
			<div class="col-4">
				<h1>CADDIT</h1>
			</div>
		</div>
		<div class="row justify-content-center text-center">
			<div class="col-4">
				<h6>Versione beta</h6>
			</div>
		</div>



	</div>

</body>

</html>