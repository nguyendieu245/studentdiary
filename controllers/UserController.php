<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function index() {
        $users = $this->user->all();
        include __DIR__ . '/../views/user/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'] ?? 'user';
            $this->user->create($username, $password, $fullname, $email, $role);
            header('Location: index.php?action=users');
            exit;
        }
        include __DIR__ . '/../views/user/form.php';
    }

    public function edit($id) {
        $user = $this->user->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $this->user->update($id, $fullname, $email);
            header('Location: index.php?action=users');
            exit;
        }
        include __DIR__ . '/../views/user/form.php';
    }

    public function delete($id) {
        $this->user->delete($id);
        header('Location: index.php?action=users');
        exit;
    }
}
