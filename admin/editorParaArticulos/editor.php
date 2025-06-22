<?php
// editor.php


$draftDir = __DIR__ . '/Draft';
$publishedDir = __DIR__ . '/Published';

$drafts = array_filter(scandir($draftDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'md');
$published = array_filter(scandir($publishedDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'md');



// $draftDir = __DIR__ . '/Draft';

// Asegurarse de que el directorio exista
if (!is_dir($draftDir)) {
    mkdir($draftDir, 0777, true);
}

// Listar archivos .md
$archivos = array_filter(
    scandir($draftDir),
    fn($f) =>
    pathinfo($f, PATHINFO_EXTENSION) === 'md' && is_file($draftDir . '/' . $f)
);

$contenido = '';
$nombreArchivo = '';

if (isset($_GET['archivo'])) {
    $archivoSolicitado = basename($_GET['archivo']);
    $rutaSolicitada = dirname($_GET['archivo']); // Draft o Published
    $rutaArchivo = __DIR__ . '/' . $rutaSolicitada . '/' . $archivoSolicitado;

    if (file_exists($rutaArchivo)) {
        $contenido = file_get_contents($rutaArchivo);
        $nombreArchivo = $rutaSolicitada . '/' . $archivoSolicitado;
    }
}

// Si se pasa un archivo por GET, cargarlo
/* if (isset($_GET['archivo'])) {
    $archivoSolicitado = basename($_GET['archivo']);
    $rutaArchivo = $draftDir . '/' . $archivoSolicitado;

    if (file_exists($rutaArchivo)) {
        $contenido = file_get_contents($rutaArchivo);
        $nombreArchivo = $archivoSolicitado;
    }
} */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editor Markdown</title>
    <style>
        body {
            background-color: hsl(43, 89%, 38%);
        }
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.8.1/github-markdown-dark.css">
</head>

<body>
    <h1>Editor Markdown</h1>

    <section id="editor">
        <form id="markdownForm" method="POST" action="guardar.php">
            <h2>Crear o editar archivo Markdown</h2>

            <label>Seleccionar archivo existente:</label>
            <label>Seleccionar archivo existente:</label>
            <select onchange="location = this.value">
                <option value="">-- Selecciona un archivo --</option>

                <optgroup label="Borradores">
                    <?php foreach ($drafts as $archivo): ?>
                        <option value="?archivo=<?= urlencode('Draft/' . $archivo) ?>" <?= $nombreArchivo === 'Draft/' . $archivo ? 'selected' : '' ?>>
                            <?= htmlspecialchars($archivo) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>

                <optgroup label="Publicados">
                    <?php foreach ($published as $archivo): ?>
                        <option value="?archivo=<?= urlencode('Published/' . $archivo) ?>" <?= $nombreArchivo === 'Published/' . $archivo ? 'selected' : '' ?>>
                            <?= htmlspecialchars($archivo) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            </select>


            <label>Nombre del archivo (.md):</label>
            <input type="text" name="filename" value="<?= htmlspecialchars($nombreArchivo) ?>" placeholder="ejemplo.md"
                required>

            <label>Contenido Markdown:</label>
            <textarea name="content" id="content"
                oninput="actualizarVista()"><?= htmlspecialchars($contenido) ?></textarea>
            <fieldset id="btngroup">
                <button type="submit" data-action="guardar.php">Guardar</button>
                <button type="reset">Limpiar</button>
                <button type="submit" data-action="post.php">Publicar</button>
            </fieldset>
        </form>

        <?php if ($nombreArchivo): ?>
            <form method="POST" action="eliminar.php" onsubmit="return confirm('¿Deseas eliminar este archivo publicado?')">
                <input type="hidden" name="archivo" value="<?= htmlspecialchars($archivo) ?>">
                <input type="hidden" name="origen" value="posts">
                <button type="submit" style="background:#c00;color:#fff;">Eliminar</button>
            </form>
        <?php endif; ?>
        <div>
            <h2>Vista previa</h2>
            <div id="preview" class="markdown-body"></div>
            <div class="linkPreview">
                <a href="factory/view_post.php" target="_blank">Página de posts</a>
            </div>
        </div>
    </section>

    <script>
        function actualizarVista() {
            const md = document.getElementById('content').value;
            fetch('preview.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: md, mode: 'gfm' })
            })
                .then(res => res.text())
                .then(html => document.getElementById('preview').innerHTML = html);
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

</body>

</html>