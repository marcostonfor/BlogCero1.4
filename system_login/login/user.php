<?php

class User
{
    private int $id;
    private string $email;
    private string $hashedPassword;

    public function __construct(int $id, string $email, string $hashedPassword)
    {
        $this->id = $id;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function verifyPassword(string $inputPassword): bool
    {
        return password_verify($inputPassword, $this->hashedPassword);
    }

    public static function hashPassword(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}