<?php 
	session_start();
	//GENERAZIONE DOCUMENTO PDF

	// dichiarare il percorso dei font
	define('FPDF_FONTPATH','./font/');
	//questo file e la cartella font si trovano nella stessa directory
	require('fpdf.php');

	// crea l'istanza del documento
	$p = new fpdf();

	// aggiunge una pagina
	$p->AddPage();

	// Impostare le caratteristiche del carattere
	$p->SetTextColor(0);
	$p->SetFont('Arial', '', 9);

	require "connessione.php";
	//HEADER
		$p->SetFontSize(20);
		$p->Write(10, 'DIPENDENTE: '.getNomeCognome($_SESSION['dip']));	
		$p->Ln();
		$p->Write(10, 'GIORNO    ');
		$p->Write(10, "         ");
		$p->Write(10, 'ARRIVO');				
		$p->Write(10, "         ");
		$p->Write(10, 'USCITA');
		$p->Write(10, "         ");
		$p->Write(10, 'ORE');
		$p->Ln();
		$p->SetFontSize(15);
	for($i=1;$i<32;$i++){
		

		$queryoreViaggio="SELECT oraArrivo, oraUscita, giorno, oreLavoro FROM ore 
		WHERE idDipendente='".$_SESSION['dip']."' AND giorno='".$_SESSION['a']."-".$_SESSION['m']."-".$i."'";
		$result=$mysqli->query($queryoreViaggio);
		while ($row=$result->fetch_assoc()) {
				$p->Write(6, $row['giorno']);
				$p->Write(6, "                   ");
				$p->Write(6, $row['oraArrivo']);				
				$p->Write(6, "                  ");
				$p->Write(6, $row['oraUscita']);
				$p->Write(6, "                  ");
				$p->Write(6, $row['oreLavoro']);
				$p->Ln();
		}
	}	

	

	$p->output();

?>



<?php

	function getNomeCognome($idDip){
		$nomeCognome = "";
		require "connessione.php";
		$query = "SELECT nome,cognome FROM accessi WHERE idDipendente = '".$idDip."' ";
		$result = $mysqli->query($query);
		while ($row = $result->fetch_assoc()) {
			$nomeCognome = $row['nome']." ".$row['cognome'];
		}

		return $nomeCognome;
	}

?>