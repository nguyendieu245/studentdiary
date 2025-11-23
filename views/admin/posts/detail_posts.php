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
    <title>Chi tiết bài viết</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/stylepost.css">  
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    
        <div class="main-content">
    <div><a href="/studentdiary/public/index.php?action=baiviet" class="back-btn">
        <i class="fas fa-arrow-left"></i> Quay lại 
    </a>
    </div>
        <div class="post-container">
            <!-- Header -->
            <div class="post-header">
                <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
                
                <div class="post-meta">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span><?= htmlspecialchars($post['author']) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-folder"></i>
                        <span><?= htmlspecialchars($post['category_name'] ?? 'Kỹ năng') ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="status-badge status-<?= $post['status'] ?>">
                            <?= $post['status'] == 'published' ? 'Đã đăng' : 'Nháp' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ảnh đại diện -->
            <?php if($post['image']): ?>
            <div class="post-image-wrapper">
                <img src="/studentdiary/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                     alt="<?= htmlspecialchars($post['title']) ?>" 
                     class="post-image-large">
            </div>
            <?php else: ?>
            <div class="post-image-wrapper">
                <div class="no-image">
                    <i class="fas fa-image"></i>
                    <p>Bài viết không có ảnh đại diện</p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Nội dung -->
            <div class="post-content-section">
                <h2 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Nội dung bài viết
                </h2>
                <div class="content-box">
            <?= htmlspecialchars($post['content']) ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="index.php?action=edit_post&id=<?= $post['id'] ?>" class="btn btn-edit">
                    <i class="fas fa-edit"></i>
                    Chỉnh sửa
                </a>
                <button onclick="confirmDelete(<?= $post['id'] ?>)" class="btn btn-delete">
                    <i class="fas fa-trash"></i>
                    Xóa bài viết
                </button>
            </div>
        </div>
    </div>
</div>
    <script src="/studentdiary/public/js/post.js"></script>
</body>
</html>