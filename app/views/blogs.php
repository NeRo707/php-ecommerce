<?php
require_once '../app.php';

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
} else {
    $uid = $_SESSION['user_data']['user_id'];
    $blogs = $blogs->getBlogs($uid);
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
<style>
    .blog-post {
        border: 1px solid black;
        margin: 1rem;
        padding: 1rem;
        border-radius: 5px;

    }

    .blog-post:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
</style>

<body>
    <?php include_once 'partials/navbar.php'; ?>
    <h1>Blogs Page</h1>
    <a href="new.php">Create New Blog</a>

    <?php
    if (!empty($blogs)):
        foreach ($blogs as $blog):
    ?>
            <div class="blog-post">
                <h2><?= $blog['title'] ?></h2>
                <p><?= $blog['content'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No blogs found.</p>
    <?php endif; ?>
</body>

</html>