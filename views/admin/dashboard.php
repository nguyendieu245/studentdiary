<?php
$admin = $_SESSION['admin'] ?? ['fullname' => 'Quản trị viên'];
?>


<link rel="stylesheet" href="assets/css/dashboard.css">

<?php include __DIR__ . '/../layouts/sidebar.php'; ?>

<!-- 3️⃣ Nội dung chính Dashboard -->
<div class="dashboard-wrapper" style ="
    padding: 20px 25px;
    font-family: Poppins, sans-serif;
    margin-left: 260px; /* Dành chỗ cho sidebar */
}
"> 
    <?php
        $welcomeName = htmlspecialchars($admin['fullname'] ?? 'Quản trị viên');
        echo '<h2 class="dashboard-title">Chào mừng ' . $welcomeName . ' đến với trang quản trị Student Diary!</h2>';
        echo '<p class="dashboard-subtitle">Đây là bảng điều khiển dành cho quản trị viên.</p>';
    ?>

    <div class="dashboard-center">
        <img src="anhdep/hinh-nen-bau-troi-thump.jpg" alt="Welcome" class="dashboard-image">
        <p class="dashboard-description">
            Hệ thống Student Diary giúp quản lý bài viết theo từng lĩnh vực: kỹ năng, học tập, đời sống.
            Bạn có thể duyệt bài, quản lý bình luận và hỗ trợ tương tác nhanh chóng.
        </p>
    </div>
<<<<<<< HEAD
</div>
=======
</div>


>>>>>>> 2648973 (sua)
