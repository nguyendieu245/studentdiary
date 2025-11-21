<?php
// models/User.php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    // LƯU Ý QUAN TRỌNG: Mật khẩu được lưu trữ dưới dạng plaintext (không được khuyến nghị về bảo mật).
    public $password; 
    public $full_name; 
    public $email;
    public $created_at;

    // Sửa constructor để chấp nhận kết nối DB (Dependency Injection)
    public function __construct($db) {
        $this->conn = $db;
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

    // Đăng ký user mới (SỬA: KHÔNG HASH MẬT KHẨU, loại bỏ cột 'status', 'role')
    public function register($username, $password, $fullname, $email) {
        
        // **LƯU Ý:** $password được sử dụng trực tiếp, KHÔNG HASH.
        
        // Sửa truy vấn: Chỉ giữ lại các trường cơ bản và created_at
        // Giả định các cột 'username', 'password', 'fullname', 'email', 'created_at' là bắt buộc.
        $sql = "INSERT INTO $this->table (username, password, fullname, email, created_at)
                VALUES (?, ?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        
        // Truyền mật khẩu plaintext vào thực thi
        return $stmt->execute([$username, $password, $fullname, $email]); 
    }

    // Tìm người dùng theo tên đăng nhập (Dùng cho login)
    public function findUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username=?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Đăng nhập (SỬA: KHÔNG DÙNG password_verify, khớp mật khẩu plaintext)
    public function login($username, $password) {
        // 1. Lấy thông tin người dùng từ DB 
        $user = $this->findUserByUsername($username);
        
        // 2. Kiểm tra người dùng tồn tại và khớp mật khẩu plaintext
        // CẢNH BÁO BẢO MẬT: So sánh mật khẩu plaintext (==) là RẤT NGUY HIỂM.
        if ($user && $password === $user['password']) {
             // Giả định nếu cột 'status' không tồn tại, thì người dùng luôn active (1)
            if (!isset($user['status']) || $user['status'] == 1) { 
                return $user;
            } else {
                return false; 
            }
        }
        return false;
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
    // PHƯƠNG THỨC NÀY CHỈ HOẠT ĐỘNG NẾU CÓ CỘT 'status' TRONG DB.
    public function changeStatus($id, $status) {
        // Lưu ý: Nếu cột 'status' không tồn tại, hàm này sẽ gây lỗi SQL. 
        $stmt = $this->conn->prepare("UPDATE $this->table SET status=? WHERE id=?");
        return $stmt->execute([$status, $id]);
    }
}
