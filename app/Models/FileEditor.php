<?php
class FileEditor {

  private string $filepath;
  private ?string $content = null;

  public function __construct(string $filepath) {
    $this->filepath = $filepath;
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

  public function read2(): ?string {
    return file_get_contents($this->filepath);
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
}
