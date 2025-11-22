
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

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: #8B7355;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #6B5442;
            transform: translateX(-4px);
        }

        .back-btn i {
            margin-right: 8px;
        }

        .page-title {
            font-size: 28px;
            color: #2c2c2c;
            font-weight: 600;
        }

        .add-btn {
            padding: 12px 24px;
            background: #8B7355;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .add-btn:hover {
            background: #6B5442;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139,115,85,0.3);
        }

        .add-btn i {
            margin-right: 8px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #D4A574;
            color: white;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
            font-size: 14px;
        }

        tbody tr {
            transition: all 0.2s;
        }

        tbody tr:hover {
            background: #fffbf0;
        }

        .stt-col {
            width: 80px;
            text-align: center;
            font-weight: 600;
        }

        .category-name {
            font-weight: 500;
            color: #2c2c2c;
            font-size: 15px;
        }

        .slug-text {
            color: #666;
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .post-count-badge {
            background: #E3F2FD;
            color: #1976D2;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
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

        .alert-error {
            background: #F8D7DA;
            color: #721C24;
            border-left: 4px solid #DC3545;
        }

        .alert i {
            margin-right: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
    </style>
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
            <h1 class="page-title">Quản lý danh mục</h1>
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
</body>
</html>