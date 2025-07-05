<?php
session_start(); // Esencial para guardar mensajes entre páginas (flash messages).
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sistema de notificaciones para mostrar un mensaje de éxito/error después de una acción.
$flash_message = '';
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // El mensaje se usa una vez y se borra.
}

require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/../components/factoryForComponents.php';

$header = FactoryForComponents::renderComponents('header');
$footer = FactoryForComponents::renderComponents('footer');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.8.1/github-markdown-dark.css">
    <link rel="stylesheet" href="css/style.css">
    <!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/539486a65b.js" crossorigin="anonymous"></script> -->
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <style>
        /* Estilos para los mensajes de notificación (flash message) */
        .flash-message {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #e9e2d0;
            background-color: #3c444d;
            border-color: #4b545d;
        }
    </style>
    <script src="script.js"></script>
</head>

<body>
    <?php $header->pageComponents(); ?>
    <hr>
    <a href="<?php echo BASE_URL; ?>/admin/editorParaArticulos/factory/view_post.php">Página de
        posts</a>
    <section id="panel">
        <aside id="dashboardNavigation">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'home')" id="defaultOpen">Administracíon</button>
                <button class="tablinks" onclick="openTab(event, 'socialMedia')">Social Media icons</button>
                <button class="tablinks" onclick="openTab(event, 'editor')">Editor para artículos</button>
                <button class="tablinks" onclick="openTab(event, 'config')">Configuraciones</button>
                <button class="tablinks" onclick="openTab(event, 'subidaPaginas')">Subida de páginas</button>
                <button class="tablinks" onclick="openTab(event, 'subidaMedia')">Subida de media</button>
                <button class="tablinks" onclick="openTab(event, 'gestionPaginas')">Gestión de contenidos</button>
            </div>
        </aside>
        <section id="contentForDashboard">
            <!-- Contenedor para mostrar el mensaje de notificación -->
            <?php if ($flash_message): ?>
                <div class="flash-message"><?php echo $flash_message; ?></div>
            <?php endif; ?>

            <div id="home" class="tabcontent">
                <h3>Dashboard</h3>

            </div>

            <div id="socialMedia" class="tabcontent">
                <h3>Interfaz para administrar <br> iconos de redes sociales.</h3>
                <?php require_once __DIR__ . '/socialMedia/brand_icons.php'; ?>
            </div>

            <div id="editor" class="tabcontent">
                <h3>Redaccíon de artículos</h3>
                <?php require_once __DIR__ . '/editorParaArticulos/editor.php'; ?>
            </div>
            <div id="config" class="tabcontent">
                <h3>Configuracíon del sitio</h3>
                <?php require_once __DIR__ . '/configuracion/siteConfigIU.php'; ?>
            </div>
            <div id="subidaPaginas" class="tabcontent">
                <h3>Subida de contenidos</h3>
                <?php require_once __DIR__ . '/subirArchivos/subirArchivo.php'; ?>
            </div>
            <div id="subidaMedia" class="tabcontent">
                <h3>Subida de medios</h3>
                <?php require_once __DIR__ . '/subirMedia/subirMedia.php'; ?>
            </div>
            <div id="gestionPaginas" class="tabcontent">
                <h3>Gestión de contenidos</h3>
                <?php require_once __DIR__ . '/core/crearDirectorioYfichero.php'; ?>
            </div>
        </section>
    </section>
    <div id="footer">
        <?php $footer->pageComponents(); ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script type="module">
        import { SeleccionDetector } from '../dist/SeleccionDetector.js';

        document.addEventListener("DOMContentLoaded", () => {
            const archivos = document.querySelector(".archivos"); // selector por clase
            if (archivos) {
                new SeleccionDetector(".archivos"); // también con punto
            }
        });
    </script>

</body>

</html>