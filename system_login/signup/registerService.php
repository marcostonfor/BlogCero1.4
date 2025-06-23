<?php
require_once __DIR__ . '/../login/userRepository.php';
require_once __DIR__ . '/../login/user.php';

class RegisterService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $repo)
    {
        $this->userRepository = $repo;
    }

    public function register(string $email, string $plainPassword): bool
    {
        // Verifica si ya existe un usuario
        if ($this->userRepository->findByEmail($email)) {
            return false; // ya existe
        }

        // Hashear contraseña
        $hashed = User::hashPassword($plainPassword);

        // Crear nuevo objeto User
        $user = new User(0, $email, $hashed);

        // Guardar usuario. El método save() ahora devuelve true o false,
        // indicando si la operación en la base de datos fue exitosa.
        return $this->userRepository->save($user);
    }
}