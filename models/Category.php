<?php
// models/Category.php

class Category
{
    private $conn;
    private $table = "categories";

    public $id;
    public $name;
    public $slug;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ============================
    // Lấy tất cả danh mục
    // ============================
    public function all()
    {
        return $this->getAllCategories();
    }

    public function getAllCategories()
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

    // ============================
    // Lấy 1 danh mục theo ID (Controller gọi hàm này)
    // ============================
    public function getById($id)
    {
        return $this->find($id);
    }

    // ============================
    // Hàm find cơ bản
    // ============================
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // Thêm danh mục
    // ============================
    public function create($name, $slug)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (name, slug, created_at)
            VALUES (?, ?, NOW())
        ");
        return $stmt->execute([$name, $slug]);
    }

    // ============================
    // Cập nhật danh mục
    // ============================
    public function update($id, $name, $slug)
    {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET name = ?, slug = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $slug, $id]);
    }

    // ============================
    // Xóa danh mục (chỉ khi không có bài viết)
    // ============================
    public function delete($id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM posts WHERE category_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result["count"] > 0) {
            return false; // còn bài viết → không xóa
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ============================
    // Tạo slug từ tên danh mục
    // ============================
    public function createSlug($str)
    {
        $str = mb_strtolower($str, "UTF-8");

        $unicode = [
            "a" => "á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ",
            "d" => "đ",
            "e" => "é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ",
            "i" => "í|ì|ỉ|ĩ|ị",
            "o" => "ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ",
            "u" => "ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự",
            "y" => "ý|ỳ|ỷ|ỹ|ỵ",
        ];

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

        $str = preg_replace("/[^a-z0-9\s-]/", "", $str);
        $str = preg_replace("/[\s-]+/", "-", $str);
        return trim($str, "-");
    }
}
