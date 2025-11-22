<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/stylepost.css">
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <div>
            <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay lại trang chính
            </a>
        </div>

        <!-- Thông báo -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if($_GET['success'] == 'deleted') echo 'Xóa bài viết thành công!';
                    elseif($_GET['success'] == 'updated') echo 'Cập nhật bài viết thành công!';
                    else echo 'Thêm bài viết thành công!';
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Có lỗi xảy ra. Vui lòng thử lại!
            </div>
        <?php endif; ?>

        <a href="index.php?action=create_post" class="add-btn">
            <i class="fas fa-plus"></i> Thêm bài viết
        </a>

        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh</th>
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
                                    <?php if($post['image']): ?>
                                        <img src="/studentdiary/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                                             alt="<?= htmlspecialchars($post['title']) ?>" 
                                             class="post-image">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/80x60?text=No+Image" 
                                             alt="No image" 
                                             class="post-image">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        switch ($post['category_id']) {
                                            case 1: echo "Kỹ năng"; break;
                                            case 2: echo "Đời sống"; break;
                                            case 3: echo "Học tập"; break;
                                            default: echo "Khác";
                                        }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($post['author']) ?></td>
                                <td><?= htmlspecialchars($post['status']) ?></td>
                                <td><?= htmlspecialchars($post['created_at']) ?></td>
                                <td>
                                    <a href="index.php?action=edit_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="index.php?action=delete_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá bài viết này?')"><i class="fas fa-trash"></i></a>
                                    <a href="index.php?action=show_post&id=<?= $post['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Chưa có bài viết nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
