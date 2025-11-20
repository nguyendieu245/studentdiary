<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $admin;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->admin = new Admin($db);
    }

    // ======== LOGIN ============
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->admin->login($username, $password);

            if ($admin) {
                $_SESSION['admin'] = $admin;

                // CHUYỂN SANG DASHBOARD
                header("Location: /studentdiary/public/index.php?action=admin_dashboard");
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

        include __DIR__ . '/../views/admin/login.php';
    }

    // ======== DASHBOARD ============
    public function dashboard() {
        if (empty($_SESSION['admin'])) {
            header("Location: /studentdiary/public/index.php?action=admin_login");
            exit;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    // ======== LOGOUT ============
    public function logout() {
        session_destroy();
        header("Location: /studentdiary/public/index.php?action=admin_login");
        exit;
    
}
