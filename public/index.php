<?php
// Bắt đầu session để quản lý trạng thái đăng nhập và quyền hạn
session_start();

// 1. REQUIRE CÁC THÀNH PHẦN CẦN THIẾT
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/CommentController.php';
require_once __DIR__ . '/../controllers/AdminController.php';


$db = (new Database())->getConnection();


$userCtrl     = new UserController($db);
$postCtrl     = new PostController($db);
$categoryCtrl = new CategoryController($db);
$commentCtrl  = new CommentController($db);
$adminCtrl    = new AdminController($db);

// Thiết lập action mặc định là 'home' (Trang chủ Frontend)
$action = $_GET['action'] ?? 'home'; 
$id     = $_GET['id'] ?? null;

// Kiểm tra trạng thái đăng nhập Admin (Giả định user_role được lưu trong session)
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

switch ($action) {
    // HOME & TRANG CHỦ FRONTEND
    case 'index':
    case 'home':
        $postCtrl->showHomeFeed(); // <--- GỌI PHƯƠNG THỨC MỚI
        exit(); // Thoát sau khi hiển thị trang để tránh chạy tiếp
        break;
    
    // XEM BÀI VIẾT CHI TIẾT (CÓ THỂ DÙNG CHUNG)
    case 'show_post':
        if($id) {
            $postCtrl->show($id);
            exit(); 
        } else {
            header('Location: index.php?action=home&error=no_id');
            exit();
        }
        break;
    
    // CHỨC NĂNG LIÊN QUAN ĐẾN USER (ĐĂNG KÝ, ĐĂNG NHẬP, ĐĂNG XUẤT)
    case 'register':
        $userCtrl->register();
        exit();
        break;
    case 'user_login':
        $userCtrl->login();
        exit();
        break;
    case 'user_logout':
        $userCtrl->logout();
        exit();
        break;

    // XỬ LÝ ĐĂNG NHẬP ADMIN (Cần phải tồn tại để người dùng có thể đăng nhập Admin)
    case 'admin_login':
        $adminCtrl->login();
        exit();
        break;
        
    // Nếu action là của admin, chuyển sang khối Admin
    default:
        // Tiếp tục kiểm tra khối Admin
        break;
}



    if ($action !== 'home' && $action !== 'index' && $action !== 'show_post') {
        header('Location: index.php?action=home&auth_error=1');
        exit();
    }
 else {
    // CHỈ CHẠY LOGIC ADMIN KHI ĐÃ ĐĂNG NHẬP ADMIN
    switch ($action) {
        
        // CÁC ACTION DASHBOARD VÀ LOGOUT
        case 'admin_dashboard':
            $adminCtrl->dashboard();
            break;
        case 'admin_logout':
            $adminCtrl->logout();
            break;

        // QUẢN LÝ BÀI VIẾT
        case 'hoctap':
        case 'posts': 
            $postCtrl->index(); 
            break;
        case 'create_post':
            $postCtrl->create();
            break;
        case 'store':
            $postCtrl->store();
            break;
        case 'edit_post':
            if($id) {
                $postCtrl->edit($id);
            } else {
                header('Location: index.php?action=hoctap&error=no_id');
            }
            break;
        case 'update':
            if($id) {
                $postCtrl->update($id);
            } else {
                header('Location: index.php?action=hoctap&error=no_id');
            }
            break;
        case 'delete_post':
            if($id) {
                $postCtrl->delete($id);
            } else {
                header('Location: index.php?action=hoctap&error=no_id');
            }
            break;
        
        // QUẢN LÝ DANH MỤC
        case 'categories':
            $categoryCtrl->index();
            break;
        case 'create_category':
            $categoryCtrl->create();
            break;
        case 'edit_category':
            $categoryCtrl->edit($id);
            break;
        case 'delete_category':
            $categoryCtrl->delete($id);
            break;

        // QUẢN LÝ BÌNH LUẬN
        case 'comments':
            $commentCtrl->index();
            break;
        case 'delete_comment':
            $commentCtrl->delete($id);
            break;

        // QUẢN LÝ NGƯỜI DÙNG
        case 'users':
        case 'user_list':
            $userCtrl->listUsers();
            break;
        
        default:
            // Nếu admin truy cập action không rõ, chuyển về dashboard
            header('Location: index.php?action=admin_dashboard');
            break;
    }
    // Dừng chương trình sau khi chạy action Admin
    exit();
} 