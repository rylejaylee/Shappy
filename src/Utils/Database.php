<?php

namespace Shappy\Utils;

use PDO;
use PDOException;

class Database {
    private $host = DB_HOST;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $db_name = DB_NAME;
    private $connection;


    public function __construct()
    {
        $this->connect();   
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function close() {
        $this->connection = null;
    }

    public function get_last_inserted_id() {
        return $this->connection->lastInsertId();
    }
}