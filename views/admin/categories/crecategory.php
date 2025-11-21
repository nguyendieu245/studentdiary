
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
    <title>Thêm danh mục mới - Student Diary Admin</title>
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
            max-width: 700px;
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

        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #8B7355;
        }

        .help-text {
            font-size: 13px;
            color: #666;
            margin-top: 6px;
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
            gap: 8px;
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
    </style>
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

   <div class="main-content">
        <a href="/studentdiary/public/index.php?action=dashboard" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại trang chính
        </a>

        <div class="form-container">
            <h1>Thêm danh mục mới</h1>

            <form action="index.php?action=store_category" method="POST">
                <div class="form-group">
                    <label for="name">Tên danh mục <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" required 
                           placeholder="Vd: Kỹ năng, Học tập, Đời sống...">
                    <div class="help-text">Tên danh mục sẽ hiển thị trên website</div>
                </div>

                <div class="form-group">
                    <label for="slug">Slug (URL thân thiện)</label>
                    <input type="text" id="slug" name="slug" 
                           placeholder="Để trống để tự động tạo từ tên danh mục">
                    <div class="help-text">Vd: ky-nang, hoc-tap, doi-song (chỉ dùng chữ thường, số và dấu gạch ngang)</div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu danh mục
                    </button>
                    <a href="index.php?action=danhmuc" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>