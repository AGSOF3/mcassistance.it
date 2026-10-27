<?php

class Azienda {

    public $IdAzienda = "";

    public $Descrizione = "";
    
    public $CodiceAziendaEsterno = "";
    
    public $SitoWeb = "";

    public function __construct($IdAzienda, $Descrizione,$CodiceAziendaEsterno,$SitoWeb) {
        $this->setIdAzienda($IdAzienda);
        $this->setDescrizione($Descrizione);
        $this->setCodiceAziendaEsterno($CodiceAziendaEsterno);
        $this->setSitoWeb($SitoWeb);
    }

    public function getIdAzienda() {
        return $this->IdAzienda;
    }

    public function getDescrizione() {
        return $this->Descrizione;
    }

    public function setIdAzienda($IdAzienda) {
        $this->IdAzienda = $IdAzienda;
    }

    public function setDescrizione($Descrizione) {
        $this->Descrizione = $Descrizione;
    }

    public function getCodiceAziendaEsterno(){
        return $this->CodiceAziendaEsterno;
    }

    public function getSitoWeb(){
        return $this->SitoWeb;
    }

    public function setCodiceAziendaEsterno($CodiceAziendaEsterno){
        $this->CodiceAziendaEsterno = $CodiceAziendaEsterno;
    }

    public function setSitoWeb($SitoWeb){
        $this->SitoWeb = $SitoWeb;
    }

    public static function retrieveList($mysqli) {
        $Aziende = array();
        $query = "SELECT * FROM aziende ";
        $table = mysqli_query($mysqli, $query);
        while ($row = mysqli_fetch_array($table)) {
            $Aziende[] = new Azienda($row['ID_AZIENDA'], $row['DESCRIZIONE'],$row['COD_AZIENDA_ESTERNO'],$row['SITO_WEB']);
        }
        return $Aziende;
    }

    public static function elementWithKey($IdAzienda, $mysqli) {
        $query = "SELECT * FROM aziende WHERE ID_AZIENDA = '" . $IdAzienda . "' ";
        $table = mysqli_query($mysqli, $query);
        $azienda = null;
        while ($row = mysqli_fetch_array($table)) {
            $azienda = new Azienda($row['ID_AZIENDA'], $row['DESCRIZIONE'],$row['COD_AZIENDA_ESTERNO'],$row['SITO_WEB']);
        }
        return $azienda;
    }

    public function getAziendaDesc() {
        return $this->getDescrizione() . " (" . $this->getIdAzienda() . ")";
    }

    public static function deleteFromKeys($mysqli, $keys) {
        if ($keys != null) {
            foreach ($keys as $key) {
                Azienda::deleteFromKey($mysqli, $key);
            }
        }
    }

    public static function deleteFromKey($mysqli, $key) {
        $delete = "DELETE FROM aziende WHERE " . " ID_AZIENDA = '" . $key . "' ";
        $mysqli->autocommit(FALSE);
        $mysqli->query($delete);
        if ($mysqli->affected_rows == 1) {
            $mysqli->commit();
        } else {
            echo "<script>window.alert('Problema nella cancellazione');</script>";
            $mysqli->rollback();
        }
    }
    
    public function isOnDB(){
        $isOnDB = false;
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $select = "SELECT * FROM aziende WHERE ID_AZIENDA = '".$this->getIdAzienda()."' ";
        if ($result = $mysqli->query($select)) {
            if ($row = $result->fetch_assoc()) {
                $isOnDB = true;
            }
        }
        return $isOnDB;
    }
    
    public function save($Mode){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        if($this->isOnDB() && $Mode == "UPDATE"){//UPDATE
            $query = "UPDATE aziende SET DESCRIZIONE = '".$this->getDescrizione()."', COD_AZIENDA_ESTERNO = '".$this->getCodiceAziendaEsterno()."', " .
            " SITO_WEB = '".$this->getSitoWeb()."' WHERE ID_AZIENDA = '".$this->getIdAzienda()."' ";
        }else{//INSERT
            $query = "INSERT INTO aziende VALUES ".
                    " ('".$this->getIdAzienda()."','".$this->getDescrizione()."','".$this->getCodiceAziendaEsterno()."','".$this->getSitoWeb()."')";
        }
        $mysqli->autocommit(FALSE);
        $mysqli->query($query);
        if($mysqli->info != null)
            $rowMatched = substr(explode(":",$mysqli->info)[1],1,1);
        else
            $rowMatched = $mysqli->affected_rows;
        if ($rowMatched == 1) {
            $mysqli->commit();
        } else {
            echo "<script>window.alert('Problema nel salvataggio: ".str_replace("'", "", str_replace("\"", "", $mysqli->error))."');</script>";
            $mysqli->rollback();
        }
    }
}

?>