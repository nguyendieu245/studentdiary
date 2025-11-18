<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $category;

    public function __construct($db) {
        $this->category = new Category($db);
    }

    public function index() {
        $categories = $this->category->all();
        include __DIR__ . '/../views/category/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $this->category->create($name, $slug);
            header('Location: index.php?action=categories');
            exit;
        }
        include __DIR__ . '/../views/category/form.php';
    }

    public function edit($id) {
        $category = $this->category->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $this->category->update($id, $name, $slug);
            header('Location: index.php?action=categories');
            exit;
        }
        include __DIR__ . '/../views/category/form.php';
    }

    public function delete($id) {
        $this->category->delete($id);
        header('Location: index.php?action=categories');
        exit;
    }
}
