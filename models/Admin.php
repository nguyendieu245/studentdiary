<?php
class Admin
{
    private $conn;
    private $table = "admins";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy thông tin admin duy nhất
    public function getAdmin()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng nhập admin
    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username=? AND password=? LIMIT 1");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin admin
    public function updateProfile($fullname)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET fullname=? WHERE id=1");
        return $stmt->execute([$fullname]);
    }

    // Cập nhật mật khẩu
    public function updatePassword($newPassword)
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET password=? WHERE id=1");
        return $stmt->execute([$newPassword]);
    }
}
