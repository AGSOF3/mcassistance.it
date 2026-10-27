<?php
include "src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include "src/it/caddit/base/utility/KeyHelper.php";
    //print_r($_GET);  // for all GET variables
	//print_r($_POST); // for all POST variables
	if(isset($_GET['UID'])){
	    $UID = $_GET['UID'];
	    $IdAzienda = $_GET['IdAzienda'];
	    $IdUtente = cercaIdUtenteDaUID($IdAzienda,$UID,$mysqli);
	    if($IdUtente != null){
	        $key = cercaTimbraturaAperta($IdAzienda,$IdUtente,$mysqli);
	        if($key == null){
	            if(insertTimbratura($IdAzienda,$IdUtente,$mysqli))
    	            $payload = "ENTRATA   " . date("h:i"); //.$IdUtente;
	            else
	                $payload = "ERRORE1";// inserimento timbratura";
	        }else{
	            if(updateTimbratura($key,$mysqli))
    	            $payload = "USCITA    " . date("h:i");//.$IdUtente;
	            else 
	                $payload = "ERRORE2"; //aggiornamento timbratura";
	        }
	    }else{
	        inserisciUIDSconosciuto($IdAzienda,$UID,$mysqli);
	        $payload = "ERRORE3";
	    }
	}else{
	    $payload = "ERRORE4";
	}
	
	echo "<h1>".$payload."</h1>";

    /**
     * Con l'UID che mi viene passato cerco se esiste a sistema un utente
     * con quell'UID assegnato
     * @param $IdAzienda
     * @param $UID
     * @return $IdUtente
     */
    function cercaIdUtenteDaUID($IdAzienda,$UID,$mysqli){
        $IdUtente = null;
        $select = "SELECT ID_UTENTE FROM utenti ";
        $select.= "WHERE ID_AZIENDA = '".$IdAzienda."' AND UID_TAG LIKE '%".$UID."%' ";//permetto di avere più UID_TAG per un solo utente
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()){
            $IdUtente = $row['ID_UTENTE'];
        }
        return $IdUtente;
    }
    
    /**
     * Controllo se esiste un record in TIMBRATURE con IdAzienda e IdUtente trovati, 
     * con ORA_ARRIVO != NULL perchè significa che è stata timbrata l'entrata e 
     * con ORA_USCITA == NULL perchè significa che non è ancora stata timbrata l'uscita,
     * ritorno la key di questo record così da poter poi fare l'update
     * @param $IdAzienda
     * @param $IdUtente
     * @return $key
     */
    function cercaTimbraturaAperta($IdAzienda,$IdUtente,$mysqli){
        $key = null;
        $select = "SELECT ID_AZIENDA,ID_UTENTE,DTA_TIMBRATURA,ORA_ARRIVO ".
                    "FROM timbrature ".
                    "WHERE ID_AZIENDA = '".$IdAzienda."' AND ID_UTENTE = '".$IdUtente."' ".
                    "AND ORA_ARRIVO IS NOT NULL AND ORA_USCITA IS NULL";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()){
            $key = $row['ID_AZIENDA'].KEY_SEPARATOR.$row['ID_UTENTE'].
                KEY_SEPARATOR.$row['DTA_TIMBRATURA'].KEY_SEPARATOR.$row['ORA_ARRIVO'];
        }
        
        return $key;
    }
    
    /**
     * Inserisco un nuovo record in TIMBRATURE con IdAzienda e IdUtente trovati e con data e ora attuale
     * @param $IdAzienda
     * @param $IdUtente
     */
    function insertTimbratura($IdAzienda,$IdUtente,$mysqli){
        $insert = "INSERT INTO timbrature (ID_AZIENDA,ID_UTENTE,DTA_TIMBRATURA,ORA_ARRIVO,ORA_ARRIVO_FMT) ".
                    "SELECT". 
                    "'".$IdAzienda."' AS ID_AZIENDA,".
                    "'".$IdUtente."' AS ID_UTENTE,".
                    "CURDATE() AS DTA_TIMBRATURA,".
                    "CURTIME() AS ORA_ARRIVO,".
                    "CASE ".
                    "WHEN MINUTE(CURTIME()) <= 15 THEN CONCAT(HOUR(CURTIME()),':00') ".
                    "WHEN MINUTE(CURTIME()) > 15 AND MINUTE(CURTIME()) <= 45 THEN CONCAT(HOUR(CURTIME()),':30') ".
                    "WHEN MINUTE(CURTIME()) > 45 THEN CONCAT(HOUR(CURTIME())+1,':00') ".
                    "END AS ORA_ARRIVO_FMT ";
        $result = $mysqli->query($insert);
        return $result;
    }
    
    /**
     * Aggiorno il record che trovo con la $key passata, ORA_USCITA = ora attuale,
     * faccio anche il calcolo di quante ore di differenza ci sono tra ORA_USCITA e ORA_ARRIVO
     * @param $key
     */
    function updateTimbratura($key,$mysqli){
        $k = explode(chr(22),$key);
        $update = "UPDATE timbrature ". //aggiorno l'ora di arrivo
                   " SET ORA_USCITA = CURTIME(), ".
                   " ORA_USCITA_FMT = CASE ".
                   " WHEN MINUTE(CURTIME()) <= 15 THEN CONCAT(HOUR(CURTIME()),':00') ".
                   " WHEN MINUTE(CURTIME()) > 15 AND MINUTE(CURTIME()) <= 45 THEN CONCAT(HOUR(CURTIME()),':30') ".
                   " WHEN MINUTE(CURTIME()) > 45 THEN CONCAT(HOUR(CURTIME())+1,':00') ".
                   " END ".                    
                    "WHERE ID_AZIENDA = '".$k[0]."' AND ID_UTENTE = '".$k[1]."' ".
                    "AND DTA_TIMBRATURA = '".$k[2]."' AND ORA_ARRIVO = '".$k[3]."'";
        $result = $mysqli->query($update);
        if($result){ //aggiorno le ore totali 
            $update = "UPDATE timbrature ".
                        "SET ORE_TOTALI = CASE WHEN ORA_USCITA_FMT >= ORA_ARRIVO_FMT THEN TRUNCATE(time_to_sec(TIMEDIFF(ORA_USCITA_FMT,ORA_ARRIVO_FMT)) / (60 * 60),2) WHEN ORA_USCITA_FMT < ORA_ARRIVO_FMT THEN TRUNCATE(time_to_sec(TIMEDIFF(CONCAT(DATE_ADD(DTA_TIMBRATURA,INTERVAL 1 DAY),' ',ORA_USCITA_FMT),CONCAT(DTA_TIMBRATURA,' ',ORA_ARRIVO_FMT))) / (60 * 60),2) ELSE '0.00' END ".
                        "WHERE ID_AZIENDA = '".$k[0]."' AND ID_UTENTE = '".$k[1]."' ".
                        "AND DTA_TIMBRATURA = '".$k[2]."' AND ORA_ARRIVO = '".$k[3]."'";
            $result = $mysqli->query($update);
        }
        return $result;
    }
    
    /**
     * Se il tag ha un UID non collegato ad un utente lo scrivo nella tabella UID_SCONOSCIUTI
     * così che possa vedere l'UID da sistema e associarlo ad un utente
     * @param $IdAzienda
     * @param $UID
     */
    function inserisciUIDSconosciuto($IdAzienda,$UID,$mysqli){
        $insert = "INSERT INTO uid_sconosciuti (ID_AZIENDA,PROGRESSIVO,UID,TIMESTAMP_CRZ) ".
                    "SELECT '".$IdAzienda."', MAX(PROGRESSIVO)+1,'".$UID."',current_timestamp() FROM uid_sconosciuti";
        $result = $mysqli->query($insert);
    }
    
    
    
    
?>