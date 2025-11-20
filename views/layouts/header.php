<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Định nghĩa BASE_URL để dễ quản lý các liên kết Controller
$BASE_URL_ACTION = "/studentdiary/public/index.php?action=";
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
        <a href="/studentdiary/views/frontend/home.php">Trang chủ</a>
        <a href="/studentdiary/views/frontend/post_frontend/skill.php">Kỹ năng</a>
        <a href="/studentdiary/views/frontend/post_frontend/social.php">Đời sống</a>
        <a href="/studentdiary/views/frontend/post_frontend/study.php">Học tập</a>
        <a href=>Danh mục khác</>
        </div>
        <div class="header-auth-links">
            <?php 
            // SỬA LỖI LẤY SESSION: Controller đặt session là $_SESSION['user']
            if (!empty($_SESSION['user'])): 
                // Lấy tên người dùng (ưu tiên fullname, sau đó username)
                $display_name = $_SESSION['user']['fullname'] ?? $_SESSION['user']['username'] ?? 'Bạn';
            ?>
                <span class="welcome-message">Xin chào, <strong><?php echo htmlspecialchars($display_name); ?></strong>!</span>
                <a href="<?php echo $BASE_URL_ACTION; ?>user_logout" class="auth-link logout-btn">Đăng xuất</a>
                
            <?php else: ?>
                <a href="<?php echo $BASE_URL_ACTION; ?>user_login" class="auth-link login-btn">Đăng nhập</a>
                <a href="<?php echo $BASE_URL_ACTION; ?>register" class="auth-link register-btn">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>