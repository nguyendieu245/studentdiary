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
    $stmt = $this->db->prepare("
        SELECT p.*, c.name AS category_name
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC
    ");
    $stmt->execute();

    // ⚠ BẮT BUỘC PHẢI FETCHALL RA MẢNG
    $posts_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $currentPage = 'hoctap';
    require_once __DIR__ . '/../views/admin/posts/skill_posts_list.php';
}


    // Hiển thị form thêm bài viết
    public function create() {
        // Lấy danh sách categories
        $categories_stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
            
            // Lấy tên category
            $cat_stmt = $this->db->prepare("SELECT name FROM categories WHERE id = ?");
            $cat_stmt->execute([$this->post->category_id]);
            $cat = $cat_stmt->fetch(PDO::FETCH_ASSOC);
            $this->post->category = $cat ? $cat['name'] : 'Kỹ năng';

            // Upload ảnh - Sửa đường dẫn
            $this->post->image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                // Đường dẫn tuyệt đối đến thư mục uploads
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
                
                // Tạo thư mục nếu chưa có
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
                $file_type = $_FILES['image']['type'];
                
                if (in_array($file_type, $allowed_types)) {
                    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $this->post->image = $new_filename;
                        error_log("Image uploaded successfully: " . $new_filename);
                    } else {
                        error_log("Failed to move uploaded file to: " . $upload_path);
                    }
                } else {
                    error_log("Invalid file type: " . $file_type);
                }
            } else if (isset($_FILES['image'])) {
                error_log("Upload error code: " . $_FILES['image']['error']);
            }

            if ($this->post->create()) {
                header('Location: index.php?page=hoctap&success=1');
                exit();
            } else {
                error_log("Create failed!");
                header('Location: index.php?page=hoctap&error=create_failed');
                exit();
            }
        }
    }

    // Hiển thị form sửa bài viết
    public function edit($id) {
        $post = $this->post->getById($id);
        if ($post) {
            // Lấy danh sách categories
            $categories_stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
            $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $currentPage = 'hoctap';
            require_once __DIR__ . '/../views/admin/posts/edit.php';
        } else {
            header('Location: index.php?page=hoctap&error=notfound');
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
            header('Location: index.php?page=hoctap&error=notfound');
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
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
                $file_type = $_FILES['image']['type'];
                
                if (in_array($file_type, $allowed_types)) {
                    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
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
            } else {
                $old_post = $this->post->getById($id);
                $this->post->image = $old_post['image'];
            }

            if ($this->post->update()) {
                header('Location: index.php?page=hoctap&success=updated');
                exit();
            } else {
                header('Location: index.php?page=hoctap&error=update_failed');
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
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
                if (file_exists($upload_dir . $post_data['image'])) {
                    unlink($upload_dir . $post_data['image']);
                }
            }

            $this->post->id = $id;
            if ($this->post->delete()) {
                header('Location: index.php?page=hoctap&success=deleted');
                exit();
            }
        }
        header('Location: index.php?page=hoctap&error=delete_failed');
        exit();
    }
}
?>