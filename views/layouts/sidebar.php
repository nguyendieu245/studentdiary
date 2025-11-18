<?php
$currentAction = $currentAction ?? ($_GET['action'] ?? 'admin_dashboard');

function isActive($expectedAction, $currentAction) {
    if (strpos($currentAction, $expectedAction) === 0) {
        return 'active';
    }
    if ($expectedAction === 'admin_dashboard' && $currentAction === 'admin_dashboard') {
         return 'active';
    }
    return '';
}
?>

<div class="sidebar">
    <div class="logo-text">STUDENT DIARY ADMIN</div>

    <a class="menu-item <?php echo isActive('admin_dashboard', $currentAction); ?>" 
       href="index.php?action=admin_dashboard">
        <div class="menu-icon"><i class="fas fa-home"></i></div>
        <div>Dashboard</div>
    </a>
    
    <a class="menu-item <?php echo isActive('kynang', $currentAction); ?>" 
       href="index.php?action=kynang">
        <div class="menu-icon"><i class="fas fa-lightbulb"></i></div>
        <div>Quản lý bài viết Kỹ năng</div>
    </a>
    
    <a class="menu-item <?php echo isActive('hoctap', $currentAction); ?>" 
       href="index.php?action=hoctap">
        <div class="menu-icon"><i class="fas fa-book"></i></div>
        <div>Quản lý bài viết Học tập</div>
    </a>
    
    <a class="menu-item <?php echo isActive('doisong', $currentAction); ?>" 
       href="index.php?action=doisong">
        <div class="menu-icon"><i class="fas fa-heartbeat"></i></div>
        <div>Quản lý bài viết Đời sống</div>
    </a>
    
    <a class="menu-item <?php echo isActive('comments', $currentAction); ?>" 
       href="index.php?action=comments">
        <div class="menu-icon"><i class="fas fa-comments"></i></div>
        <div>Quản lý bình luận</div>
    </a>
    
    <a class="menu-item" href="index.php?action=admin_logout">
        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
        <div>Đăng xuất</div>
    </a>
</div>