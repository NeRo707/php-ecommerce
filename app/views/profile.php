<?php

require_once '../app.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $auth->logout();
  header('Location: login.php');
  exit();
}

$isLoggedIn = $auth->isLoggedIn();
if (!$isLoggedIn) {
  header('Location: login.php');
  exit();
}
$userData = $auth->getUserData();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_name'])) {
  $newName = trim($_POST['newname']);
  if (!empty($newName)) {
    $updateSuccess = $auth->changeName($userData['user_id'], $newName);
    
    if ($updateSuccess) {
      $_SESSION['msg'] = "Name updated successfully.";
      $userData = $auth->getUserData();
    } else {
      $_SESSION['msg'] = "<p style=\"color: red\">Failed to update name.<p>";
    }
  } else {
    $_SESSION['msg'] = "Name cannot be empty.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styless.css">
</head>

<body>
  <?php include_once './partials/navbar.php'; ?>
  <?= $auth->getMessage() ?>
  <div class="profile-card">
    <h2>Welcome, <?= $userData['username'] ?></h2>
    <div class="info">
      <div><strong>Name:</strong> <?= $userData['name'] ?></div>
      <div><strong>Last Name:</strong> <?= $userData['lastname'] ?></div>
      <div><strong>Username:</strong> @<?= $userData['username'] ?></div>
      <div><strong>Phone:</strong> <?= $userData['tel'] ?></div>
    </div>

    <form action="" method="post">
      <label for="newname"></label>
      <input type="text" name="newname" id="newname" placeholder="New Name" required>
      <button type="submit" name="change_name">Change Name</button>
    </form>

  </div>
</body>

</html>