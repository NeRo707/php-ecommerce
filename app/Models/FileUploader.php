<?php
require_once __DIR__ . '/../cfg/db.php';
class FileUploader {
  private Dbh $db;
  private string $filepath;
  private ?string $content = null;

  public function __construct() {
    $this->db = new Dbh();
  }

  public function read(): ?string {

    $handle = fopen($this->filepath, 'r');

    if (!$handle) {
      return null;
    };

    $this->content = fread($handle, filesize($this->filepath));
    fclose($handle);

    return $this->content;
  }

  public function write(string $input): bool {
    $handle = fopen($this->filepath, 'w');

    if (!$handle) {
      return false;
    };

    fwrite($handle, $input);
    fclose($handle);

    return true;
  }

  public function upload(array $file): array {
    $targetDir = __DIR__ . '/../storage/';
    $targetFile = $targetDir . basename($file['name']);
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    $extensions = ['pdf'];
    if (!in_array($fileType, $extensions)) {
      return [0 => false, 1 => 'Invalid file type. Only PDF files are allowed.'];
    }

    $fileSize = $file['size'];
    $maxSize = 2 * 1024 * 1024; // 2mb

    if($fileSize > $maxSize){
      return [0 => false, 1 => "file size is more than 2mb"];
    };
    

    if ($fileType !== 'pdf') {
      return [0 => false, 1 => 'Only PDF files are allowed.'];
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
      $this->db->upload($targetFile);
      return [0 => true, 'filePath' => $targetFile];
    } else {
      return [0 => false, 1 => 'Error uploading file.'];
    }
  }
}
