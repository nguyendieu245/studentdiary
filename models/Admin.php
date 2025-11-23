<?php
class Admin
{
    private $conn;
    private $table = "admins";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Đăng nhập admin
    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username=? AND password=? ");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}