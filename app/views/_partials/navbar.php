<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<nav>
    <a href="../home/index.php">Home</a>
    <?php if (!$isLoggedIn): ?>
        <a href="../auth/register.php">Register</a>
        <a href="../auth/login.php">Login</a>
    <?php else: ?>
        <a href="../dashboard/profile.php">Profile</a>
        <a href="../posts/posts.php">Posts</a>
        <a href="../posts/create_post.php">Create Post</a>
        <a href="../auth/login.php?action=logout">Logout</a>
    <?php endif; ?>
</nav>