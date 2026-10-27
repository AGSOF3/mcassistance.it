<?php

  header( "refresh:2;url=protetta.php" );
  echo "<div align='center' style='position:relative; top:30%;'>";
  echo "<h4>Se il tuo browser non supporta il redirect clicka <a href=\"protetta.php\">qui</a>.</h3>";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//controllo esistenza file
if (file_exists($target_file)) {
    echo "Il file che vuoi inserire esiste gia'!";
    $uploadOk = 0;
}
// controllo grandezza file
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Il file e' troppo grande!";
    $uploadOk = 0;
}

// controllo eccezioni
if ($uploadOk == 0) {
    echo "Il file non e' stato caricato!";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<h1>IL FILE ". basename( $_FILES["fileToUpload"]["name"]). " E' STATO CARICATO, STAI PER ESSERE RIPORTATO NELL'AREA PROTETTA!</h2>";
    } else {
        echo "Si e' verificato un errore nel caricamento del file!";
    }
}

echo "</div>";
?>