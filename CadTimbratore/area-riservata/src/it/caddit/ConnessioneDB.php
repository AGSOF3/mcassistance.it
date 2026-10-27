<?php
	//Connessioni a MYSQL

	//Parametri locali
	// $host = "localhost";
	// $username = "root";
	// $password =  "";
	// $database =  "cadtimbratore";

	//Parametri effettivi"89.46.111.28","Sql1015171","8b5wrlj217","Sql1015171_5"
	$host = "89.46.111.28";
	$username = "Sql1015171";
	$password =  "8b5wrlj217";
	$database =  "Sql1015171_4";

	$mysqli = mysqli_connect($host, $username, $password, $database);

	if(false === $mysqli){
		session_start();
		$_SESSION['PARAM_CONNESSIONE'] = $host."<br>".$username."<br>".$password."<br>".$database;
		header("Location:src/it/caddit/base/connessioni/database/ErroreConnessione.php");
	}

?>

<?php

	//Connessioni a SQLServer

    // $serverName = "localhost\\PANTH02"; //serverName\instanceName
    // $connectionInfo = array( "Database"=>"CADDIT", "UID"=>"sa", "PWD"=>"sa2014");
    // $conn = sqlsrv_connect( $serverName, $connectionInfo);
    
    // if( !$conn ){
    //    die( print_r( sqlsrv_errors(), true));
    // }
?>