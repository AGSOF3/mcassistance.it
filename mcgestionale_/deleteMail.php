<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		div#orizzontale {
			width: 300px;
			height: 300px;
			margin: 0 auto;
			align-content:  center;
		}
		div#verticale {
			align-content:  center;
			width: 300px;
			height: 300px;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -100px;
			margin-left: -100px;
		}
	</style>
</head>
<body>
	<div id="orizzontale">
		<div id="verticale">
			<?php
				if (isset($_GET['id'])){
				  $var = $_GET['id'];
				}
				@include 'connessioneMail.php';
				if ((@imap_delete($conn,$var)) && (@imap_expunge($conn))){ 
					echo "<h2>MAIL CANCELLATA CON SUCCESSO, ATTENDI...</h2>";
					@imap_close($conn); //chiudo la connessione al server di posta
					header( "refresh:3;url=mail.php" );
				}
			?>
		</div>
	</div>
</body>
</html>