<?php
class Utente{

	public $idDipendente = "";
	public $nome = "";
	public $cognome = "";
	public $username = "";
	public $password = "";
	

	public function __construct($idDip,$nome,$cognome,$username,$password){
        $this->setIdDipendente($idDip);
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setUsername($username);
        $this->setPassword($password);
	}

	
	
    /**
     * @return string
     */
    public function getIdDipendente()
    {
        return $this->idDipendente;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $idDipendente
     */
    public function setIdDipendente($idDipendente)
    {
        $this->idDipendente = $idDipendente;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function save(){
        require "../../connessione.php";
        $ret = false;
        //echo "<script>window.alert('".$this->idDipendente.$this->username.$this->password."');</script>";
    	if($this->idDipendente != null && $this->username != null && $this->password != null){
    		$query = "INSERT INTO accessi VALUES ";
    		$query .= "(\"".$this->idDipendente."\",\"".$this->username."\",\"".$this->password."\"";
    		$query .= ",\"".$this->nome."\",\"".$this->cognome."\")";
    		$mysqli->autocommit(FALSE);
    		$mysqli->query($query);
    		if($mysqli->affected_rows == 1){
    		    $mysqli->commit();
    		    $ret = true;
    		}else{
    			echo "<script>window.alert('Insert terminata in errore -- ".$query." --');</script>";
    		    $mysqli->rollback();
    		    return false;
    		}
    	}else
    		return false;
        
    	//creo il QR contenente l'id dipendente
    	$this->generaQRDipendente($this->idDipendente);
   	 //    	return false;
    	
        return $ret;
    }
    
    public function generaQRDipendente($idDip){
        require("librerieQR/qrlib.php"); 
        // ECC Level, livello di correzione dell'errore (valori possibili in ordine crescente: L,M,Q,H - da low a high)
        $errorCorrectionLevel = 'L';        
        // Matrix Point Size, dimensione dei punti della matrice (da 1 a 10)
        $matrixPointSize = 10;        
        // I dati da codificare nel QRcode
        $data = $idDip;
        // Il File da salvare (deve essere salvato in una directory scrivibile dal web server)
        $filename = 'QRGenerati/'.$data.'.png';
        // echo "<img src=\"".$filename."\" >";
        // Generiamo il QRcode in formato immagine PNG
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//         echo "<img src=\"".$filename."\" >";
    }
}

?>
