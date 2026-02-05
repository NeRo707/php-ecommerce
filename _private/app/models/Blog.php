<?php

class Blog {
    private ?int $post_id;
    private int $user_id;
    private string $title;
    private string $content;

    public function __construct(?int $post_id, int $user_id, string $title, string $content) {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
    }

    public function getPostId(): int {
        return $this->post_id;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }
}
