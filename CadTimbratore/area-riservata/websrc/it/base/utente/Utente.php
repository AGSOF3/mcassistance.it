<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";

protetta_session_start();
$key = $_GET['Key'];
$mode = $_GET['Mode'];
$utente = Utente::elementWithKey($key, $mysqli);

$IdAzienda = $_SESSION['IdAzienda'];
$IdUtente = $utente != null ? $utente->getIdUtente() : "";
$Nome = $utente != null ? $utente->getNome() : "";
$Cognome = $utente != null ? $utente->getCognome() : "";
$DtaNascita = $utente != null ? $utente->getDtaNascita() : "";
$UIDTag = $utente != null ? $utente->getUIDTag() : "";
$Matricola = $utente != null ? $utente->getMatricola() : "";
$QRCode = $utente != null ? $utente->getQRCode() : "";
$OreGiornaliere = $utente != null ? $utente->getOreGiornaliere() : "";

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


<link rel="stylesheet" href="style/styleUtente.css">

</head>
<body>
	<form action="UtenteFormAA.php" method="POST" target="actionsFrame">
		<input type="hidden" name="Key" value="<?php echo $key;?>"> <input
			type="hidden" name="IdAzienda" value="<?php echo $IdAzienda;?>"> <input
			type="hidden" name="Mode" value="<?php echo $mode;?>">
		<div class="container-fluid">
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/websrc/it/base/forms/toolBarForms.php"; ?>
		<hr>
			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Codice utente</label>
				</div>
				<div class="col-sm">
					<input type="text" name="IdUtente" id="IdUtente"
						value="<?php echo $IdUtente ?>" readOnly>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Nome</label>
				</div>
				<div class="col-sm">
					<input type="text" name="Nome" id="Nome"
						value="<?php echo $Nome ?>" required>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Cognome</label>
				</div>
				<div class="col-sm">
					<input type="text" name="Cognome" id="Cognome"
						value="<?php echo $Cognome ?>" required>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Data di nascita</label>
				</div>
				<div class="col-sm">
					<input type="text" name="DtaNascita" id="DtaNascita"
						value="<?php echo $DtaNascita ?>">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>UID Tag</label>
				</div>
				<div class="col-sm">
					<input type="text" name="UIDTag" id="UIDTag"
						value="<?php echo $UIDTag ?>">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Matricola</label>
				</div>
				<div class="col-sm">
					<input type="text" name="Matricola" id="Matricola"
						value="<?php echo $Matricola ?>">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>QR Code</label>
				</div>
				<div class="col-sm">
					<input type="text" name="QRCode" id="QRCode"
						value="<?php echo $QRCode ?>">
					<?php 
				if($QRCode != null && $QRCode != ""){
			    ?>
				    <button type="button" onclick="apriQR()">VEDI QR</button>
				<?php
				}
				?>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Ore giornaliere</label>
				</div>
				<div class="col-sm">
					<input type="number" step="1" max="8" name="OreGiornaliere" id="OreGiornaliere"
						value="<?php echo $OreGiornaliere ?>">
				</div>
			</div>
	
	</form>
	<div id="myModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<iframe frameborder="0" id="actionsFrame" class="frameQR" name="actionsFrame" src=""> </iframe>
		</div>
	</div>

	<script type="text/javascript" src="Utente.js"></script>
</body>
</html>