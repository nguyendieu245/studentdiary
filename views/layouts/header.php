<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Lấy action hiện tại
$currentAction = $_GET['action'] ?? 'admin_dashboard'; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Student Diary</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* CSS CHUNG */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7; 
            margin: 0;
            padding: 0;
        }

        .main-content-wrapper {
            margin-left: 250px; 
            padding: 20px;
            min-height: 100vh;
            background-color: #fff; /* Nền trắng cho khu vực nội dung */
            box-shadow: -2px 0 5px rgba(0,0,0,0.05); 
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #a5747eff; 
            color: #ecf0f1;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            font-family: Poppins, sans-serif;
        }

        .logo-text {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 30px;
            padding: 0 15px;
            color: #ede0e9ff; /* Màu nổi bật */
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            font-size: 0.95rem;
        }

        .menu-item:hover {
            background-color: #543d49ff;
            color: #fff;
        }

        .menu-item.active {
            background-color: #f1f5f7ff;
            color: #fff;
            border-left: 5px solid #fff;
        }

        .menu-icon {
            width: 30px;
            text-align: center;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    
    <?php include __DIR__ . '/sidebar.php'; ?> 
    
    <div class="main-content-wrapper"> 
        


<?php
?>

    
</body>
</html>