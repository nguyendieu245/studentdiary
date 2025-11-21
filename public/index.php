<?php
// public/index.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/CommentController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

// Kết nối DB
$db = (new Database())->getConnection();

// Khởi tạo controller
$userCtrl     = new UserController($db);
$postCtrl     = new PostController($db);
$categoryCtrl = new CategoryController($db);
$commentCtrl  = new CommentController($db);
$adminCtrl    = new AdminController($db);

// Lấy action/id từ URL
$action = $_GET['action'] ?? 'home';
$id     = $_GET['id'] ?? null;

// Xử lý routing
switch ($action) {

    // ================== FRONTEND POSTS ==================
    case 'home':
        $postCtrl->showHomeFeed();
        break;
    case 'skill':
        $postCtrl->showSkillFeed();
        break;
    case 'study':
        $postCtrl->showStudyFeed();
        break;
    case 'social':
        $postCtrl->showSocialFeed();
        break;
    case 'show_post':
        if ($id) {
            $postCtrl->show($id);
        } else {
            header('Location: index.php?action=home');
            exit();
        }
        break;

    // ================== ADMIN POSTS ==================
    case 'hoctap':
        $postCtrl->adminIndex();  // admin danh sách bài viết
        break;
    case 'create_post':
        $postCtrl->create();
        break;
    case 'store_post':
        $postCtrl->store();
        break;
    case 'edit_post':
        if ($id) {
            $postCtrl->edit($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;
    case 'update_post':
        if ($id) {
            $postCtrl->update($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;
    case 'delete_post':
        if ($id) {
            $postCtrl->delete($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;

    // ================== CATEGORIES ==================
    case 'categories':
        $categoryCtrl->index();
        break;
    case 'create_category':
        $categoryCtrl->create();
        break;
    case 'edit_category':
        if ($id) $categoryCtrl->edit($id);
        break;
    case 'delete_category':
        if ($id) $categoryCtrl->delete($id);
        break;

    // ================== COMMENTS (ADMIN) ==================
    case 'comments':
        $commentCtrl->index();
        break;
    case 'show_comment':
        if ($id) $commentCtrl->show($id);
        else header('Location: index.php?action=comments');
        break;
    case 'toggle_comment':
        if ($id) $commentCtrl->toggleStatus($id);
        else header('Location: index.php?action=comments');
        break;
    case 'delete_comment':
        if ($id) $commentCtrl->delete($id);
        else header('Location: index.php?action=comments');
        break;
    case 'reply_comment':
        if ($id) $commentCtrl->reply($id);
        else header('Location: index.php?action=comments');
        break;

    // ================== USER ==================
    case 'register':
        $userCtrl->register();
        break;
    case 'user_login':
        $userCtrl->login();
        break;
    case 'user_logout':
        $userCtrl->logout();
        break;
    case 'user_list':
        $userCtrl->listUsers();
        break;

    // ================== ADMIN ==================
    case 'admin_login':
        $adminCtrl->login();
        break;
    case 'admin_dashboard':
    case 'dashboard':
        $adminCtrl->dashboard();
        break;
    case 'admin_logout':
        $adminCtrl->logout();
        break;

    // ================== DEFAULT ==================
    default:
        $postCtrl->showHomeFeed();
        break;
}
