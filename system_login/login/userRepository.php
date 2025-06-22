<?php
require_once __DIR__ . '/../dbSingleton/databaseSingleton.php';
require_once __DIR__ . '/user.php';

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseSingleton::getInstance()->getConnection();
        
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        if ($stmt === false) { return null; }
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                (int) $row['id'],
                $row['email'],
                $row['password']
            );
        }

        return null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        if ($stmt === false) { return null; }
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['id'], $row['email'], $row['password']);
        }

        return null;
    }

    public function save(User $user): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');

        if ($stmt === false) {
            // Si prepare() falla, evitamos un error fatal.
            // En un entorno real, aquí se registraría el error específico de la base de datos.
            return false;
        }

        // execute() devuelve true si tiene éxito o false si falla.
        return $stmt->execute([
            'email' => $user->getEmail(),
            'password' => $user->getHashedPassword()
        ]);
    }

    public function verifyCredentials(string $email, string $password): bool
    {
        $stmt = $this->pdo->prepare('SELECT password FROM users WHERE email = :email');
        if ($stmt === false) { return false; }
        $stmt->execute(['email' => $email]);
        $hash = $stmt->fetchColumn();

        if ($hash && password_verify($password, $hash)) {
            return true;
        }
        return false;
    }

    public function getUserIdByEmail(string $email): ?int
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email');
        if ($stmt === false) { return null; }
        $stmt->execute(['email' => $email]);
        $id = $stmt->fetchColumn();

        return $id !== false ? (int) $id : null;
    }
}