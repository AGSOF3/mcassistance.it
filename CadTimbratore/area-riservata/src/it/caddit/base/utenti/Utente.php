<?php

class Utente {

    public $IdAzienda = "";

    public $IdUtente = "";

    public $Nome = "";

    public $Cognome = "";

    public $DtaNascita = "";

    public $UIDTag = "";

    public $Matricola = "";
    
    public $QRCode = "";
    
    public $OreGiornaliere = "";

    public function __construct($IdAzienda, $IdUtente, $Nome, $Cognome, $DtaNascita, $UIDTag, $Matricola, $QRCode, $OreGiornaliere) {
        $this->setIdAzienda($IdAzienda);
        $this->setIdUtente($IdUtente);
        $this->setNome($Nome);
        $this->setCognome($Cognome);
        $this->setDtaNascita($DtaNascita);
        $this->setUIDTag($UIDTag);
        $this->setMatricola($Matricola);
        $this->setQRCode($QRCode);
        $this->setOreGiornaliere($OreGiornaliere);
    }

    public function getKey() {
        return $this->getIdAzienda() . chr(22) . $this->getIdUtente();
    }

    public function getIdAzienda() {
        return $this->IdAzienda;
    }

    public function setIdAzienda($IdAzienda) {
        $this->IdAzienda = $IdAzienda;
    }

    /**
     *
     * @return string
     */
    public function getIdUtente() {
        return $this->IdUtente;
    }

    /**
     *
     * @return string
     */
    public function getNome() {
        return $this->Nome;
    }

    /**
     *
     * @return string
     */
    public function getCognome() {
        return $this->Cognome;
    }

    /**
     *
     * @param string $idDipendente
     */
    public function setIdUtente($IdUtente) {
        $this->IdUtente = $IdUtente;
    }

    /**
     *
     * @param string $nome
     */
    public function setNome($nome) {
        $this->Nome = $nome;
    }

    /**
     *
     * @param string $cognome
     */
    public function setCognome($cognome) {
        $this->Cognome = $cognome;
    }

    public function getMatricola() {
        return $this->Matricola;
    }

    public function setMatricola($Matricola) {
        $this->Matricola = $Matricola;
    }

    public function getQRCode(){
        return $this->QRCode;
    }

    public function getOreGiornaliere(){
        return $this->OreGiornaliere;
    }

    public function setOreGiornaliere($OreGiornaliere){
        $this->OreGiornaliere = $OreGiornaliere;
    }

    public function setQRCode($QRCode){
        $this->QRCode = $QRCode;
    }

    public function getDtaNascita() {
        return $this->DtaNascita;
    }

    public function getUIDTag() {
        return $this->UIDTag;
    }

    public function setDtaNascita($DtaNascita) {
        $this->DtaNascita = $DtaNascita;
    }

    public function setUIDTag($UIDTag) {
        $this->UIDTag = $UIDTag;
    }

    public static function elementWithKey($key, $mysqli) {
        $utente = null;
        if ($key != null) {
            $k = explode(chr(22), $key);
            $query = "SELECT * FROM utenti WHERE ID_AZIENDA = '" . $k[0] . "' AND ID_UTENTE = '" . $k[1] . "' ";
            if ($result = $mysqli->query($query)) {
                if ($row = $result->fetch_assoc()) {
                    $utente = new Utente($row['ID_AZIENDA'], $row['ID_UTENTE'], $row['NOME'], $row['COGNOME'], $row['DTA_NASCITA'], $row['UID_TAG'], $row['MATRICOLA'], $row['QRCODE'], $row['ORE_GIORNALIERE']);
                }
            }
        }
        return $utente;
    }

    public function getNomeCompleto() {
        return $this->getNome() . " " . $this->getCognome();
    }

    public function getOreLavorateGiorno($giorno, $mysqli) {
        $select = "SELECT FORMAT ( COALESCE(SUM(ORE_TOTALI),0), 1 )  AS ORE_TOTALI " . "FROM timbrature " . "WHERE DTA_TIMBRATURA = '" . $giorno . "' AND ID_UTENTE = '" . $this->getIdUtente() . "'  AND ID_AZIENDA = '" . $this->getIdAzienda() . "' ";
        if ($result = $mysqli->query($select)) {
            if ($row = $result->fetch_assoc()) {
                return $row['ORE_TOTALI'];
            }
        }
        return "0";
    }

    public function getListaEntrateUscite($giorno, $mysqli, $chiaveTimbratura) {
        $lista = "";
        $select = "SELECT ORA_ARRIVO,ORA_ARRIVO_FMT,ORA_USCITA,ORA_USCITA_FMT,ORE_TOTALI " . " FROM timbrature " . " WHERE DTA_TIMBRATURA = '" . $giorno . "' AND ID_UTENTE = '" . $this->getIdUtente() . "'  AND ID_AZIENDA = '" . $this->getIdAzienda() . "' ";
        if ($result = $mysqli->query($select)) {
            while ($row = $result->fetch_assoc()) {
                $msg = "ENTRATA " . $row['ORA_ARRIVO'] . " (" . $row['ORA_ARRIVO_FMT'] . ") <br> USCITA &nbsp;&nbsp;&nbsp;" . $row['ORA_USCITA'] . " (" . $row['ORA_USCITA_FMT'] . ") <br> ORE: " . $row['ORE_TOTALI'];
                $lista .= "<ul class=\"list-group\">";
                $lista .= "<li class=\"list-group-item\">";
                $lista .= "<span class=\"new\" title=\"Elimina timbratura\" onclick=\"cancellaRegistrazione('".$chiaveTimbratura.chr(22).$row['ORA_ARRIVO']."')\")>-</span>";
                $lista .= $msg;
                $lista .= "</li></ul>";
            }
        }
        return $lista;
    }
    
    public function eliminaTimbrataGiornoOra($key,$mysqli){
        $k = explode(chr(22), $key);
        $delete = "DELETE FROM timbrature WHERE ";
        $delete .= " ID_AZIENDA = '".$k[0]."' AND ID_UTENTE='".$k[1]."' AND DTA_TIMBRATURA = '".$k[2]."' ";
        $delete .= " AND ORA_ARRIVO = '".$k[3]."' ";
        $mysqli->autocommit(FALSE);
        $mysqli->query($delete);
        if ($mysqli->affected_rows == 1) {
            $mysqli->commit();
            echo "<script>opener.location.reload();window.close();</script>";
        } else {
            echo "<script>window.alert('Problema nella eliminazione!');window.close();</script>";
            $mysqli->rollback();
        }
    }
    
    public function inserisciTimbrataGiorno($data,$arrivo,$uscita,$ore,$mysqli, $giorno, $mese, $anno){
        $date = mktime(0, 0, 0, $mese, $giorno, $anno);
        $gd = getdate($date);
        if($gd['wday'] != 0 && $gd['wday'] != 6){ //se NON è sabato o domenica 
            $insert = "INSERT INTO timbrature VALUES ".
                    "('".$this->getIdAzienda()."','".$this->getIdUtente()."','".$data."', ". 
                    "'".$arrivo."','".$arrivo."','".$uscita."','".$uscita."','".$ore."')";
            $mysqli->autocommit(FALSE);
            $mysqli->query($insert);
            if ($mysqli->affected_rows == 1) {
                $mysqli->commit();
            } else {
                echo "<script>window.alert('Problema nell inserimento!');</script>";
                $mysqli->rollback();
            }
        }
    }

    public static function deleteFromKeys($mysqli, $keys) {
        if ($keys != null) {
            foreach ($keys as $key) {
                $utente = Utente::elementWithKey($key, $mysqli);
                if ($utente != null)
                    $utente->delete();
            }
        }
    }

    public static function retrieveList($where, $orderBy, $mysqli) {
        $utenti = array();
        $select = "SELECT * FROM utenti ";
        if (strlen($where) > 1)
            $select .= "WHERE " . $where;
        if (strlen($orderBy) > 1)
            $select .= "ORDER BY " . $orderBy;
        if ($result = $mysqli->query($select)) {
            while ($row = $result->fetch_assoc()) {
                $key = $row['ID_AZIENDA'].chr(22).$row['ID_UTENTE'];
                $utenti[] = Utente::elementWithKey($key, $mysqli);
            }
        }
        return $utenti;
    }

    public function delete() {
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $delete = "DELETE FROM utenti WHERE ID_AZIENDA = '" . $this->getIdAzienda() . "' " . " AND ID_UTENTE = '" . $this->getIdUtente() . "' ";
        $mysqli->autocommit(FALSE);
        $mysqli->query($delete);
        if ($mysqli->affected_rows == 1) {
            $mysqli->commit();
        } else {
            echo "<script>window.alert('Problema nella cancellazione');</script>";
            $mysqli->rollback();
        }
    }

    public function isOnDB() {
        $isOnDB = false;
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $select = "SELECT * FROM utenti WHERE ID_AZIENDA = '" . $this->getIdAzienda() . "' AND ID_UTENTE = '" . $this->getIdUtente() . "' ";
        if ($result = $mysqli->query($select)) {
            if ($row = $result->fetch_assoc()) {
                $isOnDB = true;
            }
        }
        return $isOnDB;
    }

    public function save($Mode) {
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        if ($this->isOnDB() && $Mode == "UPDATE") { // UPDATE
            $query = "UPDATE utenti SET NOME = '" . $this->getNome() . "', COGNOME = '" . $this->getCognome() . "', " . " DTA_NASCITA = '" . $this->getDtaNascita() . "', UID_TAG = '" . $this->getUIDTag() . "', MATRICOLA = '" . $this->getMatricola() . "', QRCODE = '".$this->getQRCode()."', ORE_GIORNALIERE = '".$this->getOreGiornaliere()."'  " . " WHERE ID_AZIENDA = '" . $this->getIdAzienda() . "' AND ID_UTENTE = '" . $this->getIdUtente() . "' ";
        } else { // INSERT
            $this->setIdUtente($this->costruisciIdUtente());
            $query = "INSERT INTO utenti VALUES " . " ('" . $this->getIdAzienda() . "','" . $this->getIdUtente() . "','?','" . $this->getNome() . "','" . $this->getCognome() . "' " . ",'" . $this->getDtaNascita() . "','" . $this->getUIDTag() . "','" . $this->getMatricola() . "', '".$this->getQRCode()."', '".$this->getOreGiornaliere()."')";
        }
        $mysqli->autocommit(FALSE);
        $mysqli->query($query);
        if ($mysqli->info != null)
            $rowMatched = substr(explode(":", $mysqli->info)[1], 1, 1);
        else
            $rowMatched = $mysqli->affected_rows;
        if ($rowMatched == 1) {
            $mysqli->commit();
        } else {
            echo "<script>window.alert('Problema nel salvataggio: " . str_replace("'", "", str_replace("\"", "", $mysqli->error)) . "');</script>";
            $mysqli->rollback();
        }
    }

    function costruisciIdUtente() {
        return substr(strtoupper($this->getCognome()), 0, 3) . substr(strtoupper($this->getNome()), 0, 3);
    }
}

?>
