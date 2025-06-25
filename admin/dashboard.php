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
            <div id="gestionPaginas" class="tabcontent">
                <h3>Gestión de contenidos</h3>
                <?php require_once __DIR__ . '/core/crearDirectorioYfichero.php'; ?>
            </div>
        </section>
    </section>
    <script>
        // Función global para cambiar de pestaña, llamada por los botones.
        function openTab(evt, tabName) {
            // Ocultar todo el contenido de las pestañas
            const tabcontent = document.getElementsByClassName("tabcontent");
            for (let i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Quitar la clase "active" de todos los botones de pestaña
            const tablinks = document.getElementsByClassName("tablinks");
            for (let i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Mostrar la pestaña actual y añadir la clase "active" al botón
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Se ejecuta cuando el DOM está completamente cargado.
        document.addEventListener("DOMContentLoaded", function () {

            // Lógica para inicializar las pestañas
            function initTabs() {
                const hash = window.location.hash.substring(1);
                let buttonToClick;

                if (hash) {
                    // Busca un botón que corresponda al hash en la URL.
                    buttonToClick = document.querySelector(`.tablinks[onclick*="'${hash}'"]`);
                }

                // Si no se encuentra un botón para el hash (o no hay hash), usa el predeterminado.
                if (!buttonToClick) {
                    buttonToClick = document.getElementById("defaultOpen");
                }

                // Simula un clic en el botón para abrir la pestaña correcta.
                if (buttonToClick) {
                    buttonToClick.click();
                }
            }

            // Lógica para manejar los mensajes flash que se desvanecen
            function initFlashMessages() {
                const flash = document.querySelector(".flash-message");
                if (flash) {
                    setTimeout(() => {
                        flash.style.transition = "opacity 0.6s ease";
                        flash.style.opacity = 0;
                        // Espera a que termine la transición para eliminar el elemento.
                        setTimeout(() => flash.remove(), 600);
                    }, 5000); // 5 segundos
                }
            }

            // Lógica para los checkboxes de iconos de redes sociales
            function initSocialMediaCheckboxes() {
                // Usar un selector más específico para evitar conflictos
                const checkboxes = document.querySelectorAll('#socialMedia input[type="checkbox"]');
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const maxSeleccionados = 5;
                        const seleccionados = document.querySelectorAll('#socialMedia input[type="checkbox"]:checked').length;
                        if (seleccionados > maxSeleccionados) {
                            this.checked = false; // Desmarca el checkbox actual
                            alert('Solo puedes seleccionar un máximo de ' + maxSeleccionados + ' iconos.');
                        }
                    });
                });
            }

            // Inicializar funcionalidades
            initTabs();
            initFlashMessages();
            initSocialMediaCheckboxes();
        });
    </script>
</body>

</html>