<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        if (file_exists(__DIR__ . '/../app/Views/' . $view . '.php')) {
            require_once __DIR__ . '/../app/Views/' . $view . '.php';
        } else {
            die("View file does not exist.");
        }
    }
}
