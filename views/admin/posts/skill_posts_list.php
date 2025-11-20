

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/styleadmin.css">
    
    
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
            <h1 class="page-title">Quản lý bài viết</h1>
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
                        <th>Danh mục</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($posts_data)): ?>
                        <tr>
                            <td colspan="6">
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
                                <div class="post-title">
                                    <?= htmlspecialchars($post['title']) ?>
                                </div>
                            </td>
                            <td>
                                <span style="color: #8B7355; font-weight: 500;">
                                    <?= htmlspecialchars($post['category_name'] ?? 'Chưa phân loại') ?>
                                </span>
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