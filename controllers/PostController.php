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

    // Hiển thị danh sách bài viết kĩ năng
    public function index() {
        $posts = $this->post->getAllSkillPosts();
        $currentPage = 'hoctap';
        require_once __DIR__ . '/../views/admin/posts/skill_posts_list.php';
    }

    // Hiển thị form thêm bài viết
    public function create() {
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
            $this->post->category_id = 1; // Kĩ năng
            $this->post->category = 'Kỹ năng';

            // Upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload_dir = __DIR__ . '/../public/uploads/';
                if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                    $this->post->image = $new_filename;
                } else {
                    $this->post->image = '';
                }
            } else {
                $this->post->image = '';
            }

            if ($this->post->create()) {
                header('Location: index.php?action=hoctap&success=1');
                exit();
            } else {
                header('Location: index.php?action=hoctap&error=1');
                exit();
            }
        }
    }

    // Hiển thị form sửa bài viết
    public function edit($id) {
        $post = $this->post->getById($id);
        if ($post) {
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
            $this->post->category_id = 1; // Giữ nguyên category Kĩ năng

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';

            // Upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                    // Xóa ảnh cũ
                    $old_post = $this->post->getById($id);
                    if ($old_post['image'] && file_exists($upload_dir . $old_post['image'])) {
                        unlink($upload_dir . $old_post['image']);
                    }
                    $this->post->image = $new_filename;
                } else {
                    $old_post = $this->post->getById($id);
                    $this->post->image = $old_post['image'];
                }
            } else {
                $old_post = $this->post->getById($id);
                $this->post->image = $old_post['image'];
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
        $post_data = $this->post->getById($id);
        if ($post_data) {
            // Xóa ảnh nếu có
            if ($post_data['image']) {
                $upload_dir = __DIR__ . '/../public/uploads/';
                if (file_exists($upload_dir . $post_data['image'])) {
                    unlink($upload_dir . $post_data['image']);
                }
            }

            $this->post->id = $id;
            if ($this->post->delete()) {
                header('Location: index.php?action=hoctap&success=deleted');
                exit();
            }
        }
        header('Location: index.php?action=hoctap&error=delete_failed');
        exit();
    }
}
?>