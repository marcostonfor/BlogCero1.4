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

    $carpetasAIgnorar = ['Subidasmd', 'Media'];

    foreach ($items as $item) {
        if (
            strpos($item, '.') === 0 ||
            ($directorio === $GLOBALS['baseDir'] && in_array($item, $carpetasAIgnorar))
        ) {
            continue;
        }

        $rutaAbsoluta = $directorio . '/' . $item;
        $rutaRelativaCompleta = ltrim($rutaRelativa . '/' . $item, '/');

        if (is_dir($rutaAbsoluta)) {
            // Ocultar prefijo numérico si existe
            $nombreVisual = preg_replace('/^\d{2}-/', '', $item);
            $html .= "<li>📁 <strong>$nombreVisual</strong>";
            $html .= generarMenuRecursivo($rutaAbsoluta, $rutaRelativaCompleta, true);
            $html .= "</li>";
        } elseif (is_file($rutaAbsoluta)) {
            if (preg_match('/\.md$/i', $item)) {
                $url = 'usePreviewer.php?md=' . urlencode($rutaRelativaCompleta);
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