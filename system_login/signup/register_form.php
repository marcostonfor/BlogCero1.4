<!DOCTYPE html>
<html lang="ca-ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de registro</title>
    <link rel="stylesheet" href="../assets/css/estilosLogins.css">
</head>

<body>
    <?php

    require_once __DIR__ . '/../partials/header.php'; ?>
    <?php if (!empty($message)): ?>
        <p>
            <?php echo $message ?>
        </p>
    <?php endif; ?>
    <div class="login_align_center">
    <h1>Registro</h1>
    <span><small>OR</small> <a href="../login/login.php">Login</a></span>
    </div>
    <form action="signup.php" method="post" id="singup">
        <label for="email">Campo e-Mail</label>
        <input type="email" name="email" id="email" placeholder="introduzca su e-Mail">
        <label for="password">Campo contraseña</label>
        <input type="password" name="password" id="password" placeholder="introduzca su contraseña">
        <label for="passwordBis">Campo contraseña</label>
        <input type="password" name="passwordBis" id="passwordBis" placeholder="repita su contraseña">
        <fieldset>
            <label class="btnsave" for="btnsave">Botón de guardar<br>&nbsp;&nbsp;Procesar Login</label>
            <input type="submit" value="Login">
            <label class="btnclean" for="btnclean">Botón de reset<br>&nbsp;&nbsp;Limpiar el formulario</label>
            <input type="reset" value="Clear login">
        </fieldset>
    </form>
</body>

</html>