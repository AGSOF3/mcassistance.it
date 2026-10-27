<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
protetta_session_start();
$key = $_GET['Key'];
$IdAzienda = explode(chr(22), $key)[0];
$IdUtente = explode(chr(22), $key)[1];
$keyUtente = $IdAzienda . chr(22) . $IdUtente;
$utente = Utente::elementWithKey($keyUtente, $mysqli);
if($utente != null){
    $utente->eliminaTimbrataGiornoOra($key, $mysqli);   
}

?>