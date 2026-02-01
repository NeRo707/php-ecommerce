<?php

require_once __DIR__ . '/../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
  $auth->register();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title="Register"; include_once __DIR__ . '/../_partials/header.php'; ?>

<body>

  <?php 
    $message = $auth->getMessage();
    if (!empty($message)) echo "<p>" . $message . "</p>";
  ?>

  <?php include_once __DIR__ . '/../_partials/navbar.php'; ?>

  <form action="" method="post">
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="lastname" placeholder="Lastname">
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="tel" placeholder="Telephone">
    <input type="password" name="password" placeholder="password" required>
    <button type="submit" name="register">Register</button>
  </form>

</body>

</html>