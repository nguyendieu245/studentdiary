<?php
// models/Category.php

class Category
{
    private $conn;
    private $table = "categories";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy tất cả các danh mục trong cơ sở dữ liệu (Dùng cho PostController::showHomeFeed)
     * @return array Danh sách các danh mục dưới dạng mảng kết hợp
     */
    public function getAllCategories()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 danh mục theo id
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function create($name, $slug)
    {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, slug) VALUES (?, ?)");
        return $stmt->execute([$name, $slug]);
    }

    // Cập nhật danh mục
    public function update($id, $name, $slug)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=?, slug=? WHERE id=?");
        return $stmt->execute([$name, $slug, $id]);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}