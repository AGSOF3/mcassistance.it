<?php
		// server IMAP per la connessione
		$server = '{imaps.aruba.it:993/ssl/novalidate-cert}';
		// account mail
		$login = 'info@mcassistance.it';
		// password mail
		$password = 'Anna25Elena17';
		//connessione o messaggio di errore
		$conn = imap_open($server, $login, $password) or die('Non sono riuscito a connettermi, errore:' .imap_last_error());
?>