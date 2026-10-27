<?php 
   
?>
<!DOCTYPE html>
<html>
<head>
	<title>IMPOSTAZIONI QR</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleQR.css">
</head>
<body onload="impostazioniQROL()">
	<div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0px;">
		<div class="container">
			<div class="navbar-header">
				<a href="" class="navbar-brand"><span id="tit">M.C.ASSISTANCE</span></a>
			</div>
		</div>
	</div>
	<form action="" method="POST">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<button title="Salva e chiudi"style="display: contents;" name="SaveClose"><img src="images/btn/SaveClose.gif"></button>
					<hr style="margin:2%;">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<span>CONFERMA:</span>
					<select name="suoniConferma" onchange="mostraContrVoce()" id="suoniConferma">
						<option value="S">SUONI CONFERMA</option>
						<option value="V">VOCE CONFERMA</option>
					</select>
				</div>
			</div>
			<div class="row" id="controlliVoce" style="display:none;">
				<div class="col-sm-12">
					<input type="checkbox" name="VOCE_ORA" id="voceOra" value="Y"><span>ORA</span>
				</div>
				<div class="col-sm-12">
					<input type="checkbox" name="VOCE_GIORNO" id="voceGiorno" value="Y"><span>GIORNO</span>
				</div>
			</div>
		</div>
	</form>

<script type="text/javascript" src="js/appQR.js"></script>
</body>
</html>



<?php 
    completaCampi();
    
	if(isset($_POST['Save'])){ //se è stato premuto salva
	    save();
	}elseif(isset($_POST['SaveClose'])){ //se è stato premuto salva e chiudi
	    $conferma = $_POST['suoniConferma'];
	    $voceOra = "N";
	    if(isset($_POST['VOCE_ORA']))
	        $voceOra = "Y";
        $voceGiorno = "N";
        if(isset($_POST['VOCE_GIORNO']))
            $voceGiorno = "Y";
	    save($conferma,$voceOra,$voceGiorno);
	    chiudiPagina();
	}
	
	function completaCampi(){
	    require "connessione.php";
	    $q = "SELECT * FROM impostazioniQR";
	    $result = $mysqli->query($q);
	    while($row = $result->fetch_assoc()){
	        $conferma = $row['CONFERMA'];
	        $voceOra = $row['VOCE_ORA'];
	        $voceGiorno = $row['VOCE_GIORNO'];
	    }
	    
	    if($voceOra == 'Y')
	        echo "<script> document.getElementById('voceOra').checked = true;</script>";
	    elseif($voceOra == 'N')
    	    echo "<script> document.getElementById('voceOra').checked = false;</script>";
	    if($voceGiorno == 'Y')
	        echo "<script> document.getElementById('voceGiorno').checked = true;</script>";
        elseif($voceGiorno == 'N')
	        echo "<script> document.getElementById('voceGiorno').checked = false;</script>";
        
        if($conferma == 'V')
            echo "<script> document.getElementById('suoniConferma').value = 'V';</script>";
        elseif($conferma = 'S')
            echo "<script> document.getElementById('suoniConferma').value = 'S';</script>";
	}
	
	function save($conferma,$voceOra,$voceGiorno){
	    require "connessione.php";
        $q = "UPDATE impostazioniqr SET CONFERMA = '".$conferma."' ,".
            "VOCE_ORA = '".$voceOra."', VOCE_GIORNO = '".$voceGiorno."'";
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
	
	function chiudiPagina(){
	    echo "<script>";
	    echo "window.close();";
	    echo "</script>";
	}
	
?>