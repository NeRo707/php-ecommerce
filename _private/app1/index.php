<?php
require_once __DIR__ . '/Models/FileUploader.php';
$css = "background-color: #202020; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;";


echo "<pre>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uploader = new FileUploader();
  $result = $uploader->upload($_FILES['pdf']);
  if ($result[0]) {
    echo "File uploaded successfully: " . $result['filePath'];
  } else {
    echo "Error uploading file: " . $result[1];
  }
}
echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body style="<?= $css; ?>">
  <h1>upload pdf</h1>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="pdf" accept="application/pdf" required>
    <button type="submit">Upload</button>
  </form>

</body>

</html>