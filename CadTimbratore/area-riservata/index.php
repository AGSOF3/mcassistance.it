<?php
include 'src/it/caddit/base/azienda/Azienda.php';
include "src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include "src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include "src/it/caddit/base/login/login.php";
protetta_session_start(); // avvio un SessioneProtetta
$Aziende = Azienda::retrieveList($mysqli);
foreach ($Aziende as $azienda) {
    $idAzienda = $azienda->getIdAzienda();
    if (isset($_POST['sendLogin'.$idAzienda])) {
        if (login($idAzienda, $_POST['UserAreaRiservata'.$idAzienda], $_POST['PasswordAreaRiservata'.$idAzienda], $mysqli)) {
            $_SESSION['IdAzienda'] = $idAzienda;
            $_SESSION['webAppPath'] = "\CadTimbratore/area-riservata";
            header("location: websrc/it/base/home/home.php"); // Redirect alla pagina home.php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>Timbratore</title>
<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- CSS Files -->
<link href="assets/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">
<link href="assets/css/styleAreaRiservata.css" rel="stylesheet">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script	src="assets/js/AreaRiservata.js"></script>

</head>
<body>

<?php
$Aziende = Azienda::retrieveList($mysqli);
$classeCard = "cAperta";
$displayContent = "block";
foreach ($Aziende as $azienda) {
    $idAzienda = $azienda->getIdAzienda();
    ?>
	<div id="card<?php echo $azienda->getIdAzienda()?>" class="ccard <?php echo $classeCard?>">
		<div id="card-header" onclick="mostraNascondiCard(card<?php echo $azienda->getIdAzienda()?>)">
			<label class="titleCard"><?php echo $azienda->getDescrizione() ?></label>
		</div>
		<div id="card-content" style="display: <?php echo $displayContent ?>">
			<div id="card-title">
				<img src="assets/img/azienda<?php echo $idAzienda?>.png" class="logoLogin">
			</div>
			<form action="" method="POST" class="form">
				<label for="user-email" style="padding-top: 13px" class="labelInput"> Username </label>
				<input type="text" name="UserAreaRiservata<?php echo $idAzienda?>" id="UserAreaRiservata<?php echo $idAzienda?>"
					class="form-content" required />
				<div class="form-border"></div>
				<label for="user-password" style="padding-top: 22px" class="labelInput">Password</label>
				<input type="password" name="PasswordAreaRiservata<?php echo $idAzienda?>"
					id="PasswordAreaRiservata<?php echo $idAzienda?>" class="form-content" required />
				<div class="form-border"></div>
				<!-- <a href="#">
				<legend id="forgot-pass">Forgot password?</legend>
				</a> -->
				<input class="submit-btn" type="submit" name="sendLogin<?php echo $idAzienda?>" value="ACCEDI" />
				<!-- <a href="#" id="signup">Don't have account yet?</a> -->
			</form>
		</div>
	</div>
<?php
$classeCard = "cChiusa";
$displayContent = "none";
}
?>

</body>
</html>

