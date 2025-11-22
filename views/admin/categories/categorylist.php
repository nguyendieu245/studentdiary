
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
    <link rel="stylesheet" href="/studentdiary/public/css/category.css">
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    
        <div class="main-content">
        <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại trang chính
        </a>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                    if($_GET['success'] == 'deleted') echo 'Xóa danh mục thành công!';
                    elseif($_GET['success'] == 'updated') echo 'Cập nhật danh mục thành công!';
                    elseif($_GET['success'] == 'created') echo 'Thêm danh mục thành công!';
                    else echo 'Thao tác thành công!';
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php 
                    if($_GET['error'] == 'has_posts') echo 'Không thể xóa danh mục này vì còn bài viết!';
                    else echo 'Có lỗi xảy ra. Vui lòng thử lại!';
                ?>
            </div>
        <?php endif; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
           
            <a href="index.php?action=create_category" class="add-btn">
                <i class="fas fa-plus"></i> Thêm danh mục
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="stt-col">ID</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Số bài viết</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="7">
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
                                <?= $category['updated_at'] ? date('d/m/Y H:i', strtotime($category['updated_at'])) : '-' ?>
                            </td>
                            <td>
                                <span class="post-count-badge">
                                    <?= $category['post_count'] ?> bài viết
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?action=edit_category&id=<?= $category['id'] ?>">
                                        <button class="btn-icon btn-edit" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <button class="btn-icon btn-delete" 
                                            onclick="confirmDelete(<?= $category['id'] ?>, <?= $category['post_count'] ?>)" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id, postCount) {
            if(postCount > 0) {
                alert('Không thể xóa danh mục này vì còn ' + postCount + ' bài viết!');
                return;
            }
            if(confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                window.location.href = 'index.php?action=delete_category&id=' + id;
            }
        }
    </script>
    <script src="/studentdiary/public/js/category.js"></script>
</body>
</html>