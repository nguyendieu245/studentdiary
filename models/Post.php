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
    public function all()
    {
        $stmt = $this->conn->query("
            SELECT p.*, c.name AS category_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả bài viết kĩ năng (category_id = 1)
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
        return $stmt; // trả về statement giống cách controller dùng
    }

    // Tìm 1 bài viết theo id
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

    // Xóa bài viết
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}
