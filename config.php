<?php
class Database {
    // Variabili per la connessione
    private $servername = "localhost";
    private $username = "root";
    private $password = "Matteo00";
    private $dbname = "sim";
    private $conn;

    // Costruttore per inizializzare la connessione
    public function __construct() {
        // Crea la connessione
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Controlla la connessione
        if ($this->conn->connect_error) {
            die("Connessione fallita: " . $this->conn->connect_error);
        }

        // Imposta il set di caratteri
        $this->conn->set_charset("utf8");
    }

    // Metodo per ottenere la connessione
    public function getConnection() {
        return $this->conn;
    }

    // Funzione per eseguire una query di selezione (SELECT)
    public function getQueryResult($query) {
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            die("Errore nella query: " . $this->conn->error);
        }
        return $result;
    }

    // Funzione per eseguire una query di modifica (INSERT, UPDATE, DELETE)
    public function executeQuery($query) {
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            die("Errore nell'eseguire la query: " . $this->conn->error);
        }
    }

    // Funzione per eseguire una query con prepared statement
    public function executePreparedStatement($query, $params) {
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Errore nella preparazione della query: " . $this->conn->error);
        }

        // Collega i parametri
        $stmt->bind_param(...$params);

        // Esegui la query
        if ($stmt->execute() === false) {
            die("Errore nell'esecuzione della query: " . $stmt->error);
        }

        // Ritorna il risultato, se necessario
        return $stmt->get_result();
    }

    // Funzione per chiudere la connessione
    public function closeConnection() {
        $this->conn->close();
    }
}
?>
