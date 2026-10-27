<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";
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
    /* azione gestita in Utente.js
    elseif($action == "VEDI_QR_CODE"){
        $qrcode = $_POST['QRCode'];
        header('Location: https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$qrcode);
    }
    */

    function salva($key,$mode){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $utente = Utente::elementWithKey($key, $mysqli);
        $IdAzienda = $_POST['IdAzienda'];
        $IdUtente = $_POST['IdUtente'];
        $Nome = $_POST['Nome'];
        $Cognome = $_POST['Cognome'];
        $DtaNascita = $_POST['DtaNascita'];
        $UIDTag = $_POST['UIDTag'];
        $Matricola = $_POST['Matricola'];
        $QRCode = $_POST['QRCode'];
        $OreGiornaliere = $_POST['OreGiornaliere'];
        if($mode == "UPDATE"){
            $utente->setIdAzienda($IdAzienda);
            $utente->setIdUtente($IdUtente);
            $utente->setNome($Nome);
            $utente->setCognome($Cognome);
            $utente->setDtaNascita($DtaNascita);
            $utente->setUIDTag($UIDTag);
            $utente->setMatricola($Matricola);
            $utente->setQRCode($QRCode);
            $utente->setOreGiornaliere($OreGiornaliere);
        }else{
            $utente = new Utente($IdAzienda, $IdUtente, $Nome, $Cognome, $DtaNascita, $UIDTag, $Matricola, $QRCode, $OreGiornaliere);
        }
        $utente->save($mode);
        $_GET['Key'] = $utente->getKey();
    }
    
?>