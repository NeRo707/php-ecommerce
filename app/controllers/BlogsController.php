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

    public function createBlog() {
            $user_id = $_SESSION['user_data']['user_id'] ?? null;
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
