<?php 
// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu chưa đăng nhập thì chuyển về trang login
if (!isset($_SESSION['user'])) {
    header("Location: /studentdiary/public/index.php?action=user_login");
    exit;
}
 include __DIR__ . '/../layouts/header.php'; 
 
// Lấy tên người dùng
$username = $_SESSION['user']['username'] ?? 'Người dùng';
?>

<div class="introduce-wrapper">
    <h1>Student Diary – Hành trình chia sẻ kiến thức & kỹ năng dành cho sinh viên đại học</h1>

    <p><i>Xin chào, <?= htmlspecialchars($username) ?>! Chào mừng trở lại Student Diary.</i></p>

    <p>Bạn đang đọc những dòng này có thể là một bạn sinh viên mới bước chân vào giảng đường, hoặc đang tìm kiếm những mẹo học tập, kỹ năng để không bị “đuối” giữa núi bài vở...</p>

    <h2>1. Student Diary là gì?</h2>
    <p>Student Diary không phải một blog cá nhân bình thường kể chuyện cuộc sống, cũng không phải một trang “hàn lâm”, mà là một website chia sẻ kiến thức, kỹ năng và kinh nghiệm học tập từ trải nghiệm sinh viên.</p>

    <p>Mục đích của Student Diary rất đơn giản nhưng cũng rất lớn lao: giúp sinh viên tiếp cận kiến thức & kỹ năng thực tế.</p>

    <h2>2. Vì sao lại là Student Diary?</h2>
    <p>Chính mình cũng từng là sinh viên năm nhất “ngơ ngác”...</p>

    <h2>3. Student Diary chia sẻ gì?</h2>
    <h3>🌱 Kỹ năng mềm – Chìa khóa để sinh viên “tỏa sáng”</h3>
    <ul>
        <li>Quản lý thời gian hợp lý, không bị “ôm deadline”.</li>
        <li>Kỹ năng giao tiếp, thuyết trình.</li>
        <li>Viết email chuyên nghiệp.</li>
        <li>Làm việc nhóm hiệu quả.</li>
    </ul>

    <h3>📘 Phương pháp học tập</h3>
    <ul>
        <li>Chia nhỏ bài, ôn tập đúng cách, mindmap.</li>
        <li>Mẹo làm bài luận, bài tập lớn.</li>
        <li>Học online thông minh.</li>
    </ul>

    <h3>🍃 Cuộc sống & tinh thần sinh viên</h3>
    <ul>
        <li>Tự lập khi xa nhà, cân bằng học – chơi.</li>
        <li>Vượt qua áp lực & stress.</li>
        <li>Câu chuyện đời sinh viên.</li>
    </ul>

    <h2>4. Ai sẽ thấy Student Diary hữu ích?</h2>
    <ul>
        <li>Sinh viên năm nhất bỡ ngỡ.</li>
        <li>Sinh viên năm 2 – 3 muốn nâng cao kỹ năng.</li>
        <li>Những ai cần bài học thực tế, dễ hiểu.</li>
    </ul>

    <h2>5. Student Diary khác biệt</h2>
    <ul>
        <li>Ngôn ngữ gần gũi, vui vẻ.</li>
        <li>Cập nhật thường xuyên.</li>
        <li>Truyền cảm hứng mạnh mẽ.</li>
    </ul>

    <h2>6. Một vài lời nhắn nhủ chân thành</h2>
    <p>Hành trình đại học giống như một chuyến phiêu lưu...</p>
    <p>Mình hy vọng từng dòng chữ sẽ giúp bạn nhẹ nhàng & ý nghĩa hơn.</p>
    <p><i>Cảm ơn bạn đã đồng hành cùng Student Diary 💖</i></p>
</div>

<?php 
// Include footer chung
include __DIR__ . '/../layouts/footer.php'; 
?>
