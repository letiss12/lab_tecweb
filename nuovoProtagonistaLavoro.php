<?php


require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnectionLavoro.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('nuovoProtagonistaForm.html');

$messaggioPerForm = '';
$nome = ''; $specializzazione = ''; $qi = ''; $descrizione = ''; $stagioni = array();

if (isset($_POST['submit'])) { 

    $nome = $_POST['nome'];
    $specializzazione = $_POST['specializzazione'];
    $qi = $_POST['qi'];
    $descrizione = $_POST['descrizione'];

    
    if (!empty($_POST['stagioni'])) {
        $stagioni = $_POST['stagioni'];
    }

    if (strlen($nome) != 0 && strlen($specializzazione) != 0 && strlen($qi) != 0 && strlen($descrizione) > 5 && is_numeric($qi)) {
        // inserire le informazioni nel database
        $dbAccess = new DBAccess();
        $openDBConnection = $dbAccess->openDBConnection();

        if ($openDBConnection == true) {

            $inPrimaStagione = 0;
            $inSecondaStagione = 0;
            $inTerzaStagione = 0;
            $inQuartaStagione = 0;

            if(in_array("primaStagione", $stagioni)) {
                $inPrimaStagione = 1;
            }

            if(in_array("secondaStagione", $stagioni)) {
                $inSecondaStagione = 1;
            }

            if(in_array("terzaStagione", $stagioni)) {
                $inTerzaStagione = 1;
            }

            if(in_array("quartaStagione", $stagioni)) {
                $inQuartaStagione = 1;
            }

            $risultatoInseriemnto = $dbAccess->inserisciProtagonista($nome, $specializzazione, $qi, $descrizione, $inPrimaStagione, $inSecondaStagione, $inTerzaStagione);

            if($risultatoInseriemnto == true){
                $messaggioPerForm = '<div id="conferma"><p>Personaggio inserito correttamente</p></div>';
                $nome= ''; $specializzazione = ''; $qi = ''; $descrizione = '';
            } else {
                $messaggioPerForm = '<div id="errori"><p>Errore nell\'inseriemnto del personaggio. Riprovare</p></div>';
            }
        }
    } else {
        // mostrare all'utente gli errori commessi
        $messaggioPerForm = '<div id="errori"><ul>';
        if (strlen($nome) == 0) {
            $messaggioPerForm .= '<li>Nome troppo corto</li>';
        }
        if (strlen($specializzazione) == 0) {
            $messaggioPerForm .= '<li>Specializzazione troppo corta</li>';
        }
        if (strlen($descrizione) == 0) {
            $messaggioPerForm .= '<li>La descrizione deve essere almeno 5 caratteri</li>';
        }

        $messaggioPerForm .= '</ul></div>';
    }


}

$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreSpecializzazione />', $specializzazione, $paginaHTML);
$paginaHTML = str_replace('<valoreQi />', $qi, $paginaHTML);
$paginaHTML = str_replace('<valoreDescrizione />', $descrizione, $paginaHTML);

echo $paginaHTML;

?>
