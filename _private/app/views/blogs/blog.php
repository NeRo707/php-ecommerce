<?php
require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: login.php');
  exit;
} else {
  $bid = $_GET['id'];
  $blog = $blogs->getBlog($bid);
}

?>


<!DOCTYPE html>
<html lang="en">

<?php $title = "Blogs";
include_once '../_partials/header.php'; ?>

<body>
  <?php include_once '../_partials/navbar.php'; ?>
  <h1>Blogs Page</h1>
  <a href="blogs.php">Back to Blogs</a>

  <?php
  if (!empty($blog)):
  ?>
    <div class="blog-post">
      <h2 style="color:green;"><?= $blog->getTitle() ?></h2>
      <p><?= $blog->getContent() ?></p>
    </div>
  <?php else: ?>
    <p>No blogs found.</p>
  <?php endif; ?>
</body>

</html>