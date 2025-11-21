<?php
// controllers/CategoryController.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $db;
    private $category;

    public function __construct($db)
    {
        $this->db = $db;
        $this->category = new Category($db);
    }

    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = $this->category->all();
        $currentPage = 'doisong';
        require_once __DIR__ . '/../views/admin/categories/categorylist.php';
    }

    // Hiển thị form thêm danh mục
    public function create()
    {
        $currentPage = 'doisong';
        require_once __DIR__ . '/../views/admin/categories/crecategory.php';
    }

    // Xử lý thêm danh mục
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->name = htmlspecialchars($_POST['name']);
            
            // Tạo slug tự động hoặc dùng slug custom
            if (!empty($_POST['slug'])) {
                $this->category->slug = $this->category->createSlug($_POST['slug']);
            } else {
                $this->category->slug = $this->category->createSlug($this->category->name);
            }

            if ($this->category->create()) {
                header('Location: index.php?action=doisong&success=created');
                exit();
            } else {
                header('Location: index.php?action=doisong&error=create_failed');
                exit();
            }
        }
    }

    // Hiển thị form sửa danh mục
    public function edit($id)
    {
        $category = $this->category->getById($id);
        if ($category) {
            $currentPage = 'doisong';
            require_once __DIR__ . '/../views/admin/categories/edicategory.php';
        } else {
            header('Location: index.php?action=doisong&error=notfound');
            exit();
        }
    }

    // Xử lý cập nhật danh mục
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->id = $id;
            $this->category->name = htmlspecialchars($_POST['name']);
            
            if (!empty($_POST['slug'])) {
                $this->category->slug = $this->category->createSlug($_POST['slug']);
            } else {
                $this->category->slug = $this->category->createSlug($this->category->name);
            }

            if ($this->category->update()) {
                header('Location: index.php?action=doisong&success=updated');
                exit();
            } else {
                header('Location: index.php?action=doisong&error=update_failed');
                exit();
            }
        }
    }

    // Xóa danh mục
    public function delete($id)
    {
        $this->category->id = $id;
        $result = $this->category->delete();
        
        if ($result) {
            header('Location: index.php?action=doisong&success=deleted');
            exit();
        } else {
            header('Location: index.php?action=doisong&error=has_posts');
            exit();
        }
    }
}
?>