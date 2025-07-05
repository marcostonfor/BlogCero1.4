<?php
session_start();
require_once __DIR__ . '/../../router.php';

function redirigirConMensaje($mensaje)
{
    $_SESSION['flash_message'] = $mensaje;
    header("Location: " . BASE_URL . "/admin/dashboard.php#subidaPaginas");
    exit;
}

$dir_subida = realpath(__DIR__ . '/../../MD/Subidasmd');
if (!$dir_subida || !is_dir($dir_subida)) {
    redirigirConMensaje("❌ Error crítico: La carpeta de subida no es válida o no existe.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichero_usuario'])) {
    $archivos = $_FILES['fichero_usuario'];
    $archivos_subidos_exitosamente = 0;
    if (empty($archivos['name'][0]) && $archivos['error'][0] == UPLOAD_ERR_NO_FILE) {
        redirigirConMensaje("⚠️ No se seleccionó ningún archivo para subir. Por favor, seleccione al menos uno.");
    }

    $num_archivos_seleccionados = count($archivos['name']);

    for ($i = 0; $i < $num_archivos_seleccionados; $i++) {
        if ($archivos['error'][$i] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($archivos['error'][$i] !== UPLOAD_ERR_OK) {
            redirigirConMensaje("❌ Error al subir el archivo '" . htmlspecialchars($archivos['name'][$i]) . "'. Código de error: " . $archivos['error'][$i]);
        }

        $nombre_archivo_original = $archivos['name'][$i];
        $tmp_nombre_archivo = $archivos['tmp_name'][$i];

        $tipo_mime = mime_content_type($tmp_nombre_archivo);
        if (!preg_match('/^(image|audio|video)\//', $tipo_mime)) {
            redirigirConMensaje("❌ Solo se permiten archivos de imagen, audio o video. El archivo '" . htmlspecialchars($nombre_archivo_original) . "' no es válido.");
        }

        $nombreLimpio = basename($nombre_archivo_original);
        if (empty($nombreLimpio) || $nombreLimpio === '.' || $nombreLimpio === '..') {
            redirigirConMensaje("❌ Nombre de archivo inválido después de la limpieza: '" . htmlspecialchars($nombre_archivo_original) . "'.");
        }

        $destino = $dir_subida . DIRECTORY_SEPARATOR . $nombreLimpio;

        if (move_uploaded_file($tmp_nombre_archivo, $destino)) {
            $archivos_subidos_exitosamente++;
        } else {
            redirigirConMensaje("⚠️ Error al mover el archivo '" . htmlspecialchars($nombreLimpio) . "' al directorio de destino.");
        }
    }

    if ($archivos_subidos_exitosamente > 0) {
        redirigirConMensaje("✅ Se han subido " . $archivos_subidos_exitosamente . " archivo(s) correctamente.");
    }
}
