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
    <link rel="stylesheet" href="/studentdiary/public/css/stylepost.css">  
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
        <div class="main-content">
    <div><a href="/studentdiary/public/index.php?action=baiviet" class="back-btn">
        <i class="fas fa-arrow-left"></i> Quay lại 
    </a>
    </div>
        <div class="form-container">
            <h1>Sửa bài viết</h1>

            <form action="index.php?action=update&id=<?= $post['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết <span style="color: red;">*</span></label>
                    <input type="text" id="title" name="title" required 
                           value="<?= htmlspecialchars($post['title']) ?>"
                           placeholder="Nhập tiêu đề bài viết...">
                </div>

                <div class="form-group">
                    <label for="content">Nội dung <span style="color: red;">*</span></label>
                    <textarea id="content" name="content" required><?= $post['content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="category_id">Danh mục <span style="color: red;">*</span></label>
                    <select id="category_id" name="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $post['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Ảnh đại diện</label>
                    
                    <?php if($post['image']): ?>
                    <div class="current-image">
                        <p><strong>Ảnh hiện tại:</strong></p>
                        <img src="../public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                             alt="Current image" 
                             style="max-width: 200px; border-radius: 8px;">
                    </div>
                    <?php endif; ?>
                    
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                    <p style="font-size: 13px; color: #666; margin-top: 8px;">
                        Để trống nếu không muốn thay đổi ảnh
                    </p>
                    
                    <div id="imagePreview" class="image-preview" style="display: none;">
                        <p style="font-size: 13px; color: #666; margin-bottom: 8px;"><strong>Ảnh mới:</strong></p>
                        <img id="preview" src="" alt="Preview">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select id="status" name="status">
                        <option value="published" <?= $post['status'] == 'published' ? 'selected' : '' ?>>
                            Đã đăng
                        </option>
                        <option value="draft" <?= $post['status'] == 'draft' ? 'selected' : '' ?>>
                            Nháp
                        </option>
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật bài viết
                    </button>
                    <a href="index.php?action=baiviet" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>
        

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
   <script src="/studentdiary/public/js/post.js"></script>
</body>
</html>
      