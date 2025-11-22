<?php
// FILE: views/frontend/layouts/header.php (Giữ nguyên cấu trúc DIV)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Lấy action hiện tại từ URL để đánh dấu menu active
$action = $_GET['action'] ?? 'home_front'; 

// 2. Định nghĩa các liên kết (Sử dụng URL Action-based của bạn)
$menuLinks = [
    ['page' => 'home_front', 'label' => 'Trang chủ', 'url' => '/studentdiary/public/index.php?action=home_front'], 
    ['page' => 'skill', 'label' => 'Kỹ năng', 'url' => '/studentdiary/public/index.php?action=skill'], 
    ['page' => 'social', 'label' => 'Đời sống', 'url' => '/studentdiary/public/index.php?action=social'], 
    ['page' => 'study', 'label' => 'Học tập', 'url' => '/studentdiary/public/index.php?action=study'], 
    ['page' => 'categories', 'label' => 'Danh mục khác', 'url' => '/studentdiary/public/index.php?action=categories'],
];

// 3. Thiết lập $currentPage và hàm isActiveMenu
$currentPage = isset($currentPage) ? $currentPage : $action;

if (!function_exists('isActiveMenu')) {
    function isActiveMenu($page, $currentPage) {
        return $page === $currentPage ? 'active' : '';
    }
}

// 4. Xác định user (Sử dụng biến $user/$_SESSION cũ của bạn)
$user = $_SESSION['user'] ?? null;
$display_name = $user['fullname'] ?? $user['username'] ?? 'Bạn'; 
$is_logged_in = isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] === true; // Sử dụng biến đăng nhập mới

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Diary - Nhật ký học tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/studentdiary/public/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <div class="header-banner"></div>

    <div class="header-menu-bar">
        
        <div class="header-menu-links">
            <?php foreach ($menuLinks as $link): ?>
                <a href="<?= $link['url'] ?>" class="<?= isActiveMenu($link['page'], $currentPage) ?>">
                    <?= $link['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>

            <div class="header-auth-links">
                <?php if ($user): ?> 
                    <span class="welcome-message">
                        Xin chào, <?php echo htmlspecialchars($display_name); ?>!
                    </span>
                    <a href="/studentdiary/public/index.php?action=user_logout" class="auth-link">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="/studentdiary/public/index.php?action=user_login" class="auth-link">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                    <a href="/studentdiary/public/index.php?action=register" class="auth-link">
                        <i class="fas fa-user-plus"></i> Đăng ký
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>