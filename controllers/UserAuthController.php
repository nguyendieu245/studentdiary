<?php
require_once __DIR__ . '/../models/User.php';

class UserAuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Đăng nhập User
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php?action=home');
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

        include __DIR__ . '/../views/frontend/login.php';
    }

    // Đăng ký User
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $this->userModel->create($fullname, $email, $username, $password);

            header("Location: index.php?action=user_login");
            exit;
        }

        include __DIR__ . '/../views/frontend/register.php';
    }

    // Đăng xuất User
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();

        header("Location: index.php?action=home");
        exit;
    }
}
