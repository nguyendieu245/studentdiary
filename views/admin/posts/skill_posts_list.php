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
    <title>Sửa bài viết</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/styleadmin.css">  
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
        <div class="main-content">
    <div><a href="/studentdiary/public/index.php?action=baiviet" class="back-btn">
        <i class="fas fa-arrow-left"></i> Quay lại 
    
    </div>
    <div class="main-content">
        <h1>Danh sách bài viết</h1>
        <a href="index.php?action=create_post" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm bài viết</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Tác giả</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $post['id'] ?></td>
                            <td><?= htmlspecialchars($post['title']) ?></td>
                            <td>
                                <?php
                                    switch ($post['category_id']) {
                                        case 1: echo "Kỹ năng"; break;
                                        case 2: echo "Học tập"; break;
                                        case 3: echo "Đời sống"; break;
                                        default: echo "Khác";
                                    }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($post['author']) ?></td>
                            <td><?= $post['status'] ?></td>
                            <td><?= $post['created_at'] ?></td>
                            <td>
                                <a href="index.php?action=edit_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="index.php?action=delete_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá bài viết này?')"><i class="fas fa-trash"></i></a>
                                <a href="index.php?action=show_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Chưa có bài viết nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

                </div>
                
</body>
</html>
