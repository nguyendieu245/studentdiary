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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f0;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px 30px;
            min-height: 100vh;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: #8B7355;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 24px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #6B5442;
            transform: translateX(-4px);
        }

        .back-btn i {
            margin-right: 8px;
        }

        .comment-container {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            max-width: 900px;
        }

        h1 {
            font-size: 28px;
            color: #2c2c2c;
            margin-bottom: 24px;
        }

        .comment-info {
            background: #f8f9fa;
            border-left: 4px solid #8B7355;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .info-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #2c2c2c;
            width: 150px;
        }

        .info-value {
            color: #666;
            flex: 1;
        }

        .comment-text {
            background: #fff;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 32px;
            line-height: 1.8;
            color: #444;
        }

        .reply-section {
            border-top: 2px solid #f0f0f0;
            padding-top: 24px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #8B7355;
        }

        textarea {
            width: 100%;
            min-height: 150px;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            resize: vertical;
            transition: all 0.3s;
        }

        textarea:focus {
            outline: none;
            border-color: #8B7355;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #8B7355;
            color: white;
        }

        .btn-primary:hover {
            background: #6B5442;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background: #D4EDDA;
            color: #155724;
        }

        .status-hidden {
            background: #F8D7DA;
            color: #721C24;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .alert-success {
            background: #D4EDDA;
            color: #155724;
            border-left: 4px solid #28A745;
        }

        .alert i {
            margin-right: 10px;
        }
    </style>
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
    <script src="/studentdiary/public/java/comment.js"></script>
</body>
</html>