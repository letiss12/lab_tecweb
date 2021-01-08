<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnectionLavoro.php";
use DB\DBAccess; // importo dbaccess del db

$paginaHTML = file_get_contents('personaggi.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("Errore nell'apertura del DB");
    // si chiude senza dare una risposta all'utente fare un try catch
} else {
    $listaProtagonisti = $dbAccess->getListaPersonaggi();

    $dbAccess->closeDBConnection();

    $definitionListProtagonisti ="";

    if ($listaProtagonisti != null) {
        // creo parte pg html con elenco dei personaggi
        $definitionListProtagonisti = '<dl id="charactersStory">';

        foreach ($listaProtagonisti as $protagonista) {

            $definitionListProtagonisti .= '<dt>' . $protagonista['Nome'] . '</dt>';
            $definitionListProtagonisti .= '<dd>';
            $definitionListProtagonisti .= '<img src="images'. DIRECTORY_SEPARATOR .$protagonista['Immagine']. ' "alt="'.$protagonista['AltImmagine']. '"/>';
            $definitionListProtagonisti .= '<p>'. $protagonista['Descrizione'] . '</p>';
            $definitionListProtagonisti .= '<p class="aiutoTornaSu"><a href="#contentPagina">Torna su</a></p>';

            $definitionListProtagonisti .= '</dd>';
        }

        $definitionListProtagonisti = $definitionListProtagonisti . "</dl>";

    }
    else {
        // messaggo che dice che non ci sono protagonisti nel DB
        $definitionListProtagonisti = "<p>Nessun personaggio presente</p>";
    }

    echo str_replace("<listaPersonaggi />", $definitionListProtagonisti, $paginaHTML);
}


?>