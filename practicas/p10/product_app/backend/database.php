<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "Alaskita123";
    private $dbname = "marketzone";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
