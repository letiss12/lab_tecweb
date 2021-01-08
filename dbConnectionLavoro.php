<?php 
namespace DB;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = "lscudele";
    private const PASSWORD = "suehaiHi6sie1fie";
    private const DATABASE_NAME = "lscudele";

    private $connection;

    public function openDBConnection() {

        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

        if (!$this->connection) {
            return false;
        } else {
            return true;
        }
    
    }

    public function closeBDConnection() {
        // da fare

    }

    public function getListaPersonaggi() {

        $querySelect = "SELECT * FROM protagonisti ORDER BY ID ASC";
        $queryResult = mysqli_query($this->connection, $querySelect);
    
        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        } else {

            $listaPersonaggi = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {

                $singoloPersonaggio = array(
                    "Nome" => $riga['Nome'], //  
                    "Immagine" => $riga['NomeImmagine'],
                    "AltImmagine" => $riga['AltImmagine'],
                    "Descrizione" => $riga['Descrizione'] 

                );

                array_push($listaPersonaggi, $singoloPersonaggio);
            }

            return $listaPersonaggi;
        }
    
    }

    public function inserisciProtagonista($nome, $specializzazione, $qi, $descrizione, $prima, $seconda, $terza, $quarta) {

        $queryInserimento = "INSERT INTO protagonisti(Nome, Specializzazione, QI, Descrizione, PrimaStagione, SecondaStagione, TerzaStagione, QuartaStagione, NomeImmagine, AltImmagine) VALUES (\"$nome\", \"$specializzazione\", \"$qi\", \"$descrizione\", $prima, $seconda, $terza, $quarta, \"\", \"\" )";

        mysqli_query($this->connection, $queryInserimento);

        if (mysqli_affected_rows($this->connection) > 0) { // controllo che ci sia stato veramente un inserimento
            return true;
        } else {
            return false;
        }
    }

}

?>