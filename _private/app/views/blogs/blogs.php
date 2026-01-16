<?php
require_once '../../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: login.php');
  exit;
} else {
  $uid = $auth->getUser()->getUserId();
  $blogs = $blogs->getBlogs($uid);
}

?>


<!DOCTYPE html>
<html lang="en">

<?php $title = "Blogs";
include_once '../_partials/header.php'; ?>

<style>
  .blog-post {
    border: 1px solid black;
    margin: 1rem;
    padding: 1rem;
    border-radius: 5px;
    width: 35rem;
    max-width: 35rem;
  }

  .blog-post:hover {
    background-color: #f0f0f0;
    cursor: pointer;
  }
</style>

<body>
  <?php include_once '../_partials/navbar.php'; ?>
  <h1>Blogs Page</h1>
  <a href="new.php">Create New Blog</a>

  <?php
  if (!empty($blogs)):
    foreach ($blogs as $blog):
  ?>
      <a style="text-decoration: none;" href="blog.php?id=<?= $blog->getPostId() ?>">
        <div class="blog-post">
          <h2 style="color:green;"><?= $blog->getTitle() ?></h2>
          <p><?= $blog->getContent() ?></p>
        </div>
      </a>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No blogs found.</p>
  <?php endif; ?>
</body>

</html>