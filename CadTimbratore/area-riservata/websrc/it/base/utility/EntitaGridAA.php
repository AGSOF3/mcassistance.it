<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utility/Entita.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

    $action = $_POST['action'];
    $keys = isset($_POST['recordGriglia']) ? $_POST['recordGriglia'] : null;
    if($action == "DELETE")
        Entita::deleteFromKeys($mysqli, $keys);    

?>

<script>
	parent.location.reload();
</script>