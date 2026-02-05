<?php
require_once '../app.php';

$url = trim($_GET['url'] ?? '', '/');

// small router
switch ($url) {
    case '':
        require '../views/index.php';
        break;

    case 'login':
        require '../views/auth/login.php';
        break;

    case 'register':
        require '../views/auth/register.php';
        break;

    case 'secret':
        require '../views/secret.php';
        break;

    case 'user/profile':
        require '../views/user/profile.php';
        break;

    case 'blogs':
        require '../views/blogs/blogs.php';
        break;

    case 'blogs/new':
        require '../views/blogs/new.php';
        break;

    case 'blog':
        require '../views/blogs/blog.php';
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
}
