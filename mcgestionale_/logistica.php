<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>M.C. ASSISTANCE - PERSONALE</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="apple-touch-icon" href="images/homebg.jpg">
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flag.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400"

      rel="stylesheet">
    
  </head>
  <body> <!-- PRE LOADER -->
    <div class="preloader">
      <div class="sk-spinner sk-spinner-wordpress"> <span class="sk-inner-circle"></span>
      </div>
    </div>
    <!-- Navigation section  -->
    <nobr>
    <div class="navbar navbar-default navbar-static-top" role="navigation" style="display: none">
      <div class="container">
        <div class="navbar-header"> <button class="navbar-toggle" data-toggle="collapse"

            data-target=".navbar-collapse"> <span class="icon icon-bar"></span>
            <span class="icon icon-bar"></span> <span class="icon icon-bar"></span>
          </button> <a href="index.html" class="navbar-brand">M.C.ASSISTANCE</a>
           <a href="" ><img src="images/ita.png" id="flagi" alt="Italiano" title="Italiano"></a>
           <a href=""><img src="images/ing.jpeg" id="flagi" alt="English" title="English"></a>
           <a href=""><img src="images/esp.png" id="flagi" alt="Español" title="Español"></a>
           <a href=""><img src="images/de.png" id="flagi" alt="Deutsch" title="Deutsch"></a>
           <a href=""><img src="images/po.png" id="flagi" alt="Português" title="Português"></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">

            <li><a href="index.html">Home</a></li>
            <li><a href="azienda.html">Azienda</a></li>
            <li><a href="prodotti.html">Prodotti</a></li>
            <li><a href="contatti.html">Contatti</a></li>
            <li><a href="servizi.php">Servizi</a></li>
            <li class="active"><a href="logistica.php">Logistica</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nobr>
    <!-- Home Section -->
    <section id="home" class="main-staff parallax-section">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <h1> Logistica<br/><br/>Interna</h1>
          </div>
        </div>
      </div>
    </section>
    
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-1 col-md-10 col-sm-12">
            <section id="servizi">
              <form class="box" action="logistica.php" method="POST" style="text-transform: lowercase;" >
                  <h1>Login</h1>
                  <input type="text" name="username" placeholder="Username">
                  <input type="password" name="password" placeholder="Password">
                  <input type="submit" name="invia" value="Login">
              </form>
            </section>
            </div>
          </div>
            <?php
              if(isset($_POST['invia'])){ //quando viene premuto il tasto login
                require "connessione.php";
                $q="SELECT * FROM accessi"; // creo una query che prevela tutto ciò che è all'interno della tabella accessi 
                $result=$mysqli->query($q); //eseguo la query
                while ($row=$result->fetch_assoc()) { 
                  if(($row['username']==$_POST['username'])&&($row['password']==$_POST['password'])){ //se l'username nel DB è uguale a quello inserito e la password del DB è uguale a quella inserita
                  	if($row['username']=='cm'){
              			$_SESSION['logistic']=2;
              			header("Location:ad.php");
                  	}elseif($row['username']=='DITTA'){
                      header("Location:ditta.php");
                    }else{
	                    $idDip=$row['idDipendente']; //creo variabile per il redirect
	                    $_SESSION['d']=$idDip;
	                    $_SESSION['logistic']=1; //assegno 1 alla variabile di sessione logistic che verrà poi controllata dalla pagina seguente
	                    //header("Location:".$idDip.".php");//redirect alla pagina del dipendente che sarà nominata con l'idDip.php
	                    header("Location:ore.php");
	                }
                  }
                } 
              }
            ?>
      </div>
    </section>
    <!-- Footer Section -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-md-offset-1 col-sm-6">
            <h3>M.C. Assistance</h3>
            <p>COSTRUZIONE - ASSISTENZA - PROGRAMMAZIONE - IMPIANTI ROBOTIZZATI</p>
            <div class="footer-copyright">
              <p>P.iva: 02129550980 C.F: MSS CLL 73 L02 L 66 7N</p>
            </div>
            <a href="https://www.iubenda.com/privacy-policy/88826331" class="iubenda-black iubenda-embed" title="Privacy Policy ">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src="https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
          </div>
          <div class="col-md-4 col-md-offset-1 col-sm-6">
            <h3>Contattaci</h3>
            <p><i class="fa fa-globe"></i> Via Salvella Trav. III, 9/11 25038,
              Rovato (BS), Italy.</p>
            <p><i class="fa fa-phone"></i> +39 030 5581801 </p>
            <p><i class="fa fa-envelope"></i> info@mcassistance.it</p>
          </div>
          <div class="clearfix col-md-12 col-sm-12">
            <hr> </div>
          <div class="col-md-12 col-sm-12">
            <ul class="social-icon">
              <li><a href="https://it-it.facebook.com/M.C.ASSISTANCE/" class="fa fa-facebook"></a><br>
              </li>
              <li><a href="https://twitter.com/assistance_c" class="fa fa-twitter"></a><br>
              </li>
              <li><a href="https://www.linkedin.com/in/catello-massa-33813a153/"

                  class="fa fa-linkedin"></a><br>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- Back top -->
    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.parallax.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>