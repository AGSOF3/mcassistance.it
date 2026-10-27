<?php

class DescrittoreClasseAtt {
    
    public $IdAzienda = "";

    public $IdDescrittore = "";

    public $IdAttributo = "";

    public $Descrizione = "";

    public $TipoAttributo = "";

    public $ColumnName = "";
    
    public $IsKey = "";

    public function __construct() {
        $this->setIdAzienda($_SESSION['IdAzienda']);
    }
    
    public function costruttore($IdAzienda,$IdDescrittore,$IdAttributo,$Descrizione,$TipoAttributo,$ColumnName,$IsKey){
        $instance = new self();
        $instance->setIdAzienda($IdAzienda);
        $instance->setIdDescrittore($IdDescrittore);
        $instance->setIdAttributo($IdAttributo);
        $instance->setDescrizione($Descrizione);
        $instance->setTipoAttributo($TipoAttributo);
        $instance->setColumnName($ColumnName);
        $instance->setIsKey($IsKey == "Y" ? true : false);
        return $instance;
    }

    public function getIdAzienda() {
        return $this->IdAzienda;
    }

    public function getIdDescrittore() {
        return $this->IdDescrittore;
    }

    public function getIdAttributo() {
        return $this->IdAttributo;
    }

    public function getDescrizione() {
        return $this->Descrizione;
    }

    public function getTipoAttributo() {
        return $this->TipoAttributo;
    }

    public function getColumnName() {
        return $this->ColumnName;
    }

    public function setIdAttributo($IdAttributo) {
        $this->IdAttributo = $IdAttributo;
    }

    public function setDescrizione($Descrizione) {
        $this->Descrizione = $Descrizione;
    }

    public function setTipoAttributo($TipoAttributo) {
        $this->TipoAttributo = $TipoAttributo;
    }

    public function setColumnName($ColumnName) {
        $this->ColumnName = $ColumnName;
    }

    public function getIsKey(){
        return $this->IsKey;
    }

    public function setIsKey($IsKey){
        $this->IsKey = $IsKey;
    }

    public function setIdAzienda($IdAzienda) {
        $this->IdAzienda = $IdAzienda;
    }

    public function setIdDescrittore($IdDescrittore) {
        $this->IdDescrittore = $IdDescrittore;
    }

    public function getKey() {
        $idAzienda = $this->getIdAzienda();
        $idDescrittore = $this->getIdDescrittore();
        $idAttributo = $this->getIdAttributo();
        $keyParts = array(
            $idAzienda,
            $idDescrittore,
            $idAttributo
        );
        return KeyHelper::buildObjectKey($keyParts);
    }

    public function setKey($key) {
        $objIdAzienda = KeyHelper::getTokenObjectKey($key, 1);
        $this->setIdAzienda($objIdAzienda);
        $objIdDescrittore = KeyHelper::getTokenObjectKey($key, 2);
        $this->setIdDescrittore($objIdDescrittore);
        $objIdAttributo = KeyHelper::getTokenObjectKey($key, 3);
        $this->setIdAttributo($objIdAttributo);
    }

    public function elementWithKey($key) {
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $k = explode(KeyHelper::KEY_SEPARATOR, $key);
        $select = "SELECT * FROM descrittori_classe_att ".
                    " WHERE ID_AZIENDA = '" . $k[0] . "' AND ID_DESCRITTORE = '" . $k[1] . "' ".
                    " AND ID_ATTRIBUTO = '".$k[2]."' ";
        if ($result = $mysqli->query($select)) {
            if ($row = $result->fetch_assoc()) {
                $IdAzienda = $row['ID_AZIENDA'];
                $IdDescrittore = $row['ID_DESCRITTORE'];
                $IdAttributo = $row['ID_ATTRIBUTO'];
                $Descrizione = $row['DESCRIZIONE'];
                $TipoAttributo = $row['TIPO_ATTRIBUTO'];
                $ColumnName = $row['COLUMN_NAME'];
                $IsKey = $row['IS_KEY'];
            }
        }
        return DescrittoreClasseAtt::costruttore($IdAzienda, $IdDescrittore, 
                        $IdAttributo, $Descrizione, $TipoAttributo, $ColumnName, $IsKey);
    }
    
    public static function retrieveList($where){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        
        $select = "SELECT * FROM descrittori_classe_att ";
        $where .= " AND VISIBILE = 'Y' ";
        $orderBy = " ORDER BY POSIZIONE ASC";
        $select .= $where.$orderBy;
        $table = mysqli_query($mysqli, $select);
        $attributi = [];
        while ($row = mysqli_fetch_array($table)) {
            $attributi[] = DescrittoreClasseAtt::costruttore($row['ID_AZIENDA'], $row['ID_DESCRITTORE'], $row['ID_ATTRIBUTO'],
                $row['DESCRIZIONE'], $row['TIPO_ATTRIBUTO'], $row['COLUMN_NAME'], $row['IS_KEY']);
        }
        return $attributi;
    }
    
}

?>