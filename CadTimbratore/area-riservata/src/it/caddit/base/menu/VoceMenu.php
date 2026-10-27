<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utility/Entita.php";

class VoceMenu {

    public $Posizione = "";

    public $PosizionePadre = "";

    public $entita = Entita::class;

    public function __construct($IdEntita, $Posizione, $PosizionePadre) {
        $this->setEntita(new Entita($IdEntita));
        $this->setPosizione($Posizione);
        $this->setPosizionePadre($PosizionePadre);
    }

    public function getPosizione() {
        return $this->Posizione;
    }

    public function getPosizionePadre() {
        return $this->PosizionePadre;
    }

    public function setPosizione($Posizione) {
        $this->Posizione = $Posizione;
    }

    public function setPosizionePadre($PosizionePadre) {
        $this->PosizionePadre = $PosizionePadre;
    }

    public function getEntita() {
        return $this->entita;
    }

    public function setEntita($entita) {
        $this->entita = $entita;
    }

    public static function retrieveVociPerUtente($IdUtente) {
        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";

        $select = "SELECT E.ID_ENTITA, M.POSIZIONE, M.POSIZIONE_PADRE
            FROM menu_utenti M
            INNER JOIN entita E
            ON M.ID_ENTITA = E.ID_ENTITA
            WHERE ID_UTENTE = '" . $IdUtente . "'
            ORDER BY POSIZIONE ASC";

        $table = mysqli_query($mysqli, $select);
        $vociMenu = [];
        while ($row = mysqli_fetch_array($table)) {
            $vociMenu[] = new VoceMenu($row['ID_ENTITA'], $row['POSIZIONE'], $row['POSIZIONE_PADRE']);
        }
        return $vociMenu;
    }
    
    public function creaStringaHtml(){
        $entita = $this->getEntita();
        
        if($entita->getNomeIcona() != null)
            $srcIcona = $_SESSION['webAppPath'].$entita->getNomeIcona();
        else
            $srcIcona = $_SESSION['webAppPath']."/assets/img/icon/transparent.png";
        
        $img = "<img class='iconaVoceMenu' src='".$srcIcona."'/>";
        
        $label = "<label>".$img.$entita->getNomeEntita()."</label>";
        
        $src =  "\\\CadTimbratore/area-riservata/websrc/it/base/grid/mainGrid.php?";
        $params = "DescrittoreClasse=".$entita->getRDescrittoreClasse();
        if($entita->getNomeEntita() != null &&  $entita->getNomeEntita() == "Timbra"){
			$onclick = "onclick=\"document.getElementById('mainFrame').src = '\\\CadTimbratore/area-riservata/websrc/it/base/timbra/Timbra.php'\" ";
		}else{
			$onclick = "onclick=\"document.getElementById('mainFrame').src = '".$src.$params."'\" ";
        }
        $voceMenuHTML = "<li ".$onclick.">".$label."</li>";
        return $voceMenuHTML;
    }
}

?>