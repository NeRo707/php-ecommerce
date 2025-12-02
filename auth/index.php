<?php

require_once 'User.php';
require_once 'db.php';

$dbHelper = new Dbhelper('localhost', 'root', '', 'salesdb');
$connection = $dbHelper->getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['register'])) {

        if (
            empty($_POST['name']) ||
            empty($_POST['lastname']) ||
            empty($_POST['tel']) ||
            empty($_POST['pass']) ||
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
            $_POST['pass'],
        );

        $isAdded = $dbHelper->addUser($user);

        if ($isAdded) {
            echo "User registered successfully.";
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
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <?php if (!empty($isAdded)) echo "<h1>" . $isAdded . "</h1>" ?>

    <form action="" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="tel" placeholder="Telephone">
        <input type="password" name="pass" placeholder="Password">
        <button type="submit" name="register">Register</button>
    </form>

</body>

</html>