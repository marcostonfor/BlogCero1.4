<?php
// Para mostrar el título actual, necesitamos leerlo de la base de datos.
// La lógica para GUARDAR el título está en siteConfig.php, como solicitaste.
// Usamos la constante ROOT_PATH (definida en router.php) para una ruta absoluta y fiable.
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

$titulo_actual = "Blog Cero";
try {
    $pdo = DatabaseSingleton::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = 'site_title'");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    if ($result !== false) {
        $titulo_actual = htmlspecialchars($result);
    }
} catch (PDOException $e) {
    // Si hay un error (ej. la tabla no existe), se muestra un mensaje en el campo.
    $titulo_actual = "Error al cargar título";
}
?>

<div class="container">
    <!-- El formulario ahora apunta al script de procesamiento dedicado -->
    <form action="configuracion/siteConfig.php" method="POST">
        <label for="inputTitulo" class="sr-only">Nuevo título:</label>
        <input type="text" id="inputTitulo" name="nuevo_titulo" value="<?php echo $titulo_actual; ?>" autocomplete="off">
        <button type="submit">Actualizar</button>
    </form>
</div>
