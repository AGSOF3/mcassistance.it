<?php
	session_start();
	$_SESSION['m']='';
	$_SESSION['a']='';
	if(isset($_POST['invia'])){		
		$_SESSION['m']=$_POST['mese'];
		$_SESSION['a']=$_POST['anno'];
	}

	require "connessione.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>VISUALIZZAZIONE ORE</title>
	<style type="text/css">
		select {
			font-size: 20px;
		}
		input{
			font-size: 20px;
		}
		label{
			font-size: 20px;
		}
		td{
			padding: 5px;
		}
	</style>
</head>
<body>
	<div align="center">
		<br/><br/><br/><br/>
		<h3>VISUALIZZA LE TUE ORE : </h3>
	<?php //STAMPA ORE MENSILI
    	$mesi=['gennaio','febbraio','marzo','aprile','maggio','giugno','luglio','agosto','settembre','ottobre','novembre','dicembre'];
		$num=['01','02','03','04','05','06','07','08','09','10','11','12'];
		$anni=['2019','2020','2021','2022','2023']; // creazione 3 array per stampare le option
		
		echo "<div align='center'><form action='' method='POST'>";
		echo "<select name='mese'>"; //operazione analoga alla precedente select
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
		echo "<br/><br /><input type='submit' name='invia'></select>";

		echo "</form></div>";
    ?>
    <br/><br/><br/><br/>
	</div>
    
	<div align="center">
    <!-- SEZIONE DI STAMPA TABELLA CONTENENTE I DATI SULLE ORE DI UN MESE DI UN DIPENDENTE -->
	<?php
		if(isset($_POST['invia'])){
			$qNome="SELECT nome,cognome FROM accessi WHERE idDipendente='".$_SESSION['d']."'"; //SELEZIONE NOME E COGNOME, STAMPA NOME COGNOME E MESE
			$result=$mysqli->query($qNome);
			while ($row=$result->fetch_assoc()) {
				//echo "<h1>".strtoupper($row['nome'])." ".strtoupper($row['cognome'])."</h1>";
				$n=$row['nome'];
				$c=$row['cognome'];
			}
			$mese=$_SESSION['m'];
			if($mese[0]==0){
				$mese=substr($mese, 1,2);
			}
			$mese=($mese-1);
			echo "<div align='center'><h1>".strtoupper($mesi[$mese])."</h1>";
			echo "<table id='tableexport' style='border-collapse: collapse; border:1px solid black; padding:3px;'>";
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
				WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryoreViaggio);
				while ($roe=$result->fetch_assoc()) {
					$oreviaggio=$row['oreV'];
				}
				$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore 
				WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($queryprova);				
				while($row=$result->fetch_assoc()){
					$stra=0;
					if($row['oreg']<8 && $row['oreg']>0 && $oreviaggio>01){
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
				WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
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
				$qinizia="SELECT oreviaggio FROM oreviaggio WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
				$result=$mysqli->query($qinizia);
				while($row=$result->fetch_assoc()){
					if($row['oreviaggio']>0){
						$c=1;
					}else{$c=0;}
				}
				if ($c==1) {
					$queryprova="SELECT SUM(oreLavoro) as oreg, giorno, ex FROM ore 
					WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
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
					WHERE idDipendente='".$_SESSION['d']."' AND giorno='".$_SESSION['a']."-".$_POST['mese']."-".$i."'";
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
			echo "</div>";
		}
	?>

	</div>
	<div align="center">
	<form action="" method="POST">
		
    	<table>
    		<tr align="center">
				<th>MODIFICA ORE</th>
    		</tr>
    		<tr>
    			<td><label>GIORNO:</label></td>
    			<td><input type="date" name="giornoDM"></td> <!-- GIORNO DA MODIFICARE -->
    		</tr>
    		<tr>
    			<td><label>ORE GIORNATA:</label></td>
    			<td><input type="text" name="oreM"></td><!-- ORE EFFETTUATE QUEL GIORNO -->
    			<td><input type="checkbox" name="eliminaOre"></td>
    			<td><label>SVUOTA ORE</label></td>
    			
    		</tr>
    		<tr>
    			<td><label>ORE VIAGGIO GIORNATA:</label></td>
    			<td><input type="text" name="oreVM"></td><!-- ORE VIAGGIO EFFETTUATE QUEL GIORNO -->
    			<td><input type="checkbox" name="eliminaOreV"></td>
    			<td><label>SVUOTA ORE VIAGGIO</label></td>
     		</tr>
    		<tr align="center">
    			<td><input type="submit" name="inviaM" value="invia"></td>
    		</tr>
    	</table>	
	</form>
	<!-- SEZIONE DI MODIFICA DELLE ORE! -->

	<?php
		if(isset($_POST['inviaM']) && $_POST['giornoDM']!=null){

			if($_POST['oreM']!=null){
				$qELIMINAOREATTUALI="DELETE FROM ore WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['d']."' "; //QUERY CHE ELIMINA LA RIGA DI ORE DEL GIORNO SELEZIONATO
				$result = $mysqli -> query($qELIMINAOREATTUALI);

				$qOreO="INSERT INTO ore (oreLavoro, giorno, idDipendente) VALUES ('".$_POST['oreM']."','".$_POST['giornoDM']."','".$_SESSION['d']."') ";//INS ORE DIGITATE
				$result = $mysqli -> query($qOreO);
			}elseif($_POST['eliminaOre']!=null){
				$qELIMINAOREATTUALI="DELETE FROM ore WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['d']."' "; //QUERY CHE ELIMINA LA RIGA DI ORE DEL GIORNO SELEZIONATO
				$result = $mysqli -> query($qELIMINAOREATTUALI);
			}


			if($_POST['oreVM']!=null){
				$qELIMINAOREVIAGGIOATTUALI="DELETE FROM oreviaggio WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['d']."' "; //QUERYELIMINALARIGADIOREVIAGGGIORNOSELEZIONATO
				$result = $mysqli -> query($qELIMINAOREVIAGGIOATTUALI);

				$qOreV="INSERT INTO oreviaggio (oreviaggio, giorno, idDipendente) VALUES ('".$_POST['oreVM']."','".$_POST['giornoDM']."','".$_SESSION['d']."')";//INS OREVIAGGIO DIGITATE
				$result= $mysqli -> query($qOreV);
			}elseif($_POST['eliminaOreV']!=null){
				$qELIMINAOREVIAGGIOATTUALI="DELETE FROM oreviaggio WHERE giorno='".$_POST['giornoDM']."' AND idDipendente='".$_SESSION['d']."' "; //QUERYELIMINALARIGADIOREVIAGGGIORNOSELEZIONATO
				$result = $mysqli -> query($qELIMINAOREVIAGGIOATTUALI);
			}

			//echo $_POST['oreM']."<br/>".$_POST['oreVM'];


		}
	?>
	</div>
</body>
</html>
