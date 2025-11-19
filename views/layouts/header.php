<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Đổi tên biến $currentAction thành $currentPage để khớp với logic sidebar
$currentPage = $_GET['page'] ?? 'admin_dashboard'; 

// Hàm isActive phải được định nghĩa TRƯỚC khi include sidebar.php
// Đảm bảo hàm này được định nghĩa chỉ một lần
if (!function_exists('isActive')) {
    function isActive($pageName, $currentPage) {
        return ($currentPage === $pageName) ? 'active' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Student Diary</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

:root {
    --primary-color: #5f4a41;
    --secondary-color: #b88769;
    --accent-color: #ceb6ad;
    --light-color: #fbe9e7;
    --text-color: #4e342e;
    --border-color: #a1887f;
    --success-color: #388e3c;
    --warning-color: #ffa726;
    --danger-color: #d84315;
    --info-color: #8d6e63;
}

body {
    background-color: var(--light-color);
    color: var(--text-color);
    font-weight: 500;
}

        .main-content-wrapper {
            margin-left: 260px; 
            padding: 30px; 
            min-height: 100vh;
            background-color: #fff; /* Giữ nền trắng cho nội dung để nổi bật */
            box-shadow: -2px 0 5px rgba(0,0,0,0.05); 
        }

        /* SIDEBAR - Cập nhật màu */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: var(--secondary-color); 
    color: var(--text-color-sidebar);
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    font-family: Poppins, sans-serif;
}

        .logo-text {
    font-size: 18px;
    font-weight: bold;
    padding: 24px 20px 18px 20px;
    background: var(--primary-color);
    color: #fff;
    letter-spacing: 1px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
        
        .menu-item {
    display: flex;
    align-items: center;
    padding: 15px 22px;
    cursor: pointer;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    color: #fff;
    font-size: 15px;
}

.menu-item:hover,
.menu-item.active {
    background-color: #fff3e0;
    color: var(--primary-color);
    border-left: 3px solid var(--accent-color);
}

.menu-icon {
    margin-right: 12px;
    width: 22px;
    text-align: center;
    font-size: 18px;
}

    </style>
</head>
<body>
    
    <?php include __DIR__ . '/sidebar.php'; ?> 
    
    <div class="main-content-wrapper"> 
    
