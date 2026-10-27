<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/azienda/Azienda.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

    $action = $_POST['action'];
    $key = $_POST['Key'];
    $mode = $_POST['Mode'];
    if($action == "SAVE"){
        salva($key,$mode);
        $k = $_GET['Key'];
        echo "<script>parent.location = parent.location.href.split('?')[0].concat('?Key=".$k."&Mode=UPDATE');</script>";
    }elseif($action == "SAVE_CLOSE"){
        salva($key,$mode);
        echo "<script>parent.window.close();</script>";
    }elseif($action == "REFRESH"){
        echo "<script>parent.location.reload();</script>";
    }

    function salva($key,$mode){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $azienda = Azienda::elementWithKey($key, $mysqli);
        if($mode == "UPDATE"){
            $azienda->setIdAzienda($_POST['IdAzienda']);
            $azienda->setDescrizione($_POST['Descrizione']);
            $azienda->setCodiceAziendaEsterno($_POST['CodiceAziendaEsterno']);
            $azienda->setSitoWeb($_POST['SitoWeb']);
        }else{
            $azienda = new Azienda($_POST['IdAzienda'], $_POST['Descrizione'], $_POST['CodiceAziendaEsterno'], $_POST['SitoWeb']);
        }
        $azienda->save($mode);
        $_GET['Key'] = $azienda->getIdAzienda();
    }
    
?>