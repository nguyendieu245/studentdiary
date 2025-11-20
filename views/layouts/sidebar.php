 <?php
// Kiểm tra biến $currentPage để làm active menu
if (!isset($currentPage)) {
    $currentPage = '';
}

function isActive($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>

<link rel="stylesheet" href="/studentdiary/public/css/sidebar.css">

<div class="sidebar">
    <div class="logo-text">STUDENT DIARY ADMIN</div>
<?php

?>

    <div class="menu-item <?php echo isActive('hoctap', $currentPage); ?>" 
         onclick="navigateTo('/studentdiary/public/index.php?action=hoctap')">
        <div class="menu-icon"><i class="fas fa-book"></i></div>
        <div>Quản lý bài viết</div>
    </div>

    <div class="menu-item <?php echo isActive('doisong', $currentPage); ?>" 
         onclick="navigateTo('/studentdiary/public/index.php??action=doisong')">
        <div class="menu-icon"><i class="fas fa-heartbeat"></i></div>
        <div>Quản lý danh mục</div>
    </div>

    <div class="menu-item <?php echo isActive('user_list', $currentPage); ?>" 
         onclick="navigateTo('/studentdiary/public/index.php?action=user_list')">
        <div class="menu-icon"><i class="fas fa-users"></i></div>
        <div>Quản lý người dùng</div>
    </div>

    <div class="menu-item <?php echo isActive('comments', $currentPage); ?>" 
         onclick="navigateTo('/studentdiary/public/index.php?page=comments')">
        <div class="menu-icon"><i class="fas fa-comments"></i></div>
        <div>Quản lý bình luận</div>
    </div>

    <div class="menu-item" onclick="handleLogout()">
        
        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
        <div>Đăng xuất</div>
    </div>
</div>

</div> 

<script> 
function navigateTo(url) { window.location.href = url; } 
function handleLogout() { if (confirm('Bạn có chắc chắn muốn đăng xuất không?'))
     { window.location.href = "/studentdiary/views/admin/logout.php"; } }
 </script>