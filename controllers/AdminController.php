<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $admin;

    public function __construct($db) {
        $this->admin = new Admin($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->admin->login($username, $password);
            if ($admin) {
                $_SESSION['admin'] = $admin;
                header('Location: index.php?action=dashboard');
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }
        include __DIR__ . '/../views/admin/login.php';
    }

    public function profile() {
        $admin = $this->admin->getAdmin();
        include __DIR__ . '/../views/admin/profile.php';
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $this->admin->updateProfile($fullname);
            header('Location: index.php?action=admin_profile');
            exit;
        }
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'] ?? '';
            $this->admin->updatePassword($newPassword);
            header('Location: index.php?action=admin_profile');
            exit;
        }
    }
}
