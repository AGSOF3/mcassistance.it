<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/azienda/Azienda.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utility/KeyHelper.php";
protetta_session_start(); // avvio un SessioneProtetta
$utente = Utente::elementWithKey($_SESSION['IdAzienda'] . KeyHelper::KEY_SEPARATOR. $_SESSION['IdUtente'], $mysqli);
$azienda = Azienda::elementWithKey($_SESSION['IdAzienda'], $mysqli);
?>
<html>
<head>
<title>CADDIT - <?php echo $azienda->getDescrizione()?></title>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicons -->
<link href="<?php echo $_SESSION['webAppPath']?>/assets/img/favicon.png" rel="icon">
<link href="<?php echo $_SESSION['webAppPath']?>/assets/img/apple-touch-icon.jpg" rel="apple-touch-icon">

<link
	href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
	rel="stylesheet">
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/bootstrap4.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/mainStyle.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/styleTreeMenu.css">
<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/styleFrames.css">
</head>

<body>

	<div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar">
			<div class="p-4 margRight maxHeight">
				<img class="img logo mb-2"
					src="<?php echo $_SESSION['webAppPath']?>/assets/img/azienda<?php echo $_SESSION['IdAzienda']?>.png" />
				<ul class="list-unstyled components mb-5">
				<?php 
				include_once $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/menu/MenuUtente.php"; 
				?>
				</ul>
			</div>
		</nav>

		<!-- Page Content  -->
		<div id="content" class="maxHeight">
			<nav class="navbar navbar-expand navbar-light bg-light">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn btn-primary"
						onclick="toggleSideBar()">
						<i class="fa fa-bars"></i> <span class="sr-only">Toggle Menu</span>
					</button>

					<div
						class="navbar-collapse collapse justify-content-between align-items-center w-100"
						id="collapsingNavbar2">

						<ul class="navbar-nav mx-auto text-md-center text-left">
<!-- 							<li class="nav-item"><a class="nav-link" href="#">Link</a></li> -->
<!-- 							<li class="nav-item"><a class="nav-link" href="#">Link</a></li> -->
<!-- 							<li class="nav-item my-auto"><a -->
<!-- 								class="nav-link navbar-brand mx-0 .d-sm-none .d-md-inline" -->
<!-- 								target="_blank" href="http://www.caddit.it">CADDIT</a></li> -->
<!-- 							<li class="nav-item"><a class="nav-link" href="#">Link</a></li> -->
<!-- 							<li class="nav-item"><a class="nav-link" href="#">Link</a></li> -->
						</ul>
						<ul
							class="nav navbar-nav flex-row justify-content-md-center justify-content-start flex-nowrap">
							<li><a><?php echo $utente->getNomeCompleto()?> </a> <br> <a href="<?php echo $azienda->getSitoWeb() ?>" target="_blank"> <span
									class="labelAzienda"><?php echo $azienda->getAziendaDesc()?></span></a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			
			<iframe class="mainFrame" frameborder="0" name="mainFrame" id="mainFrame" src="<?php echo $_SESSION['webAppPath'] . "/websrc/it/base/home/mainFramePrincipale.php"; ?>">
			</iframe>
			
		</div>
	</div>

	<script
		src="<?php echo $_SESSION['webAppPath']?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script
		src="<?php echo $_SESSION['webAppPath']?>/assets/js/Treemenu.js"></script>
</body>
</html>