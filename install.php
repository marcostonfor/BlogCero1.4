<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$config_file = __DIR__ . '/config.php';
$template_file = __DIR__ . '/config.template.php';
$schema_file = __DIR__ . '/database/blog_cero1.3.sql';
$message = '';
$message_type = '';

// 1. Verificar si ya está instalado
if (file_exists($config_file)) {
    die('¡El proyecto ya está configurado! Si quieres reinstalar, elimina el archivo <strong>config.php</strong> y actualiza esta página.');
}

// 2. Verificar si la plantilla existe
if (!file_exists($template_file)) {
    die('Error: No se encuentra el archivo de plantilla <strong>config.template.php</strong>. Asegúrate de que exista en la raíz del proyecto.');
}

// Nuevo: Verificar si el archivo SQL existe
if (!file_exists($schema_file)) {
    die('Error: No se encuentra el archivo de estructura de la base de datos <strong>database/schema.sql</strong>.');
}

// 3. Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';

    // Cargar contenido de la plantilla
    $template_content = file_get_contents($template_file);

    // Reemplazar los marcadores de posición
    $config_content = str_replace(
        ['%%DB_HOST%%', '%%DB_NAME%%', '%%DB_USER%%', '%%DB_PASS%%'],
        [$db_host, $db_name, $db_user, $db_pass],
        $template_content
    );

    // Escribir el nuevo archivo de configuración y verificar si tuvo éxito
    // @ suprime la advertencia de PHP para que podamos manejar el error nosotros mismos.
    if (@file_put_contents($config_file, $config_content) === false) {
        $message = 'Error de permisos: No se pudo escribir el archivo <strong>config.php</strong>. <br>Por favor, verifica los permisos de la carpeta del proyecto en el servidor.';
        $message_type = 'error';
    } else {
        // 4. Intentar conectar a la base de datos para verificar las credenciales
        try {
            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
            $pdo = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // 5. Ejecutar el script SQL para crear las tablas
            $sql_script = file_get_contents($schema_file);
            if ($sql_script === false) {
                throw new Exception("No se pudo leer el archivo schema.sql.");
            }
            
            // FORMA ROBUSTA DE EJECUTAR EL SCRIPT:
            // Eliminar comentarios y dividir el script en sentencias individuales por el punto y coma.
            $sql_script = preg_replace('/--.*$/m', '', $sql_script); 
            $sql_script = preg_replace('!/\*.*?\*/!s', '', $sql_script); //// Elimina comentarios SQL
            $statements = array_filter(array_map('trim', explode(';', $sql_script)));

            foreach ($statements as $statement) {
                $pdo->exec($statement);
            }

            $message = '¡Instalación completada con éxito! El archivo <strong>config.php</strong> ha sido creado y las tablas de la base de datos han sido importadas. <br><strong>Por seguridad, elimina este archivo (install.php) ahora.</strong>';
            $message_type = 'success';

        } catch (Exception $e) { // Capturar PDOException y Exception general
            // Si la conexión o la importación de SQL fallan, eliminar el config.php creado y mostrar error
            unlink($config_file);
            $message = 'Error durante la instalación: <br><small>' . htmlspecialchars($e->getMessage()) . '</small><br>Por favor, verifica los datos y los permisos e inténtalo de nuevo.';
            $message_type = 'error';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación del Proyecto</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h1 {
            color: #111;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <h1>Asistente de Instalación</h1>

    <?php if ($message && $message_type === 'success'): ?>
        <div class="message success"><?= $message ?></div>
    <?php else: ?>
        <?php if ($message && $message_type === 'error'): ?>
            <div class="message error"><?= $message ?></div>
        <?php endif; ?>

        <p>Por favor, introduce los datos de tu base de datos. Estos se guardarán en el archivo <code>config.php</code>.</p>

        <form action="install.php" method="POST">
            <div>
                <label for="db_host">Servidor de Base de Datos:</label>
                <input type="text" id="db_host" name="db_host"
                    value="<?= htmlspecialchars($_SERVER['SERVER_NAME'] ?? 'localhost') ?>" required>
                <small>Normalmente es 'localhost' o '127.0.0.1'.</small>
            </div>

            <div>
                <label for="db_name">Nombre de la Base de Datos:</label>
                <input type="text" id="db_name" name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>" required>
            </div>

            <div>
                <label for="db_user">Usuario de la Base de Datos:</label>
                <input type="text" id="db_user" name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" required>
            </div>

            <div>
                <label for="db_pass">Contraseña:</label>
                <input type="password" id="db_pass" name="db_pass">
            </div>

            <input type="submit" value="Instalar">
        </form>
    <?php endif; ?>

</body>

</html>