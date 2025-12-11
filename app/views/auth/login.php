<?php

require_once '../../app.php';

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $authController->logout();
}

// Handle login
$authController->login();

// Check if user is logged in
$isLoggedIn = $authController->isUserLoggedIn();

?>



<!DOCTYPE html>
<html lang="en">

<?php 
$name = "Login";
include_once '../_partials/header.php'; 
?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>
  <main>
    <?php if (!empty($authController->message)): ?>
      <div class="message error"><?= $authController->message ?></div>
    <?php endif; ?>

    <?php if (!$isLoggedIn): ?>
      <form action="" method="post">
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Sign In</button>
      </form>
    <?php else: 
      Header("Location: ../dashboard/profile.php");
    ?>
    <?php endif; ?>

  </main>
</body>

</html>