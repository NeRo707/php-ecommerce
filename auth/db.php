<?php
class Dbhelper {
    // private $hostname;
    // private $username;
    // private $password;
    // private $database;
    private $connection;

    // public function __construct($hostname, $username, $password, $database) {
    //     $this->hostname = $hostname;
    //     $this->username = $username;
    //     $this->password = $password;
    //     $this->database = $database;
    //     $this->connection = new mysqli('localhost', 'root', '', 'salesdb');
    // }

    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'salesdb');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection->close();
    }

    public function addUser($user) {

        $query = "INSERT INTO users (name, lastname, username, tel, pass) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);

        $name = $user->getName();
        $lastname = $user->getLastname();
        $username = $user->getUsername();
        $tel = $user->getTel();
        $pass = $user->getPass();

        $stmt->bind_param("sssss", $name, $lastname, $username, $tel, $pass);
        return $stmt->execute();
        $this->closeConnection();
    }

    public function login($username, $pass) {
        $query = "SELECT * FROM users WHERE username = ? AND pass = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $username, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        $this->closeConnection();
    }
}
