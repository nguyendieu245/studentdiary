
<?php


if (empty($_SESSION['admin'])) {
    header("Location: /studentdiary/public/index.php?action=admin_login");
    exit;
}

$admin = $_SESSION['admin'];
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục - Student Diary Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/studentdiary/public/css/category.css">
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <div class="main-content">
        <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại trang chính
        </a>


            <form action="index.php?action=update_category&id=<?= $category['id'] ?>" method="POST">
                <div class="form-group">
                    <label for="name">Tên danh mục <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" required 
                           value="<?= htmlspecialchars($category['name']) ?>"
                           placeholder="Vd: Kỹ năng, Học tập, Đời sống...">
                    <div class="help-text">Tên danh mục sẽ hiển thị trên website</div>
                </div>

                <div class="form-group">
                    <label for="slug">Slug (URL thân thiện)</label>
                    <input type="text" id="slug" name="slug" 
                           value="<?= htmlspecialchars($category['slug']) ?>"
                           placeholder="Để trống để tự động tạo từ tên danh mục">
                    <div class="help-text">Vd: ky-nang, hoc-tap, doi-song (chỉ dùng chữ thường, số và dấu gạch ngang)</div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật danh mục
                    </button>
                    <a href="index.php?action=danhmuc" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script src="/studentdiary/public/js/category.js"></script>
</body>
</html>