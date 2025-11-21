<?php
// controllers/PostController.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';

class PostController {
    private $db;
    private $post;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->post = new Post($this->db);
        $this->category = new Category($this->db);
    }

    /* ===== FRONTEND ===== */

    public function showHomeFeed() {
        $posts = $this->post->getAllPublishedPosts();
        $categories = $this->category->getAllCategories();
        
        $currentPage = 'home_front';
        $isAdminPage = false;
        require_once __DIR__ . '/../views/frontend/home.php';
    }

    public function showSkillFeed() {
        $posts = $this->post->getAllSkillPosts();
        $categories = $this->category->getAllCategories();
        
        $currentPage = 'skill';
        $isAdminPage = false;
        require_once __DIR__ . '/../views/frontend/post_frontend/skill.php';
    }

    public function showStudyFeed() {
        $posts = $this->post->getAllStudyPosts();
        $categories = $this->category->getAllCategories();
        
        $currentPage = 'study';
        $isAdminPage = false;
        require_once __DIR__ . '/../views/frontend/post_frontend/study.php';
    }

    public function showSocialFeed() {
        $posts = $this->post->getAllLifePosts();
        $categories = $this->category->getAllCategories();
        
        $currentPage = 'social';
        $isAdminPage = false;
        require_once __DIR__ . '/../views/frontend/post_frontend/social.php';
    }

    public function showPostDetail($id) {
        $post = $this->post->getById($id);
        if (!$post) {
            header('Location: index.php?action=home&error=notfound');
            exit();
        }
        $currentPage = 'post_detail';
        $isAdminPage = false;
        require_once __DIR__ . '/../views/frontend/post_detail.php';
    }

    /* ===== ADMIN ===== */

    public function adminIndex() {
        $posts = $this->post->getAllSkillPosts();
        $currentPage = 'hoctap';
        $isAdminPage = true;
        require_once __DIR__ . '/../views/admin/posts/skill_posts_list.php';
    }

    public function adminCreate() {
        $currentPage = 'hoctap';
        $isAdminPage = true;
        require_once __DIR__ . '/../views/admin/posts/create.php';
    }

    public function adminStore() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->post->title = htmlspecialchars($_POST['title']);
        $this->post->content = $_POST['content'];
        $this->post->author = 'Admin';
        $this->post->status = $_POST['status'] ?? 'published';
        $this->post->category_id = 1;
        $this->post->category = 'Kỹ năng';

        // Upload ảnh
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                $this->post->image = $new_filename;
            }
        }

        $this->post->image = $this->post->image ?? '';

        if ($this->post->create()) {
            header('Location: index.php?action=hoctap&success=1');
            exit();
        }
        header('Location: index.php?action=hoctap&error=1');
        exit();
    }

    public function adminEdit($id) {
        $post = $this->post->getById($id);
        if (!$post) {
            header('Location: index.php?action=hoctap&error=notfound');
            exit();
        }
        $currentPage = 'hoctap';
        $isAdminPage = true;
        require_once __DIR__ . '/../views/admin/posts/edit.php';
    }

    public function adminUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $this->post->id = $id;
        $this->post->title = htmlspecialchars($_POST['title']);
        $this->post->content = $_POST['content'];
        $this->post->status = $_POST['status'] ?? 'published';
        $this->post->category_id = 1;

        $upload_dir = __DIR__ . '/../public/uploads/';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                $old_post = $this->post->getById($id);
                if ($old_post['image'] && file_exists($upload_dir . $old_post['image'])) {
                    unlink($upload_dir . $old_post['image']);
                }
                $this->post->image = $new_filename;
            } else {
                $old_post = $this->post->getById($id);
                $this->post->image = $old_post['image'];
            }
        } else {
            $old_post = $this->post->getById($id);
            $this->post->image = $old_post['image'];
        }

        if ($this->post->update()) {
            header('Location: index.php?action=hoctap&success=updated');
            exit();
        }
        header('Location: index.php?action=hoctap&error=update_failed');
        exit();
    }

    public function adminDelete($id) {
        $post_data = $this->post->getById($id);
        if ($post_data && $this->post->delete()) {
            $upload_dir = __DIR__ . '/../public/uploads/';
            if ($post_data['image'] && file_exists($upload_dir . $post_data['image'])) {
                unlink($upload_dir . $post_data['image']);
            }
            header('Location: index.php?action=hoctap&success=deleted');
            exit();
        }
        header('Location: index.php?action=hoctap&error=delete_failed');
        exit();
    }
}
