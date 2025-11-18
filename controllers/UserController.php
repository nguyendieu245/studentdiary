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

    public function delete($id) {
        $this->user->delete($id);
        header('Location: index.php?action=users');
        exit;
    }
}
