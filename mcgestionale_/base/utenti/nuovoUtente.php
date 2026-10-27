<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>NUOVO UTENTE</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <style>
        input[type=text]{
            margin:1%;
        }
    </style>
</head>
<body onload="">
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
					<button title="Salva e chiudi"style="display: contents;" name="SaveClose"><img src="../../images/btn/SaveClose.gif"></button>
					<hr style="margin:2%;">
				</div>
			</div>
			<table>
				<tr style="display:none;">
					<td><span>Id Dipendente</span></td>
					<td><input type="text" name="IdDipendente" id="IdDipendente" readonly="readonly"></td>
				</tr>
				<tr>
					<td><span>Nome</span></td>
					<td><input type="text" name="Nome" id="Nome" onchange="completaDatiUtente()"></td>
				</tr>
				<tr>
					<td><span>Cognome</span></td>
					<td><input type="text" name="Cognome" id="Cognome" onchange="completaDatiUtente()"></td>
				</tr>
				<tr>
					<td><span>Username</span></td>
					<td><input type="text" name="Username" id="Username" readonly="readonly"></td>
				</tr>
				<tr>
					<td><span>Password</span></td>
					<td><input type="text" name="Password" id="Password" readonly="readonly"></td>
				</tr>
			</table>
		</div>
	</form>

<script>
	function completaDatiUtente(){
		var nome = document.getElementById("Nome");
		var cognome = document.getElementById("Cognome");
		if(nome.value != null && nome.value != "" && cognome.value != null && cognome.value != ""){
			var UserPass = (nome.value).charAt(0)+(cognome.value).charAt(0);
			document.getElementById("IdDipendente").value = UserPass.toLowerCase();
			document.getElementById("Username").value = UserPass.toLowerCase();
			document.getElementById("Password").value = UserPass.toLowerCase();
		}
	}
</script>
</body>
</html>



<?php 
if(isset($_POST['SaveClose'])){
    require 'UtenteObj.php';
    $idDip = $_POST["IdDipendente"];
    $nome = $_POST["Nome"];
    $cognome = $_POST["Cognome"];
    $username = $_POST["Username"];
    $password = $_POST["Password"];
    $nuovoUtente = new Utente($idDip, $nome, $cognome, $username, $password);
    if($nuovoUtente->save())
        echo "<script>window.close();</script>";
    else
        echo "<script>window.alert(\"ERRORE NEL SALVATAGGIO!\")</script>";
    
}






?>