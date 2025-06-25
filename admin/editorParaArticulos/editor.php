<?php
// editor.php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../mdParser/Parsedown.php';
$draftDir = __DIR__ . '/Draft';
$publishedDir = __DIR__ . '/Published'; // Estandarizamos el nombre de la carpeta

$drafts = array_filter(scandir($draftDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'md');
$published = array_filter(scandir($publishedDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'md');

// Asegurarse de que el directorio exista
if (!is_dir($draftDir)) {
    mkdir($draftDir, 0777, true);
}

$contenido = '';
$nombreArchivoCompleto = ''; // ej: 'Draft/mi-post.md'
$nombreArchivoBase = '';     // ej: 'mi-post.md'
$rutaArchivoOrigen = '';     // ej: 'Draft'

if (isset($_GET['archivo']) && !empty($_GET['archivo'])) {
    $nombreArchivoCompleto = $_GET['archivo'];
    $nombreArchivoBase = basename($nombreArchivoCompleto);
    $rutaArchivoOrigen = dirname($nombreArchivoCompleto);

    // Medida de seguridad: asegurar que la ruta sea una de las permitidas.
    if (in_array($rutaArchivoOrigen, ['Draft', 'Published'])) { // <-- Changed to 'posts' here
        $rutaAbsoluta = __DIR__ . '/' . $nombreArchivoCompleto;
        if (file_exists($rutaAbsoluta)) {
            $contenido = file_get_contents($rutaAbsoluta);
        }
    } else {
        // Si la ruta no es válida, se resetea para no cargar nada.
        $nombreArchivoCompleto = '';
    }
}
?>
<style>
    /* Estilos que antes estaban en editor.php */
    #editor {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        font-family: sans-serif;
        padding: 20px;
    }

    #markdownForm {
        width: 48%;
    }

    textarea {
        width: 100%;
        height: 400px;
    }

    #preview {
        width: 20rem;
        height: 540px;
        border: 1px solid #ccc;
        padding: 10px;
        overflow-y: scroll;
    }

    input[type="text"] {
        width: 100%;
        padding: 5px;
    }

    select {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
    }

    .linkPreview {
        width: fit-content;
        padding: 0.5rem 1rem;
        margin: 0.5rem 0;
    }

    .linkPreview a {
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: green;
        background-color: yellow;
        border-radius: 0.3rem;
    }

    #btngroup {
        margin: 0 auto;
        margin-top: 0.5rem;
        padding: 0.3rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.3rem;
        border: 0;
    }

    #btngroup button {
        padding: 0.3rem 0.5rem;
    }

    button[type="submit"]:nth-child(1) {
        background-color: dodgerblue;
    }

    button[type="submit"]:last-child {
        background-color: darkolivegreen;
    }

    button[type="reset"] {
        background-color: #b7610b;
    }
</style>
<!-- Este archivo ahora es un componente, no una página completa -->
<h1>Editor Markdown</h1>
<section id="editor">
    <form id="markdownForm" method="POST" action="<?php echo BASE_URL; ?>/admin/editorParaArticulos/guardar.php">
        <h2>Crear o editar archivo Markdown</h2>

        <label>Seleccionar archivo existente:</label>
        <select onchange="if (this.value) window.location.href = this.value;">
            <option value="">-- Selecciona un archivo --</option>

            <optgroup label="Borradores">
                <?php foreach ($drafts as $archivo): ?>
                    <option value="?archivo=<?= urlencode('Draft/' . $archivo) ?>" <?= $nombreArchivoCompleto === 'Draft/' . $archivo ? 'selected' : '' ?>>
                        <?= htmlspecialchars($archivo) ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>

            <optgroup label="Publicados">
                <?php foreach ($published as $archivo): ?>
                    <option value="?archivo=<?= urlencode('Published/' . $archivo) ?>"
                        <?= $nombreArchivoCompleto === 'Published/' . $archivo ? 'selected' : '' ?>>
                        <?= htmlspecialchars($archivo) ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>
        </select>

        <label>Nombre del archivo (.md):</label>
        <input type="text" name="filename" value="<?= htmlspecialchars($nombreArchivoCompleto) ?>"
            placeholder="Draft/ejemplo.md" required>

        <label>Contenido Markdown:</label>
        <textarea name="content" id="content" oninput="actualizarVista()"><?= htmlspecialchars($contenido) ?></textarea>
        <fieldset id="btngroup">
            <button type="submit"
                data-action="<?php echo BASE_URL; ?>/admin/editorParaArticulos/guardar.php">Guardar</button>
            <button type="reset">Limpiar</button>
            <button type="submit"
                data-action="<?php echo BASE_URL; ?>/admin/editorParaArticulos/post.php">Publicar</button>
        </fieldset>
    </form>

    <?php if ($nombreArchivoCompleto): ?>
        <form method="POST" action="<?php echo BASE_URL; ?>/admin/editorParaArticulos/eliminar.php"
            onsubmit="return confirm('¿Deseas eliminar este archivo publicado?')">
            <input type="hidden" name="archivo" value="<?= htmlspecialchars($nombreArchivoBase) ?>">
            <input type="hidden" name="origen" value="<?= htmlspecialchars($rutaArchivoOrigen) ?>">
            <button type="submit" style="background:#c00;color:#fff;">Eliminar</button>
        </form>
    <?php endif; ?>
    <div>
        <h2>Vista previa</h2>
        <div id="preview" class="markdown-body"></div>
        <div class="linkPreview">
            <a href="<?php echo BASE_URL; ?>/admin/editorParaArticulos/factory/view_post.php">Página de
                posts</a>
        </div>
    </div>
</section>
<script>
    function actualizarVista() {
        const md = document.getElementById('content').value;
        // Construimos una URL absoluta para que la llamada a fetch funcione sin importar desde dónde se incluya este archivo.
        const previewUrl = "<?php echo BASE_URL; ?>/admin/editorParaArticulos/preview.php";
        fetch(previewUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text: md, mode: 'gfm' })
        })
            .then(res => {
                // Si la respuesta no es OK (ej. un error 400 o 500), lanzamos un error.
                if (!res.ok) {
                    // Devolvemos la promesa para que el .catch() la reciba.
                    return res.text().then(text => { throw new Error(text) });
                }
                return res.text();
            })
            .then(html => document.getElementById('preview').innerHTML = html)
            .catch(err => {
                console.error('Error en la previsualización:', err);
                document.getElementById('preview').innerHTML = `<div style="color:red; font-family:monospace;">${err.message.replace(/\n/g, '<br>')}</div>`;
            });
    }

    if (document.getElementById('content').value.trim() !== '') {
        actualizarVista();
    }
    ///////////////////////////////////////////////////////////////#c00
    document.querySelectorAll('#markdownForm button[type="submit"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const form = document.getElementById('markdownForm');
            form.action = this.getAttribute('data-action');
        });
    });
</script>