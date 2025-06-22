<?php
/**
 * Carpeta raíz donde están los .md
 * archivos .md son la base de las
 * publicacíones y páginas del blog
 * @var mixed
 */
$baseDir = __DIR__ . '/../MD'; 

/**
 * generarMenuRecursivo
 *
 * @param  mixed $directorio
 * @param  mixed $rutaRelativa
 * @param  mixed $isSubmenu
 * @return void
 */
function generarMenuRecursivo($directorio, $rutaRelativa = '', $isSubmenu = false): string
{
    $ulClass = $isSubmenu ? ' class="submenu"' : '';
    $html = "<ul$ulClass>";
    $items = scandir($directorio);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || ($item === 'Subidasmd' && $directorio === $GLOBALS['baseDir'])) {
            continue;
        }
        $rutaAbsoluta = $directorio . '/' . $item;
        $rutaRelativaCompleta = ltrim($rutaRelativa . '/' . $item, '/');

        if (is_dir($rutaAbsoluta)) {
            $html .= "<li><strong>$item</strong>"; // El nombre del directorio
            $html .= generarMenuRecursivo($rutaAbsoluta, $rutaRelativaCompleta, true); // Llamada recursiva para el submenú
            $html .= "</li>";
        } elseif (is_file($rutaAbsoluta)) {
             if (preg_match('/\.md$/i', $item)) {
                 $url = 'usePreviewer.php?md=' . urlencode($rutaRelativaCompleta);
 
                 // Intentar leer el metadato 'Title:' del archivo.
                 $contenido = @file($rutaAbsoluta);
                 $titulo = null;
                 if ($contenido) {
                     foreach ($contenido as $linea) {
                         if (stripos(trim($linea), 'title:') === 0) {
                             $titulo = trim(substr(trim($linea), strlen('title:')));
                             break;
                         }
                     }
                 }
                 // El texto del enlace es el título si existe, o "Sin título" si no.
                 $linkText = !empty($titulo) ? $titulo : 'Sin título';
                 $html .= "<li><a href=\"$url\">$linkText</a></li>";
             } else {
                 $url = '?ruta=' . urlencode($rutaRelativaCompleta);
                 $html .= "<li><a href=\"$url\">$item</a></li>";
             }
        }
    }
    $html .= "</ul>";
    return $html;
}

echo generarMenuRecursivo($baseDir);
?>

<style>
    #navigation nav ul .submenu {
        display: none;
    }

    #navigation nav ul li:hover .submenu {
        display: block;
    }
</style>