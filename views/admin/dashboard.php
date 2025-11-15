<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin'])) {
    header("Location: /Studentdiary/public/index.php?action=admin_login");
    exit;
}

$admin = $_SESSION['admin'];
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="dashboard-container">
    <h2>🔥 Chào mừng quản trị viên, <?= htmlspecialchars($admin['fullname'] ?? $admin['username']) ?>!</h2>

    <div class="dashboard-menu">

        <a class="menu-item" href="/Studentdiary/public/index.php?action=posts">
            📚 Quản lý bài viết
        </a>

        <a class="menu-item" href="/Studentdiary/public/index.php?action=users">
            👥 Quản lý người dùng
        </a>

        <a class="menu-item" href="/Studentdiary/public/index.php?action=categories">
            🗂️ Quản lý danh mục
        </a>

        <a class="menu-item" href="/Studentdiary/public/index.php?action=comments">
            💬 Quản lý bình luận
        </a>

        <a class="menu-item menu-logout" 
           href="/Studentdiary/public/index.php?action=admin_logout">
            🚪 Đăng xuất
        </a>

    </div>
</div>

<style>
.dashboard-container {
    max-width: 900px;
    margin: 40px auto;
    text-align: center;
}

.dashboard-menu {
    margin-top: 30px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.menu-item {
    display: block;
    padding: 15px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 18px;
    transition: 0.2s;
}

.menu-item:hover {
    background: #217dbb;
}

.menu-logout {
    background: #e74c3c;
}

.menu-logout:hover {
    background: #c0392b;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
