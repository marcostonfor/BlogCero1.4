<?php
/**
 * Función recursiva para escanear un directorio y construir un árbol de archivos en HTML.
 *
 * @param string $dir La ruta del directorio a escanear.
 * @param string $basePath La ruta base para construir las rutas relativas de los archivos.
 * @return string El HTML generado con la lista de archivos y carpetas.
 */
function construirArbolDeArchivos($dir, $basePath = '')
{
    // Ignorar directorios que no existen o no son legibles.
    if (!is_dir($dir) || !is_readable($dir)) {
        return '<ul><li><span class="error">Error: No se puede leer el directorio ' . htmlspecialchars($dir) . '</span></li></ul>';
    }

    $html = '<ul>';
    // Escanea el contenido del directorio.
    $items = scandir($dir);

    foreach ($items as $item) {
        // Ignorar los directorios '.' y '..'
        if ($item == '.' || $item == '..') {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $item;
        // Construye la ruta relativa que se usará en el frontend.
        $relativePath = $basePath . $item;

        if (is_dir($path)) {
            // Si es un directorio, lo muestra y llama a la función de nuevo (recursividad).
            $html .= '<li><span class="folder" data-path="' . htmlspecialchars($relativePath) . '/">' . htmlspecialchars($item) . '</span>';
            $html .= construirArbolDeArchivos($path, $relativePath . '/');
            $html .= '</li>';
        } else {
            // Si es un archivo, simplemente lo muestra.
            $html .= '<li><span class="file" data-path="' . htmlspecialchars($relativePath) . '">' . htmlspecialchars($item) . '</span></li>';
        }
    }

    $html .= '</ul>';
    return $html;
}

// Define el directorio raíz a escanear. En este caso, la carpeta 'MD' que está al mismo nivel que 'copiador'.
$directorioRaiz = realpath(__DIR__ . '/../MD');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selector de Rutas de Archivo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="explorer-panel">
            <h1>Explorador de Archivos</h1>
            <p>Haz clic en un archivo o carpeta para copiar su ruta al destino seleccionado.</p>
            <div id="file-explorer">
                <?php
                if ($directorioRaiz) {
                    echo construirArbolDeArchivos($directorioRaiz);
                } else {
                    echo '<ul><li><span class="error">El directorio base "MD" no se encuentra.</span></li></ul>';
                }
                ?>
            </div>
        </div>

        <div class="input-panel">
            <h2>Campos de Destino</h2>
            <p>Selecciona dónde quieres copiar la ruta:</p>

            <div class="input-group">
                <input type="radio" id="target1" name="target_input" value="input1" checked>
                <label for="target1">Ruta para Artículo Principal:</label>
                <input type="text" id="input1" class="output-input" placeholder="La ruta seleccionada aparecerá aquí...">
            </div>

            <div class="input-group">
                <input type="radio" id="target2" name="target_input" value="input2">
                <label for="target2">Ruta para Imagen de Cabecera:</label>
                <input type="text" id="input2" class="output-input" placeholder="La ruta seleccionada aparecerá aquí...">
            </div>

            <div class="input-group">
                <input type="radio" id="target3" name="target_input" value="input3">
                <label for="target3">Ruta para Documento Relacionado:</label>
                <input type="text" id="input3" class="output-input" placeholder="La ruta seleccionada aparecerá aquí...">
            </div>
        </div>
    </div>

    <script src="script.js"></script>

</body>
</html>