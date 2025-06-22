<?php
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

$titulo_actual = "Blog Cero";
$menu_items = [
    'menu_home' => 'Inicio',
    'menu_articles' => 'Artículos',
    'menu_about' => 'Sobre mi:'
];

try {
    $pdo = DatabaseSingleton::getInstance()->getConnection();

    // Obtener título guardado
    $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = 'site_title'");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    if ($result !== false) {
        $titulo_actual = htmlspecialchars($result);
    }

    // Obtener textos del menú guardados
    foreach ($menu_items as $key => &$value) {
        $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = :key");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetchColumn();
        if ($result !== false) {
            $value = htmlspecialchars($result);
        }
    }

} catch (PDOException $e) {
    // Si hay error, deja los valores por defecto
}
?>

<div class="container">
    <!-- Un único formulario para todos los campos -->
    <form action="configuracion/siteConfig.php" method="POST">
        <label for="inputTitulo">Título del sitio:</label><br>
        <input type="text" id="inputTitulo" name="nuevo_titulo" value="<?php echo $titulo_actual; ?>"
            autocomplete="off"><br><br>

        <label for="menu_home">Texto para "Inicio":</label><br>
        <input type="text" id="menu_home" name="menu_home" value="<?php echo $menu_items['menu_home']; ?>"><br><br>


        <label for="menu_articles_main">Texto principal (negrita):</label><br>
        <input type="text" name="menu_articles_main" id="menu_articles_main"
            value="<?php echo htmlspecialchars($menu_articles_main ?? 'Página de blog'); ?>">

        <label for="menu_articles_sub">Texto secundario (abajo):</label><br>
        <input type="text" name="menu_articles_sub" id="menu_articles_sub"
            value="<?php echo htmlspecialchars($menu_articles_sub ?? 'tu contenido'); ?>">

        <label for="menu_about">Texto para sobre mi:</label><br>
        <input type="text" id="menu_about" name="menu_about" value="<?php echo $menu_items['menu_about']; ?>"><br><br>

        <button type="submit">Actualizar configuración</button>
    </form>
</div>