<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
protetta_session_start();
$mode = $_GET['Mode'];
$MONTHS = array(
    1 => 'Gennaio',
    'Febbraio',
    'Marzo',
    'Aprile',
    'Maggio',
    'Giugno',
    'Luglio',
    'Agosto',
    'Settembre',
    'Ottobre',
    'Novembre',
    'Dicembre'
);
$mese = date("m");
$anno = date("Y");
$stop = true;
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

<link rel="stylesheet" href="style/styleUtenteOre.css">

</head>
<body>

	<div class="center">
		<form action="ExcelOre.php" method="GET">
			<input type="hidden" name="MODE" value="<?php echo $mode;?>">
			<h2>Scegli il mese e l'anno di cui vuoi generare il report:</h2>
			<select name="mese" id="mese">
				<?php
				for ($i = 1; $i <= count($MONTHS); $i ++) {
				    if($i == $mese)
				        $selected = "selected='selected'";
				    else
				        $selected = "";
				    $value = $i;
				    // if(strlen($value) == 1)
				    //     $value = "0".$value;
                    echo "<option value='".$value."' ".$selected." >".$MONTHS[$i]."</option>";   
                }
                ?>
			</select>
			<select name="anno" id="anno">
				<?php 
				    $annoInizio = "2021";
				    for($i=$annoInizio; $i<$anno+10;$i++){
				        if($i == $anno)
				            $selected = "selected='selected'";
			            else
			                $selected = "";
		                echo "<option value='".$i."' ".$selected." >".$i."</option>";   
				    }
				?>
			</select>
			<button class="btn">VAI</button>
			<button type="button" class="btn" onclick="resetMese()">RESET MESE</button>		
		</form>
	</div>
	<script>
		function resetMese(){
			let mese = document.getElementById('mese').value;
			let anno = document.getElementById('anno').value;
			let c = window.confirm('Procedere con il reset di '+mese+"-"+anno+"?");
			if(c){
    			let url = "ResetMese.php?mese="+mese+"&anno="+anno;
    			window.location = url;
			}
		}
	</script>
</body>
</html>