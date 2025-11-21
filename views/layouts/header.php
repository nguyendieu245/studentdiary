<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Student Diary</title>
    <link rel="stylesheet" href="/studentdiary/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="header-banner"></div>

    <div class="header-menu-bar">
        <div class="header-menu-links">
            <a href="/studentdiary/public/index.php?action=home">Trang chủ</a>
            <a href="/studentdiary/public/index.php?action=posts&page=kynang">Kỹ năng</a>
            <a href="/studentdiary/public/index.php?action=posts&page=doisong">Đời sống</a>
            <a href="/studentdiary/public/index.php?action=posts&page=hoctap">Học tập</a>
            <a href="/studentdiary/public/index.php?action=categories">Danh mục khác</a>
        </div>

        <div class="header-auth-links">
            <?php 
            if (!empty($_SESSION['user'])): 
                $display_name = $_SESSION['user']['fullname'] ?? $_SESSION['user']['username'] ?? 'Bạn';
            ?>
                <span class="welcome-message">Xin chào, <strong><?= htmlspecialchars($display_name) ?></strong>!</span>
                <a href="/studentdiary/public/index.php?action=user_logout" class="auth-link logout-btn">Đăng xuất</a>
            <?php else: ?>
                <a href="/studentdiary/public/index.php?action=user_login" class="auth-link login-btn">Đăng nhập</a>
                <a href="/studentdiary/public/index.php?action=register" class="auth-link register-btn">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
