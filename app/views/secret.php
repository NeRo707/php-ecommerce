<?php require_once '../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: login.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<?php $title = "Secret";
include_once './partials/header.php'; ?>

<body>
  <?php include_once './partials/navbar.php'; ?>
  <h1>secret page</h1>
  <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=W-ikt4_2sb-5byro" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"></iframe>
</body>

</html>