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
    <title>M.C. ASSISTANCE - Area Protetta</title> 
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="icon" href="favicon.ico.png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lora%7CMerriweather:300,400"

      rel="stylesheet">
      <style type="text/css">
        input[type=submit]{
          border: 1px solid black;
          background-color: white;
          border-radius: 24px; 
        }
        input[type=submit]:hover{
          background-color: black;
          color:white; 
        }
        label {
          cursor: pointer;
          font-family: inherit;
          border: 1px solid black;
          background-color: white;
          border-radius: 24px;
          padding-left: 5px;
          padding-right: 5px;
          padding-top: 1px;
          padding-bottom: 1px;
        }
        label:hover{
          background: black;
          color: white;
        }

        #fileToUpload {
           opacity: 0;
           position: absolute;
           z-index: -1;
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
          </ul>
        </div>
      </div>
    </div>
    <!-- Home Section -->
    <section id="home" class="main-single-post parallax-section" style="height: 150px;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <h1>AREA PROTETTA</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Single Post Section -->
    <section id="blog-single-post">
      <div class="container">
        <div class="row">
         <?php
          foreach (glob("uploads/*.*") as $filename) {
            $files = substr($filename, 8);
            $link = '<a href="'.$filename.'" download="'.$files.'">Download</a>';
            $f = "<input type='submit' value='ELIMINA' name='file' >";  
            $inv = "<input type='text' name='send' value='".$filename."' style='display:none;' />";
            echo " <form action='delete.php' method='post'>
            <table cellspacing=\"2px\" style=\"width: 100%;  text-align: center; border-spacing: 15px;\">
                <tr>
                    <td style=\"width: 25%;border:1px solid black; \">" . $files ."</td>
                    <td style=\"width: 25%;border:1px solid black;\">" . date("d/m/Y - H:i:s", filemtime($filename)) . "</td>
                    <td style=\"width: 25%;border:1px solid black;\">" . $link . "</td>
                    <td align='left' style=\"width: 25%;\"> &ensp;&ensp;" . $f . "</td>
                    <td>".$inv." </td>
                </tr>
            </table></form>";
          }
        ?> <br />
        </div>
        <div class="row">
          
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Scegli file...</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Carica online" name="submit">
          </form>
        </div>
        <div class="row">
          <form action="logout.php" method="post">
            <input type="submit" value="Logout">
          </form><br/>
          <form action="protetta.php" method="POST">
            <input type="submit" name="admin" value="VISUALIZZA ADMIN">
            <input type="submit" name="aggadmin" value="AGGIUNGI ADMIN">
          </form><br/>
          <form action="protetta.php" method="POST">
            <input type="submit" name="utenti" value="VISUALIZZA UTENTI">
            <input type="submit" name="aggutente" value="AGGIUNGE UTENTE">
          </form>

        </div>
        <div class="row">
          
        </div>
        <div class="row">
          <br />
            <?php
            if(isset($_POST['utenti'])){
              $q="SELECT * FROM utenti";
              $result = $mysqli->query($q);
              echo "<table style='border-collapse: collapse; border:1px solid black; padding:3px;'>";
              echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center;'>USERNAME</th><th style='border:1px solid black; padding: 3px; text-align:center;'>PASSWORD</th></tr>";
              while($row=$result->fetch_assoc()){
                echo "<tr style='border:1px solid black;'>";
                echo "<td style='border:1px solid black; padding: 3px; text-align:center;'>".$row['username']."</td>";
                echo "<td style='border:1px solid black; padding: 3px; text-align:center;'>".$row['password']."</td></tr>";         
              }
              echo "</table>";
            }
            ?>
        </div>
        <div class="row">
          <br />
          <?php
          if(isset($_POST['admin'])){
            $q="SELECT * FROM admin";
            $result = $mysqli->query($q);
            echo "<table style='border-collapse: collapse; border:1px solid black; padding:3px;'>";
            echo "<tr><th style='border:1px solid black; padding: 3px; text-align:center;'>USERNAME</th><th style='border:1px solid black; padding: 3px; text-align:center;'>PASSWORD</th></tr>";
            while($row=$result->fetch_assoc()){
              echo "<tr style='border:1px solid black;'>";
              echo "<td style='border:1px solid black; padding: 3px; text-align:center;'>".$row['username']."</td>";
              echo "<td style='border:1px solid black; padding: 3px; text-align:center;'>".$row['password']."</td></tr>";         
            }
            echo "</table>";
          }
            ?>
        </div>
        <div class="row">
          <br />
          <?php
          if(isset($_POST['aggadmin'])){
            echo "<form action='protetta.php' method='POST'>
                    <input type='text' name='uagg' placeholder='USERNAME'><br /><br />
                    <input type='text' name='pagg' placeholder='PASSWORD'><br /><br />
                    <input type='submit' value='aggiungi' name='aggiungiadmin'>
                  </form>";
          }
          
          if(isset($_POST['aggiungiadmin'])){
            $u = $_POST['uagg'];
            $p=$_POST['pagg'];
            $q="INSERT INTO admin (username, password) VALUES ('$u', '$p' )";
            $result = $mysqli->query($q);
            }
            ?>
        </div>
        <div class="row">
          <br />
          <?php
          if(isset($_POST['aggutente'])){
            echo "<form action='protetta.php' method='POST'>
                    <input type='text' name='uagg' placeholder='USERNAME'><br /><br />
                    <input type='text' name='pagg' placeholder='PASSWORD'><br /><br />
                    <input type='submit' value='aggiungi' name='aggiungiutente'>
                  </form>";
          }
         
          if(isset($_POST['aggiungiutente'])){
            $u = $_POST['uagg'];
            $p=$_POST['pagg'];
            $q="INSERT INTO utenti (username, password) VALUES ('$u', '$p' )";
            $result = $mysqli->query($q);
          }
            ?>
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
