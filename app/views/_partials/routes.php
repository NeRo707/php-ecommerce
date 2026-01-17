<?php
$routes = [
  "home" => [
    "label" => "Home",
    "path"  => "",
  ],
  "shop" => [
    "label" => "Shop",
    "path"  => "items/shop",
  ],
  "cart" => [
    "label" => "Cart",
    "path"  => "cart/cart",
    "auth"  => true
  ],
  "orders" => [
    "label" => "My Orders",
    "path"  => "cart/orders",
    "auth"  => true
  ],
  "balance" => [
    "label" => "Balance",
    "path"  => "user/balance",
    "auth"  => true
  ],
  "admin" => [
    "label" => "Admin Panel",
    "path"  => "admin/index",
    "admin" => true
  ],
  "profile" => [
    "label" => "Profile",
    "path"  => "user/profile",
    "auth"  => true
  ],
  "logout" => [
    "label" => "Logout",
    "path"  => "auth/login?action=logout",
    "auth"  => true
  ],
  "login" => [
    "label" => "Login",
    "path"  => "auth/login",
    "auth"  => false
  ],
  "register" => [
    "label" => "Register",
    "path" => "auth/register",
    "auth" => false
  ],
];

?>