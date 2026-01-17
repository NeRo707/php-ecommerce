<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ItemController.php';
require_once __DIR__ . '/controllers/CartController.php';

$auth = new AuthController();
$items = new ItemController();
$cart = new CartController();
