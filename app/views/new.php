<?php
require_once '../app.php';
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $blogs->createBlog();
    if ($result) {
        header('Location: blogs.php');
        exit;
    } else {
        echo "<p style='color:red;'>Failed to create blog. Please try again.</p>";
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
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    form {
        max-width: 600px;
    }

    div {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 15px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }
</style>

<body>
    <?php include_once 'partials/navbar.php'; ?>
    <h1>Create new Blog</h1>

    <form action="" method="post">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <button type="submit">Create Blog</button>
    </form>
</body>

</html>