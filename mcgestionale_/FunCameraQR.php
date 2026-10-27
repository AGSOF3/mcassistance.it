<?php

if(isset($_POST['dip'])){
    if(dipendenteEsiste($_POST['dip'])){
        $ora = date('H:i');
        $data = date("Y/m/d");
        $entrata = verificaEntrata($_POST['dip'],$data,$ora);
        if($entrata){
            echo "<h1>ENTRATA</h1>";
            echo "<script> document.getElementById('audioEntrata').play(); </script>";
            if(inserisciEntrata($_POST['dip'],$data,$ora)){
//                 playAudioEntrata();
                playVoce($entrata,$_POST['dip'],$data,$ora);
            }else{
                playAudioErrore();
            }
        }
        else {
            echo "<h1>USCITA</h1>";
            if(inserisciUscita($_POST['dip'],$data,$ora)){
                $oraArrivo = oraArrivoRelativa($_POST['dip'],$data);
                if($oraArrivo != null && $oraArrivo != ""){
                    if(calcolaOreTrascorse($_POST['dip'],$oraArrivo,$ora,$data)){
                        playAudioEntrata();
                        playVoce($entrata,$_POST['dip'],$data,$ora);
                    }else{
                        playAudioErrore();
                    }
                }
            }
            else
                echo "<script> document.getElementById('audioErrore').play(); </script>";
        }
    }else{
        echo "<script> window.alert('QR CODE NON ASSEGNATO!'); </script>";
    }
}

function verificaEntrata($dip,$giorno,$ora){
    require "connessione.php";
    $q = "SELECT * FROM ARRIVI WHERE idDipendente = '".$dip."' AND giornoArrivo = '".$giorno."' ";
    $result = $mysqli->query($q);
    if($result->num_rows > 0){
        $q2 = "SELECT * FROM uscite WHERE idDipendente = '".$dip."' AND giornoUscita = '".$giorno."' ";
        $result2 = $mysqli->query($q2);
        if($result->num_rows > $result2->num_rows)
            return false;
    }
    return true;
}


function dipendenteEsiste($dip){
    require "connessione.php";
    $q = "SELECT * FROM accessi where idDipendente = '".$dip."' ";
    $result = $mysqli->query($q);
    if($result->num_rows == 1)
        return true;
        return false;
}

function inserisciEntrata($dip,$giorno,$ora){
    require "connessione.php";
    $qEntrata="INSERT INTO arrivi (oraArrivo, giornoArrivo, idDipendente) ".
        " VALUES ('".$ora."','".$giorno."','".$dip."')";
    $mysqli->autocommit(FALSE); //disabilito l'autocommit
    $mysqli->query($qEntrata);//ESEGUO LA QUERY
    if($mysqli->affected_rows == 1){ // se la insert ha inserito una riga committo, se no rollback
        $mysqli->commit();
        return true;
    }else{
        $mysqli->rollback();
        return false;
    }
}

function inserisciUscita($dip,$giorno,$ora){
    require "connessione.php";
    $qUscita="INSERT INTO uscite (oraUscita, giornoUscita, idDipendente) VALUES ".
        "('".$ora."','".$giorno."','".$dip."')";
    $mysqli->autocommit(FALSE);
    $mysqli->query($qUscita);
    if($mysqli->affected_rows == 1){
        $mysqli->commit();
        return true;
    }else{
        $mysqli->rollback();
        return false;
    }
    
}

function oraArrivoRelativa($dip,$giorno){
    require "connessione.php";
    $q = "SELECT oraArrivo FROM arrivi WHERE idDipendente = '".$dip."' AND giornoArrivo = '".$giorno."' ORDER BY oraArrivo DESC LIMIT 1";
    $result = $mysqli->query($q);
    if($row = $result->fetch_assoc())
        return $row['oraArrivo'];
        return null;
}

function calcolaOreTrascorse($dip,$oraArrivo,$oraUscita,$data){
    require "connessione.php";
    $oretot = differenceInHours($oraArrivo, $oraUscita);
    $oretot = round($oretot, 1);
    $virgola = substr($oretot, 2);//SALVO IN VIRGOLA IL NUMERO DOPO LA VIRGOLA
    if($virgola<5){//SE E' MINORE DI 5 LE ORE TOTALI SARANNO APPROSSIMATE A DIFETTO
        $oretot = substr($oretot, 0, 1);
        echo $oretot;
    }else if ($virgola>5) {//SE E' MAGGIORE DI 5 SARANNO APPROSSIMATE A ,5
        $oretot = substr($oretot, 0, 2)."5";
    }
    if($oretot != null && $oretot >= 0){
        $q="INSERT INTO ore (oraArrivo, oraUscita, oreLavoro, giorno, idDipendente) VALUES ".
            "('".$oraArrivo."','".$oraUscita."','".$oretot."','".$data."','".$dip."')";
        $mysqli->autocommit(FALSE);
        $mysqli->query($q);
        if($mysqli->affected_rows == 1){
            $mysqli->commit();
            return true;
        }else{
            $mysqli->rollback();
            return false;
        }
        
    }
}

function differenceInHours($startdate,$enddate){
    require "connessione.php";
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $difference = abs($endtimestamp - $starttimestamp)/3600;
    return $difference;
}

function playAudioEntrata(){
    echo "<script> document.getElementById('audioEntrata').play(); </script>";
}

function playAudioErrore(){
    echo "<script> document.getElementById('audioErrore').play(); </script>";
}

function playVoce($entrata, $dip, $data, $ora){
    echo "<script>";
    $nomeCognome = getNomeCognomeDaId($dip);
    
    $dataini = $data;
    $data = substr($dataini, strlen($dataini)-2, strlen($dataini));
    $data = $data." ".substr($dataini, strlen($dataini)-5, strlen($dataini)-3);
    $data = $data." ".substr($dataini, strlen($dataini)-10, strlen($dataini)-4);

    $imp = controllaImpostazioniVoce();
    if (! $imp) {
        window . alert('Errore nelle impostazioni, contattare l\'amministratore');
    } else {
        if ($imp[0] == 'V') { // VOCE CONFERMA
            if ($entrata) {
                $testo = "Benvenuto " . $nomeCognome;
                if ($imp[1] == 'Y'){
                    $testo = $testo . ", entrata alle ore " . $ora;
                }
                if($imp[2] == 'Y'){
                    $testo = $testo." ".$data;
                }
            }else{
                $testo = "Arrivederci ".$nomeCognome ;
                if ($imp[2] == 'Y'){
                    $testo = $testo . ", uscita alle ore " . $ora;
                }
                if($imp[2] == 'Y'){
                    $testo = $testo ." " . $data;
                }
            }
        }elseif($imp[0] == 'S'){ //SUONI CONFERMA
            if ($entrata) {
                $testo = "BIP";
            } else {
                $testo = "BIP";
            }
        }

        echo "document.getElementById('btnVoce').onlick= voce('" . $testo . "');";
        echo "document.getElementById('btnVoce').click();";
    }

    echo "</script>";
}

function getNomeCognomeDaId($idDip){
    $nomeCognome = "";
    require "connessione.php";
    $q = "SELECT nome,cognome FROM accessi WHERE idDipendente = '".$idDip."' ";
    $result = $mysqli->query($q);
    while($row = $result->fetch_assoc()){
        $nomeCognome = $row['nome']." ".$row['cognome'];
    }
    return $nomeCognome;
}

function controllaImpostazioniVoce(){
    require "connessione.php";
    $query = "SELECT * FROM impostazioniqr ";
    $result = $mysqli->query($query);
    if($row = $result->fetch_assoc()){
        $imp = array($row['CONFERMA'],$row['VOCE_ORA'],$row['VOCE_GIORNO']);
    }else{
        return false;
    }    
    return $imp;
}



?>