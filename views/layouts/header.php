
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy tên đăng nhập từ Session['user']['username'] (giả sử $user là 1 mảng/object)
// Kiểm tra xem $_SESSION['user'] có tồn tại và thuộc tính 'username' có tồn tại không.
$action = $action ?? '';

// SỬA DÒNG NÀY:

$username = $_SESSION['user']['username'] ?? ''; // Nếu $user là một mảng
// HOẶC:
// $username = $_SESSION['user']->username ?? ''; // Nếu $user là một đối tượng

// Giả sử $user là mảng (Array)
$username = $_SESSION['user']['username'] ?? '';

?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Student Diary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/studentdiary/public/css/style.css">
</head>
<body>
    <div class="header-banner"></div>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php?action=index">Trang chủ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu trái -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($action=='posts_skill') ? 'active' : '' ?>" href="/studentdiary/public/index.php?action=posts_skill">Kỹ năng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($action=='posts_life') ? 'active' : '' ?>" href="/studentdiary/public/index.php?action=posts_life">Đời sống</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($action=='posts_study') ? 'active' : '' ?>" href="/studentdiary/public/index.php?action=posts_study">Học tập</a>
                </li>
            </ul>

            <!-- Menu phải (user) -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if(!empty($username)): ?>
                    <li class="nav-item">
                        <span class="nav-link">Xin chào, <?= htmlspecialchars($username) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=user_logout">Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($action=='user_login') ? 'active' : '' ?>" href="index.php?action=user_login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($action=='register') ? 'active' : '' ?>" href="index.php?action=register">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
