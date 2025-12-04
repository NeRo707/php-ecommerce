<?php
require_once '../core/db.php';

$dbHelper = new Dbhelper();
$connection = $dbHelper->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['login'])) {

    if (
      empty($_POST['username']) ||
      empty($_POST['password'])
    ) {
      die("All fields are required.");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $isLoggedIn = $dbHelper->login($username, $password);

    if ($isLoggedIn) {
      $user = $dbHelper->getUserByUsername($username);
      $name = $user['name'];
      $lastname = $user['lastname'];
      $tel = $user['tel'];
      echo "Login successful.";
    } else {
      echo "Invalid username or password.";
    }
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <nav>
    <a href="index.php">Register</a>
    <a href="login.php">Login</a>
  </nav>
  <main>
    <?php if (!isset($isLoggedIn) || !$isLoggedIn): ?>
      <form action="" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">Login</button>
      </form>
    <?php elseif ($isLoggedIn): ?>
      <div class="profile-card">
        <h2>Welcome, <?= $username ?></h2>

        <div class="info">
          <div><strong>Name:</strong> <?= $name ?></div>
          <div><strong>Last Name:</strong> <?= $lastname ?></div>
          <div><strong>Username:</strong> @<?= $username ?></div>
          <div><strong>Phone:</strong> <?= $tel ?></div>
        </div>

        <a class="logout-btn" href="login.php">Logout</a>
      </div>
    <?php endif; ?>

  </main>
</body>

</html>