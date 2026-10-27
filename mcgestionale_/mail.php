<?php
	session_start();
	// CONTROLLO SICUREZZA 
	if($_SESSION['autoMail'] != 1 ){
		header("Location:logistica.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>M.C. ASSISTANCE - MAIL</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="icon" href="favicon.ico.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/flag.css">
	<link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400" rel="stylesheet">
	<style>
		input.btnAggMail {
			background:white;
			border: 2px solid #555;
			color: black;
			font-weight: bold;
			transition: all 0.4s ease-in-out;
			height: 50px;
			width: 100px;
			box-shadow: none;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		input.btnAggMail:hover{
			background:black;
			color: white; 
			border:2px solid black;
		}
		th{
			text-align: center;
			height: 30px;
			border: 1px solid black; 
		}
		td{
			text-align: center;
			height: 30px;
			border: 1px solid black; 
		}
		td#noBorder{
			text-align: center;
			height: 30px;
			border: 0px solid black; 
		}
	</style>
</head>
 <body>
 	<!-- PRE LOADER -->
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
           <a href="en/company.html"><img src="images/ing.jpeg" id="flagi" alt="English" title="English"></a>
           <a href="es/azienda.html"><img src="images/esp.png" id="flagi" alt="Español" title="Español"></a>
           <a href="de/azienda.html"><img src="images/de.png" id="flagi" alt="Deutsch" title="Deutsch"></a>
           <a href="po/azienda.html"><img src="images/po.png" id="flagi" alt="Português" title="Português"></a>
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

   
     	
    



<section id="scr">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10 col-sm-12">
				<div class="blog-post-thumb">
					<div class="blog-post-image">
						<!-- CREO LA TABELLA CHE CONTERRA LE MAIL -->
						<table cellspacing="2px" style="width: 100%;  text-align: center; border-spacing: 15px;">
							<tr>
								<td id="noBorder"></td>
							</tr>
							<tr>
								<th>INVIATO DA</th>
								<th>OGGETTO</th>
								<th style="min-width: 80px;">DATA</th>
								<th>LEGGI</th>
								<th>ELIMINA</th>
							</tr>


						<!-- SEZIONE DI COLLEGAMENTO ALL'ACCOUNT MAIL info@mcassistance.it -->
						<?php
							$numMailVis = 20;
							if(isset($_POST['caricaMail'])){
								$numMailVis += 20;
							}
							@include 'connessioneMail.php'; //collegamento al server di posta
							$conteggio = imap_num_msg($conn); //int del numero totale di mail presenti in casella
							for($i=$conteggio;$i>$conteggio-$numMailVis;$i--){
								$f_over = @imap_fetch_overview($conn, $i, 0);
								while(@list($k, $v) = @each($f_over)){

									if($v->date != null && strlen($v->date) > 15 )
										$data = substr($v->date, 0,7).",".substr($v->date, 11,11);
									else
										$data = "";									

									echo "<tr><td>".$v->from."</td>";
									echo "<td>".$v->subject."</td>";
									echo "<td>".$data."</td>";
									echo "<td> <a href=\"showMail.php?id=".$i."\">Leggi</a> </td>";
									echo "<td><a href=\"deleteMail.php?id=".$i."\">Del</a></td></tr>";
								}
							}
						?>
						</table>						
						<br/>
						<form action="" method="POST">
							<input type="submit" name="caricaMail" value="+20 MAIL" class="btnAggMail">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
						

	
	

	<!-- Footer Section -->
    <footer>
      <div class="container">
        <div class="container">
          <div class="row">
            <div class="col-md-5 col-md-offset-1 col-sm-6">
              <h3>M.C. Assistance</h3>
              <p>COSTRUZIONE - ASSISTENZA - PROGRAMMAZIONE - IMPIANTI
                ROBOTIZZATI</p>
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