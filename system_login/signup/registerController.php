<?php
require_once __DIR__ . '/registerService.php';
require_once __DIR__ . '/../login/userRepository.php';
require_once __DIR__ . '/../../router.php';

class RegisterController
{
    private RegisterService $service;

    public function __construct()
    {
        $this->service = new RegisterService(new UserRepository());
    }

    public function handleRequest(array $post): void
    {
        $message = '';

        if (!empty($post['email']) && !empty($post['password'])) {
            $success = $this->service->register($post['email'], $post['password']);

            if ($success) {
                // Redirigimos usando una ruta relativa, que es más robusta en este contexto.
                header('Location: ../login/login.php?registered=true');
                exit;
            } else {
                $message = 'Este email ya está registrado.';
            }
        }

        include __DIR__ . '/register_form.php';
    }
}