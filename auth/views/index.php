<?php

require_once '../models/User.php';
require_once '../core/db.php';

$dbHelper = new Dbhelper();
$connection = $dbHelper->getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['register'])) {

        if (
            empty($_POST['name']) ||
            empty($_POST['lastname']) ||
            empty($_POST['tel']) ||
            empty($_POST['password']) ||
            empty($_POST['username'])
        ) {
            die("All fields are required.");
        }

        $user = new User(
            null,
            $_POST['name'],
            $_POST['lastname'],
            $_POST['username'],
            $_POST['tel'],
            password_hash($_POST['password'], PASSWORD_DEFAULT),
        );

        $isAdded = $dbHelper->addUser($user);

        if ($isAdded) {
            echo "User registered successfully.";
            header("Location: login.php");
            exit();
        } else {
            echo "Error registering user.";
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

    <?php if (!empty($isAdded)) echo "<h1>" . $isAdded . "</h1>" ?>

    <nav>
        <a href="index.php">Register</a>
        <a href="login.php">Login</a>
    </nav>

    <form action="" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="tel" placeholder="Telephone">
        <input type="password" name="password" placeholder="password">
        <button type="submit" name="register">Register</button>
    </form>

</body>

</html>