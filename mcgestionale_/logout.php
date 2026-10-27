<?php
session_start();

 $_SESSION=array(); // Desetta tutte le variabili di sessione.
 session_destroy(); //DISTRUGGE la sessione.
 header("Location: servizi.php"); //si ricarica la pagina di login
 exit; //si termina lo script in modo da ritornare alla schermata di login

?>