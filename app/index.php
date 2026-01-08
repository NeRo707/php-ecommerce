<?php
header("Location: views/index.php");
# Source - https://stackoverflow.com/a
# Posted by alexn
# Retrieved 2026-01-08, License - CC BY-SA 3.0

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ $1.php [L]

exit();
