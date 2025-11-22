<?php
if (empty($_SESSION['admin'])) {
    header("Location: /studentdiary/public/index.php?action=admin_login");
    exit;
}
$admin = $_SESSION['admin'];
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bình luận - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/stylecomment.css">
    <link rel="stylesheet" href="/studentdiary/public/css/sidebar.css">
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
   
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
    <div class="main-content">
        <a href="index.php?action=comments" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
        <?php if(isset($_GET['success']) && $_GET['success'] == 'replied'): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Phản hồi bình luận thành công!
            </div>
        <?php endif; ?>
        <div class="comment-container">
            <h1>Chi tiết bình luận</h1>
            <div class="comment-info">
                <div class="info-row">
                    <div class="info-label">Bài viết:</div>
                    <div class="info-value"><strong><?= htmlspecialchars($comment['post_title']) ?></strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Người bình luận:</div>
                    <div class="info-value">
                        <?= htmlspecialchars($comment['user_name'] ?? $comment['name']) ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ngày bình luận:</div>
                    <div class="info-value"><?= date('d/m/Y H:i:s', strtotime($comment['created_at'])) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Trạng thái:</div>
                    <div class="info-value">
                        <span class="status-badge <?= $comment['status'] == 1 ? 'status-active' : 'status-hidden' ?>">
                            <?= $comment['status'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="comment-text">
                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
            </div>
            <div class="reply-section">
                <h2 class="section-title">
                    <i class="fas fa-reply"></i>
                    Phản hồi bình luận
                </h2>
                <form action="index.php?action=reply_comment&id=<?= $comment['id'] ?>" method="POST">
                    <textarea name="reply_content" 
                              placeholder="Nhập phản hồi của bạn..." 
                              required></textarea>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Gửi phản hồi
                        </button>
                        <a href="index.php?action=comments" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Đã chuyển tất cả JavaScript sang file comment.js -->
    <script src="/studentdiary/public/java/comment.js"></script>
</body>
</html>