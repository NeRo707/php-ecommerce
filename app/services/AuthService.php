<?php
require_once __DIR__ . '/../core/db.php';

class AuthService extends Dbh {

  public function add_user($user) {

    $query = "INSERT INTO users (name, lastname, username, tel, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->connection->prepare($query);

    $name = $user->getName();
    $lastname = $user->getLastname();
    $username = $user->getUsername();
    $tel = $user->getTel();
    $password = $user->getpassword();

    if (empty($name) || empty($lastname) || empty($username) || empty($password)) {
      throw new Exception("service: All fields are required.");
    }

    $stmt->bind_param("sssss", $name, $lastname, $username, $tel, $password);

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

      // Verify the password against the hash stored in database
      if (password_verify($password, $hashedPassword)) {
        $stmt->close();
        return true;
      }
    }

    $stmt->close();
    return false;
  }

  public function get_user($username) {
    $query = "SELECT name, lastname, username, tel, image, user_id FROM users WHERE username = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $username);
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
    $newTel = $newData['tel'];

    $query = "UPDATE users SET name = ?, lastname = ?, username = ?, tel = ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("ssssi", $newName, $newLastName, $newUserName, $newTel, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  public function upload_image($user_id, $imagePath) {
    $query = "UPDATE users SET image = ? WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("si", $imagePath, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }
}
