<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
protetta_session_start();
$key = $_GET['Key'];
$data = $_GET['Data'];
$utente = Utente::elementWithKey($key, $mysqli);

$d = substr($data, 6,2) . "-" . substr($data, 4,2) . "-" . substr($data, 0,4);

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
<body>
   <div class="container">
		<div class="row">
			<div class="col">
                <span class="new" onclick="nuovaRegistrazione('<?php echo $key.chr(22).$data;?>')">+</span>
            </div>
		</div>		
        <div class="row">
            <div class="col">
                <h3><?php echo $utente->getNomeCompleto() . " " . $d; ?></h3>
            </div>            
        </div>
        <div class="row">
            <div class="col">
                <!-- SCRIVERE I RECORD DELL'ENTRATE E DELLE USCITE -->
                <?php 
                echo $utente->getListaEntrateUscite($data, $mysqli, $key.chr(22).$data);
                ?>
            </div>            
        </div>
   </div>
</body>

<script type="text/javascript">
	function nuovaRegistrazione(key){
		window.open('NuovoDettaglioOre.php?Key='+key,'Nuovo dettaglio ore', 'width=400px,height=330px');
	}
	function cancellaRegistrazione(key){
		var c = window.confirm("Sei sicuro di voler cancellare la timbratura?");
		if(c)
			window.open('CancellaRegistrazione.php?Key='+key,'Cancellazione', 'width=400px,height=330px');
	}
</script>

</html>