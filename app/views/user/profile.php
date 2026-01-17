<?php

require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: ../auth/login.php');
  exit();
}

$user = $auth->getUser();

$editing = false;
if (isset($_GET['edit']) && $_GET['edit'] === 'true') {
  $editing = true;
} else {
  $editing = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $auth->update();

  header('Location: profile');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<?php $title = "My Profile";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>

  <main>
    <h1 class="page-title">My Profile</h1>

    <?php
    $response = $auth->getResponse();
    if (!empty($response)):
    ?>
      <div class="response success">
        <?= $response ?>
      </div>
    <?php endif; ?>

    <?php if (!$editing) {
      include_once './_partials/profile_card.php';
    } else {
      include_once './_partials/edit_profile_card.php';
    }
    ?>
  </main>
</body>

</html>