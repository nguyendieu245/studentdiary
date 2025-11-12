<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/CommentController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$db = (new Database())->connect();

$userCtrl     = new UserController($db);
$postCtrl     = new PostController($db);
$categoryCtrl = new CategoryController($db);
$commentCtrl  = new CommentController($db);
$adminCtrl    = new AdminController($db);

$action = $_GET['action'] ?? 'index';
$id     = $_GET['id'] ?? null;

switch ($action) {
    case 'create_post':
        $postCtrl->create();
        break;
    case 'edit_post':
        $postCtrl->edit($id);
        break;
    case 'delete_post':
        $postCtrl->delete($id);
        break;
    case 'show_post':
        $postCtrl->show($id);
        break;
    case 'posts':
        $postCtrl->index();
        break;

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

    case 'comments':
        $commentCtrl->index();
        break;
    case 'delete_comment':
        $commentCtrl->delete($id);
        break;

    case 'users':
        $userCtrl->index();
        break;
    case 'register':
        $userCtrl->register();
        break;
    case 'login':
        $userCtrl->login();
        break;
    case 'logout':
        $userCtrl->logout();
        break;

    case 'admin_login':
        $adminCtrl->login();
        break;
    case 'admin_dashboard':
        $adminCtrl->dashboard();
        break;
    case 'admin_logout':
        $adminCtrl->logout();
        break;

    default:
        $postCtrl->index();
        break;
}
