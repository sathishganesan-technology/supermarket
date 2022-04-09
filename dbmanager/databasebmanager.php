<?php

class DatabaseManager {

    private $database = "supermarket";
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $connection;

    function __construct() {
        $this->connection = $this->connectToDB();
    }

    function connectToDB() {// database connection
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    /**
     *  @return  returns array with product ID as key
     */
    function productByID($query) {
        $result = mysqli_query($this->connection, $query);
        while ($rows = mysqli_fetch_assoc($result)) {
            $results[$rows['id']] = $rows;
        }
        if (!empty($results))
            return $results;
    }

    public function lastInsertID() {
        return $this->connection->insert_id;
    }

    function executeQuery($query) {
        $result = mysqli_query($this->connection, $query);
        while ($rows = mysqli_fetch_assoc($result)) {
            $results[] = $rows;
        }
        if (!empty($results)) {
            return $results;
        }
    }
    

}

?>