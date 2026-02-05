<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/BlogsController.php';
$auth = new AuthController();
$blogs = new BlogsController();