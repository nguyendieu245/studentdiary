<?php
require_once __DIR__ . '/../models/Comments.php';

class CommentController {
    private $comment;

    public function __construct($db) {
        $this->comment = new Comment($db);
    }

    public function store($post_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'] ?? null;
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $_POST['comment'];
            $this->comment->create($post_id, $user_id, $name, $email, $comment);
            header("Location: index.php?action=post_detail&id=$post_id");
            exit;
        }
    }

    public function delete($id, $post_id) {
        $this->comment->delete($id);
        header("Location: index.php?action=post_detail&id=$post_id");
        exit;
    }
}
