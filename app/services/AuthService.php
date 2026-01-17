<?php
require_once __DIR__ . '/../core/db.php';

class AuthService extends Dbh {

  public function add_user($user) {
    $query = "INSERT INTO users (name, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connection->prepare($query);

    $name = $user->getName();
    $lastname = $user->getLastname();
    $username = $user->getUsername();
    $email = $user->getEmail();
    $password = $user->getPassword();

    if (empty($name) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
      throw new Exception("All fields are required.");
    }

    $stmt->bind_param("sssss", $name, $lastname, $username, $email, $password);

    $existingUser = $this->get_user($username);
    if ($existingUser) {
      throw new Exception("Username already exists.");
    }

    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function login($username, $password) {
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $hashedPassword = $user['password'];

      if (password_verify($password, $hashedPassword)) {
        $stmt->close();
        return true;
      }
    }

    $stmt->close();
    return false;
  }

  public function get_user($username, $email = null) {
    $query = "SELECT 
              user_id, role, name, lastname, username, email, balance 
              FROM users 
              WHERE username = ? OR email = ?";
    
    $stmt = $this->connection->prepare($query);
    $emailParam = $email ?? $username;
    $stmt->bind_param("ss", $username, $emailParam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $stmt->close();
      return $user;
    }

    $stmt->close();
    return null;
  }

  public function get_user_by_id($user_id) {
    $query = "SELECT user_id, role, name, lastname, username, email, balance FROM users WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $stmt->close();
      return $user;
    }

    $stmt->close();
    return null;
  }

  public function update_user($user_id, $newData) {
    $newName = $newData['name'];
    $newLastName = $newData['lastname'];
    $newUserName = $newData['username'];
    $newEmail = $newData['email'];

    $query = "UPDATE users SET name = ?, lastname = ?, username = ?, email = ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("ssssi", $newName, $newLastName, $newUserName, $newEmail, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function add_balance($user_id, $amount) {
    $query = "UPDATE users SET balance = balance + ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("di", $amount, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function deduct_balance($user_id, $amount) {
    $query = "UPDATE users SET balance = balance - ? WHERE user_id = ? AND balance >= ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("did", $amount, $user_id, $amount);
    $result = $stmt->execute();
    $stmt->close();
    return $result && $this->connection->affected_rows > 0;
  }

  public function get_balance($user_id) {
    $query = "SELECT balance FROM users WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row ? $row['balance'] : 0;
  }
}
