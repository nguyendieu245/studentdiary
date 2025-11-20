<?php
// controllers/PostController.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Post.php';

class PostController {
    private $db;
    private $post;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->post = new Post($this->db);
    }

    // Hiển thị danh sách tất cả bài viết
    public function index() {
        $posts_data = $this->post->getAllPosts();
        $currentPage = 'hoctap';
        require_once __DIR__ . '/../views/admin/posts/skill_posts_list.php';
    }

    // Hiển thị form thêm bài viết
    public function create() {
        $categories = $this->post->getAllCategories(); // gọi model để lấy categories
        $currentPage = 'hoctap';
        require_once __DIR__ . '/../views/admin/posts/create.php';
    }

    // Xử lý thêm bài viết
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post->title = htmlspecialchars($_POST['title']);
            $this->post->content = $_POST['content'];
            $this->post->author = 'Admin';
            $this->post->status = $_POST['status'] ?? 'published';
            $this->post->category_id = $_POST['category_id'] ?? 1;

            // Upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $this->post->uploadImage($_FILES['image']);
            }

            if ($this->post->create()) {
                header('Location: index.php?action=hoctap&success=1');
                exit();
            } else {
                header('Location: index.php?action=hoctap&error=create_failed');
                exit();
            }
        }
    }

    // Hiển thị form sửa bài viết
    public function edit($id) {
        $post = $this->post->getById($id);
        if ($post) {
            $categories = $this->post->getAllCategories();
            $currentPage = 'hoctap';
            require_once __DIR__ . '/../views/admin/posts/edit.php';
        } else {
            header('Location: index.php?action=hoctap&error=notfound');
            exit();
        }
    }

    // Xem chi tiết bài viết
    public function show($id) {
        $post = $this->post->getById($id);
        if ($post) {
            $currentPage = 'hoctap';
            require_once __DIR__ . '/../views/admin/posts/detail_posts.php';
        } else {
            header('Location: index.php?action=hoctap&error=notfound');
            exit();
        }
    }

    // Xử lý cập nhật bài viết
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post->id = $id;
            $this->post->title = htmlspecialchars($_POST['title']);
            $this->post->content = $_POST['content'];
            $this->post->status = $_POST['status'] ?? 'published';
            $this->post->category_id = $_POST['category_id'] ?? 1;

            // Upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $this->post->uploadImage($_FILES['image'], $id);
            }

            if ($this->post->update()) {
                header('Location: index.php?action=hoctap&success=updated');
                exit();
            } else {
                header('Location: index.php?action=hoctap&error=update_failed');
                exit();
            }
        }
    }

    // Xóa bài viết
    public function delete($id) {
        if ($this->post->deleteById($id)) {
            header('Location: index.php?action=hoctap&success=deleted');
            exit();
        } else {
            header('Location: index.php?action=hoctap&error=delete_failed');
            exit();
        }
    }
}
?>
