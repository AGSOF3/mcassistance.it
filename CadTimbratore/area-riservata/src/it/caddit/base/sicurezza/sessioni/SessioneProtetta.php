<?php
	
	function protetta_session_start(){
		$session_name = 'protetta_session_start';
		$secure = false; //DA IMPOSTARE A TRUE SE SI USA IL PROT HTTPS
		$httponly = true; //non permette a javascript di intercettare l'id sessione
		ini_set('session.use_only_cookies', 1); //Obbliga la sessione ad usare solo i cookie
		$cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
        session_start(); // Avvia la sessione php.
        session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.	
	}

?>