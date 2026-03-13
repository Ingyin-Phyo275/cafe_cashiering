<?php
class Database {
    public $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql, $types = null, $params = null) {
        if ($types && $params) {
            $stmt = $this->connection->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $this->connection->error);
            }
            $stmt->bind_param($types, ...$params);
            $result = $stmt->execute();
            if ($result === false) {
                die("Execute failed: " . $stmt->error);
            }
            return $stmt;
        } else {
            return $this->connection->query($sql);
        }
    }

    public function fetchAssoc($result) {
        return $result->fetch_assoc();
    }

    public function numRows($result) {
        return $result->num_rows;
    }

    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }
    public function close() {
        $this->connection->close();
    }
}
?>
