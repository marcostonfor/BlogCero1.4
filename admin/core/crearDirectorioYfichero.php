<?php
$raizMD = realpath(__DIR__ . '/../../MD');

$rutasProtegidas = [
    $raizMD . '/Subidasmd',
    $raizMD . '/Media',
    $raizMD . '/Media/imagenes',
    $raizMD . '/Media/videos',
    $raizMD . '/Media/audios'
];

function esCarpetaProtegida(string $ruta, array $rutasProtegidas): bool
{
    foreach ($rutasProtegidas as $protegida) {
        if (strpos($ruta, $protegida) === 0) {
            return true;
        }
    }
    return false;
}

function mostrarContenido(string $dir, string $raiz, array $rutasProtegidas, string $rutaRel = ''): string
{
    $items = @scandir($dir);
    if (!$items)
        return '';

    $html = '';
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || $item[0] === '.')
            continue;

        $rutaAbs = $dir . '/' . $item;
        $rutaRelPath = $rutaRel === '' ? $item : $rutaRel . '/' . $item;

        if (is_dir($rutaAbs)) {
            $esProtegida = esCarpetaProtegida($rutaAbs, $rutasProtegidas);
            $contenidoInt = mostrarContenido($rutaAbs, $raiz, $rutasProtegidas, $rutaRelPath);

            $html .= '<li class="padre-submenu">';
            $html .= '<span>📁 ' . htmlspecialchars($item) . '</span>';

            if (!$esProtegida) {
                $html .= '<form method="POST" action="' . BASE_URL . '/admin/core/procesar_contenido.php" onsubmit="return confirm(\'¿Eliminar carpeta ' . htmlspecialchars($item) . '?\');" style="display:inline-block;margin-left:10px;">';
                $html .= '<input type="hidden" name="form_eliminar_contenido" value="1">';
                $html .= '<input type="hidden" name="path" value="' . htmlspecialchars($rutaRel) . '">';
                $html .= '<input type="hidden" name="nombre" value="' . htmlspecialchars($item) . '">';
                $html .= '<button type="submit" class="btn-eliminar">Eliminar carpeta 🗑️</button>';
                $html .= '</form>';
            }

            if ($contenidoInt !== '') {
                $html .= '<ul class="submenu">' . $contenidoInt . '</ul>';
            }

            $html .= '</li>';
        } else {
            $html .= '<li>';
            $html .= '<span>📄 ' . htmlspecialchars($item) . '</span>';
            $html .= '<form method="POST" action="' . BASE_URL . '/admin/core/procesar_contenido.php" onsubmit="return confirm(\'¿Eliminar archivo ' . htmlspecialchars($item) . '?\');" style="display:inline-block;margin-left:10px;">';
            $html .= '<input type="hidden" name="form_eliminar_contenido" value="1">';
            $html .= '<input type="hidden" name="path" value="' . htmlspecialchars($rutaRel) . '">';
            $html .= '<input type="hidden" name="nombre" value="' . htmlspecialchars($item) . '">';
            $html .= '<button type="submit" class="btn-eliminar">Eliminar archivo 🗑️</button>';
            $html .= '</form>';
            $html .= '</li>';
        }
    }

    return $html;
}

if ($raizMD !== false) {
    echo '<ul class="explorador-gestion">' . mostrarContenido($raizMD, $raizMD, $rutasProtegidas) . '</ul>';
}
?>

<hr>
<h4>Crear nuevo contenido</h4>
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
        padding-left: 15px;
        border-left: 1px dashed #ccc;
        margin-top: 5px;
        margin-left: 1rem;
    }

    .explorador-gestion li {
        /* display: flex;
        justify-content: flex-start;
        align-items: center; */
        padding: 8px 12px;
        margin: 4px 0;
        border-radius: 4px;
        transition: background-color 0.2s ease-in-out;
    }

    .explorador-gestion li:hover {
        background-color: #f0f0f0;
    }

    .explorador-gestion ul.submenu {
        display: none;
    }

    .explorador-gestion li.padre-submenu:hover > ul.submenu {
        display: block;
    }
    .explorador-gestion li>span {
        font-weight: 500;
        color: #333;
    }

    .explorador-gestion form {
        margin-left: auto;
        display: inline-block;
    }

    .btn-eliminar {
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
        transition: background-color 0.2s, opacity 0.2s;
        background-color: #ff4d4d;
        color: white;
    }

    .btn-eliminar:hover {
        background-color: #cc0000;
    }
</style>