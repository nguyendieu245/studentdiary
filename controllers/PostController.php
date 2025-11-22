<?php
// controllers/PostController.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php'; 

class PostController {
    private $db;
    private $post;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->post = new Post($this->db);
        $this->category = new Category($this->db);
    }

    // ==============================
    // FRONTEND METHODS
    // ==============================
    public function showHomeFeed() {
        // Lấy 3 danh mục chính để hiển thị riêng
        $skillPosts = $this->post->getByCategory(1);  // Kỹ năng
        $studyPosts = $this->post->getByCategory(3);  // Học tập
        $lifePosts  = $this->post->getByCategory(2);  // Đời sống
        $categories = $this->category->getAllCategories(); // tất cả category nếu cần hiển thị dropdown
        $currentPage = 'home';
        require __DIR__ . '/../views/frontend/home.php';
    }

    public function getByCategory($categoryId) {
        return $this->post->getByCategory($categoryId);
    }

    public function showCategoryPost($id, $commentCtrl) {
        $post = $this->post->find($id);
        if (!$post) {
            header('Location: index.php?action=home');
            exit();
        }

        if (method_exists($commentCtrl, 'allByPost')) {
            $comments = $commentCtrl->allByPost($id);
        } else {
            $comments = [];
        }

        // Xác định currentPage dựa trên category chính
        switch ($post['category_id']) {
            case 1: $currentPage = 'skill'; break;
            case 3: $currentPage = 'study'; break;
            case 2: $currentPage = 'social'; break;
            default: $currentPage = 'home';
        }

        require __DIR__ . '/../views/frontend/category_detail.php';
    }

    // ==============================
    // ADMIN METHODS
    // ==============================
    // Lấy tất cả danh mục để hiển thị trong form admin
    private function getCategoriesForForm() {
        return $this->category->getAllCategories();
    }

    public function index() {
        $posts = $this->post->all();
        $currentPage = 'baiviet';
        require __DIR__ . '/../views/admin/posts/skill_posts_list.php';
    }

    public function create() {
        $categories = $this->getCategoriesForForm();
        $currentPage = 'baiviet';
        require __DIR__ . '/../views/admin/posts/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->post->title   = htmlspecialchars($_POST['title']);
        $this->post->content = $_POST['content'];
        $this->post->author  = 'Admin';
        $this->post->status  = $_POST['status'] ?? 'published';

        if (empty($_POST['category_id'])) {
            header('Location: index.php?action=create&error=category_required');
            exit();
        }
        $this->post->category_id = $_POST['category_id'];

        // Upload ảnh nếu có
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_file = uniqid() . '_' . time() . '.' . $file_ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_file)) {
                $this->post->image = $new_file;
            } else {
                $this->post->image = '';
            }
        } else {
            $this->post->image = '';
        }

        if ($this->post->create()) {
            header('Location: index.php?action=baiviet&success=1');
            exit();
        } else {
            header('Location: index.php?action=baiviet&error=1');
            exit();
        }
    }

    public function edit($id) {
        $post = $this->post->find($id);
        if (!$post) {
            header('Location: index.php?action=baiviet&error=notfound');
            exit();
        }
        $categories = $this->getCategoriesForForm();
        $currentPage = 'baiviet';
        require __DIR__ . '/../views/admin/posts/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->post->id      = $id;
        $this->post->title   = htmlspecialchars($_POST['title']);
        $this->post->content = $_POST['content'];
        $this->post->status  = $_POST['status'] ?? 'published';

        if (empty($_POST['category_id'])) {
            header('Location: index.php?action=edit&id=' . $id . '&error=category_required');
            exit();
        }
        $this->post->category_id = $_POST['category_id'];

        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_file = uniqid() . '_' . time() . '.' . $file_ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_file)) {
                $old_post = $this->post->find($id);
                if ($old_post['image'] && file_exists($upload_dir . $old_post['image'])) {
                    unlink($upload_dir . $old_post['image']);
                }
                $this->post->image = $new_file;
            } else {
                $old_post = $this->post->find($id);
                $this->post->image = $old_post['image'];
            }
        } else {
            $old_post = $this->post->find($id);
            $this->post->image = $old_post['image'];
        }

        if ($this->post->update()) {
            header('Location: index.php?action=baiviet&success=updated');
            exit();
        } else {
            header('Location: index.php?action=baiviet&error=update_failed');
            exit();
        }
    }

    public function delete($id) {
        $post_data = $this->post->find($id);
        if ($post_data && $this->post->deleteById($id)) {
            header('Location: index.php?action=baiviet&success=deleted');
            exit();
        }
        header('Location: index.php?action=baiviet&error=delete_failed');
        exit();
    }

    public function show($id) {
        $post = $this->post->find($id);
        if (!$post) {
            header('Location: index.php?action=baiviet&error=notfound');
            exit();
        }
        $currentPage = 'baiviet';
        require __DIR__ . '/../views/admin/posts/detail_posts.php';
    }
}
?>
