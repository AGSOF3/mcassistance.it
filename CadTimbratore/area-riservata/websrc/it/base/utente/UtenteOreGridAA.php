<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

$action = $_POST['action'];
if ($action == "EXCEL") {
    $formName = "\\\CadTimbratore/area-riservata/websrc/it/base/utente/SceltaMeseAnnoExcel.php?Mode=ALL";
    echo "<script>window.open('" . $formName . "','Utente','width=630px,height=200px');</script>";
}
?>
