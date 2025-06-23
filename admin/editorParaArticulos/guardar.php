<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['filename']) || trim($_POST['filename']) === '') {
        die("❌ Error: no se proporcionó el nombre del archivo.");
    }

    $filename = basename(trim($_POST['filename']));
    $content = $_POST['content'] ?? '';

    // Asegura que tenga extensión .md
    if (!str_ends_with($filename, '.md')) {
        $filename .= '.md';
    }

    $draftDir = __DIR__ . '/Draft';

    // Si no existe la carpeta, intentar crearla con permisos forzados
    if (!is_dir($draftDir)) {
        if (!mkdir($draftDir, 0777, true)) {
            die("❌ Error: no se pudo crear la carpeta 'Draft'.");
        }
    }

    // Si existe pero no tiene permisos, intentar forzarlos
    if (!is_writable($draftDir)) {
        @chmod($draftDir, 0777); // intenta corregir permisos
        clearstatcache(true, $draftDir); // limpia caché de permisos
        if (!is_writable($draftDir)) {
            die("❌ La carpeta 'Draft' no tiene permisos de escritura y no se pudieron cambiar.");
        }
    }

    require_once __DIR__ . '/../../router.php';
    $filepath = $draftDir . '/' . $filename;

    // Guardar archivo
    if (file_put_contents($filepath, $content) === false) {
        echo '¿Draft es escribible?: ' . (is_writable(__DIR__ . '/Draft') ? 'Sí' : 'No');
        // echo "<a href='" . BASE_URL ."/admin/dashboard.php#editor'> Volver al editor</a>";
        header("Location: " . BASE_URL . "/admin/dashboard.php#editor");
        exit;
    }

    /* echo "✅ Archivo guardado correctamente como <strong>$filename</strong> en la carpeta Draft.<br><br>";
    echo "<a href='editor.php'>Volver al editor</a>"; */
    header("Location: " . BASE_URL . "/admin/dashboard.php#editor");
    exit;
} else {
    header("Location: " . BASE_URL . "/admin/dashboard.php#editor");
    exit;
}

