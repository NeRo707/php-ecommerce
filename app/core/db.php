<?php

class Dbh {
  protected $connection;

  public function __construct() {
    $this->connection = new mysqli('localhost', 'root', '', 'shop_db');
    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  public function getConnection() {
    return $this->connection;
  }
}
