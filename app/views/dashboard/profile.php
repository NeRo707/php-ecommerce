<?php
require_once __DIR__ . '/../../app.php';

$userData = $authController->getUserData();
$userPosts = $postController->getUserPosts();
?>

<?php
$name = "Profile - " . $userData['username'];
include '../_partials/header.php';
include '../_partials/navbar.php';
?>
<main>
  <div class="profile-wrap">
    <div class="profile-bar">
      <h2>Welcome, <?= $userData['username'] ?></h2>

      <div class="info">
        <div><strong>Name:</strong> <?= $userData['name'] ?></div>
        <div><strong>Last Name:</strong> <?= $userData['lastname'] ?></div>
        <div><strong>Username:</strong> @<?= $userData['username'] ?></div>
        <div><strong>Phone:</strong> <?= $userData['tel'] ?></div>
      </div>
    </div>
    <div class="posts-bar">
      <h3>My Posts</h3>
      <?php if (empty($userPosts)): ?>
        <p>You haven't posted anything yet.</p>
      <?php else: ?>
        <ul>
          <?php foreach ($userPosts as $post): ?>
            <a href=../posts/post.php?id=<?= $post['post_id'] ?>>
              <li>
                <h4><?= $post['title'] ?></h4>
                <p><?= $post['content'] ?></p>
                <small>Posted on <?= $post['created_at'] ?></small>
              </li>
            </a>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</main>