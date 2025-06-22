<!DOCTYPE html>
<html lang="ca-ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de acceso</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php

    require_once __DIR__ . '/../partials/header.php'; ?>
    <h1>LOGIN</h1>
    <span><small>OR</small> <a href="../signup/signup.php">Registro</a></span>

    <?php if (!empty($message)): ?>
        <p>
            <?php echo $message ?>
        </p>
    <?php endif; ?>

    <form action="login.php" method="post" id="login">
        <label for="email">Campo e-Mail</label>
        <input type="email" name="email" id="email" placeholder="introduzca su e-Mail">
        <label for="password">Campo contraseña</label>
        <input type="password" name="password" id="password" placeholder="introduzca su contraseña">
        <fieldset>
            <label class="btnsave" for="btnsave">Botón de guardar<br>&nbsp;&nbsp;Procesar Login</label>
            <input type="submit" value="Login">
            <label class="btnclean" for="btnclean">Botón de reset<br>&nbsp;&nbsp;Limpiar el formulario</label>
            <input type="reset" value="Clear login">
        </fieldset>
    </form>
</body>

</html>