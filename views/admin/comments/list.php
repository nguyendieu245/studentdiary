<?php


if (empty($_SESSION['admin'])) {
    header("Location: /studentdiary/public/index.php?action=admin_login");
    exit;
}

$admin = $_SESSION['admin'];
?><?php
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
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/stylecomment.css">
    
    
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    
        <div class="main-content">
    <div> <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
        <i class="fas fa-arrow-left"></i> Quay lại trang chính
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
</div>
    
    <!-- Đã chuyển tất cả JavaScript sang file comment.js -->
    <script src="/studentdiary/public/java/comment.js"></script>
</body>
</html>