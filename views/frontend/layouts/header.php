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
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<header class="main-header">

    <!-- Banner -->
    <div class="header-banner">
        <h1>Student Diary</h1>
        <p>Chia sẻ kiến thức & kỹ năng dành cho sinh viên</p>
    </div>

    <!-- MENU NAVIGATION -->
    <nav class="header-nav">
        <ul class="nav-left">
            <li><a href="index.php?action=home">Trang chủ</a></li>

            <!-- Danh mục bài viết -->
            <li><a href="index.php?action=category&id=1">Kỹ năng</a></li>
            <li><a href="index.php?action=category&id=2">Đời sống</a></li>
            <li><a href="index.php?action=category&id=3">Học tập</a></li>
        </ul>

        <!-- SEARCH BAR -->
        <form class="search-form" method="GET" action="index.php">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Tìm kiếm bài viết...">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <!-- USER AUTH SECTION -->
        <ul class="nav-right">

            <?php if (!empty($_SESSION['user'])): ?>
                <li class="welcome-msg">
                    Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['fullname']) ?></strong>
                </li>
                <li><a href="index.php?action=user_logout">Đăng xuất</a></li>
            <?php else: ?>
                <li><a href="index.php?action=user_login">Đăng nhập</a></li>
                <li><a href="index.php?action=user_register">Đăng ký</a></li>
            <?php endif; ?>

        </ul>
    </nav>

</header>

<!-- MAIN CONTENT AREA -->
<main class="content">
