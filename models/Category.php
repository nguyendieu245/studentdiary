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

    /*Lấy tất cả danh mục*/
    public function all()
    {
        $sql = "
            SELECT c.*, COUNT(p.id) AS post_count
            FROM {$this->table} c
            LEFT JOIN posts p ON c.id = p.category_id
            GROUP BY c.id
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}