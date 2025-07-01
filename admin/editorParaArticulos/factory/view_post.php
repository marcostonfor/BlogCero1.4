<?php
session_start();
require_once __DIR__ . '/article_component.php';
require_once __DIR__ . '/../../../mdParser/Parsedown.php';
require_once __DIR__ . '/../../../components/factoryForComponents.php';
require_once __DIR__ . '/../../../router.php';

$header = FactoryForComponents::renderComponents('header');
$footer = FactoryForComponents::renderComponents('footer');

$parser = new Parsedown();

if (isset($_GET['post'])) {
    $requested = basename($_GET['post']); // sanitiza
    $filepath = realpath(__DIR__ . "/../Published/$requested.md");

    if ($filepath && file_exists($filepath)) {
        $content = file_get_contents($filepath);
    } else {
        $content = "El artículo no existe.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.8.1/github-markdown-dark.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/frijole');

        body {
            font-family: sans-serif;
            padding: 20px;
            background: hsl(34, 96.50%, 77.50%);
        }

        #section_post {
            width: 65%;
            margin: 1rem auto;
        }

        .post {
            width: 100%;
            margin: 0 auto;
            background-color: darkcyan;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 5px #ccc;
        }

        h2 {
            margin-top: 0;
        }

        .markdown-body {
            padding: 15px;
        }

        .prueba_grid {

            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .paginacion {
            width: fit-content;
            margin: 0.5rem auto;
            padding: 0.2rem 0.3rem;
            border: 0.1rem solid black;
            background-color: #f0d;
            color: black;
            text-shadow: 0 0 20px aliceblue;
            font-family: 'Frijole', sans-serif;
        }

        .paginacion a {
            color: dodgerblue;
        }

        .paginacion small {
            background-color: #ffe !important;
        }

        #main {
            display: flex;
            justify-content: space-evenly;
            align-items: baseline;
        }

        #link_list {
            position: relative;
            width: fit-content;
            height: 18rem;
            padding: 0.5rem 1rem;
            margin: 1rem auto;
            border: 0;
            border-radius: 0.3rem;
            box-shadow: 0 0 12px blanchedalmond;
        }

        #link_list a {
            text-decoration: none;
        }

        #link_list ul {
            list-style-type: none;
        }

        .menu-paginator {
            position: absolute;
            left: 0.4rem;
            bottom: 0.4rem;
        }

        #calendar {
            width: 30%;
            height: fit-content;
            padding: 0 1rem;
        }
    </style>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.8.1/github-markdown.min.css">

</head>

<body>
    <?php $header->pageComponents(); ?>
    <main id="subir">
    <div id="main">
        <section id="section_post">
            <?php
            if (isset($content)) {
                echo "<article class='markdown-body'>";
                $backLink = isset($_GET['pagina']) ? "?pagina=" . intval($_GET['pagina']) : '?';
                echo "<a href='$backLink'>&larr; Volver a los artículos</a><hr>";
                // echo "<p><a class='volver' href='?'>&larr; Volver a los artículos</a></p>";
                // echo nl2br(htmlspecialchars($content)); // o usa un parser si lo prefieres
                $view = $parser->text($content);
                echo $view;
                echo "</article>";
            } else {
                $publisher = Article_component::create('view');
                echo $publisher->new_article();
            }
            ?>
        </section>
        <aside id="post_publicados">

            <?php
            $files = glob("../Published/*.md");
            $linksPerPage = 5; // Número de enlaces por página en el menú lateral
            $currentPage = isset($_GET['menu_page']) ? max(1, intval($_GET['menu_page'])) : 1;

            // Calcular el índice inicial para el array_slice
            $startIndex = ($currentPage - 1) * $linksPerPage;

            // Obtener solo los archivos para la página actual del menú
            $currentFiles = array_slice($files, $startIndex, $linksPerPage);

            // Mostrar los enlaces para la página actual del menú
            if (!empty($currentFiles)) {
                echo "<aside id='link_list'>";
                echo "<h5>Lista de POST's</h5>";
                echo "<ul>";
                foreach ($currentFiles as $file) {
                    $fechaMod = date('j F Y, g:i a', filemtime($file));
                    echo "<li>";
                    $filename = basename($file, ".md");
                    echo "<h6><a href='?post=" . urlencode($filename) . "'>" . $filename . "<small> " . $fechaMod . "</small></a></h6>";
                    echo "</li>";
                }
                echo "</ul>";

                // Calcular el número total de páginas para el menú
                $totalPages = ceil(count($files) / $linksPerPage);

                // Mostrar enlaces de paginación para el menú
                echo "<div class='menu-paginator'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?menu_page=$i'>$i</a> ";
                }
                echo "</div>";
                echo "</aside>";
            } else {
                echo "<aside><p>No hay más archivos.</p></aside>";
            }
            ?>            
        </aside>
    </div>
    </main>
    <div id="footer">
        <?php $footer->pageComponents(); ?>
    </div>
</body>

</html>