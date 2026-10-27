<?php 
	unlink($_POST['send']);
	header( "refresh:3;url=protetta.php" );
	echo "<div align='center' style='position:relative; top:30%;'>";
  	echo "<h1>ELIMINAZIONE EFFETTUATA, </h1>";
  	echo "<h1> STAI PER ESSERE RIPORTATO NELL'AREA PROTETTA!</h1>";
  	echo "</div>";
?>