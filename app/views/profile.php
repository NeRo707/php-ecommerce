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
$user = $auth->getUser();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_name'])) {
  $newName = trim($_POST['newname']);
  if (!empty($newName)) {
    $updateSuccess = $auth->changeName($user->getUserId(), $newName);
    
    if ($updateSuccess) {
      $_SESSION['msg'] = "Name updated successfully.";
      $user = $auth->getUser();
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

<?php $title="Profile"; include_once './partials/header.php'; ?>

<body>
  <?php include_once './partials/navbar.php'; ?>
  <?= $auth->getMessage() ?>
  <div class="profile-card">
    <h2>Welcome, <?= $user->getUsername() ?></h2>
    <div class="info">
      <div><strong>Name:</strong> <?= $user->getName() ?></div>
      <div><strong>Last Name:</strong> <?= $user->getLastname() ?></div>
      <div><strong>Username:</strong> @<?= $user->getUsername() ?></div>
      <div><strong>Phone:</strong> <?= $user->getTel() ?></div>
    </div>

    <form action="" method="post">
      <label for="newname"></label>
      <input type="text" name="newname" id="newname" placeholder="New Name" required>
      <button type="submit" name="change_name">Change Name</button>
    </form>

  </div>
</body>

</html>