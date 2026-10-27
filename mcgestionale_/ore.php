<?php
  //BLOCCO LA POSSIBILITA' DI TIMBRARE L'ARRIVO PIU' VOLTE CONSECUTIVE
  session_start();
  $_SESSION['disabled']='';
  $_SESSION['lab']='';
  $_SESSION['disabledViaggio']='';
  $_SESSION['labViaggio']='';
  if(isset($_POST['1'])){
    if($_POST['1']=='arrivi'){
      $_SESSION['disabled']=1;
      $_SESSION['lab']=1;
    }elseif($_POST['1']=='uscite'){
      $_SESSION['disabled']='';
      $_SESSION['lab']='';
    }
  }
  if(isset($_POST['3'])){
    if($_POST['3']=='startViaggio'){
      $_SESSION['disabledViaggio']=1;
      $_SESSION['labViaggio']=1;
    }elseif($_POST['3']=='endViaggio'){
      $_SESSION['disabledViaggio']='';
      $_SESSION['labViaggio']='';
    }
  }
  

	
	
	$_SESSION['m']='';
	$_SESSION['a']='';
	if(isset($_POST['invia'])){
		$_SESSION['m']=$_POST['mese'];
		$_SESSION['a']=$_POST['anno'];
	}



  //CONTROLLO SICUREZZA 
  if($_SESSION['logistic']!=1){
    header("Location:logistica.php");
  }
  //FUNZIONE PER IL CALCOLO DEL TEMPO TRASCORSO TRA DUE VARIABILI ORA
  function differenceInHours($startdate,$enddate){
    $starttimestamp = strtotime($startdate);
    $endtimestamp = strtotime($enddate);
    $difference = abs($endtimestamp - $starttimestamp)/3600;
    return $difference;
  }
  if(!empty($_POST["submit"])) {
    $hours_difference = differenceInHours($_POST["startdate"],$_POST["enddate"]); 
    echo "The Difference is " . $hours_difference . " hours";
  }

  header('Refresh: 20; url=ditta.php');

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
    <title><?php      
              $qnome="SELECT nome,cognome FROM accessi WHERE idDipendente='".$_SESSION['d']."'";
              $result=$mysqli->query($qnome);
              while($row=$result->fetch_assoc()){
                echo strtoupper($row['nome'])." ".strtoupper($row['cognome']);
              }
            ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/btndip.css">
    <link rel="stylesheet" href="css/flag.css">
    <link rel="apple-touch-icon" href="images/homebg.jpg">
    <link rel="stylesheet" href="css/pp.css">
    <link rel="stylesheet" href="css/radiobottonigrigi.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400"

      rel="stylesheet">
    <style type="text/css">
      .c{
        display: block;
        position: relative;
        padding-left: 0px;
        margin-top: 35px;
        margin-bottom: : 35px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        /*color: #4ac262;*/
        background: #4ac262;
      }                      
    </style>
    <script language="javascript">
      function mostra(name)
      { 
        if(document.getElementById(name).style.display == "block"){
          document.getElementById(name).style.display = "none";
        }else{
          document.getElementById(name).style.display = "block"
        }
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
    <section id="home" class="main-staff parallax-section">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <h1> BENVENUTO <?php
              $qnome="SELECT nome,cognome FROM accessi WHERE idDipendente='".$_SESSION['d']."'";
              $result=$mysqli->query($qnome);
              while($row=$result->fetch_assoc()){
                echo strtoupper($row['nome'])." ".strtoupper($row['cognome']);
              }
            ?></h1>
          </div>
        </div>
      </div>
    </section>
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-1 col-md-10 col-sm-12">

            <div id="main-container">
              <div id="form-container">
                <div align="center">
                  <form action="" method="POST">
                    <div class="radiobtn">
                      <input type="radio" id="huey" 
                             name="1" value="arrivi"  <?php //if($_SESSION['disabled']==1){echo "disabled='disabled'"; }?>/>
                      <label <?php //if($_SESSION['lab']==1){echo "style='color: #9b9a98; cursor:default;'";}?> for="huey">ARRIVO</label>
                    </div>
                    <div class="radiobtn">
                      <input type="radio" id="dewey"
                             name="1" value="uscite" <?php //if($_SESSION['lab']==''){echo "disabled='disabled'" ; }?>/>
                      <label <?php //if($_SESSION['lab']==''){echo "style='color: #9b9a98; cursor:default;'";}?>for="dewey">USCITA</label>
                    </div>
                    <div class="radiobtn">
                      <input type="submit" name="invio" value="INVIA">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div id="main-container">
              <div id="form-container">
                <div align="center">
					<img src="<?php echo 'base/utenti/QRGenerati/'.$_SESSION['d'].".png" ?>">
                </div>
              </div>
            </div>

            <div id="form-container">
              <div align="center">
                <input type=button value="MOSTRA FERIE-PERMESSO-MALATTIA" name="var_1" OnClick=mostra(name) class="btnplus">
              </div>
              <div id="var_1" class="variabile" style="display: none;">
                <div align="center">
                  <form action="" method="POST">
                    <div class="radiobtn">
                      <input type="radio" id="ferie"
                             name="2" value="ferie" />
                      <label for="ferie">FERIE</label>
                    </div>
                    <div class="radiobtn">
                      <input type="radio" id="malattia"
                             name="2" value="malattia" />
                      <label for="malattia">MALATTIA</label>
                    </div>
                    <div class="radiobtn">
                      <input type="radio" id="permesso"
                             name="2" value="permesso" />
                      <label for="permesso">PERMESSO</label>
                    </div>
                    <div class="radiobtn">
                      <input type="submit" name="invio" value="INVIA">
                    </div>
                  </form>
                </div>
              </div>
            </div>

            
            <div id="form-container">
              <div align="center">
                <input type=button value="MOSTRA ORE VIAGGIO" name="var_2" OnClick=mostra(name) class="btnplus">
              </div>
              <div id="var_2" class="variabile" style="display: none;">
                <div align="center">
                  <form action="" method="POST">
                    <div class="radiobtn">
                      <input type="radio" id="startViaggio"
                             name="3" value="startViaggio" <?php //if($_SESSION['disabledViaggio']==1){echo "disabled='disabled'"; }?>/>
                      <label <?php //if($_SESSION['labViaggio']==1){echo "style='color: #9b9a98; cursor:default;'";}?> for="startViaggio">INIZIO</label>
                    </div>
                    <div class="radiobtn">
                      <input type="radio" id="endViaggio"
                             name="3" value="endViaggio" <?php //if($_SESSION['labViaggio']==''){echo "disabled='disabled'" ; }?>/>
                      <label <?php //if($_SESSION['labViaggio']==''){echo "style='color: #9b9a98; cursor:default;'";}?> for="endViaggio">FINE</label>
                    </div>
                    <div class="radiobtn">
                      <input type="submit" name="invio" value="INVIA">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div id="form-container">
            	<div align="center">
            		<form action="" method="POST">
            			<input type="number" step="0.1" name="str" placeholder="SOLO STRAORDINARIE">
            			<input type="submit" name="INVIA">
            		</form>
            	</div>
            </div>
            <div id="form-container">
            	<div align="center">
            		<form action="gestore.php" method="POST">
            			<input type="submit" name="red" value="VISUALIZZA E MODIFICA LE TUE ORE">
            		</form>
            	</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php     
      if(isset($_POST['1'])){ //SE è STATO PREMUTO ARRIVO O USCITA
        $ora = date('H:i');//SALVO L'ORA IN CUI E' STATO PREMUTO INVIA IN UNA VAR
        $data = date("Y/m/d");//SALVO LA DATA IN CUI E' STATO PREMUTO INVIA IN UNA VAR
        if($_POST['1']=='arrivi'){//SE E' STATO PREMUTO ARRIVO
          $qEntrata="INSERT INTO arrivi (oraArrivo, giornoArrivo, idDipendente) VALUES ('".$ora."','".$data."','".$_SESSION['d']."')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB ARRIVI
          $result = $mysqli->query($qEntrata);//ESEGUO LA QUERY
          $_SESSION['oraA']=$ora;// SALVO IN UNA VAR DI SESSIONE L'ORA DI ARRIVO
        }
        if($_POST['1']=='uscite'){//SE E' STATO PREMUTO USCITA
          $qUscita="INSERT INTO uscite (oraUscita, giornoUscita, idDipendente) VALUES ('".$ora."','".$data."','".$_SESSION['d']."')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB USCITE
          $_SESSION['oraU']=$ora;//SALVO L'ORA DI USCITA IN UNA VAR DI SESSIONE
          $result= $mysqli->query($qUscita);//ESEGUO UNA QUERY
          $qorarrivo="SELECT oraArrivo FROM arrivi WHERE giornoArrivo='".$data."' AND idDipendente='".$_SESSION['d']."'";
          $result=$mysqli->query($qorarrivo);
          while ($row=$result->fetch_assoc()) {
          	$startdate=$row['oraArrivo'];
          }
          //$startdate=$_SESSION['oraA'];   
          $oretot = differenceInHours($startdate,$ora);//SALVO NELLA VAR ORETOT LE ORE TRASCORSE DA ARRIVO A USCITA GRAZIE ALLA FUNZIONE
          $oretot = round($oretot, 1);
          $virgola = substr($oretot, 2);//SALVO IN VIRGOLA IL NUMERO DOPO LA VIRGOLA
          if($virgola<5){//SE E' MINORE DI 5 LE ORE TOTALI SARANNO APPROSSIMATE A DIFETTO
            $oretot = substr($oretot, 0, 1);
            echo $oretot;
          }else if ($virgola>5) {//SE E' MAGGIORE DI 5 SARANNO APPROSSIMATE A ,5
            $oretot = substr($oretot, 0, 2)."5";
            echo $oretot;
          }
          $qOrelavoro="INSERT INTO ore (oraArrivo, oraUscita, oreLavoro, giorno, idDipendente) 
                VALUES ('".$startdate."','".$_SESSION['oraU']."','".$oretot."','".$data."','".$_SESSION['d']."')"; //QUERY PER INSERIMENTO DEI DATI ELABORATI NELLA TABELLA ore.
          $result=$mysqli->query($qOrelavoro);
        }
      }
      if(isset($_POST['2'])){
        $data = date("Y/m/d");
        if($_POST['2']=='ferie'){
          $qFerie="INSERT INTO ore (giorno, idDipendente, ex) VALUES ('".$data."','".$_SESSION['d']."', 'F')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB ore
          $result = $mysqli->query($qFerie);
        }
        if($_POST['2']=='malattia'){
          $qMalattia="INSERT INTO ore (giorno, idDipendente, ex) VALUES ('".$data."','".$_SESSION['d']."', 'M')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB ore
          $result = $mysqli->query($qMalattia);
        }
        if($_POST['2']=='permesso'){
          $qPermesso="INSERT INTO ore (giorno, idDipendente, ex) VALUES ('".$data."','".$_SESSION['d']."', 'P')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB ore
          $result = $mysqli->query($qPermesso);
        }
      }
      if(isset($_POST['3'])){
        $ora = date('H:i');//SALVO L'ORA IN CUI E' STATO PREMUTO INVIA IN UNA VAR
        $data = date("Y/m/d");//SALVO LA DATA IN CUI E' STATO PREMUTO INVIA IN UNA VAR
        if($_POST['3']=='startViaggio'){//SE E' STATO PREMUTO ARRIVO
          $qEntrata="INSERT INTO arriviviaggio (oraArrivo, giornoArrivo, idDipendente) VALUES ('".$ora."','".$data."','".$_SESSION['d']."')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB ARRIVI
          $result = $mysqli->query($qEntrata);//ESEGUO LA QUERY
          $_SESSION['oraA']=$ora;// SALVO IN UNA VAR DI SESSIONE L'ORA DI ARRIVO
        }
        if($_POST['3']=='endViaggio'){//SE E' STATO PREMUTO USCITA
          $qUscita="INSERT INTO usciteviaggio (oraUscita, giornoUscita, idDipendente) VALUES ('".$ora."','".$data."','".$_SESSION['d']."')";//SCRIVO UNA QUERY CHE INSERISCE I DATI NELLA TAB USCITE
          $_SESSION['oraU']=$ora;//SALVO L'ORA DI USCITA IN UNA VAR DI SESSIONE
          $result= $mysqli->query($qUscita);//ESEGUO UNA QUERY
          $startdate=$_SESSION['oraA'];   
          $oretot = differenceInHours($startdate,$ora);//SALVO NELLA VAR ORETOT LE ORE TRASCORSE DA ARRIVO A USCITA GRAZIE ALLA FUNZIONE
          $oretot = round($oretot, 1);
          $virgola = substr($oretot, 2);//SALVO IN VIRGOLA IL NUMERO DOPO LA VIRGOLA
          if($virgola<5){//SE E' MINORE DI 5 LE ORE TOTALI SARANNO APPROSSIMATE A DIFETTO
            $oretot = substr($oretot, 0, 1);
            echo $oretot;
          }else if ($virgola>5) {//SE E' MAGGIORE DI 5 SARANNO APPROSSIMATE A ,5
            $oretot = substr($oretot, 0, 2)."5";
            echo $oretot;
          }
          $qOrelavoro="INSERT INTO oreviaggio (oraArrivo, oraUscita, oreviaggio, giorno, idDipendente) 
                VALUES ('".$_SESSION['oraA']."','".$_SESSION['oraU']."','".$oretot."','".$data."','".$_SESSION['d']."')"; //QUERY PER INSERIMENTO DEI DATI ELABORATI NELLA TABELLA ore.
          $result=$mysqli->query($qOrelavoro);
        }
      }
      if(isset($_POST['str'])){
      	$data = date("Y/m/d");
      	$qinsstra="INSERT INTO ore (oreStraordinarie, giorno, idDipendente) VALUES ('".$_POST['str']."','".$data."','".$_SESSION['d']."')";
      	$result=$mysqli->query($qinsstra);
      }

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
  </body>
</html>