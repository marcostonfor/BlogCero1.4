<?php

/**
 * Genera un explorador de archivos HTML para gestionar el contenido de la carpeta MD.
 * Incluye formularios para eliminar elementos, con protecciones para carpetas críticas.
 *
 * @param string $directorio La ruta absoluta del directorio a escanear.
 * @param string $raiz La ruta absoluta del directorio raíz del proyecto (MD/).
 * @param string $rutaRelativa La ruta relativa actual desde la raíz.
 */
function generar_vista_gestion($directorio, $raiz, $rutaRelativa = ''): string
{
    $items = @scandir($directorio);
    if (!$items) {
        return ''; // No se puede leer o no es un directorio
    }

    $li_elements_html = ''; // Contendrá la cadena de <li> para este nivel

    $visibleItems = array_filter($items, function($item) {
        return $item !== '.' && $item !== '..' && $item[0] !== '.';
    });

    $rutasProtegidas = [
        $raiz . '/Subidasmd',
        $raiz . '/Media',
        $raiz . '/Media/imagenes',
        $raiz . '/Media/videos',
        $raiz . '/Media/audios'
    ];

    foreach ($visibleItems as $item) {
        $rutaAbsoluta = $directorio . '/' . $item;
        $rutaRelativaItem = $rutaRelativa ? $rutaRelativa . '/' . $item : $item;

        if (is_dir($rutaAbsoluta)) {
            // La llamada recursiva devuelve una cadena de elementos <li> para el subdirectorio
            $submenu_li_html = generar_vista_gestion($rutaAbsoluta, $raiz, $rutaRelativaItem);
            $esDirectorioProtegido = in_array($rutaAbsoluta, $rutasProtegidas, true);

            // Un directorio se muestra si está protegido O si tiene contenido
            if ($esDirectorioProtegido || !empty($submenu_li_html)) {
                $li_elements_html .= '<li>';
                $li_elements_html .= '<span>📁 ' . htmlspecialchars($item) . '</span>';
                $li_elements_html .= '<div class="acciones">';
                $li_elements_html .= '<form method="POST" action="' . BASE_URL . '/admin/core/procesar_contenido.php" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar ' . htmlspecialchars($item) . '?\');" style="display:inline;">';
                $li_elements_html .= '<input type="hidden" name="form_eliminar_contenido" value="1">';
                $li_elements_html .= '<input type="hidden" name="path" value="' . htmlspecialchars($rutaRelativa) . '">';
                $li_elements_html .= '<input type="hidden" name="nombre" value="' . htmlspecialchars($item) . '">';

                $mensajeProtegido = 'Este directorio está protegido y no se puede eliminar.';

                if ($esDirectorioProtegido) {
                    $li_elements_html .= '<button type="submit" class="btn-eliminar" disabled title="' . $mensajeProtegido . '">Eliminar 🗑️</button>';
                } else {
                    $li_elements_html .= '<button type="submit" class="btn-eliminar">Eliminar 🗑️</button>';
                }
                $li_elements_html .= '</form>';
                $li_elements_html .= '</div>';

                // Si el subdirectorio tiene contenido, se envuelve en su propia lista <ul>
                if (!empty($submenu_li_html)) {
                    $li_elements_html .= '<ul>' . $submenu_li_html . '</ul>';
                }

                $li_elements_html .= '</li>';
            }
        } else { // Es un archivo
            $li_elements_html .= '<li>';
            $li_elements_html .= '<span>📄 ' . htmlspecialchars($item) . '</span>';
            $li_elements_html .= '<div class="acciones">';
            $li_elements_html .= '<form method="POST" action="' . BASE_URL . '/admin/core/procesar_contenido.php" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar ' . htmlspecialchars($item) . '?\');" style="display:inline;">';
            $li_elements_html .= '<input type="hidden" name="form_eliminar_contenido" value="1">';
            $li_elements_html .= '<input type="hidden" name="path" value="' . htmlspecialchars($rutaRelativa) . '">';
            $li_elements_html .= '<input type="hidden" name="nombre" value="' . htmlspecialchars($item) . '">';
            $li_elements_html .= '<button type="submit" class="btn-eliminar">Eliminar 🗑️</button>';
            $li_elements_html .= '</form>';
            $li_elements_html .= '</div>';
            $li_elements_html .= '</li>';
        }
    }

    return $li_elements_html;
}

// Mostramos el explorador de archivos
$directorioRaizMD = realpath(__DIR__ . '/../../MD');
if ($directorioRaizMD) {
    $lista_li_html = generar_vista_gestion($directorioRaizMD, $directorioRaizMD);
    if (!empty($lista_li_html)) {
        echo '<ul class="explorador-gestion">' . $lista_li_html . '</ul>';
    }
}

?>
<hr>
<h4>Crear nuevo contenido</h4>
<!-- Formulario HTML -->
<form method="post" action="<?php echo BASE_URL; ?>/admin/core/procesar_contenido.php" id="formFornew">
    <input type="hidden" name="form_crear_contenido" value="1">
    <label>Ruta relativa (dentro de MD/):<br>
        <input type="text" name="path" placeholder="ej: docs/manual (opcional)">
    </label><br><br>

    <label>Nombre:<br>
        <input type="text" name="nombre" required>
    </label><br><br>

    <label>Tipo:<br>
        <select name="tipo" required>
            <option value="archivo">Archivo .md</option>
            <option value="carpeta">Carpeta</option>
        </select>
    </label><br><br>

    <button type="submit">Crear</button>
</form>

<style>
    .explorador-gestion {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        list-style: none;
        padding-left: 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background-color: #fdfdfd;
    }
    .explorador-gestion ul {
        list-style: none;
        padding-left: 25px;
        border-left: 1px dashed #ccc;
        margin-top: 5px;
    }
    .explorador-gestion li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        margin: 4px 0;
        border-radius: 4px;
        transition: background-color 0.2s ease-in-out;
    }
    .explorador-gestion li:hover {
        background-color: #f0f0f0;
    }
    .explorador-gestion li > span {
        font-weight: 500;
        color: #333;
        margin-right: 15px;
    }
    .explorador-gestion .acciones form {
        margin: 0;
    }
    .explorador-gestion .btn-eliminar {
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
        transition: background-color 0.2s, opacity 0.2s;
    }
    .explorador-gestion .btn-eliminar:not([disabled]) {
        background-color: #ff4d4d;
        color: white;
    }
    .explorador-gestion .btn-eliminar:hover:not([disabled]) {
        background-color: #cc0000;
    }
    .explorador-gestion .btn-eliminar:disabled {
        background-color: #e0e0e0;
        color: #999;
        cursor: not-allowed;
    }
    .explorador-gestion .carpeta-vacia {
        font-style: italic;
        color: #999;
        padding: 8px 12px;
        display: block;
    }
</style>