<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/azienda/Azienda.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/excel/SimpleXLSXGen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";

protetta_session_start();
$az = Azienda::elementWithKey($_SESSION['IdAzienda'], $mysqli);
$mese = $_GET['mese'];
$m = $mese;
if(substr($m, 0,1) == 0)
    $m = substr($m, 1,2);
$anno = $_GET['anno'];


//SVUOTA ORE DEL MESE

$delete = "DELETE ".
            "FROM timbrature ".
            "WHERE MONTH(DTA_TIMBRATURA) = '".$m."' ".
            "AND YEAR(DTA_TIMBRATURA) = '".$anno."'";
$mysqli->autocommit(FALSE);
$mysqli->query($delete);
if ($mysqli->affected_rows > 0) {
    $mysqli->commit();
}

//RIEMPI ORE DEL MESE

$nd = date('t', mktime(0, 0, 0, $mese, 1, $anno));
$utenti = Utente::retrieveList("", "", $mysqli);
foreach ($utenti as $utente){
    for ($i = 1; $i <= $nd; $i ++) {
        $giorno = $i;
        $g = $giorno;
        if (strlen($giorno) == 1)
            $giorno = "0" . $giorno;
        $dta = $anno . $mese . $giorno;
        $arrivo = "08:00:00";
        $uscita = "16:00:00";
        $ore = "8";
        $utente->inserisciTimbrataGiorno($dta, $arrivo, $uscita, $ore, $mysqli, $g, $m, $anno);
    }
}

?>

<script>
	window.alert("<?php echo $mese.'-'.$anno;?> resettato con successo!");
	window.close();
</script>