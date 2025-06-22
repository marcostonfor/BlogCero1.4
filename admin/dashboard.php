<?php
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
    <link rel="stylesheet" href="css/style.css">
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
            </div>
        </aside>
        <section id="contentForDashboard">
            <div id="home" class="tabcontent">
                <h3>Dashboard</h3>

            </div>

            <div id="socialMedia" class="tabcontent">
                <h3>Interfaz para administrar <br> iconos de redes sociales.</h3>
                <?php require_once __DIR__ . '/socialMedia/brand_icons.php'; ?>
            </div>

            <div id="editor" class="tabcontent">
                <h3>Redaccíon de artículos</h3>
                <?php require_once __DIR__ . '/editorParaArticulos/editor.php'; ?>'
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

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
</body>

</html>