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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/539486a65b.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
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
</head>

<body>
    <?php $header->pageComponents(); ?>
    <hr>
    <section id="panel">
        <aside id="dashboardNavigation">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'home')" id="defaultOpen">Administracíon</button>
                <button class="tablinks" onclick="openTab(event, 'socialMedia')">Social Media icons</button>
                <button class="tablinks" onclick="openTab(event, 'editor')">Editor para artículos</button>
                <button class="tablinks" onclick="openTab(event, 'config')">Configuraciones</button>
                <button class="tablinks" onclick="openTab(event, 'subidaPaginas')">Subida de páginas</button>
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
        </section>
    </section>
    <script>
        function openTab(evt, activeTab) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(activeTab).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Al cargar la página, revisa si hay un "hash" en la URL para abrir una pestaña específica.
        document.addEventListener("DOMContentLoaded", function () {
            const hash = window.location.hash.substring(1);
            let buttonToClick;

            if (hash) {
                // Busca un botón que abra la pestaña con el ID del hash.
                buttonToClick = document.querySelector(`.tablinks[onclick*="'${hash}'"]`);
            }

            // Si no se encontró un botón para el hash (o no había hash), usa el botón por defecto.
            if (!buttonToClick) {
                buttonToClick = document.getElementById("defaultOpen");
            }

            // Haz clic en el botón determinado.
            if (buttonToClick) {
                buttonToClick.click();
            }
        });

        // Cierra automáticamente el mensaje flash después de 5 segundos
        document.addEventListener("DOMContentLoaded", function () {
            const flash = document.querySelector(".flash-message");
            if (flash) {
                setTimeout(() => {
                    flash.style.transition = "opacity 0.6s ease";
                    flash.style.opacity = 0;
                    setTimeout(() => flash.remove(), 600); // lo quita del DOM después de desvanecerse
                }, 5000); // 5 segundos
            }
        });
    </script>
</body>

</html>