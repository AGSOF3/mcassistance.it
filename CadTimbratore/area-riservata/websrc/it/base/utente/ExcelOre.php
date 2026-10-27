<script type="text/javascript" src="xlsx.full.min.js"></script>
<script type="text/javascript">
    function ExportToExcel(type, filename, fn, dl) {
       var elt = document.getElementById('tblOre');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || filename);
    }
</script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/azienda/Azienda.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/excel/SimpleXLSXGen.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utenti/Utente.php";

protetta_session_start();
$az = Azienda::elementWithKey($_SESSION['IdAzienda'], $mysqli);

$MONTHS = array(
    1 => 'Gennaio',
    'Febbraio',
    'Marzo',
    'Aprile',
    'Maggio',
    'Giugno',
    'Luglio',
    'Agosto',
    'Settembre',
    'Ottobre',
    'Novembre',
    'Dicembre'
);

$mode = $_GET['MODE'];
$mese = $_GET['mese'];
$anno = $_GET['anno'];
$meseEsteso = $MONTHS[$mese];

$head = [
    'Azienda codice',
    $az->getCodiceAziendaEsterno(),
    $az->getDescrizione(),
    'Rilevazione presenze del mese di:',
    $meseEsteso,
    $anno
];
if (strlen($mese) == 1)
        $mese = "0" . $mese;
$nomeFile = "ORE_" . strtoupper($meseEsteso);
if ($mode == "SINGLE") {
    $key = $_GET['thKey'];
    $utenti = array();
    $utente = Utente::elementWithKey($key, $mysqli);
    $utenti[] = $utente;
    $righeDip = creaRigheDipendente($utenti, $mese, $anno, $head);
    $nomeFile .= "_" . $utente->getIdUtente();
} elseif ($mode == "ALL") {
    $utenti = array();
    $utenti = Utente::retrieveList(" ID_AZIENDA = '".$az->getIdAzienda()."' AND ID_UTENTE <> 'ADMIN' ", "", $mysqli);
    $righeDip = creaRigheDipendente($utenti, $mese, $anno, $head);
    $nomeFile .= "_GENERALE";
}
$nomeFile .= ".xlsx";

echo html_table($righeDip);
echo "<script>ExportToExcel('xlsx','".$nomeFile."');</script>"

// NON CREO PIU' IL FILE CON PHP PER PROBLEMI IN GENERAZIONE, USO JS
// $xlsx = SimpleXLSXGen::fromArray($righeDip);
// $xlsx->saveAs($nomeFile);
// $xlsx->downloadAs($nomeFile);

?>

<?php

function html_table($data = array())
{
    $rows = array();
    foreach ($data as $row) {
        $cells = array();
        foreach ($row as $cell) {
            $cells[] = "<td style='border: 1px solid black;'>{$cell}</td>";
        }
        $rows[] = "<tr>" . implode('', $cells) . "</tr>";
    }
    return "<table id='tblOre' class='hci-table'>" . implode('', $rows) . "</table>";
}

function creaRigheDipendente($utenti, $mese, $anno, $head) {
    include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
    $righeDipendenti = array();
    foreach ($utenti as $utente){
        $rigaDipendente = [
            'Matricola',
            $utente->getMatricola(),
            'Cognome Nome ',
            $utente->getCognome() . " " . $utente->getNome()
        ];
        $nd = date('t', mktime(0, 0, 0, $mese, 1, $anno));
        $giorni = [
            '',
            '',
            '',
            '',
            '',
            'Giorni'
        ]; // creo cinque celle vuote per formattazione estetitca
        $ore = [
        '',
        '',
        '',
        '',
        '',
        'Ore'
        ]; // creo cinque celle vuote per formattazione estetitca
        for ($i = 1; $i <= $nd; $i ++) {
            // giorni
            $giorni[] = $i;
            // ore
            $giorno = $i;
            if (strlen($giorno) == 1)
                $giorno = "0" . $giorno;
                $dta = $anno . $mese . $giorno;
                $ore[] = $utente->getOreLavorateGiorno($dta, $mysqli);
        }
        $rigaVuota = [
            ''
        ];
        $righeDipendenti[] = $head;
        $righeDipendenti[] = $rigaDipendente;
        $righeDipendenti[] = $giorni;
        $righeDipendenti[] = $ore;
        $righeDipendenti[] = $rigaVuota;
        $righeDipendenti[] = $rigaVuota;
        
    }
    
    return $righeDipendenti;
}

?>
