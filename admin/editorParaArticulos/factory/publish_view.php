<?php
require_once __DIR__ . '/../../../mdParser/Parsedown.php';

class Publish_view implements Post_publish_interface
{

    public function new_article(): void
    {
        date_default_timezone_set('Europe/Madrid'); // o tu zona real
        // echo "Hora actual del servidor: " . date('Y-m-d H:i:s');
        $postsDir = __DIR__ . '/../Published';
        if (!is_dir($postsDir)) {
            echo "<p>Error: la carpeta de publicaciones no existe.</p>";
            return;
        }
        // $archivos = array_filter(scandir($postsDir), fn($f) => strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'md');
        $archivos = array_filter(scandir($postsDir), fn($f) => strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'md');
        // Ordenar archivos por fecha de modificación (más recientes primero)
        usort($archivos, function ($a, $b) use ($postsDir) {
            return filemtime($postsDir . '/' . $b) - filemtime($postsDir . '/' . $a);
        });
        $parser = new Parsedown(); // Parser Markdown -> HTML
        // Número de posts por página
        $postsPorPagina = 5;

        // Página actual (por GET)
        $paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

        $archivos = array_filter(scandir($postsDir), fn($f) => strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'md');

        // Ordenar por fecha (más reciente primero)
        usort($archivos, function ($a, $b) use ($postsDir) {
            return filemtime($postsDir . '/' . $b) - filemtime($postsDir . '/' . $a);
        });

        // Calcular total de páginas
        $totalPosts = count($archivos);
        $totalPaginas = ceil($totalPosts / $postsPorPagina);

        // Obtener posts para la página actual
        $offset = ($paginaActual - 1) * $postsPorPagina;
        $postsPagina = array_slice($archivos, $offset, $postsPorPagina);


        echo "<section>\n";
        echo "<h2>Publicaciones en Markdown</h2>\n";

        if (empty($archivos)) {
            echo "<p>No hay publicaciones.</p>";
        } else {
            foreach ($postsPagina as $archivo) {
                $ruta = $postsDir . '/' . $archivo;
                $fechaMod = date('j F Y, g:i a', filemtime($ruta));
                $contenido = file_get_contents($ruta);
                $contenidoHtml = $parser->text($contenido);
                $archivoSafe = htmlspecialchars($archivo);

                echo <<<HTML
<article class="post">
    <div class="markdown-body">
        {$contenidoHtml}
    </div>
    <h5>{$archivoSafe}</h5>
    <h6>{$fechaMod}</h6>
</article>

HTML;
            }
        }

        // Mostrar paginación
        if ($totalPaginas > 1) {
            echo "<nav class='paginacion'>";
            if ($paginaActual > 1) {
                $anterior = $paginaActual - 1;
                echo "<small>";
                echo "<a href='?pagina=$anterior'>&laquo; Anterior</a> ";
                echo "</small>";
            }
            echo "<small>";
            echo " Página {$paginaActual} de {$totalPaginas} ";
            echo "</small>";
            if ($paginaActual < $totalPaginas) {
                $siguiente = $paginaActual + 1;
                echo "<small>";
                echo " <a href='?pagina=$siguiente'>Siguiente &raquo;</a>";
                echo "</small>";
            }
            echo "</nav>";
        }


        echo "</section>\n";
    }

}