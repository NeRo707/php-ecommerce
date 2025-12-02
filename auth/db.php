<?php
class Dbhelper {
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = new mysqli($hostname, $username, $password, $database);
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
}
