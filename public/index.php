
<?php

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

$action = $_GET['action'] ?? 'index';
$id     = $_GET['id'] ?? null;
 
switch ($action) {
    case 'hoctap':
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
            exit();
        }
        break;
    case 'update':
        if($id) {
            $postCtrl->update($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;
    
    case 'delete_post':
        if($id) {
            $postCtrl->delete($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;
     case 'show_post':
        if($id) {
            $postCtrl->show($id);
        } else {
            header('Location: index.php?action=hoctap&error=no_id');
            exit();
        }
        break;
    case 'posts':
        $postCtrl->index();
        break;

        // ========== CATEGORY ROUTES ==========
    case 'doisong':
        $categoryCtrl->index();
        break;

    case 'create_category':
        $categoryCtrl->create();
        break;

    case 'store_category':
        $categoryCtrl->store();
        break;

    case 'edit_category':
        if ($id) {
            $categoryCtrl->edit($id);
        } else {
            header('Location: index.php?action=categories&error=no_id');
        }
        break;

    case 'update_category':
        if ($id) {
            $categoryCtrl->update($id);
        } else {
            header('Location: index.php?action=categories&error=no_id');
        }
        break;

    case 'delete_category':
        if ($id) {
            $categoryCtrl->delete($id);
        } else {
            header('Location: index.php?action=categories&error=no_id');
        }
        break;


        // COMMENT ROUTES (Admin)
    case 'comments':
        $commentCtrl->index();
        break;

    case 'show_comment':
        if ($id) {
            $commentCtrl->show($id);
        } else {
            header('Location: index.php?action=comments');
        }
        break;

    case 'toggle_comment':
        if ($id) {
            $commentCtrl->toggleStatus($id);
        } else {
            header('Location: index.php?action=comments');
        }
        break;

    case 'delete_comment':
        if ($id) {
            $commentCtrl->delete($id);
        } else {
            header('Location: index.php?action=comments');
        }
        break;

    case 'reply_comment':
        if ($id) {
            $commentCtrl->reply($id);
        } else {
            header('Location: index.php?action=comments');
        }
        break;


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
    

    case 'admin_login':
        $adminCtrl->login();
        break;
    case 'admin_dashboard':
        $adminCtrl->dashboard();
        break;
    case 'admin_logout':
        $adminCtrl->logout();
        break;
    case 'dashboard':
        $adminCtrl->dashboard();
        break;

    default:
        $postCtrl->index();
        break;
}