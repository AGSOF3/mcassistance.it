<?php

include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/menu/VoceMenu.php";

$vociMenu = VoceMenu::retrieveVociPerUtente($_SESSION['IdUtente']);

foreach($vociMenu as $voce){
    echo $voce->creaStringaHtml();
}

?>