<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	
	// Usiamo la libreria 
	require("qrlib.php");
	 
	// ECC Level, livello di correzione dell'errore (valori possibili in ordine crescente: L,M,Q,H - da low a high)
	$errorCorrectionLevel = 'L';

	// Matrix Point Size, dimensione dei punti della matrice (da 1 a 10)
	$matrixPointSize = 10;

	// I dati da codificare nel QRcode
	$data = "mf";

	// Il File da salvare (deve essere salvato in una directory scrivibile dal web server)
	$filename = 'qrcode'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
// echo "<img src=\"".$filename."\" >";
	// Generiamo il QRcode in formato immagine PNG
	QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	echo "<img src=\"".$filename."\" >";

?>
</body>
</html>