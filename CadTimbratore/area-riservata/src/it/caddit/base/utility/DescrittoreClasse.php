<?php
include $_SERVER['DOCUMENT_ROOT'] . '/CadTimbratore/area-riservata/src/it/caddit/base/utility/KeyHelper.php';
include $_SERVER['DOCUMENT_ROOT'] . '/CadTimbratore/area-riservata/src/it/caddit/base/utility/DescrittoreClasseAtt.php';

include $_SERVER['DOCUMENT_ROOT'] . '/CadTimbratore/area-riservata/src/it/caddit/base/persist/PersistentObject.php';

class DescrittoreClasse extends PersistentObject{
    
    public $IdAzienda = "";
    
    public $IdDescrittore = "";
    
    public $BusinessClass = "";
    
    public $GridActionAdapter = "";
    
    public $TableName = "";
    
    public $FormName = "";
    
    public $VisibilityMulti = false;
    
    public $GridModifier = false;
    
    public $Attributi = array();
    
    public function __construct(){
        $this->setIdAzienda($_SESSION['IdAzienda']);
    }
    
    public function costruttore($IdAzienda,$IdDescrittore,$BusinessClass,$GridActionAdapter,$TableName,$FormName,$VisibilityMulti,$GridModifier,$Attributi){
        $instance = new self();
        $instance->setIdAzienda($IdAzienda);
        $instance->setIdDescrittore($IdDescrittore);
        $instance->setBusinessClass($BusinessClass);
        $instance->setGridActionAdapter($GridActionAdapter);
        $instance->setTableName($TableName);
        $instance->setFormName($FormName);
        $instance->setVisibilityMulti($VisibilityMulti == "Y" ? true : false);
        $instance->setGridModifier($GridModifier);
        $instance->setAttributi($Attributi);
        return $instance;
    }
    
    public function getIdAzienda(){
        return $this->IdAzienda;
    }

    public function getIdDescrittore(){
        return $this->IdDescrittore;
    }

    public function getBusinessClass(){
        return $this->BusinessClass;
    }

    public function getTableName(){
        return $this->TableName;
    }

    public function getFormName(){
        return $this->FormName;
    }

    public function setIdAzienda($IdAzienda){
        $this->IdAzienda = $IdAzienda;
    }

    public function setIdDescrittore($IdDescrittore){
        $this->IdDescrittore = $IdDescrittore;
    }

    public function setBusinessClass($BusinessClass){
        $this->BusinessClass = $BusinessClass;
    }

    public function getGridActionAdapter(){
        return $this->GridActionAdapter;
    }

    public function setGridActionAdapter($GridActionAdapter){
        $this->GridActionAdapter = $GridActionAdapter;
    }

    public function setTableName($TableName){
        $this->TableName = $TableName;
    }

    public function setFormName($FormName){
        $this->FormName = $FormName;
    }
    
    public function getVisibilityMulti(){
        return $this->VisibilityMulti;
    }

    public function setVisibilityMulti($VisibilityMulti){
        $this->VisibilityMulti = $VisibilityMulti;
    }

    public function getGridModifier(){
        return $this->GridModifier;
    }

    public function setGridModifier($GridModifier){
        $this->GridModifier = $GridModifier;
    }

    public function getAttributi(){
        return $this->Attributi;
    }

    public function setAttributi($Attributi){
        $this->Attributi = $Attributi;
    }
    
    public function getKey(){        
            $idAzienda = $this->getIdAzienda();
            $idDescrittore = $this->getIdDescrittore();
            $keyParts = array($idAzienda, $idDescrittore);
            return KeyHelper::buildObjectKey($keyParts);
    }
    
    public function setKey($key){
        $objIdAzienda = KeyHelper::getTokenObjectKey($key,1);
        $this->setIdAzienda($objIdAzienda);
        $objIdDescrittore = KeyHelper::getTokenObjectKey($key,2);
        $this->setIdDescrittore($objIdDescrittore);
    }
    
    public function elementWithKey($key){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $k = explode(KeyHelper::KEY_SEPARATOR, $key);
        $select = "SELECT * FROM descrittori_classe WHERE ID_DESCRITTORE = '".$k[1]."' ";
        if($result = $mysqli->query($select)){
            if($row = $result->fetch_assoc()){
                $IdAzienda = $row['ID_AZIENDA'];
                $IdDescrittore = $row['ID_DESCRITTORE'];
                $BusinessClass = $row['BUSINESS_CLASS'];
                $GridActionAdapter = $row['GRID_ACTION_ADAPTER'];
                $TableName = $row['TABLE_NAME'];
                $FormName = $row['FORM_NAME'];
                $VisibilityMulti = $row['VISIBILITY_MULTI'];
                $GridModifier = $row['GRID_MODIFIER'];
            }else{
                return null;
            }
        }else{
            return null;
        }
        $Attributi = array();
        if($TableName != null){
            $where = " WHERE ID_AZIENDA = '".$IdAzienda."' AND ID_DESCRITTORE = '".$IdDescrittore."' ";
            $Attributi = DescrittoreClasseAtt::retrieveList($where);
        }
        
        return DescrittoreClasse::costruttore($IdAzienda, $IdDescrittore, $BusinessClass, $GridActionAdapter, $TableName, $FormName,$VisibilityMulti,$GridModifier, $Attributi);
    }   
    
    public function getSelect(){
        $select = "SELECT ".$this->getListaColonneAttributi().
                    " FROM ".$this->getTableName();
        return $select;
    }
    
    public function getListaColonneAttributi(){
        $colonne = "";
        for($i=0; $i<count($this->getAttributi()); $i++){
            $att = $this->getAttributi()[$i];
            if($i>0)
                $colonne .= ",";
            $colonne .= $att->getColumnName();
        }
        return $colonne;
    }
    
    public function retrieveColonneKey(){
        $colonneChiave = array();
        foreach ($this->getAttributi() as $att){
            if($att->getIsKey()){
                $colonneChiave[] = $att->getColumnName();
            }
        }
        return $colonneChiave;
    }
    
    public static function deleteFromKeys($mysqli, $keys) {
        if ($keys != null) {
            foreach ($keys as $key) {
                $desc = DescrittoreClasse::elementWithKey($key, $mysqli);
                if($desc != null)
                    $desc->delete();
            }
        }
    }
    
    public function delete(){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $delete = "DELETE FROM descrittori_classe WHERE ID_AZIENDA = '" . $this->getIdAzienda() . "' ".
            " AND ID_DESCRITTORE = '".$this->getIdDescrittore()."' ";
        $mysqli->autocommit(FALSE);
        $mysqli->query($delete);
        if ($mysqli->affected_rows == 1) {
            $mysqli->commit();
        } else {
            echo "<script>window.alert('Problema nella cancellazione');</script>";
            $mysqli->rollback();
        }
    }
    
}

?>