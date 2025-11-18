<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Comment.php';

class PostViewController
{
    private $postModel;
    private $categoryModel;
    private $commentModel;

    public function __construct($db)
    {
        $this->postModel    = new Post($db);
        $this->categoryModel = new Category($db);
        $this->commentModel = new Comment($db);
    }

    // Hiển thị danh sách bài viết theo danh mục
    public function category($id)
    {
        $category = $this->categoryModel->find($id);
        $posts = $this->postModel->getByCategory($id);

        include __DIR__ . '/../views/frontend/post_list.php';
    }

    // Xem chi tiết bài viết
    public function detail($id)
    {
        $post = $this->postModel->find($id);
        $comments = $this->commentModel->getCommentsByPost($id);

        include __DIR__ . '/../views/frontend/post_detail.php';
    }
}
