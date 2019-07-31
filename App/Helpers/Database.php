<?php
class Database {

    private $db_host = "localhost";
    private $db_name = "arknado";
    private $db_user = "root";
    private $db_password = "007isKingsman!";
    private $connection;

    public function getConnection(){

        $this->connection = null;

        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        if ($this->connection->connect_errno) {
            printf("Connect failed: %s\n", $this->connection->connect_error);
            exit();
        }

        return $this->connection;
    }
}