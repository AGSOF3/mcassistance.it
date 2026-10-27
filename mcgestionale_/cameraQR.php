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
    <meta name="apple-mobile-web-app-capable" content="yes">
  	<meta http-equiv="Content-Security-Policy" content="
        default-src https://codepush.azurewebsites.net * gap://ready file:;
        style-src 'self' 'unsafe-inline' *;
        script-src 'self' 'unsafe-inline' 'unsafe-eval' blob: *;
        img-src data: 'unsafe-inline' blob: *;
        worker-src blob:;
        child-src blob:;">

    <title>M.C. ASSISTANCE - LETTORE QR</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="apple-touch-icon" href="images/homebg.jpg">
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flag.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400" rel="stylesheet">
    <!-- IMPORT QR -->
    <link rel="stylesheet" href="css/styleQR.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
    function voce(testo){
		var msg = new SpeechSynthesisUtterance(testo);
		window.speechSynthesis.speak(msg);
	}
    </script>
  </head>
  
  <body> <!-- PRE LOADER -->
    <div class="preloader">
      <div class="sk-spinner sk-spinner-wordpress"> <span class="sk-inner-circle"></span>
      </div>
    </div>
    <!-- Navigation section  -->
    <nobr>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
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
	<section id="cameraQR">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12 text-right">
          <!-- IMPOSTAZIONI -->
          <img src="images/settings.png" width="25px" height="25px" id="settingsImg" title="Impostazioni" onclick="apriImpostazioni()">
        </div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12">
					<div id="app">
						<div class="sidebar">
							<section class="cameras">
								<h2>Videocamere disponibili!</h2>
								<ul>
									<li v-if="cameras.length === 0" class="empty">Videocamera non
										trovata!</li>
									<li v-for="camera in cameras"><span
										v-if="camera.id == activeCameraId"
										:title="formatName(camera.name)" class="active">{{
											formatName(camera.name) }}</span> <span
										v-if="camera.id != activeCameraId"
										:title="formatName(camera.name)"> <a
											@click.stop="selectCamera(camera)">{{ formatName(camera.name)
												}}</a>
									</span></li>
								</ul>
							</section>
							<section class="scans" style="display: none;">
								<h2>Scansioni</h2>
								<ul v-if="scans.length === 0">
									<li class="empty">Ancora nessuna scansione</li>
								</ul>
								<transition-group name="scans" tag="ul">
								<li v-for="scan in scans" :key="scan.date" :title="scan.content">{{
									scan.content }}</li>
								</transition-group>
							</section>
						</div>
						<div class="preview-container">
							<video id="preview"></video>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-12"><br/></div>
			</div>
		</div>
	</section>
	<audio id="audioEntrata"><source src="audio/ok.mp3" type="audio/mpeg"></audio>
  <audio id="audioErrore"><source src="audio/errore.mp3" type="audio/mpeg"></audio>
  <form action="" method="POST" id="formUtente" style="display:none">
    <input type="text" id="dipQR" name="dip">
  </form>
	<button id="btnVoce" style="display:none"></button>
    
	<?php 
	   require "FunCameraQR.php";
	?>
	
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
    <script type="text/javascript" src="js/appQR.js"></script>
    <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
  </body>
</html>