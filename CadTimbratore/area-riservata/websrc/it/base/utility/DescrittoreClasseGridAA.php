<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utility/DescrittoreClasse.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

    $action = $_POST['action'];
    $keys = isset($_POST['recordGriglia']) ? $_POST['recordGriglia'] : null;
    if($action == "DELETE")
        DescrittoreClasse::deleteFromKeys($mysqli, $keys);    

?>

<script>
	parent.location.reload();
</script>