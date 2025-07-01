<?php
require_once __DIR__ . '/userRepository.php';
require_once __DIR__ . '/../../router.php';

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $repo)
    {
        $this->userRepository = $repo;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            $_SESSION['user_id'] = $user->getId();
            return true;
        }

        return false;
    }

    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        setcookie("PHPSESSID", "", time() - 3600, "/");
        header('Location: ../login/login.php');
        exit;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}