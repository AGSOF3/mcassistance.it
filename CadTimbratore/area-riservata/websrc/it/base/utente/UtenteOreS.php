<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
protetta_session_start();
$key = $_GET['Key'];
$utente = Utente::elementWithKey($key, $mysqli);
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
<body onLoad="UtenteOreOL()">

	<div class="center">
		<form action="ExcelOre.php" method="GET">

			<input type="hidden" id="thKey" name="thKey"
				value="<?php echo $key; ?>">
			<input type="hidden" name="MODE"
				value="SINGLE">


<?php
if (isset($_GET['prm'])) {
    $mese = strip_tags($_GET['prm']) + strip_tags($_GET['chm']);
} else {
    $mese = date("m");
}
$adj = "";
$d = date("d");
$y = date("Y");
$nd = date('t', mktime(0, 0, 0, $mese, 1, $y));
$mn = date('n', mktime(0, 0, 0, $mese, 1, $y));
$yn = date('Y', mktime(0, 0, 0, $mese, 1, $y));
$j = date('w', mktime(0, 0, 0, $mese, 1, $y)) - 1;
if ($j == "-1") {
    $j = "6";
}
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
for ($k = 1; $k <= $j; $k ++) {
    $adj .= "<td class='giorni'></td>";
}
?>

					<input type="hidden" name="mese" value="<?php echo $mn;?>"> <input
				type="hidden" name="anno" value="<?php echo $yn;?>">
				<input type="hidden" name="meseEsteso" value="<?php echo $MONTHS[$mn];?>">
			<table class="tableCal" cellspacing="5rem">
				<tr>
					<th class="Utente" colspan="7">
                                
                                <?php echo $utente->getNomeCompleto() ?>

                            </th>
				</tr>
				<tr class="rowMese">
					<td class='mesi'><a
						href="?Key=<?php echo $key?>&prm=<?php echo $mese ?>&chm=-1"><</a>
					</td>
					<td colspan="5" class='mesi'>
                         		<?php echo $MONTHS[$mn]." ".$yn ?>
                            </td>
					<td class='mesi'><a
						href="?Key=<?php echo $key?>&prm=<?php echo $mese ?>&chm=1">></a></td>
				</tr>
				<tr>
					<td class="giornoHead"><strong>Lun</strong></td>
					<td class="giornoHead"><strong>Mar</strong></td>
					<td class="giornoHead"><strong>Mer</strong></td>
					<td class="giornoHead"><strong>Gio</strong></td>
					<td class="giornoHead"><strong>Ven</strong></td>
					<td class="giornoHead"><strong>Sab</strong></td>
					<td class="giornoHead"><strong>Dom</strong></td>
				</tr>
				<tr>
        <?php
        for ($i = 1; $i <= $nd; $i ++) {
            $spanGiorno = "<span class='giorno' >" . $i . "</span>";
            $giorno = strlen($i) == 2 ? $i : "0" . $i;
            $mesef = strlen($mese) == 2 ? $mese : "0" . $mese;
            $data = $y . $mesef . $giorno;
            $oreTot = $utente->getOreLavorateGiorno($data, $mysqli);
            if($oreTot > 0)
                $oreTot = $utente->getOreGiornaliere();
            if ($mese > date("m")) {
                $bg = "";
            } else {
                if (date("m") > $mese || $i <= $d) {

                    if ($oreTot < 8)
                        $bg = " bgRed";
                    elseif ($oreTot == 8)
                        $bg = " bgGreen";
                    else
                        $bg = " bgBlue";
                } else
                    $bg = "";
            }
            $oreTot .= "h";
            $spanOre = "<span class='ore'>" . $oreTot . "</span>";
            echo $adj . "<td class='giorni " . $bg . "' valign='top'>" . $spanGiorno . $spanOre . "</td>";
            $adj = '';
            $j ++;
            if ($j == 7) {
                echo "</tr><tr>";
                $j = 0;
            }
        }
        ?>
       </tr>
			</table>

		</form>
	</div>

	<div id="myModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<iframe class="frameDettaglioOre" src="" name="frameDettaglioOre"
				id="frameDettaglioOre" frameborder="1"> </iframe>
		</div>

	</div>

	<script type="text/javascript" src="UtenteOre.js"></script>
</body>

</html>