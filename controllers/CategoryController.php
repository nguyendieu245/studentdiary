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
        $currentPage = 'danhmuc';
        require_once __DIR__ . '/../views/admin/categories/categorylist.php';
    }
}
?>
