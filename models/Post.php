<?php
// models/Post.php

class Post
{
    private $conn;
    private $table = "posts";

    public $id;
    public $title;
    public $content;
    public $author;       // id người viết
    public $author_name;  // tên người viết
    public $image;
    public $status;
    public $category_id;
    public $views;        // lượt xem
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả bài viết
    public function all()
    {
        $stmt = $this->conn->query("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả bài viết đã publish
    public function getAllPublishedPosts()
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            WHERE p.status = 'published'
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bài viết theo category_id (mới, dùng cho controller)
    public function getByCategory($categoryId)
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            WHERE p.category_id = ? AND p.status = 'published'
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bài viết theo id
    public function find($id)
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    // Thêm bài viết
    public function create()
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (title, content, author, image, status, category_id,  created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$this->title, $this->content, $this->author, $this->image, $this->status, $this->category_id]);
    }

    // Cập nhật bài viết
    public function update()
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET title = ?, content = ?, image = ?, status = ?, category_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$this->title, $this->content, $this->image, $this->status, $this->category_id, $this->id]);
    }

    // Xóa bài viết theo id
    public function deleteById($id)
    {
        // Xóa ảnh nếu có
        $post = $this->find($id);
        if ($post && $post['image']) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
            if (file_exists($upload_dir . $post['image'])) {
                unlink($upload_dir . $post['image']);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Lấy tất cả categories
    public function getAllCategories()
    {
        $stmt = $this->conn->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Upload ảnh bài viết
    public function uploadImage($file, $id = null)
    {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/studentdiary/public/uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        $allowed_types = ['image/jpeg','image/png','image/gif','image/jpg','image/webp'];
        if (!in_array($file['type'], $allowed_types)) return false;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $ext;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Xóa ảnh cũ nếu có
            if ($id) {
                $old_post = $this->find($id);
                if ($old_post && $old_post['image'] && file_exists($upload_dir . $old_post['image'])) {
                    unlink($upload_dir . $old_post['image']);
                }
            }
            $this->image = $new_filename;
            return true;
        }
        return false;
    }
}
?>