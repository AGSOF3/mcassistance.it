<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/azienda/Azienda.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";

protetta_session_start();
$key = $_GET['Key'];
$mode = $_GET['Mode'];
$azienda = Azienda::elementWithKey($key, $mysqli);

$IdAzienda = $azienda != null ? $azienda->getIdAzienda() : "";
$Descrizione = $azienda != null ? $azienda->getDescrizione() : "";
$CodiceAziendaEsterno = $azienda != null ? $azienda->getCodiceAziendaEsterno() : "";
$SitoWeb = $azienda != null ? $azienda->getSitoWeb() : "";

?>	

<html>
<head>

<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicons -->
<link href="<?php echo $_SESSION['webAppPath']?>/assets/img/favicon.png"
	rel="icon">
<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/img/apple-touch-icon.jpg"
	rel="apple-touch-icon">

<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">

<link rel="stylesheet"
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/styleFormsManut.css">

</head>
<body>
	<form action="AziendaFormAA.php" method="POST" target="actionsFrame">
		<input type="hidden" name="Key" value="<?php echo $key;?>">
		<input type="hidden" name="Mode" value="<?php echo $mode;?>">
		<div class="container-fluid">
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/websrc/it/base/forms/toolBarForms.php"; ?>
		<hr>
			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Codice azienda</label>
				</div>
				<div class="col-sm">
					<input type="text" name="IdAzienda" id="IdAzienda"
						value="<?php echo $IdAzienda ?>" <?php if($mode=="UPDATE")echo "readOnly"; ?> >
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Descrizione</label>
				</div>
				<div class="col-sm">
					<input type="text" name="Descrizione" id="Descrizione"
						value="<?php echo $Descrizione ?>">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Codice esterno</label>
				</div>
				<div class="col-sm">
					<input type="text" name="CodiceAziendaEsterno"
						id="CodiceAziendaEsterno"
						value="<?php echo $CodiceAziendaEsterno ?>">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Sito web</label>
				</div>
				<div class="col-sm">
					<input type="text" name="SitoWeb" id="SitoWeb"
						value="<?php echo $SitoWeb ?>">
				</div>
			</div>
		</div>
	</form>
	
	<iframe frameborder="0" id="actionsFrame" name="actionsFrame" src="">
	</iframe>
</body>
</html>