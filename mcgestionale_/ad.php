<!-- VARIABILI DI SESSIONE PER LA GESTIONE DEL SELECTED NELLE OPTION -->
<?php ob_start(); ?>
<?php

	session_start();
	$_SESSION['dip']='';
	$_SESSION['m']='';
	$_SESSION['a']='';
	if(isset($_POST['invia'])){
		$_SESSION['dip']=$_POST['dipendente'];
		$_SESSION['m']=$_POST['mese'];
		$_SESSION['a']=$_POST['anno'];
	}else{
		$_SESSION['a'] = date("Y");  
	}
	//CONTROLLO SICUREZZA 
	  if($_SESSION['logistic']!=2){
	    header("Location:logistica.php");
	  }
	  
	  require "connessione.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>GESTIONE ORE DIPENDENTI</title>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-143089243-1"></script>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/stileCommentiOre.css">
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/flag.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
		select {
			font-size: 20px;
			border-radius: 0px;
			-webkit-appearance: none;
			padding: 2px;
		}
		input{
			font-size: 20px;
		}
		input[type=submit]{
			border-radius: 0px;
		}
		label{
			font-size: 20px;
		}
		td{
			padding: 5px;
		}
		.formAccesso [type = 'text']{
			text-align: center;
		}
		.formAccesso [type = 'password']{
			text-align: center;
		}
		#divLegenda{
			display: none;
			position: absolute;
			width: 100px;
			height: 120px;
		}
	</style>

    <script type="text/javascript" src="js/fncIndex.js"></script>
</head>
<body onload="controlloLarghezza()" onresize="controlloLarghezza()">

	<div class="preloader">
      <div class="sk-spinner sk-spinner-wordpress"> 
        <span class="sk-inner-circle"></span>
      </div>
    </div>
    <!-- Navigation section  -->
    <nobr>
      <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header"> 
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon icon-bar"></span>
              <span class="icon icon-bar"></span> 
              <span class="icon icon-bar"></span>
            </button> 
            <a href="index.html" class="navbar-brand">M.C.ASSISTANCE</a>
            <a href="" ><img src="images/ita.png" id="flagi" alt="Italiano" title="Italiano"></a>
            <a href="en/index.html"><img src="images/ing.jpeg" id="flagi" alt="English" title="English"></a>
            <a href="es/index.html"><img src="images/esp.png" id="flagi" alt="Español" title="Español"></a>
            <a href="de/index.html"><img src="images/de.png" id="flagi" alt="Deutsch" title="Deutsch"></a>
            <a href="po/index.html"><img src="images/po.png" id="flagi" alt="Português" title="Português"></a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="index.html">Home</a></li>
              <li><a href="azienda.html">Azienda</a></li>
              <li><a href="prodotti.html">Prodotti</a></li>
              <li><a href="contatti.html">Contatti</a></li>
              <li><a href="servizi.php">Servizi</a></li>
              <li class="active"><a href="logistica.php">Logistica</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nobr>

<div class="container">
	<div class="row">
		<div class="col-md-offset-1 col-md-10 col-sm-12">
	<h3 style="float:left; margin-top: 1%; margin-right: 1%;">VISUALIZZA LE ORE DI: </h3>
	<!-- SEZIONE DI STAMPA PER LA SELEZIONE DELL'UTENTE	-->
	<?php
		$mesi=['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
		$num=['01','02','03','04','05','06','07','08','09','10','11','12'];
		$anni=['2019','2020','2021','2022','2023']; // creazione 3 array per stampare le option	
		$q="SELECT * FROM accessi ORDER BY nome"; //query in cui seleziono i nomi dei dipendenti tranne quello del capo
		$result = $mysqli->query($q);//eseguo query
		echo "<form action='' method='POST' style='margin-top:1%;' ><select name='dipendente' style='border-radius:0px;'>"; //stamp la form e la select che conterrà i nomi dei dipendenti
		while($row = $result->fetch_assoc()){
			if($row['nome'] != 'Catello'){
				if($_SESSION['dip']==$row['idDipendente']){ //controllo se la variabile di sessione è piena per gestire il selected
					echo "<option value='".$row['idDipendente']."' selected>".$row['nome'].' '.$row['cognome']."</option>";
				}else{
				echo "<option value='".$row['idDipendente']."'>".$row['nome'].' '.$row['cognome']."</option>";
				}
			}
		}
		echo "</select>";
		echo "<select name='mese'>"; //operazione analoga alla precedente select
		$month = date('m');	
		for($i=0;$i<count($mesi);$i++){
			if($_SESSION['m']==$num[$i]){
				echo "<option value='".$num[$i]."' selected='selected'>".$mesi[$i]."</option>";
			}else{
				echo "<option value='".$num[$i]."'>".$mesi[$i]."</option>";
			}
		}
		echo "<br/><br /></select>";

		echo "<select name='anno'>"; //operazione analoga alle precedenti select
		for($i=0;$i<count($anni);$i++){
			if($_SESSION['a']==$anni[$i]){
				echo "<option value='".$anni[$i]."' selected='selected'>".$anni[$i]."</option>";
			}else{
			echo "<option value='".$anni[$i]."'>".$anni[$i]."</option>";
			}
		}
		echo "<br/><br /><input type='submit' name='invia' value='INVIA' ></select>";
		echo "<a href='#' style=\"cursor:context-menu;\" onMouseOver=\"mostraLegenda('divLegenda',1)\" onMouseOut=\"mostraLegenda('divLegenda',0)\">";
		echo "<img style=\"width:25px;height:25px;margin-left:1%;vertical-align:text-bottom;cursor:progress;\" src=\"images\info.jpg\"/> </a>";
		echo "<div id=\"divLegenda\"><img src=\"images\legenda.png\" /></div>";
		echo "</form>";
	?>
	<!-- SEZIONE DI STAMPA TABELLA CONTENENTE I DATI SULLE ORE DI UN MESE DI UN DIPENDENTE -->
	<?php
		if(isset($_POST['invia'])){
		    /** TABELLA ORIZZONTALE **/
			$_SESSION['dipCO'] = $_POST['dipendente']; //CREO VARIABILE DI SESSIONE PER MODIFICA ORE
			$qNome="SELECT nome,cognome FROM accessi WHERE idDipendente='".$_SESSION['dip']."'"; //SELEZIONE NOME E COGNOME, STAMPA NOME COGNOME E MESE
			$result=$mysqli->query($qNome);
			while ($row=$result->fetch_assoc()) {
				// echo "<h1>".strtoupper($row['nome'])." ".strtoupper($row['cognome'])."</h1>";
				$n=$row['nome'];
				$c=$row['cognome'];
				$cognome = $row['cognome']; //non cancellare 
			}
			$mese=$_SESSION['m'];
			if($mese[0]==0){
				$mese=substr($mese, 1,2);
			}
			$mese=($mese-1);
			// echo "<h1>".strtoupper($mesi[$mese])."</h1>";
			echo "<iframe id='txtArea1' style='display:none'></iframe>";
			echo "<table id='tabellaOreOrizz' style='border-collapse: collapse; border:1px solid black; padding:3px;'>";
			echo "<tr><td style='border:1px solid black; padding: 3px; text-align:center; '>cognome</td>
					<td style='border:1px solid black; padding: 3px; text-align:center; '>qual.</td>";
			//STAMPO I NUMERI DA 01 A 31		
			for($i=1;$i<32;$i++){
				if($i<10){
					echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>0".$i."</th>";
				}else{
					echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>".$i."</th>";
				}
			}
			//STAMPO RIGA SPAZIO
			echo  "<tr> <td style='border:1px solid black; padding: 3px; text-align:center; '>nome</td>";
			for($i=0;$i<32;$i++){
					echo "<th bgcolor='' style='border:1px solid black; padding: 5px; text-align:center; '></th>";
			}
			//STAMPO ORE GIORNATA
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center;'>".strtoupper($c)."</th>
						<th style='border:1px solid black; padding: 3px; text-align:center;'>O</th>";
			for($i=1;$i<32;$i++){
				$queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio 
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryoreViaggio);
				while ($row=$result->fetch_assoc()) {
					$oreviaggio=$row['oreV'];
				}
				//REPERISCO GLI ORARI DI TIMBRATURA DEL POMERIGGIO
				$oraUscitaPome = '00:00:00';
				$oraArrivoPome = '00:00:00';
				$queryoraUscita = "SELECT oraArrivo, oraUscita FROM ore WHERE idDipendente='".$_SESSION['dip']."' 
				AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."' AND oraUscita > '14:00:00' LIMIT 0 , 30 ";
				$result = $mysqli->query($queryoraUscita);
				while($row=$result->fetch_assoc()){
					$oraArrivoPome = $row['oraArrivo'];
					$oraUscitaPome = $row['oraUscita'];
				}
				$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex, oraArrivo, oraUscita FROM ore
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryprova);				
				while($row=$result->fetch_assoc()){
					$stra=0;
					if($row['oreg']<8 && $row['oreg']>0 && $oreviaggio>0){
						$appoggio=8-$row['oreg'];
						$row['oreg']=8;
						$oreviaggio=$oreviaggio-$appoggio;
						echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['oreg']."</td>";	
					}elseif ($row['oreg']==0) {
						echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['ex']."</td>";
					}elseif($row['oreg']!=0){						
						if($row['oreg']>8){
							$stra=$row['oreg']-8;
							$row['oreg']=8;
						}if($row['oraUscita'] == '00:00:00' && $row['oraArrivo'] == '00:00:00'){
							echo "<td style='border:1px solid black; padding: 3px; text-align:center;color: white;background-color: #ff0000ab;'><a style='color:white' class='tip'>";
							echo "<span><table><tr><td class='sc'>Mattina:</td></tr><tr><td>".$row['oraArrivo']." - ".$row['oraUscita']."</td></tr>";
							echo "<tr><td class='sc'>Pomeriggio:</td></tr><tr><td>".$oraArrivoPome." - ".$oraUscitaPome."</td></tr></table></span>";
							echo "0</td>";
						}else{	
							echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '><a style='color:black' class='tip'>";
							echo "<span><table><tr><td class='sc'>Mattina:</td></tr><tr><td>".$row['oraArrivo']." - ".$row['oraUscita']."</td></tr>";
							echo "<tr><td class='sc'>Pomeriggio:</td></tr><tr><td>".$oraArrivoPome." - ".$oraUscitaPome."</td></tr></table></span>";
							echo $row['oreg']."</td>";
						}
					}/*elseif($row['oraArrivo'] == "00:00:00" && $row['oraUscita'] == "00:00:00"){
						echo "<td style='border:1px solid black; padding: 3px; text-align:center;color: white;background-color: #ff0000ab;'><a style='color:white' class='tip'>";
						echo "<span><table><tr><td class='sc'>Mattina:</td></tr><tr><td>".$row['oraArrivo']." - ".$row['oraUscita']."</td></tr>";
						echo "<tr><td class='sc'>Pomeriggio:</td></tr><tr><td>".$oraArrivoPome." - ".$oraUscitaPome."</td></tr></table></span>";
						echo $row['oreg']."</td>";
					}*/
				}
			}
			//STAMPO ORE STRAORDINARIE
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center; '>".strtoupper($n)."</th>
										<th style='border:1px solid black; padding: 3px; text-align:center;'>S</th>";
			for($i=1;$i<32;$i++){
				$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, oreStraordinarie FROM ore 
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryprova);
				while($row=$result->fetch_assoc()){
					$stra='';
					if($row['oreg']>8){
						$stra=$row['oreg']-8;
						$row['oreg']=8;
					}elseif($row['oreg']==0){
						$stra=$row['oreStraordinarie'];
					}
					echo "<td bgcolor='#32c8db' style='border:1px solid black; padding: 3px; text-align:center; '>".$stra."</td>";
				}
			}
			//STAMPO ORE VIAGGIO
			$oreviaggio='';
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center; '>VIAGGIO</th>
			<th style='border:1px solid black; padding: 3px; text-align:center;'>V</th>";
			for($i=1;$i<32;$i++){
				$c=0;
				$oreviaggio='';
				$qinizia="SELECT oreviaggio FROM oreviaggio WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($qinizia);
				while($row=$result->fetch_assoc()){
					if($row['oreviaggio']>0){
						$c=1;
					}else{$c=0;}
				}
				if ($c==1) {				
					$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore 
					WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
					$result=$mysqli->query($queryprova);
					while ($row=$result->fetch_assoc()) {
						if($row['oreg']<8 && $row['oreg']>0){
							$f=1;
							$appoggio=8-$row['oreg'];
							$row['oreg']=8;
							$oreviaggio=$oreviaggio-$appoggio;
						}else{
							$f=0;
						}
					}
					$queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio 
					WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
					$result=$mysqli->query($queryoreViaggio);
					while ($row=$result->fetch_assoc()) {
						if($f==1){
							$oreviaggio=$row['oreV']-$appoggio;
						}else{
							$oreviaggio=$row['oreV'];
						}
					}
				}
				echo "<td bgcolor='#c72cdb' style='border:1px solid black; padding: 3px; text-align:center; '>".$oreviaggio."</td>";
			}
			echo "</tr></table>";
			/** TABELLA VERTICALE **/
			echo "<br><br>";
			echo "<div align='center'>";
			echo "<table id='tabellaOreVerti' style='align:center; border-collapse: collapse; border:1px solid black; padding:3px;'> <tr> ";
			echo "<th style='border:1px solid black; padding: 5px; text-align:center;'></th>";
			echo "<th style='border:1px solid black; padding: 5px; text-align:center;'>".$cognome."</th>";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'>".$n."</th> ";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'></th></tr>";
            echo "<tr>";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'></th>";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'>O</th>";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'>S</th>";
            echo "<th style='border:1px solid black; padding: 5px; text-align:center;'>VIAGGIO</th> </tr>";
            
			echo "<tr>";
			for($i=1;$i<32;$i++){
			    if($i<10){
			        echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>0".$i."</th>";
			    }else{
			        echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>".$i."</th>";
			    }
			    //STAMPO ORE GIORNATA
		        $queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
			        $result=$mysqli->query($queryoreViaggio);
			        while ($row=$result->fetch_assoc()) {
			            $oreviaggio=$row['oreV'];
			        }
			        //REPERISCO GLI ORARI DI TIMBRATURA DEL POMERIGGIO
			        $oraUscitaPome = '00:00:00';
			        $oraArrivoPome = '00:00:00';
			        $queryoraUscita = "SELECT oraArrivo, oraUscita FROM ore WHERE idDipendente='".$_SESSION['dip']."'
				AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."' AND oraUscita > '14:00:00' LIMIT 0 , 30 ";
			        $result = $mysqli->query($queryoraUscita);
			        while($row=$result->fetch_assoc()){
			            $oraArrivoPome = $row['oraArrivo'];
			            $oraUscitaPome = $row['oraUscita'];
			        }
			        $queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex, oraArrivo, oraUscita FROM ore
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
			        $result=$mysqli->query($queryprova);
			        while($row=$result->fetch_assoc()){
			            $stra=0;
			            if($row['oreg']<8 && $row['oreg']>0 && $oreviaggio>0){
			                $appoggio=8-$row['oreg'];
			                $row['oreg']=8;
			                $oreviaggio=$oreviaggio-$appoggio;
			                echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['oreg']."</td>";
			            }elseif ($row['oreg']==0) {
			                echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['ex']."</td>";
			            }elseif($row['oreg']!=0){
			                if($row['oreg']>8){
			                    $stra=$row['oreg']-8;
			                    $row['oreg']=8;
			                }if($row['oraUscita'] == '00:00:00' && $row['oraArrivo'] == '00:00:00'){
			                    echo "<td style='border:1px solid black; padding: 3px; text-align:center;color: white;background-color: #ff0000ab;'><a style='color:white' class='tip'>";
			                    echo "<span><table><tr><td class='sc'>Mattina:</td></tr><tr><td>".$row['oraArrivo']." - ".$row['oraUscita']."</td></tr>";
			                    echo "<tr><td class='sc'>Pomeriggio:</td></tr><tr><td>".$oraArrivoPome." - ".$oraUscitaPome."</td></tr></table></span>";
			                    echo "0</td>";
			                }else{
			                    echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '><a style='color:black' class='tip'>";
			                    echo "<span><table><tr><td class='sc'>Mattina:</td></tr><tr><td>".$row['oraArrivo']." - ".$row['oraUscita']."</td></tr>";
			                    echo "<tr><td class='sc'>Pomeriggio:</td></tr><tr><td>".$oraArrivoPome." - ".$oraUscitaPome."</td></tr></table></span>";
			                    echo $row['oreg']."</td>";
			                }
			            }
			        }
			        //STAMPO ORE STRAORDINARIE
		            $queryprova="SELECT SUM(oreLavoro) as oreg, giorno, oreStraordinarie FROM ore
				                WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
		            $result=$mysqli->query($queryprova);
		            while($row=$result->fetch_assoc()){
		                $stra='';
		                if($row['oreg']>8){
		                    $stra=$row['oreg']-8;
		                    $row['oreg']=8;
		                }elseif($row['oreg']==0){
		                    $stra=$row['oreStraordinarie'];
		                }
		                echo "<td bgcolor='#32c8db' style='border:1px solid black; padding: 3px; text-align:center; '>".$stra."</td>";
		            }
		            //STAMPO ORE VIAGGIO
		            $oreviaggio='';
	                $c=0;
	                $oreviaggio='';
	                $qinizia="SELECT oreviaggio FROM oreviaggio WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
	                $result=$mysqli->query($qinizia);
	                while($row=$result->fetch_assoc()){
	                    if($row['oreviaggio']>0){
	                        $c=1;
	                    }else{$c=0;}
	                }
	                if ($c==1) {
	                    $queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
	                    $result=$mysqli->query($queryprova);
	                    while ($row=$result->fetch_assoc()) {
	                        if($row['oreg']<8 && $row['oreg']>0){
	                            $f=1;
	                            $appoggio=8-$row['oreg'];
	                            $row['oreg']=8;
	                            $oreviaggio=$oreviaggio-$appoggio;
	                        }else{
	                            $f=0;
	                        }
	                    }
	                    $queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
	                    $result=$mysqli->query($queryoreViaggio);
	                    while ($row=$result->fetch_assoc()) {
	                        if($f==1){
	                            $oreviaggio=$row['oreV']-$appoggio;
	                        }else{
	                            $oreviaggio=$row['oreV'];
	                        }
	                    }
	                }
	                echo "<td bgcolor='#c72cdb' style='border:1px solid black; padding: 3px; text-align:center; '>".$oreviaggio."</td>";
	            
			    
			    echo "</tr>";
			}
			
			
			
			echo "</div>";
		}
	?>
	
	
	
	
	<!-- STAMPO TABELLA IN DISPLAY:NONE CHE VIENE UTILIZZATA PER DOWNLOAD EXCEL -->
	<?php
		if(isset($_POST['invia'])){
			$_SESSION['dipCO'] = $_POST['dipendente']; //CREO VARIABILE DI SESSIONE PER MODIFICA OREVIAGGIO
			echo "<iframe id='txtArea1' style='display:none'></iframe>";
			echo "<table id='tableexport' style='border-collapse: collapse; border:1px solid black; padding:3px; display:none;'>";
			echo "<tr><td style='border:1px solid black; padding: 3px; text-align:center; '>cognome e</td>
					<td style='border:1px solid black; padding: 3px; text-align:center; '>qual.</td>";
			//STAMPO I NUMERI DA 01 A 31		
			for($i=1;$i<32;$i++){
				if($i<10){
					echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>0".$i."</th>";
				}else{
					echo "<th bgcolor='C3C3C3' style='border:1px solid black; padding: 5px; text-align:center; '>".$i."</th>";
				}
			}
			//STAMPO RIGA SPAZIO
			echo  "<tr> <td style='border:1px solid black; padding: 3px; text-align:center; '>nome</td>";
			for($i=0;$i<32;$i++){
					echo "<th bgcolor='' style='border:1px solid black; padding: 5px; text-align:center; '></th>";
			}
			//STAMPO ORE GIORNATA
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center;'>".strtoupper($c)."</th>
						<th style='border:1px solid black; padding: 3px; text-align:center;'>O</th>";
			for($i=1;$i<32;$i++){
				$queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio 
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryoreViaggio);
				while ($row=$result->fetch_assoc()) {
					$oreviaggio=$row['oreV'];
				}
				$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryprova);				
				while($row=$result->fetch_assoc()){
					$stra=0;
					if($row['oreg']<8 && $row['oreg']>0 && $oreviaggio>0){
						$appoggio=8-$row['oreg'];
						$row['oreg']=8;
						$oreviaggio=$oreviaggio-$appoggio;
						echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['oreg']."</td>";	
					}elseif ($row['oreg']==0) {
						echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['ex']."</td>";
					}elseif($row['oreg']!=0){
						if($row['oreg']>8){
							$stra=$row['oreg']-8;
							$row['oreg']=8;
						}
						echo "<td bgcolor='#30d15b' style='border:1px solid black; padding: 3px; text-align:center; '>".$row['oreg']."</td>";
					}
				}
			}
			//STAMPO ORE STRAORDINARIE
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center; '>".strtoupper($n)."</th>
										<th style='border:1px solid black; padding: 3px; text-align:center;'>S</th>";
			for($i=1;$i<32;$i++){
				$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, oreStraordinarie FROM ore 
				WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryprova);
				while($row=$result->fetch_assoc()){
					$stra='';
					if($row['oreg']>8){
						$stra=$row['oreg']-8;
						$row['oreg']=8;
					}elseif($row['oreg']==0){
						$stra=$row['oreStraordinarie'];
					}
					echo "<td bgcolor='#32c8db' style='border:1px solid black; padding: 3px; text-align:center; '>".$stra."</td>";
				}
			}
			//STAMPO ORE VIAGGIO
			$oreviaggio='';
			echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center; '>VIAGGIO</th>
			<th style='border:1px solid black; padding: 3px; text-align:center;'>V</th>";
			for($i=1;$i<32;$i++){
				$c=0;
				$oreviaggio='';
				$qinizia="SELECT oreviaggio FROM oreviaggio WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($qinizia);
				while($row=$result->fetch_assoc()){
					if($row['oreviaggio']>0){
						$c=1;
					}else{$c=0;}
				}
				if ($c==1) {				
					$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore 
					WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
					$result=$mysqli->query($queryprova);
					while ($row=$result->fetch_assoc()) {
						if($row['oreg']<8 && $row['oreg']>0){
							$f=1;
							$appoggio=8-$row['oreg'];
							$row['oreg']=8;
							$oreviaggio=$oreviaggio-$appoggio;
						}else{
							$f=0;
						}
					}
					$queryoreViaggio="SELECT SUM(oreviaggio) as oreV, giorno FROM oreviaggio 
					WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
					$result=$mysqli->query($queryoreViaggio);
					while ($row=$result->fetch_assoc()) {
						if($f==1){
							$oreviaggio=$row['oreV']-$appoggio;
						}else{
							$oreviaggio=$row['oreV'];
						}
					}
				}
				echo "<td bgcolor='#c72cdb' style='border:1px solid black; padding: 3px; text-align:center; '>".$oreviaggio."</td>";
			}
			echo "</tr></table>";
			echo "<br/>";
			echo " <button onclick=\"window.open('pdf.php','PDF ORE','width=600,height=650')\" style=\"display: contents;\">
				  	<img src=\"images/btn/btnPdf.png\" style=\"width:30px;height:30px;\" />	
				  </button>
				  <button id='btnExport' onclick='fnExcelReport();' style=\"display: contents;\">
				  	<img src=\"images/btn/btnXls.png\" style=\"width:30px;height:30px;\" />	
				  </button>";
		}


	?>

		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<form action="" method="POST">
				<h3 onclick="mostraModOre()" align="center" id="labelModOre" style="cursor: pointer;  user-select: none;">MODIFICA ORE &#9660;</h3>
				<div id="tableModOre" style="display: none;">
					<table style="padding: 5px;">
						<tr>
							<td><input type="date" name="giornoDM"></td> <!-- GIORNO DA MODIFICARE -->
						</tr>
						<tr>
							<td><input type="text" name="oreM" placeholder="ORE GIORNATA"></td><!-- ORE EFFETTUATE QUEL GIORNO -->  			
						</tr>
						<tr>
							<td><input type="text" name="oreVM" placeholder="ORE VIAGGIO"></td><!-- ORE VIAGGIO EFFETTUATE QUEL GIORNO -->  			
						</tr>
						<tr><td><input type="checkbox" name="eliminaOre"><label>SVUOTA ORE</label></td></tr>
						<tr><td><input type="checkbox" name="eliminaOreV"><label>SVUOTA ORE VIAGGIO</label></td></tr>
					</table>
					<input type="submit" name="inviaM" value="Invia">
				</div>
			</form>
		</div>

		<div class="col-md-3 col-sm-6">
			<form action="" method="POST">
				<!-- <input type="submit" name="mail" value="MAIL"> -->
				<button name="mail" style="display: contents;">
					<h3 style="cursor: pointer;  user-select: none;">MAIL</h3>
				</button>
			</form>
		</div>
		
		<div class="col-md-3 col-sm-6">
    		<form action="" method="POST">		
    			<button name="cameraQR" style="display: contents;">
    				<h3 style="cursor: pointer;  user-select: none;">CAMERA QRCODE</h3>
    			</button>
			</form>
		</div>

		<div class="col-md-3 col-sm-6">		
			<form action="" method="POST">
				<button name="vediUtEs" style="display: contents;">
					<h3 style="cursor: pointer;  user-select: none;">VEDI UTENTI</h3>
				</button>
			</form>
		</div>

		
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<br/><br/><br/>
		</div>
	</div>
</div>
	<?php
		// SE PREMO IL BOTTONE MAIL
		if(isset($_POST['mail'])){
			$_SESSION['autoMail'] = 1;
			header("location:mail.php");
		}elseif(isset($_POST['cameraQR'])){ //SE PREMO IL BOTTONE CAMERAQR    
		    header("location:cameraQR.php");
		}
	?>
	<?php
		/*
			IF AVVIATO CON IL BOTTONE VEDI UTENTI CHE STAMPA UNA TABELLA CON TUTTI GLI UTENTI REGISTRATI NEL DATABASE!
		*/
		if(isset($_POST['vediUtEs'])){
			$result = $mysqli->query("SELECT * FROM accessi");
			echo "<div align='center'><form method='POST'>";
			echo "<span onclick=\"newUtente()\" style=\"margin:5px;cursor:pointer;font-weight: bold;font-size: medium;\">NUOVO</span>";
// 			echo "<button name=\"eliminaUtente\" style=\"display:contents;margin:5px;\"><span>ELIMINA</span></button>";
            echo "<table style='border-collapse: collapse; border:0px solid black; padding:3px;'>
			<tr>
				<th style='border:0px solid black; padding: 3px; text-align:center; '></th>
				<th style='border:1px solid grey; padding: 3px; text-align:center; '>ID DIPENDENTE</th>
				<th style='border:1px solid grey; padding: 3px; text-align:center; '>USERNAME</th>
				<th style='border:1px solid grey; padding: 3px; text-align:center; '>PASSWORD</th>
				<th style='border:1px solid grey; padding: 3px; text-align:center; '>NOME</th>
				<th style='border:1px solid grey; padding: 3px; text-align:center; '>COGNOME</th>
			</tr>";
			$i = 0;
			while ($row = $result->fetch_assoc()) {
				
				if($i%2!=0){										//STAMPO UNA RIGA BIANCA E UNA GRIGIA (i=0 prima riga grigia)
					echo "<tr style='background:white;'>";					
				}elseif($i%2 == 0){
					echo "<tr style='background:#DFDFDF;'>";					
				}
				echo "<td style='border:0px solid white; padding: 3px; text-align:center; '>
						<input type='checkbox' value='".$row['idDipendente']."' name='eli[]'></td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['idDipendente']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center; '>".$row['username']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center; '>".$row['password']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center; '>".$row['nome']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center; '>".$row['cognome']."</td>";
				
				echo "</tr>";
				$i++;
				
			}
			echo "</table></form></div>";
		}

		/*
			IF AVVIATO CON IL BOTTONE VEDI ADMIN CHE STAMPA UNA TABELLA CON TUTTI GLI ADMIN REGISTRATI NEL DATABASE!
		*/
		/*if(isset($_POST['vediAdEs'])){
			$mysqli = new mysqli("89.46.111.28","Sql1015171","8b5wrlj217","Sql1015171_5"); //COLLEGAMENTO A DB
			$result = $mysqli->query("SELECT * FROM accessiadmin");
			echo "<div align='center'>";
			echo "<form method='POST'>";
			echo "<table style='border-collapse: collapse; border:0px solid black; padding:3px;'>";
			echo "<tr>																						
					<th style='border:0px solid black; padding: 3px; text-align:center; '></th>
					<th style='border:1px solid grey; padding: 3px; text-align:center; '>ID ADMIN</th>
					<th style='border:1px solid grey; padding: 3px; text-align:center; '>USERNAME</th>
					<th style='border:1px solid grey; padding: 3px; text-align:center; '>PASSWORD</th>
					<th style='border:1px solid grey; padding: 3px; text-align:center; '>NOME</th>
					<th style='border:1px solid grey; padding: 3px; text-align:center; '>COGNOME</th>
				  </tr>";

			$i = 0;

			while ($row = $result->fetch_assoc()) {

				if($i%2!=0){								//STAMPO UNA RIGA BIANCA E UNA GRIGIA (i=0 prima riga grigia)
					echo "<tr style='background:white;'>";					
				}elseif($i%2 == 0){
					echo "<tr style='background:#DFDFDF;'>";					
				}

				echo "<td style='border:0px solid white; padding: 3px; text-align:center; '>
						<input type='checkbox' value='".$row['idAdmin']."' name='eli[]'></td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['idAdmin']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['username']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['password']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['nome']."</td>";
				echo "<td style='border:0px solid black; padding: 3px; text-align:center;'>".$row['cognome']."</td>";
				$i++;
			}
			echo "</table><input type='submit' value='elimina' name='eliminaAdmin'></form></div>";
		}*/

		/*
			IF AVVIATO CON LA PRESSIONE DEL TASTO ELIMINA UTENTI CHE ELIMINA DAL DB QUELLI SELEZIONATI
		*/

		if(isset($_POST['eliminaUtenti'])){

			$eli = isset($_POST['eli']) ? $_POST['eli'] : array(); //CREO UN ARRAY CON TUTTI GLI ID SELEZIONATI DALLA TABELLA
			
			foreach ($eli as $elimina ) {
				$result=$mysqli->query("DELETE FROM accessi WHERE idDipendente='".$elimina."'"); //ESEGUO LA QUERY CHE ELIMINA DAL DB
			}

		}

		/*
			IF AVVIATO CON LA PRESSIONE DEL TASTO ELIMINA UTENTI CHE ELIMINA DAL DB QUELLI SELEZIONATI
		*/

		/*
		if(isset($_POST['eliminaAdmin'])){
			$mysqli = new mysqli("89.46.111.28","Sql1015171","8b5wrlj217","Sql1015171_5"); //COLLEGAMENTO A DB
			$eli = isset($_POST['eli']) ? $_POST['eli'] : array(); //CREO UN ARRAY CON TUTTI GLI ID SELEZIONATI DALLA TABELLA
			
			foreach ($eli as $elimina ) {
				$result=$mysqli->query("DELETE FROM accessiadmin WHERE idAdmin='".$elimina."'"); //ESEGUO LA QUERY CHE ELIMINA DAL DB
			}

		}
		*/

		

	?>
</div>
	  <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-md-offset-1 col-sm-6">
            <h3>M.C. Assistance</h3>
            <p>COSTRUZIONE - ASSISTENZA - PROGRAMMAZIONE - IMPIANTI ROBOTIZZATI</p>
            <div class="footer-copyright">
              <p>P.iva: 02129550980 C.F: MSS CLL 73 L02 L 66 7N</p>
            </div>
            <a href="https://www.iubenda.com/privacy-policy/88826331" class="iubenda-black iubenda-embed" title="Privacy Policy ">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src="https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
          </div>
          <div class="col-md-4 col-md-offset-1 col-sm-6">
            <h3>Contattaci</h3>
            <p><i class="fa fa-globe"></i> Via Salvella Trav. III, 9/11 25038,
              Rovato (BS), Italy.</p>
            <p><i class="fa fa-phone"></i> +39 030 5581801 </p>
            <p><i class="fa fa-envelope"></i> info@mcassistance.it</p>
          </div>
          <div class="clearfix col-md-12 col-sm-12">
            <hr> 
          </div>
          <div class="col-md-12 col-sm-12">
            <ul class="social-icon">
              <li><a href="https://it-it.facebook.com/M.C.ASSISTANCE/" class="fa fa-facebook"></a><br>
              </li>
              <li><a href="https://twitter.com/assistance_c" class="fa fa-twitter"></a><br>
              </li>
              <li><a href="https://www.linkedin.com/in/catello-massa-33813a153/"

                  class="fa fa-linkedin"></a><br>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- Back top -->
    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/particles.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/jquery.parallax.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/custom.js"></script>
    <script>
    function controlloLarghezza(){
    	var w = window.outerWidth;
    	if(w < 975){
    		document.getElementById('tabellaOreOrizz').style.display = 'none';
    		document.getElementById('tabellaOreVerti').style.display = 'table';
    	}else{
    		document.getElementById('tabellaOreVerti').style.display = 'none';
    		document.getElementById('tabellaOreOrizz').style.display = 'table';
    	}
    }
    </script>
</body>
</html>



<!-- SEZIONE DI MODIFICA DELLE ORE! -->
	<?php
		if(isset($_POST['inviaM']) && $_POST['giornoDM']!=null){

			if($_POST['oreM']!=null){
				$qELIMINAOREATTUALI="DELETE FROM ore WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['dipCO']."' "; //QUERY CHE ELIMINA LA RIGA DI ORE DEL GIORNO SELEZIONATO
				$result = $mysqli -> query($qELIMINAOREATTUALI);

				$qOreO="INSERT INTO ore (oreLavoro, giorno, idDipendente, oraArrivo) VALUES ('".$_POST['oreM']."','".$_POST['giornoDM']."','".$_SESSION['dipCO']."', '08:00:00') ";//INS ORE DIGITATE
				$result = $mysqli -> query($qOreO);
			}elseif($_POST['eliminaOre']!=null){
				$qELIMINAOREATTUALI="DELETE FROM ore WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['dipCO']."' "; //QUERY CHE ELIMINA LA RIGA DI ORE DEL GIORNO SELEZIONATO
				$result = $mysqli -> query($qELIMINAOREATTUALI);
			}


			if($_POST['oreVM']!=null){
				$qELIMINAOREVIAGGIOATTUALI="DELETE FROM oreviaggio WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['dipCO']."' "; //QUERYELIMINALARIGADIOREVIAGGGIORNOSELEZIONATO
				$result = $mysqli -> query($qELIMINAOREVIAGGIOATTUALI);

				$qOreV="INSERT INTO oreviaggio (oreviaggio, giorno, idDipendente) VALUES ('".$_POST['oreVM']."','".$_POST['giornoDM']."','".$_SESSION['dipCO']."')";//INS OREVIAGGIO DIGITATE
				$result= $mysqli -> query($qOreV);
			}elseif($_POST['eliminaOreV']!=null){
				$qELIMINAOREVIAGGIOATTUALI="DELETE FROM oreviaggio WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['dipCO']."' "; //QUERYELIMINALARIGADIOREVIAGGGIORNOSELEZIONATO
				$result = $mysqli -> query($qELIMINAOREVIAGGIOATTUALI);
			}

			//echo $_SESSION['dipCO'];


		}
	?>