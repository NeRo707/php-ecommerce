<?php
require_once __DIR__ . '/../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: /uni/app/public/login');
  exit;
} else {
  $bid = $_GET['id'];
  $blog = $blogs->getBlog($bid);
}

?>


<!DOCTYPE html>
<html lang="en">

<?php $title = "Blogs";
include_once __DIR__ . '/../_partials/header.php'; ?>

<body>
  <?php include_once __DIR__ . '/../_partials/navbar.php'; ?>
  <h1>Blogs Page</h1>
  <a href="/uni/app/public/blogs">Back to Blogs</a>

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