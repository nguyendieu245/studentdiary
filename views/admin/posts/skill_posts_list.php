<?php
// views/admin/posts/skill_posts_list.php
function isActive($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết Kĩ năng - Student Diary Admin</title>
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
            display: flex;
        }

        .main-content {
            margin-left: -30px;
            flex: 1;
            padding: 20px 30px;
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
            background: #FFF8E7;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            color: #2c2c2c;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
        }

        tbody tr {
            transition: all 0.2s;
        }

        tbody tr:hover {
            background: #fffbf0;
        }

        .post-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .post-title {
            max-width: 400px;
            font-weight: 500;
            color: #2c2c2c;
            line-height: 1.4;
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

        .btn-view {
            background: #E3F2FD;
            color: #1976D2;
        }

        .btn-view:hover {
            background: #1976D2;
            color: white;
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
        <div class="header-section">
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

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
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                Có lỗi xảy ra. Vui lòng thử lại!
            </div>
        <?php endif; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 class="page-title">Quản lý bài viết </h1>
            <a href="index.php?action=create_post" class="add-btn">
                <i class="fas fa-plus"></i> Thêm bài viết
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $posts_data = $posts->fetchAll(PDO::FETCH_ASSOC);
                    if(empty($posts_data)): 
                    ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    <p>Chưa có bài viết nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($posts_data as $post): ?>
                        <tr>
                            <td>
                                <?php if($post['image']): ?>
                                    <img src="../public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                                         alt="<?= htmlspecialchars($post['title']) ?>" 
                                         class="post-image">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/80x60?text=No+Image" 
                                         alt="No image" 
                                         class="post-image">
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="post-title">
                                    <?= htmlspecialchars($post['title']) ?>
                                </div>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i:s', strtotime($post['created_at'])) ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $post['status'] ?>">
                                    <?= $post['status'] == 'published' ? 'Đã đăng' : 'Nháp' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?action=show_post&id=<?= $post['id'] ?>">
                                        <button class="btn-icon btn-view" title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="index.php?action=edit_post&id=<?= $post['id'] ?>">
                                        <button class="btn-icon btn-edit" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <button class="btn-icon btn-delete" 
                                            onclick="confirmDelete(<?= $post['id'] ?>)" 
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
        function confirmDelete(id) {
            if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                window.location.href = 'index.php?action=delete_post&id=' + id;
            }
        }
    </script>
</body>
</html>


    