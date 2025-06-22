<?php
// Obtener conexión a la base de datos
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

try {
    $pdo = DatabaseSingleton::getInstance()->getConnection();
    $stmt = $pdo->prepare("
        SELECT config_key, config_value 
        FROM site_config 
        WHERE config_key IN ('menu_home', 'menu_articles_main', 'menu_articles_sub', 'menu_about')
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $menu_home = $results['menu_home'] ?? 'Inicio';
    $menu_articles_main = $results['menu_articles_main'] ?? 'Página de blog';
    $menu_articles_sub = $results['menu_articles_sub'] ?? 'tu contenido';
    $menu_about = $results['menu_about'] ?? 'Sobre mi:';

} catch (PDOException $e) {
    $menu_home = 'Inicio';
    $menu_articles_main = 'Página de blog';
    $menu_articles_sub = 'tu contenido';
    $menu_about = 'Sobre mi:';
}

?>

<ul>
    <li><a href="<?php echo BASE_URL; ?>/public/home.php"
            class="menuBlogLink"><?php echo htmlspecialchars($menu_home); ?></a></li>
    <li><a href="<?php echo BASE_URL; ?>/mdParser/usePreviewer.php"
            class="menuBlogLink"><strong><?php echo htmlspecialchars($menu_articles_main); ?></strong>
            <br>
            <small><?php echo htmlspecialchars($menu_articles_sub); ?></small></a></li>
    <li><a href="<?php echo BASE_URL; ?>/public/about.php"
            class="menuBlogLink"><?php echo htmlspecialchars($menu_about); ?></a></li>
</ul>
<link href="https://fonts.cdnfonts.com/css/frijole" rel="stylesheet">
<style>
    #navigationToolbar {
        position: relative;
        width: 100%;
        height: auto;
        margin: 0.5rem auto;
        background-color: #006080;
    }

    #navigationToolbar nav ul {
        list-style-type: none;
        display: flex;
        justify-content: stretch;
        align-items: baseline;
        gap: 0.5rem;
        font-family: 'Frijole', sans-serif;
    }

    #navigationToolbar nav ul li {
        text-align: center;
    }

    #navigationToolbar nav ul li a {
        color: #c0c0c0;
        text-decoration: none;
    }

    #navigationToolbar nav ul li a strong {
        padding: 0.03125rem 0.0625rem;
        background-color: #808080;
        border-radius: 0.1250rem;
    }

    #navigationToolbar nav ul li a small {
        display: block;
        padding: 0.0625rem;
        background-color: #e6e6e6;
        margin-top: 0.5em;
    }
</style>