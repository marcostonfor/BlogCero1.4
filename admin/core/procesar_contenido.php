<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Necesitamos la sesión para los mensajes flash

// Incluimos los archivos necesarios
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../../router.php';

// Ruta base: carpeta MD fuera del directorio actual
$raiz = realpath(__DIR__ . '/../../MD');

if (!$raiz || !is_dir($raiz)) {
    $_SESSION['flash_message'] = "❌ Error crítico: La carpeta raíz MD no existe o no es accesible.";
    header("Location: " . BASE_URL . "/admin/dashboard.php#gestionPaginas");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_crear_contenido'])) {
        $path = limpiarRuta($_POST['path'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $tipo = $_POST['tipo'] ?? '';
        $mensaje = '';

        if (empty($nombre) || !in_array($tipo, ['archivo', 'carpeta'])) { // Validar que el nombre no esté vacío y el tipo sea válido
            $mensaje = "❌ Parámetros inválidos. El nombre no puede estar vacío.";
        } else {
            $directorioContenedor = $raiz;
            if (!empty($path)) {
                $directorioContenedor .= '/' . $path;
            }

            if (!is_dir($directorioContenedor)) {
                if (!@mkdir($directorioContenedor, 0755, true)) {
                    $mensaje = "❌ Error al crear el directorio contenedor '" . htmlspecialchars($path) . "'. Verifique los permisos del servidor.";
                    $_SESSION['flash_message'] = $mensaje;
                    header("Location: " . BASE_URL . "/admin/dashboard.php#gestionPaginas");
                    exit;
                }
            }

            $directorioContenedorReal = realpath($directorioContenedor);

            if ($directorioContenedorReal === false || strpos($directorioContenedorReal, $raiz) !== 0) {
                $mensaje = "❌ Error de seguridad: La ruta del directorio contenedor está fuera del directorio permitido.";
            } else {
                $rutaCompletaElemento = $directorioContenedorReal . '/' . $nombre;

                if ($tipo === 'carpeta') {
                    if (is_dir($rutaCompletaElemento)) {
                        $mensaje = "⚠️ La carpeta '" . htmlspecialchars($nombre) . "' ya existe.";
                    } else {
                        if (@mkdir($rutaCompletaElemento, 0755)) {
                            $mensaje = "✅ Carpeta '" . htmlspecialchars($nombre) . "' creada con éxito.";
                        } else {
                            $mensaje = "❌ Error al crear la carpeta '" . htmlspecialchars($nombre) . "'.";
                        }
                    }
                } elseif ($tipo === 'archivo') {
                    if (!str_ends_with(strtolower($nombre), '.md')) {
                        $nombre .= '.md';
                        $rutaCompletaElemento .= '.md';
                    }

                    if (file_exists($rutaCompletaElemento)) {
                        $mensaje = "⚠️ El archivo '" . htmlspecialchars($nombre) . "' ya existe.";
                    } else {
                        $contenidoInicial = "# " . htmlspecialchars(basename($nombre, '.md')) . "\n\n";
                        if (@file_put_contents($rutaCompletaElemento, $contenidoInicial)) {
                            $mensaje = "✅ Archivo '" . htmlspecialchars($nombre) . "' creado con éxito.";
                        } else {
                            $mensaje = "❌ Error al crear el archivo '" . htmlspecialchars($nombre) . "'.";
                        }
                    }
                }
            }
        }

        $_SESSION['flash_message'] = $mensaje;
        header("Location: " . BASE_URL . "/admin/dashboard.php#gestionPaginas");
        exit;
    }
}

// Si se accede por GET o sin el POST correcto, redirigir.
header("Location: " . BASE_URL . "/admin/dashboard.php#gestionPaginas");
exit;