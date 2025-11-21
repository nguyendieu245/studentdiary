
<?php
// Tạo mảng comment cha và con
$parents = [];
$children = [];

foreach ($comments as $c) {
    if ($c['parent_id'] == 0) {
        $parents[$c['id']] = $c;
    } else {
        $children[$c['parent_id']][] = $c;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            margin-bottom: 24px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        thead {
            background: #D4A574;
            color: white;
        }

        th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
            font-size: 14px;
            vertical-align: top;
        }

        tbody tr {
            transition: all 0.2s;
        }

        tbody tr:hover {
            background: #fffbf0;
        }

        .stt-col {
            width: 50px;
            text-align: center;
            font-weight: 600;
        }

        .post-title-col {
            max-width: 250px;
        }

        .post-title-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .commenter-name {
            font-weight: 500;
            color: #2c2c2c;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #FFF3CD;
            color: #856404;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 6px;
        }

        .comment-content {
            max-width: 300px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #666;
            line-height: 1.5;
        }

        .comment-type {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .type-comment {
            background: #E3F2FD;
            color: #1976D2;
        }

        .type-reply {
            background: #F3E5F5;
            color: #7B1FA2;
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

        .action-btns {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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

        .btn-reply {
            background: #E8DAEF;
            color: #7B1FA2;
        }

        .btn-reply:hover {
            background: #7B1FA2;
            color: white;
        }

        .btn-toggle {
            background: #FFF3CD;
            color: #856404;
        }

        .btn-toggle:hover {
            background: #856404;
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

        .reply-row {
            background: #FFF9E6 !important;
        }

        .reply-indicator {
            padding-left: 20px;
            color: #666;
            font-size: 13px;
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
                    if($_GET['success'] == 'deleted') echo 'Xóa bình luận thành công!';
                    elseif($_GET['success'] == 'status_updated') echo 'Cập nhật trạng thái thành công!';
                    elseif($_GET['success'] == 'replied') echo 'Phản hồi bình luận thành công!';
                    else echo 'Thao tác thành công!';
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                Có lỗi xảy ra. Vui lòng thử lại!
            </div>
        <?php endif; ?>

        <h1 class="page-title">Quản lý bình luận</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="stt-col">STT</th>
                        <th>Bài viết</th>
                        <th>Người bình luận</th>
                        <th>Nội dung</th>
                        <th>Loại bình luận</th>
                        <th>Ngày</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($parents)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-comments"></i>
                                    <p>Chưa có bình luận nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $stt = 1;
                        foreach ($parents as $parent): 
                        ?>
                        
                        <!-- Bình luận gốc -->
                        <tr>
                            <td class="stt-col"><?= $stt++ ?></td>
                            <td class="post-title-col">
                                <div class="post-title-text">
                                    <?= htmlspecialchars($parent['post_title']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="commenter-name">
                                    <?= htmlspecialchars($parent['commenter_name']) ?>
                                </div>
                                <?php if($parent['is_admin']): ?>
                                    <span class="admin-badge">
                                        <i class="fas fa-crown"></i> Admin
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="comment-content">
                                    <?= htmlspecialchars($parent['comment']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="comment-type type-comment">Bình luận gốc</span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($parent['created_at'])) ?></td>
                            <td>
                                <span class="status-badge <?= $parent['status'] ? 'status-active' : 'status-hidden' ?>">
                                    <?= $parent['status'] ? 'Hiển thị' : 'Ẩn' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?action=show_comment&id=<?= $parent['id'] ?>">
                                        <button class="btn-icon btn-reply" title="Phản hồi">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                    </a>
                                    <button class="btn-icon btn-toggle" 
                                            onclick="toggleStatus(<?= $parent['id'] ?>)" 
                                            title="<?= $parent['status'] ? 'Ẩn' : 'Hiển thị' ?>">
                                        <i class="fas fa-eye<?= $parent['status'] ? '-slash' : '' ?>"></i>
                                    </button>
                                    <button class="btn-icon btn-delete" 
                                            onclick="confirmDelete(<?= $parent['id'] ?>)" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Phản hồi (nếu có) -->
                        <?php if (!empty($children[$parent['id']])): ?>
                            <?php foreach ($children[$parent['id']] as $reply): ?>
                            <tr class="reply-row">
                                <td class="stt-col"></td>
                                <td class="post-title-col">
                                    <div class="reply-indicator">↳ Phản hồi</div>
                                </td>
                                <td>
                                    <div class="commenter-name">
                                        <?= $reply['is_admin'] ? '<strong>Student Diary</strong>' : htmlspecialchars($reply['commenter_name']) ?>
                                    </div>
                                    <?php if($reply['is_admin']): ?>
                                        <span class="admin-badge">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="comment-content">
                                        <?= htmlspecialchars($reply['comment']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="comment-type type-reply">Phản hồi của Admin</span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($reply['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge <?= $reply['status'] ? 'status-active' : 'status-hidden' ?>">
                                        <?= $reply['status'] ? 'Hiển thị' : 'Ẩn' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-icon btn-toggle" 
                                                onclick="toggleStatus(<?= $reply['id'] ?>)" 
                                                title="<?= $reply['status'] ? 'Ẩn' : 'Hiển thị' ?>">
                                            <i class="fas fa-eye<?= $reply['status'] ? '-slash' : '' ?>"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" 
                                                onclick="confirmDelete(<?= $reply['id'] ?>)" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if(confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                window.location.href = 'index.php?action=delete_comment&id=' + id;
            }
        }

        function toggleStatus(id) {
            window.location.href = 'index.php?action=toggle_comment&id=' + id;
        }
    </script>
</body>
</html>
        