<?php

class Entita{
    
    public $IdEntita = "";
    public $NomeEntita = "";
    public $RDescrittoreClasse = "";
    public $BusinessClass = "";
    public $FormName = "";
    public $TipoPanello = "";
    public $NomeIcona = "";
    
    public function __construct($IdEntita){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $select = "SELECT * 
                    FROM entita 
                    WHERE ID_ENTITA = '".$IdEntita."' ";        
        $table = mysqli_query($mysqli, $select);
        if($row = mysqli_fetch_array($table)) {
            $this->setIdEntita($row['ID_ENTITA']);
            $this->setNomeEntita($row['NOME_ENTITA']);
            $this->setRDescrittoreClasse($row['R_DESCRITTORE_CLASSE']);
            $this->setBusinessClass($row['BUSINESS_CLASS']);
            $this->setFormName($row['FORM_NAME']);
            $this->setTipoPanello($row['TIPO_PANNELLO']);
            $this->setNomeIcona($row['NOME_ICONA']);
        }
    }
    
    public function getIdEntita()
    {
        return $this->IdEntita;
    }

    public function getNomeEntita()
    {
        return $this->NomeEntita;
    }

    public function getRDescrittoreClasse()
    {
        return $this->RDescrittoreClasse;
    }

    public function getBusinessClass()
    {
        return $this->BusinessClass;
    }

    public function getFormName()
    {
        return $this->FormName;
    }

    public function getTipoPanello()
    {
        return $this->TipoPanello;
    }

    public function getNomeIcona()
    {
        return $this->NomeIcona;
    }

    public function setIdEntita($IdEntita)
    {
        $this->IdEntita = $IdEntita;
    }

    public function setNomeEntita($NomeEntita)
    {
        $this->NomeEntita = $NomeEntita;
    }

    public function setRDescrittoreClasse($RDescrittoreClasse)
    {
        $this->RDescrittoreClasse = $RDescrittoreClasse;
    }

    public function setBusinessClass($BusinessClass)
    {
        $this->BusinessClass = $BusinessClass;
    }

    public function setFormName($FormName)
    {
        $this->FormName = $FormName;
    }

    public function setTipoPanello($TipoPanello)
    {
        $this->TipoPanello = $TipoPanello;
    }

    public function setNomeIcona($NomeIcona)
    {
        $this->NomeIcona = $NomeIcona;
    }
    
    public static function deleteFromKeys($mysqli, $keys) {
        if ($keys != null) {
            foreach ($keys as $key) {
                $entita = new Entita($key);
                if($entita != null)
                    $entita->delete();
            }
        }
    }
    
    public function delete(){
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
        $delete = "DELETE FROM entita WHERE ID_ENTITA = '" . $this->getIdEntita() . "' ";
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