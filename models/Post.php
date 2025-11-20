<?php
// models/Post.php

class Post
{
    private $conn;
    private $table = "posts";

    public $id;
    public $title;
    public $content;
    public $author; // Sửa từ author_id thành author để khớp với cột DB
    public $author_name; // Biến tạm để chứa tên tác giả khi join
    public $image;
    public $status;
    public $category_id;
    public $views; // Thêm trường views (lượt xem)
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả bài viết 
    public function all()
    {
        // SỬA: Dùng p.author
        $stmt = $this->conn->query("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id 
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getAllPublishedPosts() {
        // Chỉ lấy những bài viết có status là 'published'
        // SỬA: Dùng p.author
        $query = "SELECT p.*, c.name as category_name, u.username AS author_name
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN users u ON p.author = u.id
                  WHERE p.status = 'published'
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả bài viết kĩ năng (category_id = 1)
    public function getAllSkillPosts()
    {
        // SỬA: Dùng p.author
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name, u.username AS author_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            WHERE p.category_id = 1
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    // TÌM 1 BÀI VIẾT THEO ID (Đổi tên từ getById thành find)
    public function find($id) 
    {
        // SỬA: Dùng p.author và thêm JOIN để lấy tên tác giả
        $stmt = $this->conn->prepare("
            SELECT 
                p.*, 
                c.name AS category_name, 
                u.username AS author_name 
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN users u ON p.author = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // HÀM MỚI: Lấy bài viết theo category_id (cần cho PostController->category)
    public function getByCategory($categoryId) {
        $query = "SELECT p.*, c.name AS category_name, u.username AS author_name
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN users u ON p.author = u.id
                  WHERE p.category_id = ? AND p.status = 'published'
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$categoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // HÀM MỚI: Tăng số lượt xem (views) của bài viết
    public function incrementViews($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET views = COALESCE(views, 0) + 1 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    // Thêm bài viết
    public function create()
    {
        // THÊM: Cột 'views' và sửa 'author'
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (title, content, author, image, status, category_id, views, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 0, NOW())
        ");
        return $stmt->execute([$this->title, $this->content, $this->author, $this->image, $this->status, $this->category_id]);
    }

    // Cập nhật bài viết
    public function update()
    {
        // THÊM: Cột 'views'
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET title=?, content=?, image=?, status=?, category_id=?, views=?
            WHERE id=?
        ");
        return $stmt->execute([$this->title, $this->content, $this->image, $this->status, $this->category_id, $this->views, $this->id]);
    }

    // Xóa bài viết
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}