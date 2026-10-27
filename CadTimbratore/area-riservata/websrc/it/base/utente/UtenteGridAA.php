<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

$action = $_POST['action'];
$keys = isset($_POST['recordGriglia']) ? $_POST['recordGriglia'] : null;
if ($action == "DELETE") {
    Utente::deleteFromKeys($mysqli, $keys);
    echo "<script>parent.location.reload();</script>";
} elseif ($action == "NEW") {
    $formName = "\\\CadTimbratore/area-riservata/" . $_POST['formName'] . "?Key=&Mode=NEW";
    echo "<script>window.open('" . $formName . "','Utente','width=900px,height=600px');</script>";
}
?>
