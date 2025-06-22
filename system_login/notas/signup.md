# Perfecto, ¡ya tienes la mitad del camino hecho! Vamos ahora con la **parte del registro (signup)**, que completará tu sistema orientado a objetos y basado en patrones de diseño como `Entity`, `Repository`, y `Service`.

---

## 🎯 Objetivo

Crear un flujo **de registro de usuario** donde:

1. El formulario recibe email y contraseña.
2. Se valida que no exista un usuario con el mismo email.
3. Se hashea la contraseña.
4. Se guarda en la base de datos usando `UserRepository`.
5. El flujo de lógica lo gestiona un `RegisterService`.

---

## ✅ 1. Crear el `RegisterService.php`

Este servicio representa la lógica de negocio del proceso de registro:

```php
<?php
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Entity/User.php';

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

        // Guardar usuario
        $this->userRepository->save($user);

        return true;
    }
}
```

---

## ✅ 2. Crear `RegisterController.php`

Este controller gestiona el flujo entre el formulario y el `RegisterService`.

```php
<?php
require_once __DIR__ . '/../Service/RegisterService.php';
require_once __DIR__ . '/../Repository/UserRepository.php';

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
                header('Location: /login.php?registered=true');
                exit;
            } else {
                $message = 'Este email ya está registrado.';
            }
        }

        include __DIR__ . '/../views/register_form.php';
    }
}
```

---

## ✅ 3. Crear la vista `register_form.php`

```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/header.php'; ?>
    <h1>REGISTRO</h1>
    <span><small>O</small> <a href="/login.php">Iniciar sesión</a></span>

    <?php if (!empty($message)): ?>
        <p style="color:red"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="/signup.php" method="post">
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
```

---

## ✅ 4. Crear el `signup.php` principal

Este es el archivo público que se encarga de delegar al controlador.

```php
<?php
session_start();
require_once __DIR__ . '/app/Controller/RegisterController.php';

$controller = new RegisterController();
$controller->handleRequest($_POST);
```

---

## 🧱 Resumen de estructura recomendada

```
/app
  /Entity
    - User.php
  /Repository
    - UserRepository.php
  /Service
    - RegisterService.php
    - AuthService.php
  /Controller
    - RegisterController.php
    - LoginController.php
/views
  - login_form.php
  - register_form.php
/public
  - login.php
  - signup.php
```

---

¿Quieres que te dé los archivos `signup.php`, `RegisterController.php`, etc., juntos en un paquete organizado como árbol de carpetas y con código completo para copiar y pegar directamente?
