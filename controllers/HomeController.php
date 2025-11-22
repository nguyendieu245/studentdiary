<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';

class HomeController
{
    private $postModel;
    private $categoryModel;

    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->postModel = new Post($db);
        $this->categoryModel = new Category($db);
    }

    // Trang chủ
    public function index()
    {
        $latestPosts = $this->postModel->getLatest(6); 
        $categories  = $this->categoryModel->all();

        // Biến cho header
        $action = 'index';
        $username = $_SESSION['username'] ?? '';

        include __DIR__ . '/../views/frontend/home.php';
    }
}