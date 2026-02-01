<?php require_once __DIR__ . '/../app.php';

if (!$auth->isLoggedIn()) {
  header('Location: /uni/app/public/login');
  exit;
}

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
  <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=W-ikt4_2sb-5byro" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"></iframe>
</body>

</html>