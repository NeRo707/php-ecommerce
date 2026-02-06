<?php
class Dbh {

  private $connection;

  public function __construct() {
    $this->connection = new mysqli('localhost', 'root', '', 'file_db');
    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  public function upload($filePath){
    $stmt = $this->connection->prepare("INSERT INTO files (file_dir) VALUES (?)");
    $stmt->bind_param("s", $filePath);
    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
}
