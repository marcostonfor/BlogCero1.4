# Muy bien visto. En efecto, si no has definido el método `getHashedPassword()` en tu clase `User`, pero tu repositorio lo está usando para guardar un nuevo usuario (por ejemplo, al registrar), entonces causará un **error fatal**.

---

## ✅ Solución: Añadir `getHashedPassword()` a tu clase `User`

Este método debe devolver el **password ya hasheado**, que normalmente ya viene así desde la base de datos (en el login), o lo hasheas tú mismo (en el registro).

Aquí tienes una versión corregida y completa de la clase `User`:

```php
<?php
class User
{
    private int $id;
    private string $email;
    private string $hashedPassword;

    public function __construct(int $id = 0, string $email, string $hashedPassword)
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

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    public static function hashPassword(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}
```

---

## 🔁 ¿Dónde usarías esto?

### En el registro (signup):

```php
$email = $_POST['email'];
$password = $_POST['password'];
$hashed = User::hashPassword($password);

$newUser = new User(0, $email, $hashed);
$userRepo->save($newUser);
```

---

### En el login:

```php
$user = $userRepo->findByEmail($email);
if ($user && $user->verifyPassword($inputPassword)) {
    // login OK
}
```

---

¿Te gustaría que prepare el código completo del sistema `signup.php` siguiendo este mismo estilo orientado a objetos?
