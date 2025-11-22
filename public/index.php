<?php
// public/index.php

session_start();

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

$action = $_GET['action'] ?? 'home';
$id     = $_GET['id'] ?? null;

switch ($action) {

    // ========== FRONTEND ==========
    case 'home':
        $postCtrl->showHomeFeed();
        break;

    // === Danh mục Kỹ năng ===
    case 'posts_skill':
        $posts = $postCtrl->getByCategory(1);
        $currentPage = 'skill';
        include __DIR__ . '/../views/frontend/category_list.php';
        break;
    case 'skill_detail':
        if ($id) {
            $postCtrl->showCategoryPost($id, $commentCtrl);
        } else {
            header('Location: index.php?action=posts_skill');
            exit();
        }
        break;

    // === Danh mục Học tập ===
    case 'posts_study':
        $posts = $postCtrl->getByCategory(2);
        $currentPage = 'study';
        include __DIR__ . '/../views/frontend/category_list.php';
        break;
    case 'study_detail':
        if ($id) {
            $postCtrl->showCategoryPost($id, $commentCtrl);
        } else {
            header('Location: index.php?action=posts_study');
            exit();
        }
        break;

    // === Danh mục Đời sống ===
    case 'posts_life':
        $posts = $postCtrl->getByCategory(3);
        $currentPage = 'social';
        include __DIR__ . '/../views/frontend/category_list.php';
        break;
    case 'social_detail':
        if ($id) {
            $postCtrl->showCategoryPost($id, $commentCtrl);
        } else {
            header('Location: index.php?action=posts_life');
            exit();
        }
        break;

    // ========== ADMIN POSTS ==========
    case 'baiviet':
        $postCtrl->index();
        break;
    case 'create_post':
        $postCtrl->create();
        break;
    case 'store':
        $postCtrl->store();
        break;
    case 'edit_post':
        if ($id) $postCtrl->edit($id);
        else header('Location: index.php?action=baiviet&error=no_id');
        break;
    case 'update':
        if ($id) $postCtrl->update($id);
        else header('Location: index.php?action=baiviet&error=no_id');
        break;
    case 'delete_post':
        if ($id) $postCtrl->delete($id);
        else header('Location: index.php?action=baiviet&error=no_id');
        break;
    case 'show_post':
        if ($id) $postCtrl->show($id);
        else header('Location: index.php?action=baiviet&error=no_id');
        break;

    // ========== CATEGORY ==========
    case 'danhmuc':
        $categoryCtrl->index();
        break;
    case 'create_category':
        $categoryCtrl->create();
        break;
    case 'store_category':
        $categoryCtrl->store();
        break;
    case 'edit_category':
        if ($id) $categoryCtrl->edit($id);
        else header('Location: index.php?action=categories&error=no_id');
        break;
    case 'update_category':
        if ($id) $categoryCtrl->update($id);
        else header('Location: index.php?action=categories&error=no_id');
        break;
    case 'delete_category':
        if ($id) $categoryCtrl->delete($id);
        else header('Location: index.php?action=categories&error=no_id');
        break;

    // ========== COMMENT ==========
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

    // ========== USER ==========
    case 'users':
        $userCtrl->index();
        break;
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

    // ========== ADMIN ==========
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

    default:
        $postCtrl->showHomeFeed();
        break;
}
?>
