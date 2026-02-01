<?php

require_once __DIR__ . '/../../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $auth->login();
}

$isLoggedIn = $auth->isLoggedIn();

if ($isLoggedIn) {
  header('Location: /uni/app/public/user/profile');
  exit();
}

?>



<!DOCTYPE html>
<html lang="en">

<?php $title="Login"; include_once __DIR__ . '/../_partials/header.php'; ?>

<body>
  <?php include_once __DIR__ . '/../_partials/navbar.php'; ?>
  <main>
    <p style="color: red;"><?= $auth->getMessage() ?></p>

    <form action="" method="post">
      <input type="text" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="login">Login</button>
    </form>
  </main>
</body>

</html>