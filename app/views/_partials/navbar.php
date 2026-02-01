<?php
$routes = [
  "secret" => [
    "label" => "Secret",
    "path" => "secret",
    "auth" => true
  ],
  "home" => [
    "label" => "Home",
    "path"  => "",
  ],
  "profile" => [
    "label" => "Profile",
    "path"  => "user/profile",
    "auth"  => true
  ],
  "logout" => [
    "label" => "Logout",
    "path"  => "login?action=logout",
    "auth"  => true
  ],
  "login" => [
    "label" => "Login",
    "path"  => "login",
    "auth"  => false
  ],
  "register" => [
    "label" => "Register",
    "path" => "register",
    "auth" => false
  ],
  "blogs" => [
    "label" => "Blogs",
    "path" => "blogs",
    "auth" => true
  ]
];
$base = "/uni/app/public/";
$isLoggedIn = $auth->isLoggedIn();
?>

<nav>
  <?php foreach ($routes as $route): ?>

    <?php
    if (isset($route['auth'])) {
      if ($route['auth'] && !$isLoggedIn) continue;
      if (!$route['auth'] && $isLoggedIn) continue;
    }
    ?>

    <a href="<?= $base . $route['path'] ?>">
      <?= htmlspecialchars($route['label']) ?>
    </a>
  <?php endforeach; ?>
</nav>