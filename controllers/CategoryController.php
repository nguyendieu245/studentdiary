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
            $name = htmlspecialchars($_POST['name']);
            $slug = !empty($_POST['slug']) ? $this->category->createSlug($_POST['slug']) : $this->category->createSlug($name);

            if ($this->category->create($name, $slug)) {
                header('Location: index.php?action=danhmuc&success=created');
                exit();
            } else {
                header('Location: index.php?action=danhmuc&error=create_failed');
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
            header('Location: index.php?action=danhmuc&error=notfound');
            exit();
        }
    }

    // Xử lý cập nhật danh mục
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $slug = !empty($_POST['slug']) ? $this->category->createSlug($_POST['slug']) : $this->category->createSlug($name);

            // Truyền đủ tham số cho model
            if ($this->category->update($id, $name, $slug)) {
                header('Location: index.php?action=danhmuc&success=updated');
                exit();
            } else {
                header('Location: index.php?action=danhmuc&error=update_failed');
                exit();
            }
        }
    }

    // Xóa danh mục
    public function delete($id)
    {
        if ($this->category->delete($id)) {
            header('Location: index.php?action=danhmuc&success=deleted');
            exit();
        } else {
            header('Location: index.php?action=danhmuc&error=has_posts');
            exit();
        }
    }
}
?>