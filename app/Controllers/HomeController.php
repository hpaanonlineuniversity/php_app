<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class HomeController extends Controller {
    public function index() {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $data = [
            'title' => 'User List',
            'users' => $users
        ];

        $this->view('home', $data);
    }
}
