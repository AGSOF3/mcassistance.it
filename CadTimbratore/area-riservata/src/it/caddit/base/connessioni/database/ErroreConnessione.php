<?php

	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>ERRORE CONNESSIONE</title>
</head>
<body>
	<h1>ERRORE NELLA CONNESSIONE AL DATABASE</h1><br>
	<h2>Parametri:</h2><br>
	<h3><?php echo $_SESSION['PARAM_CONNESSIONE']; ?></h3>
</body>
</html>