<?php
require_once __DIR__ . '/../../router.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archivo'], $_POST['origen'])) {
    $archivo = basename($_POST['archivo']);
    $origen = basename($_POST['origen']); // prevenir path traversal
    $carpetaPermitida = ['Draft', 'Published'];

    if (!in_array($origen, $carpetaPermitida)) {
        header("Location: editor.php?error=Carpeta no permitida");
        exit;
    }

    $ruta = __DIR__ . '/' . $origen . '/' . $archivo;

    if (file_exists($ruta)) {
        unlink($ruta);
        header("Location: " . BASE_URL . "/admin/dashboard.php#editor");
        exit;
    } else {
        header("Location: editor.php?error=Archivo no encontrado");
        exit;
    }
} else {
    header("Location: editor.php");
    exit;
}
