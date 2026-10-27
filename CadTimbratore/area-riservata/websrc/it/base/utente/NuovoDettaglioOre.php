<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
protetta_session_start();
$key = $_GET['Key'];
$IdAzienda = explode(chr(22), $key)[0];
$IdUtente = explode(chr(22), $key)[1];
$data = explode(chr(22), $key)[2];

$keyUtente = $IdAzienda . chr(22) . $IdUtente;
$utente = Utente::elementWithKey($keyUtente, $mysqli);

$d = substr($data, 6, 2) . "-" . substr($data, 4, 2) . "-" . substr($data, 0, 4);

if (isset($_POST['action'])) {
    $OraArrivo = $_POST['OraArrivo'];
    $OraUscita = $_POST['OraUscita'] != null ? $_POST['OraUscita'] : "NULL";
    $OreTotali = $_POST['OreTotali'] != null ? $_POST['OreTotali'] : "NULL";
    if($OraUscita != "NULL")
        $insert = "INSERT INTO timbrature VALUES " . " ('" . $IdAzienda . "','" . $IdUtente . "','" . $data . "','" . $OraArrivo . "', " . " '" . $OraArrivo . "','" . $OraUscita . "','" . $OraUscita . "','" . $OreTotali . "' )";
    else
        $insert = "INSERT INTO timbrature VALUES " . " ('" . $IdAzienda . "','" . $IdUtente . "','" . $data . "','" . $OraArrivo . "', " . " '" . $OraArrivo . "',NULL,NULL,NULL )";
    $mysqli->autocommit(FALSE);
    $mysqli->query($insert);
    if ($mysqli->affected_rows == 1) {
        $mysqli->commit();
        echo "<script>opener.location.reload();window.close();</script>";
    } else {
        echo "<script>window.alert('Problema nel salvataggio: " . str_replace("'", "", str_replace("\"", "", $mysqli->error)) . "');window.close();</script>";
        $mysqli->rollback();
    }
}

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

<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/styleDettaglioOre.css"
	rel="stylesheet">

</head>
<body style="background: #e8e8e8;">
	<form action="" method="POST">
		<div class="container">
			<div class="row">
				<div class="col">
					<h3><?php echo $utente->getNomeCompleto() . " " . $d; ?></h3>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Ora arrivo</label>
				</div>
				<div class="col-sm">
					<input type="time" name="OraArrivo" id="OraArrivo" required>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Ora uscita</label>
				</div>
				<div class="col-sm">
					<input type="time" name="OraUscita" id="OraUscita" onblur="calcoloOre()">
				</div>
			</div>

			<div class="row mt-3">
				<div class="col-sm-2">
					<label>Ore totali</label>
				</div>
				<div class="col-sm">
					<input type="number" name="OreTotali" id="OreTotali" step="0.1">
				</div>
			</div>

			<div class="btn-toolbar mt-2 sticky-top" role="toolbar"
				aria-label="Toolbar with button groups">
				<div class="btn-group mr-3" role="group" aria-label="Second group">
					<button class="btn btn-secondary" name="action" value="SAVE_CLOSE">Salva
						e chiudi</button>
				</div>
			</div>
		</div>
	</form>
	<script>
		function calcoloOre(){
			let oraArrivo = document.getElementById('OraArrivo').value;
			let oraUscita = document.getElementById('OraUscita').value;
			var hArr = new Date("01/01/2007 " + oraArrivo).getHours();
			var hUsc = new Date("01/01/2007 " + oraUscita).getHours();
			var mArr = new Date("01/01/2007 " + oraArrivo).getMinutes();
			var mUsc = new Date("01/01/2007 " + oraUscita).getMinutes();
			
			if(mArr >= 15 && mArr < 45)
				hArr = hArr + 0.5;
		 	if(mArr >= 45)
			 	hArr = hArr + 1;

		 	if(mUsc >= 15 && mUsc < 45)
				hUsc = hUsc + 0.5;
		 	if(mUsc >= 45)
		 		hUsc = hUsc + 1;

			var diff = hUsc - hArr;
			document.getElementById('OreTotali').value = diff;
		}
	</script>
</body>

</html>