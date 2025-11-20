<?php
// views/admin/posts/view.php
function isActive($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include __DIR__ . '/../../layouts/header.php'; ?>
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
            margin-left: 0px;
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

        .post-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            max-width: 900px;
        }

        .post-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }

        .post-title {
            font-size: 32px;
            color: #2c2c2c;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .post-meta {
            display: flex;
            gap: 24px;
            align-items: center;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .meta-item i {
            color: #8B7355;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-published {
            background: #D4EDDA;
            color: #155724;
        }

        .status-draft {
            background: #FFF3CD;
            color: #856404;
        }

        .post-image-wrapper {
            margin-bottom: 32px;
        }

        .post-image-large {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .post-content-section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 18px;
            color: #2c2c2c;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #8B7355;
        }

        .content-box {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            color: #444;
            font-size: 15px;
            line-height: 1.8;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 2px solid #f0f0f0;
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

        .btn-edit {
            background: #FFF3E0;
            color: #F57C00;
        }

        .btn-edit:hover {
            background: #F57C00;
            color: white;
        }

        .btn-delete {
            background: #FFEBEE;
            color: #C62828;
        }

        .btn-delete:hover {
            background: #C62828;
            color: white;
        }

        .no-image {
            background: #f8f9fa;
            border: 2px dashed #d0d0d0;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            color: #999;
        }

        .no-image i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <a href="index.php?action=hoctap" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>

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

    <script>
        function confirmDelete(id) {
            if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                window.location.href = 'index.php?action=delete_post&id=' + id;
            }
        }
    </script>
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>
</body>
</html>