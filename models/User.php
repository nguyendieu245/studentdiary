<?php
// models/User.php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $password; // plaintext (không khuyến nghị)
    public $full_name;
    public $email;
    public $status; // 0 = inactive, 1 = active
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra username đã tồn tại
    public function existsUsername($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $this->table WHERE username=?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra email đã tồn tại
    public function existsEmail($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $this->table WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Đăng ký user mới — có cột status (auto active = 1)
    public function register($username, $password, $fullname, $email) {
        $sql = "INSERT INTO $this->table (username, password, fullname, email, status, created_at)
                VALUES (?, ?, ?, ?, 1, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$username, $password, $fullname, $email]);
    }

    // Tìm user theo username
    public function findUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username=?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng nhập có kiểm tra status
    public function login($username, $password) {
        $user = $this->findUserByUsername($username);

        if ($user && $password === $user['password']) {
            if ($user['status'] == 1) {
                return $user; // active
            }
            return false; // inactive
        }
        return false;
    }

    // Lấy user theo ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả người dùng
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM $this->table ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thay đổi trạng thái user
    public function changeStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET status=? WHERE id=?");
        return $stmt->execute([$status, $id]);
    }
}