<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xác định menu chính
$menuLinks = [
    ['page' => 'home_front', 'label' => 'Trang chủ', 'url' => '/studentdiary/public/index.php?action=home'],
    ['page' => 'skill', 'label' => 'Kỹ năng', 'url' => '/studentdiary/public/index.php?action=skill'],  // <-- sửa action
    ['page' => 'social', 'label' => 'Đời sống', 'url' => '/studentdiary/public/index.php?action=social'],
    ['page' => 'student', 'label' => 'Học tập', 'url' => '/studentdiary/public/index.php?action=study'],
    ['page' => 'other', 'label' => 'Danh mục khác', 'url' => '/studentdiary/public/index.php?action=categories'],
];

// Biến $currentPage cần được controller frontend set trước khi include header
if (!isset($currentPage)) {
    $currentPage = '';
}

// Hàm check active menu
if (!function_exists('isActiveMenu')) {
    function isActiveMenu($page, $currentPage) {
        return $page === $currentPage ? 'active' : '';
    }
}

// Xác định user
$user = $_SESSION['user'] ?? null;
$display_name = $user['fullname'] ?? $user['username'] ?? 'Bạn';
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
            <?php foreach ($menuLinks as $link): ?>
                <a href="<?= $link['url'] ?>" class="<?= isActiveMenu($link['page'], $currentPage) ?>">
                    <?= $link['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="header-auth-links">
            <?php if ($user): ?>
                <span class="welcome-message">
                    Xin chào, <strong><?= htmlspecialchars($display_name) ?></strong>!
                </span>
                <a href="/studentdiary/public/index.php?action=user_logout" class="auth-link logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            <?php else: ?>
                <a href="/studentdiary/public/index.php?action=user_login" class="auth-link login-btn">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </a>
                <a href="/studentdiary/public/index.php?action=register" class="auth-link register-btn">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
