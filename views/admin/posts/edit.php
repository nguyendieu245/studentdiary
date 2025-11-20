<?php
// views/admin/posts/edit.php
function isActive($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa bài viết - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
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

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: #8B7355;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 24px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #6B5442;
            transform: translateX(-4px);
        }

        .back-btn i {
            margin-right: 8px;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            max-width: 900px;
        }

        h1 {
            font-size: 28px;
            color: #2c2c2c;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        textarea {
            min-height: 300px;
            resize: vertical;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #8B7355;
        }

        input[type="file"] {
            padding: 10px;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary {
            background: #8B7355;
            color: white;
        }

        .btn-primary:hover {
            background: #6B5442;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139,115,85,0.3);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #666;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .btn i {
            margin-right: 8px;
        }

        .image-preview {
            margin-top: 12px;
            max-width: 300px;
        }

        .image-preview img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .current-image {
            margin-bottom: 12px;
        }

        .current-image p {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <a href="index.php?action=hoctap" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>

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
                    <a href="index.php?action=hoctap" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
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
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>
</body>
</html>
      