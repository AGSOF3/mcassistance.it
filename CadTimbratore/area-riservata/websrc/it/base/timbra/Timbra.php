<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
protetta_session_start();
$key = $_GET['Key'];
$utente = Utente::elementWithKey($key, $mysqli);//non funziona perche la chiave non ce
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

</head>
<body onLoad="">

		<div class="center">
			<button type="button" onclick="timbra()" style="width: 250px;   height: 50px; color: black;    font-weight: bolder;    font-size: 20;">TIMBRA</button>
			
		</div>
</body>
<script>
	function timbra(){
			window.location = "\\<?php echo $_SESSION['webAppPath']?>/InsertBadgeGet.php?UID=13 11 F8 89&IdAzienda=001";
//		window.alert("<?php echo $_SESSION['webAppPath']?>/InsertBadge.php?UID 13 11 F8 89=&IdAzienda=001");
	}
</script>
</html>