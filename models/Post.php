<?php
class Post
{
    private $conn;
    private $table = "posts";

    public $id;
    public $title;
    public $content;
    public $author;
    public $image;
    public $status;
    public $category_id;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả bài viết
    public function getAllPosts()
    {
        $stmt = $this->conn->query("
            SELECT p.*, c.name AS category_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả bài viết kỹ năng (category_id = 1)
    public function getAllSkillPosts()
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.category_id = 1
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bài viết theo id
    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách categories
    public function getAllCategories()
    {
        $stmt = $this->conn->query("SELECT * FROM categories ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Upload ảnh
    public function uploadImage($file, $id = null)
    {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
        $file_type = $file['type'];

        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Xóa ảnh cũ nếu có
                if ($id) {
                    $old_post = $this->getById($id);
                    if ($old_post && $old_post['image'] && file_exists($upload_dir . $old_post['image'])) {
                        unlink($upload_dir . $old_post['image']);
                    }
                }
                $this->image = $new_filename;
                return true;
            }
        }
        return false;
    }

    // Thêm bài viết
    public function create()
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (title, content, author, image, status, category_id, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$this->title, $this->content, $this->author, $this->image, $this->status, $this->category_id]);
    }

    // Cập nhật bài viết
    public function update()
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET title=?, content=?, image=?, status=?, category_id=?
            WHERE id=?
        ");
        return $stmt->execute([$this->title, $this->content, $this->image, $this->status, $this->category_id, $this->id]);
    }

    // Xóa bài viết theo id
    public function deleteById($id)
    {
        // Xóa ảnh nếu có
        $post = $this->getById($id);
        if ($post && $post['image']) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
            if (file_exists($upload_dir . $post['image'])) {
                unlink($upload_dir . $post['image']);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
