<?php

function login($IdAzienda, $Username, $Password, $connection) {
    $query = "SELECT ID_UTENTE,PASSWORD FROM utenti WHERE ID_AZIENDA = '" . $IdAzienda . "' AND ID_UTENTE = '" . $Username . "' AND PASSWORD = '" . $Password . "' ";
    if ($result = $connection->query($query)) {
        if ($row = $result->fetch_assoc()) {
            $_SESSION['IdUtente'] = $row['ID_UTENTE'];
            return true;
        } else
            return false;
    } else {
        die("Errore" . $connection->error);
        return false;
    }
}

?>