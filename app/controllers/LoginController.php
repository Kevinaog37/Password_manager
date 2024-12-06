<?php
class LoginController {
    public function index() {
        require_once __DIR__ . '/../views/loginView.php';
    }

    public function about() {
        echo "Esta es la página de información.";
    }
}
