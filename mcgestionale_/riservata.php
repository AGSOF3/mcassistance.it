<?php
  session_start();
  if($_SESSION['autorized']==0)
    header("Location:servizi.php");

  require "connessione.php";

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
    <title>M.C. ASSISTANCE - Area Riservata</title>
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400"

      rel="stylesheet">
      <style type="text/css">
      .pulse:hover,
      .pulse:focus {
        -webkit-animation: pulse 1s;
                animation: pulse 1s;
        box-shadow: 0 0 0 2em rgba(255, 255, 255, 0);
      }

      @-webkit-keyframes pulse {
        0% {
          box-shadow: 0 0 0 0 var(--hover);
        }
      }

      @keyframes pulse {
        0% {
          box-shadow: 0 0 0 0 var(--hover);
        }
      }

      .pulse {
        --color: #3498db;
        --hover: #3498db;
      }
      button {
        color: var(--color);
        transition: 0.25s;
      }
      button:hover, button:focus {
        border-color: var(--hover);
        color: #fff;
        background-color: #3498db;
      }
      button {
        background: none;
        border: 2px solid;
        font: inherit;
        line-height: 1;
        margin: 0.5em;
        padding: 1em 2em;
      }
      h1 {
        font-weight: 400;
      }
      code {
        color: #e4cb58;
        font: inherit;
      }
  </style>
  </head>
  <body> <!-- PRE LOADER -->
    <div class="preloader">
      <div class="sk-spinner sk-spinner-wordpress"> <span class="sk-inner-circle"></span>
      </div>
    </div>
    <!-- Navigation section  -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header"> <button class="navbar-toggle" data-toggle="collapse"

            data-target=".navbar-collapse"> <span class="icon icon-bar"></span>
            <span class="icon icon-bar"></span> <span class="icon icon-bar"></span>
          </button> <a href="index.html" class="navbar-brand">M.C. ASSISTANCE</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.html">Home</a></li>
            <li><a href="azienda.html">Azienda</a></li>
            <li><a href="prodotti.html">Prodotti</a></li>
            <li><a href="contatti.html">Contatti</a></li>
            <li class="active"><a href="servizi.php">Servizi</a></li>
            <li><a href="logistica.php">Logistica</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Home Section -->
    <section id="home" class="main-single-post parallax-section" style="height:150px;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          
            <div class="col-md-offset-1 col-md-10 col-sm-12">
            <h1>AREA RISERVATA</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Single Post Section -->
    <section id="blog-single-post">
      <div class="container">
        <div class="row" style="margin:0 auto">
          <div style="width: 100%; margin: 0 auto; margin-left: 6%;">
            <video width="auto" height="550" controls>
              <source  src="videos/video.mp4" type="video/mp4">
            </video>
            <!--<div style="position: relative; left: 41%; ">
            <a href="videos/video.zip" download>
              <div class="buttons"><br/>
                <button class="pulse">DOWNLOAD</button>
              </div></div>
            </a>
          </div>-->
        </div>
        </div>
        <div class="row" style="margin:0 auto">
          <div style="width:100%; margin: 0 auto; margin-left: 6%;">
            <video width="auto" height="550" controls>
              <source  src="videos/rub1.mp4" type="video/mp4">
            </video>
            <video width="auto" height="550" controls>
              <source  src="videos/rub2.mp4" type="video/mp4">
            </video>
          </div>
        </div>
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
            <p><i class="fa fa-save"></i> info@mcassistance.it</p>
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
