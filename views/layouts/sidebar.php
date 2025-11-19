<div class="sidebar">
    <div class="logo-text">STUDENT DIARY ADMIN</div>

    <div class="menu-item <?php echo isActive('kynang', $currentPage); ?>" onclick="navigateTo('index.php?page=kynang')">
        <div class="menu-icon"><i class="fas fa-lightbulb"></i></div>
        <div>Tổng quan</div>
    </div>
    <div class="menu-item <?php echo isActive('hoctap', $currentPage); ?>" onclick="navigateTo('index.php?page=hoctap')">
        <div class="menu-icon"><i class="fas fa-book"></i></div>
        <div>Quản lý bài viết</div>
    </div>
    <div class="menu-item <?php echo isActive('doisong', $currentPage); ?>" onclick="navigateTo('index.php?page=doisong')">
        <div class="menu-icon"><i class="fas fa-heartbeat"></i></div>
        <div>Quản lý danh mục</div>
    </div>
    
    <div class="menu-item <?php echo isActive('users', $currentPage); ?>" onclick="navigateTo('index.php?page=users')">
        <div class="menu-icon"><i class="fas fa-users"></i></div>
        <div>Quản lý người dùng</div>
    </div>
    
    <div class="menu-item <?php echo isActive('comments', $currentPage); ?>" onclick="navigateTo('index.php?page=comments')">
        <div class="menu-icon"><i class="fas fa-comments"></i></div>
        <div>Quản lý bình luận</div>
    </div>
    
    <div class="menu-item" onclick="handleLogout()">
        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
        <div>Đăng xuất</div>
    </div>
</div>


<script>
function navigateTo(url) {
    // Chức năng chuyển hướng trang (client-side)
    window.location.href = url;
}
function handleLogout() {
    // Chức năng xử lý đăng xuất (client-side)
    if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
        window.location.href = "/studentdiary/views/admin/logout.php";
    }
}
</script>