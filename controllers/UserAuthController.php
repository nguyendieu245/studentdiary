<?php
// Đảm bảo đường dẫn require_once chính xác
require_once __DIR__ . '/../models/User.php';

class UserAuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);

        // Bắt đầu session nếu chưa được bắt đầu
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Đăng nhập User
    public function login()
    {
        // Khởi tạo biến $error trước khi xử lý POST
        // Điều này đảm bảo biến luôn tồn tại khi View được include, tránh lỗi "Undefined variable"
        $error = ''; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Gọi phương thức login từ Model
            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Đăng nhập thành công: Lưu thông tin User vào Session
                $_SESSION['user'] = $user;
                header('Location: index.php?action=home');
                exit;
            } else {
                // Đăng nhập thất bại: Gán thông báo lỗi cho biến $error
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }
        
        // Include View file. Biến $error (có thể rỗng hoặc chứa lỗi) sẽ được truyền sang View.
        include __DIR__ . '/../views/frontend/user_login.php';
    }

    // Đăng ký User
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Xử lý logic đăng ký: 
            $this->userModel->create($fullname, $email, $username, $password);

            // Chuyển hướng về trang đăng nhập sau khi đăng ký thành công
            header("Location: index.php?action=user_login");
            exit;
        }

        // Hiển thị form đăng ký
        include __DIR__ . '/../views/frontend/register.php';
    }

    // Đăng xuất User
    public function logout()
    {
        // Xóa thông tin user trong session
        unset($_SESSION['user']);
        
        // Hủy toàn bộ session
        session_destroy();

        // Chuyển hướng về trang chủ
        header("Location: index.php?action=home");
        exit;
    }
}