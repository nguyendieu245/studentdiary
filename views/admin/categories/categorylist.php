<?php
if (empty($_SESSION['admin'])) {
    header("Location: /studentdiary/public/index.php?action=admin_login");
    exit;
}

$admin = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/category.css">
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại trang chính
        </a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="stt-col">ID</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Ngày tạo</th>
                        <th>Số bài viết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    <p>Chưa có danh mục nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($categories as $category): ?>
                        <tr>
                            <td class="stt-col"><?= $category['id'] ?></td>
                            <td>
                                <div class="category-name">
                                    <?= htmlspecialchars($category['name']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="slug-text">
                                    <?= htmlspecialchars($category['slug']) ?>
                                </span>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($category['created_at'])) ?>
                            </td>
                            <td>
                                <span class="post-count-badge">
                                    <?= $category['post_count'] ?> bài viết
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Đã chuyển tất cả JavaScript sang file category.js -->
    <script src="/studentdiary/public/js/category.js"></script>
</body>
</html>