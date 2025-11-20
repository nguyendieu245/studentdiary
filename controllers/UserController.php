<?php
// controllers/UserController.php
require_once __DIR__ . '/../models/User.php';

// Đây là class UserController mà index.php đang tìm kiếm
class UserController {
    private $user;

    public function __construct($db) {
        // Khởi tạo Model User
        $this->user = new User($db);
    }

    // ======== LOGIN ============ 
    // Phương thức này không nhận tham số, nó lấy dữ liệu từ $_POST
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Gọi Model User để xử lý logic đăng nhập, truyền 2 tham số vào đây
            $user = $this->user->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                // Chuyển sang trang home
                header("Location: index.php?action=home");
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

        // Đảm bảo view tồn tại
        include __DIR__ . '/../views/frontend/user_login.php';
    }

    // ======== REGISTER ============
    public function register() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? ''; 

            if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
                 $message = 'Vui lòng điền đầy đủ thông tin!';
            } elseif ($this->user->existsUsername($username)) {
                $message = 'Tên đăng nhập đã tồn tại!';
            } elseif ($this->user->existsEmail($email)) {
                $message = 'Email đã được sử dụng!';
            } else {
                $success = $this->user->register($username, $password, $fullname, $email);
                if ($success) {
                    header("Location: index.php?action=user_login&registered=1");
                    exit(); 
                } else {
                    $message = 'Đăng ký thất bại! Lỗi hệ thống.';
                }
            }
        }

        // Đảm bảo view tồn tại
        include __DIR__ . '/../views/frontend/register.php';
    }


    // ======== LOGOUT ============
    public function logout() {
        session_destroy();
        header("Location: index.php?action=user_login");
        exit;
    }

    
    public function home() {
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=user_login");
            exit;
        }
        
        include __DIR__ . '/../views/frontend/home.php';
    }

    // ======== LIST USERS (ADMIN) ============
    public function listUsers() {
        $is_admin = isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
        if (empty($_SESSION['user']) || !$is_admin) {
            header("Location: index.php?action=user_login");
            exit;
        }

        // Xử lý thay đổi trạng thái
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && in_array($_GET['action'], ['activate', 'deactivate']) && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $status = $_GET['action'] === 'deactivate' ? 0 : 1; 
            
            $this->user->changeStatus($id, $status); 
        }

        $users = $this->user->getAll();
        // Đảm bảo view tồn tại
        include __DIR__ . '/../views/admin/manage_user/user_list.php';
    }
}