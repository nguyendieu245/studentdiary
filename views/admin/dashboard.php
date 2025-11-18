<?php
$admin = $_SESSION['admin'] ?? ['fullname' => 'Quản trị viên'];
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
// Sử dụng thông tin admin để chào mừng
$welcomeName = htmlspecialchars($admin['fullname'] ?? 'Quản trị viên');

echo '<h2 style="
    text-align: center;
    margin-top: 30px;
    font-family: Poppins, sans-serif;
    font-size: 2.0rem;
    color: #4e342e;
    text-shadow: 1px 2px 5px #e0cfc2;
    letter-spacing: 1px;
    font-weight: 700;
">Chào mừng bạn, ' . $welcomeName . ' đến với trang quản trị Student Diary!</h2>'; // Đã thêm $welcomeName

echo '<p style="
    text-align: center;
    font-family: Poppins, sans-serif;
    font-size: 1.2rem;
    color: #6d4c41;
    margin-top: 10px;
    font-style: italic;
    text-shadow: 1px 1px 3px #e0cfc2;
">Đây là bảng điều khiển dành cho quản trị viên.</p>';
?>

<div style="text-align: center; margin-top: 30px;">
    <img src="anhdep/hinh-nen-bau-troi-thump.jpg" alt="Welcome" 
         style="max-width: 800px; width: auto; height: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); display: inline-block;">
    <p style="
        margin: 15px auto 40px auto; 
        font-size: 1rem; 
        color: #444; 
        max-width: 700px; 
        text-align: center;
        font-family: Poppins, sans-serif;
        line-height: 1.6;
    ">
        Hệ thống Student Diary giúp quản lý bài viết theo từng lĩnh vực: kỹ năng, học tập, đời sống. 
        Bạn có thể duyệt bài, quản lý bình luận và hỗ trợ tương tác nhanh chóng.
    </p>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    
</div>

