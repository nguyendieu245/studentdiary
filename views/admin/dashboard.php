<?php
session_start();

if (empty($_SESSION['admin'])) {
    header("Location: /studentdiary/public/index.php?action=admin_login");
    exit;
}

$admin = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/studentdiary/public/css/dashboard.css">
</head>

<body>

<?php include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="dashboard-wrapper" style="
    padding: 25px;
    margin-left: 280px;
    font-family: Poppins, sans-serif;
">
    
    <p class="dashboard-subtitle">Chào mừng bạn đến với trang quản trị Student Diary.</p>

    <div class="dashboard-center">
        <img src="/studentdiary/public/anhdep/hinh-nen-bau-troi-thump.jpg" 
             alt="Welcome" 
             class="dashboard-image">

        <p class="dashboard-description">
            Đây là hệ thống giúp quản lý bài viết, danh mục, bình luận và người dùng.
            Vui lòng chọn chức năng ở thanh sidebar bên trái.
        </p>
    </div>
</div>

</body>
</html>
