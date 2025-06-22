<?php
require_once __DIR__ . '/userRepository.php';
require_once __DIR__ . '/authservice.php';
require_once __DIR__ . '/../../router.php';

class LoginController {
    private AuthService $auth;

    public function __construct() {
        $repo = new UserRepository();
        $this->auth = new AuthService($repo);
    }

    public function handleRequest(array $post): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/public/home.php');
            exit;
        }

        if (!empty($post['email']) && !empty($post['password'])) {
            $success = $this->auth->login($post['email'], $post['password']);
            if ($success) {
                header('Location: ' . BASE_URL . '/public/home.php');
                exit;
            } else {
                $this->renderForm('Credenciales inválidas');
            }
        } else {
            $this->renderForm();
        }
    }

    private function renderForm(string $message = ''): void {
        include __DIR__ . '/login_form.php';
    }
}