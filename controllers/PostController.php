<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';

class PostController {
    private $post;
    private $category;

    public function __construct($db) {
        $this->post = new Post($db);
        $this->category = new Category($db);
    }

    public function index() {
        $posts = $this->post->all();
        include __DIR__ . '/../views/post/list.php';
    }

    public function create() {
        $categories = $this->category->all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $author = $_POST['author'];
            $image = $_POST['image'];
            $status = $_POST['status'];
            $category_id = $_POST['category_id'];
            $this->post->create($title, $content, $author, $image, $status, $category_id);
            header('Location: index.php?action=posts');
            exit;
        }
        include __DIR__ . '/../views/post/form.php';
    }

    public function edit($id) {
        $categories = $this->category->all();
        $post = $this->post->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_POST['image'];
            $status = $_POST['status'];
            $category_id = $_POST['category_id'];
            $this->post->update($id, $title, $content, $image, $status, $category_id);
            header('Location: index.php?action=posts');
            exit;
        }
        include __DIR__ . '/../views/post/form.php';
    }

    public function delete($id) {
        $this->post->delete($id);
        header('Location: index.php?action=posts');
        exit;
    }
}
