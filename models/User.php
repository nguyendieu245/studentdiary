<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Kiểm tra username đã tồn tại chưa
    public function existsUsername($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $this->table WHERE username=?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra email đã tồn tại chưa
    public function existsEmail($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $this->table WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Đăng ký user mới
    public function register($username, $password, $fullname, $email) {
        $sql = "INSERT INTO $this->table (username, password, fullname, email, status)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $status = 1; // mặc định active
        return $stmt->execute([$username, $password, $fullname, $email, $status]);
    }

    // Đăng nhập
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username=? AND password=?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin user theo ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách tất cả người dùng
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM $this->table ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Admin thay đổi trạng thái user (0 = inactive, 1 = active)
    public function changeStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET status=? WHERE id=?");
        return $stmt->execute([$status, $id]);
    }
}
