<?php
// controllers/auth/LogoutController.php

// 1. Đảm bảo session đã được bắt đầu (thường đã có trong index.php/header.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Hủy tất cả các biến session đã đăng ký
$_SESSION = array();

// 3. Hủy session (nếu phiên trình duyệt hiện tại có cookie)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Hủy session
session_destroy();

// 5. Chuyển hướng người dùng về trang chủ hoặc trang đăng nhập
header("Location: index.php?action=home"); // Chuyển về trang chủ
exit;
?>