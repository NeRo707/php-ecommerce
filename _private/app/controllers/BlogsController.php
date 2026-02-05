<?php
require_once __DIR__ . '/../services/BlogsService.php';
require_once __DIR__ . '/../models/Blog.php';

class BlogsController {
  private $blogsService;

  public function __construct() {
    $this->blogsService = new BlogsService();
  }

  public function getBlogs($user_id) {

    if (empty($user_id) || !is_numeric($user_id)) {
      echo "Invalid user ID.";
      return false;
    }

    try {
      $blogs = $this->blogsService->get_blogs($user_id);
      return $blogs;
    } catch (\Throwable $th) {
      echo "Error fetching blogs: " . $th->getMessage();
      return false;
    }

    return false;
  }

  public function getBlog($blog_id) {
    if (empty($blog_id) || !is_numeric($blog_id)) {
      echo "Invalid blog ID.";
      return false;
    }

    try {
      $blog = $this->blogsService->get_blog($blog_id);
      return $blog;
    } catch (\Throwable $th) {
      echo "Error fetching blog: " . $th->getMessage();
      return false;
    }

    return false;
  }

  public function createBlog() {
    $user_id = isset($_SESSION['user']) ? $_SESSION['user']->getUserId() : null;
    $title = $_POST['title'] ?? null;
    $content = $_POST['content'] ?? null;

    echo "Creating blog for user ID: " . $user_id . "\n";

    if (empty($user_id) || !is_numeric($user_id)) {
      echo "Invalid user ID.";
      return false;
    }

    if (empty($title) || empty($content)) {
      echo "Title and content cannot be empty.";
      return false;
    }

    try {
      $newBlog = new Blog(null, $user_id, $title, $content);
      $result = $this->blogsService->create_blog($newBlog);
      return $result;
    } catch (\Throwable $th) {
      echo "Error creating blog: " . $th->getMessage();
      return false;
    }

    return false;
  }
}
