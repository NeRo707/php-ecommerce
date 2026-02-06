<?php
require_once __DIR__ . '/Models/FileEditor.php';

if (isset($_GET['file'])) {
  $fileEditor = new FileEditor(__DIR__ . '/storage/' . $_GET['file']);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileEditor->write($_POST['content'] ?? '');
  }

  $content = $fileEditor->read();
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing <?= htmlspecialchars($_GET['file']) ?></title>
  </head>

  <body>
    <h1>Editing <?= htmlspecialchars($_GET['file']) ?></h1>
    <form method="POST">
      <textarea name="content" cols="100" rows="30"><?= htmlspecialchars($content) ?></textarea><br>
      <button type="submit">Save</button>
    </form>
    <a href="index.php">Back to file list</a>
  </body>

  </html>

<?php
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>select file to edit</h1>
  <?php
  
  $files = array_filter(scandir(__DIR__ . '/storage'), fn($val) => $val !== '.' and $val !== '..');

  foreach ($files as $file): ?>
    <li>
      <a href="?file=<?= $file ?>">
        <?= $file ?>
      </a>
    </li>
  <?php endforeach; ?>

</body>

</html>