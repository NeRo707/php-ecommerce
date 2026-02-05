<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../models/User.php';
class AuthController {

  private $isLoggedIn = false;
  private $user = null;
  protected $authService;

  public function __construct() {
    $this->authService = new AuthService();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['user'])) {
      $this->isLoggedIn = true;
      $this->user = $_SESSION['user'];
    }
  }

  public function login() {
    if (empty($_POST['username']) || empty($_POST['password'])) {
      $_SESSION['msg'] = "All fields are required.";
      return false;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $this->isLoggedIn = $this->authService->login($username, $password);

    if ($this->isLoggedIn) {
      $userData = $this->authService->get_user($username);
      $_SESSION['logged_in'] = true;

      $this->user = new User(
        $userData['user_id'],
        $userData['name'],
        $userData['lastname'],
        $userData['username'],
        $userData['tel'],
        $userData['image'],
      );
      $_SESSION['user'] = $this->user;

      $_SESSION['msg'] = "Login successful.";
      return true;
    } else {
      $_SESSION['msg'] = "Invalid username or password.";
      return false;
    }

    return false;
  }

  public function logout() {
    session_start();
    session_destroy();
    header("Location: login.php");
    exit();
  }

  public function isLoggedIn() {
    return $this->isLoggedIn;
  }

  public function getUser() {
    if ($this->isLoggedIn()) {
      return $this->user;
    }
    return null;
  }

  public function register() {
    if (
      empty($_POST['name']) ||
      empty($_POST['lastname']) ||
      empty($_POST['tel']) ||
      empty($_POST['password']) ||
      empty($_POST['username'])
    ) {
      $_SESSION['msg'] = "All fields are required.";
      return false;
    }

    $user = new User(
      null,
      $_POST['name'],
      $_POST['lastname'],
      $_POST['username'],
      $_POST['tel'],
      password_hash($_POST['password'], PASSWORD_DEFAULT),
      null
    );

    try {
      $isAdded = $this->authService->add_user($user);
    } catch (\Throwable $th) {
      $_SESSION['msg'] = "Error: " . $th->getMessage();
      return false;
    }

    if ($isAdded) {
      $_SESSION['msg'] = "User registered successfully.";
      header("Location: login.php");
      exit();
    } else {
      $_SESSION['msg'] = "Error registering user.";
    }
    return $isAdded;
  }

  public function getMessage() {
    if (isset($_SESSION['msg'])) {
      $message = $_SESSION['msg'];
      unset($_SESSION['msg']);
      return $message;
    }
    return '';
  }

  public function updateProfile($user_id, $newData) {
    if (empty($_POST['update_profile'])) {
      $_SESSION['msg'] = "No data to update.";
      return false;
    }

    if( empty($newData['username']) || empty($newData['name']) || empty($newData['lastname']) || empty($newData['tel']) ) {
      $_SESSION['msg'] = "All fields are required.";
      return false;
    }

    $isUpdated = $this->authService->update_user($user_id, $newData);

    if ($isUpdated) {
      $_SESSION['msg'] = "Name updated successfully.";
      // Update session user data
      if ($this->user) {
        $this->user->setName($newData['name']);
        $this->user->setLastname($newData['lastname']);
        $this->user->setUsername($newData['username']);
        $this->user->setTel($newData['tel']);
        $_SESSION['user'] = $this->user;
      }
      return true;
    } else {
      $_SESSION['msg'] = "Error updating name.";
      return false;
    }
  }

  public function uploadProfileImage($user_id, $file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
      $_SESSION['msg'] = "File upload error.";
      return false;
    }

    $targetDir = __DIR__ . '/../uploads/';
    if (!is_dir($targetDir)) {
      echo "No Dir at " . $targetDir;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    if( !in_array(strtolower($fileExtension), $allowedExtensions) ) {
      $_SESSION['msg'] = "<p style=\"color: red\">Invalid file type. Only JPG, JPEG, and PNG are allowed.</p>";
      return false;
    }

    echo "File Extension: " . $fileExtension;

    $fileSize = $file['size'];
    $maxSize = 5 * 1024 * 1024;
    if ($fileSize > $maxSize) {
      $_SESSION['msg'] = "File size exceeds " . ($maxSize / 1024 / 1024) ." MB limit.";
      return false;
    }

    $fileName = basename($file['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
      $relativePath = '/uni/app/uploads/' . $fileName;
      $isUpdated = $this->authService->upload_image($user_id, $relativePath);

      if ($isUpdated) {
        $_SESSION['msg'] = "Profile image updated successfully.";
        // Update session user data
        if ($this->user) {
          $this->user->setImage($relativePath);
          $_SESSION['user'] = $this->user;
        }
        return true;
      } else {
        $_SESSION['msg'] = "Error updating profile image in database.";
        return false;
      }
    } else {
      $_SESSION['msg'] = "Error moving uploaded file.";
      return false;
    }
  }
}
