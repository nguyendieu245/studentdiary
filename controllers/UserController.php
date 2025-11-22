<?php
// controllers/UserController.php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = $db;
        $this->user = new User($db);
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
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

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

            if ($this->user->existsUsername($username)) {
                $message = 'Tên đăng nhập đã tồn tại!';
            } elseif ($this->user->existsEmail($email)) {
                $message = 'Email đã được sử dụng!';
            } else {
                $success = $this->user->register($username, $password, $fullname, $email);
                if ($success) {
                    header("Location: /studentdiary/public/index.php?action=user_login");
                    exit(); 
                } else {
                    $message = 'Đăng ký thất bại!';
                }
            }
        }

        include __DIR__ . '/../views/frontend/register.php';
    }

    // ======== LOGOUT ============
    public function logout() {
        session_destroy();
        header("Location: /studentdiary/public/index.php?action=user_login");
        exit;
    }

    // ======== HOME ============
    public function home() {
        if (empty($_SESSION['user'])) {
            header("Location: /studentdiary/public/index.php?action=user_login");
            exit;
        }
        include __DIR__ . '/../views/frontend/home.php';
    }

    // ======== LIST USERS (ADMIN) ============
    public function listUsers() {
        // Xử lý toggle status
        if (isset($_GET['toggle_id'])) {
            $id = intval($_GET['toggle_id']);
            $currentUser = $this->user->getById($id);
            
            if ($currentUser) {
                // Đảo ngược status: 1 -> 0, 0 -> 1
                $newStatus = ($currentUser['status'] ?? 0) == 1 ? 0 : 1;
                $this->user->changeStatus($id, $newStatus);
                
                // Redirect để tránh submit lại form
                header('Location: index.php?action=user_list&success=status_updated');
                exit();
            }
        }

        $users = $this->user->getAll();
        $currentPage = 'users';
        include __DIR__ . '/../views/admin/manage_user/user_list.php';
    }

    // ======== INDEX (ADMIN) ============
    public function index() {
        $this->listUsers();
    }
} 
?>