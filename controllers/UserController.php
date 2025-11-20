<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // ======== LOGIN ============ 
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->user->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: /studentdiary/public/index.php?action=home");
                exit();
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

        $currentPage = 'login';
        require_once __DIR__ . '/../views/frontend/user_login.php';
    }

    // ======== REGISTER ============
    public function register() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');

            if ($this->user->existsUsername($username)) {
                $message = 'Tên đăng nhập đã tồn tại!';
            } elseif ($this->user->existsEmail($email)) {
                $message = 'Email đã được sử dụng!';
            } else {
                $success = $this->user->register($username, $password, $fullname, $email);
                if ($success) {
                    header("Location: /studentdiary/public/index.php?action=user_login&success=1");
                    exit();
                } else {
                    $message = 'Đăng ký thất bại!';
                }
            }
        }

        $currentPage = 'register';
        require_once __DIR__ . '/../views/frontend/register.php';
    }

    // ======== LOGOUT ============
    public function logout() {
        session_destroy();
        header("Location: /studentdiary/public/index.php?action=user_login");
        exit();
    }

    // ======== HOME ============
    public function home() {
        if (empty($_SESSION['user'])) {
            header("Location: /studentdiary/public/index.php?action=user_login");
            exit();
        }

        $currentPage = 'home';
        require_once __DIR__ . '/../views/frontend/home.php';
    }

    // ======== LIST USERS (ADMIN) ============  
public function listUsers() {
    // Xử lý toggle trạng thái user nếu có id trong URL
    if (isset($_GET['toggle_id'])) {
        $id = intval($_GET['toggle_id']);
        $this->user->toggleStatus($id);
        header("Location: index.php?action=user_list"); // quay lại trang danh sách
        exit();
    }

    $users = $this->user->getAll();
    $currentPage = 'user_list';
    require_once __DIR__ . '/../views/admin/manage_user/user_list.php';
}
}
?>