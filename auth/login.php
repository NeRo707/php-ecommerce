<?php
require_once 'db.php';
$dbHelper = new Dbhelper();
$connection = $dbHelper->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['login'])) {

        if (
            empty($_POST['username']) ||
            empty($_POST['pass'])
        ) {
            die("All fields are required.");
        }

        $username = $_POST['username'];
        $pass = $_POST['pass'];

        $isLoggedIn = $dbHelper->login($username, $pass);

        if ($isLoggedIn) {
            echo "Login successful.";
        } else {
            echo "Invalid username or password.";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <a href="index.php">Register</a>
        <a href="login.php">Login</a>
    </nav>
    <main>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="pass" placeholder="Password">
            <button type="submit" name="login">Login</button>
        </form>
    </main>
</body>

</html>