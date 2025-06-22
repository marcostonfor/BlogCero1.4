<?php
$publishedDir = __DIR__ . '/posts';

if (!is_dir($publishedDir)) {
    mkdir($publishedDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'], $_POST['content'])) {
    $filename = basename(trim($_POST['filename']));
    $content = $_POST['content'];

    // Asegurar extensión .md
    if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) !== 'md') {
        $filename .= '.md';
    }

    $ruta = $publishedDir . '/' . $filename;
    file_put_contents($ruta, $content);

    echo "<p>✅ Archivo publicado como <strong>{$filename}</strong>.</p>";
    echo "<p><a href='editor.php'>Volver</a></p>";
} else {
    echo "<p>❌ Error: datos incompletos.</p>";
}
