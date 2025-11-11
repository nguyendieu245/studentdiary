<?php
class Post
{
    private $conn;
    private $table = "posts";

    public function __construct($db)
    {
        $this->conn = $db;
    }

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

    public function find($id)
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name 
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id=?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $content, $author, $image, $status, $category_id)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (title, content, author, image, status, category_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$title, $content, $author, $image, $status, $category_id]);
    }

    public function update($id, $title, $content, $image, $status, $category_id)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table} 
            SET title=?, content=?, image=?, status=?, category_id=? 
            WHERE id=?
        ");
        return $stmt->execute([$title, $content, $image, $status, $category_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
