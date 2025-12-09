<?php
require_once __DIR__ . '/../models/Blog.php';

class BlogsService extends Dbh {

  public function get_blogs($user_id) {
    $query = "SELECT * FROM posts WHERE user_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blogs = [];
    while ($row = $result->fetch_assoc()) {
      $blogs[] = new Blog($row['post_id'], $row['user_id'], $row['title'], $row['content']);
    }
    return $blogs;
  }

  public function get_blog($blog_id) {
    $query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
      return new Blog($row['post_id'], $row['user_id'], $row['title'], $row['content']);
    }
    return null;
  }

  public function create_blog($blog) {
    $user_id = $blog->getUserId();
    $title = $blog->getTitle();
    $content = $blog->getContent();
    $query = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("iss", $user_id, $title, $content);
    return $stmt->execute();
  }
}
