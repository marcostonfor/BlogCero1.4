# Excelente pregunta. Vamos a desglosar claramente **qué son** y **cómo preparar** `UserRepository` y `AuthService` en tu sistema orientado a objetos y con patrones de diseño. Te lo explico paso a paso, como si estuviéramos estructurando un mini-framework de login limpio en PHP.

---

## 📁 1. ¿Qué es `UserRepository`?

**`UserRepository`** es una clase que implementa el **patrón Repository**, y su objetivo es **aislar la lógica de acceso a los datos del resto de la aplicación**. Es decir:

* Se encarga de leer o escribir `User` desde/hacia la base de datos.
* Se comunica con PDO, pero no con formularios ni lógica de negocio.

### 📦 Estructura esperada

```php
<?php
require_once __DIR__ . '/../Database/DatabaseSingleton.php';
require_once __DIR__ . '/../Entity/User.php';

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
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                (int)$row['id'],
                $row['email'],
                $row['password']
            );
        }

        return null;
    }

    public function save(User $user): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $stmt->execute([
            'email' => $user->getEmail(),
            'password' => $user->getHashedPassword()
        ]);
    }
}
```

---

## 🔐 2. ¿Qué es `AuthService`?

**`AuthService`** implementa el patrón **Service Layer**. Su función es **contener la lógica de negocio del login**, es decir:

* Saber cómo autenticar a un usuario.
* Saber cuándo iniciar una sesión.
* Validar contraseñas usando la entidad `User`.

### 📦 Estructura recomendada

```php
<?php
require_once __DIR__ . '/../Repository/UserRepository.php';

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

    public function logout(): void
    {
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}
```

---

## 👤 3. ¿Y `User.php`?

Aquí está, más completa, para integrarse bien con `UserRepository` y `AuthService`:

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

## 🧪 ¿Cómo usarlo en `LoginController.php`?

```php
<?php
require_once __DIR__ . '/../Service/AuthService.php';
require_once __DIR__ . '/../Repository/UserRepository.php';

class LoginController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService(new UserRepository());
    }

    public function handleRequest(array $post): void
    {
        $message = '';
        if (!empty($post['email']) && !empty($post['password'])) {
            if ($this->auth->login($post['email'], $post['password'])) {
                header('Location: /index.php');
                exit;
            } else {
                $message = 'Credenciales incorrectas';
            }
        }

        include __DIR__ . '/../views/login_form.php';
    }
}
```

---

## 🎁 ¿Quieres que te lo prepare todo junto en estructura de carpetas para copiar directamente?

Puedo organizarte:

```
/app
  /Database
    - DatabaseSingleton.php
  /Entity
    - User.php
  /Repository
    - UserRepository.php
  /Service
    - AuthService.php
  /Controller
    - LoginController.php
/views
  - login_form.php
/public
  - login.php
```

¿Te gustaría eso? ¿O prefieres avanzar tú mismo e ir puliendo parte por parte?
