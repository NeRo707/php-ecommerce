<?php require_once __DIR__ . '/../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: /uni/app/public/login');
  exit;
}


$a = fopen('sigma.txt', 'r');
$text = fread($a, filesize('sigma.txt'));
echo $text;



?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secret</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <?php include_once __DIR__ . '/_partials/navbar.php'; ?>
  <h1>secret page</h1>

</body>

</html>