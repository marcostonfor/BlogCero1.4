<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Incluimos los archivos necesarios
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../../router.php';

/**
 * Función para verificar si un directorio está vacío.
 *
 * @param string $dir Ruta del directorio.
 * @return bool True si el directorio está vacío, false en caso contrario.
 */
function esDirectorioVacio($dir)
{
    if (!is_readable($dir) || !is_dir($dir)) {
        return false;
    }

    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
        }
    }
    closedir($handle);
    return true;
}
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

        if (empty($nombre) || !in_array($tipo, ['archivo', 'carpeta'])) {
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
    } elseif (isset($_POST['form_eliminar_contenido'])) {
        $path = limpiarRuta($_POST['path'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $mensaje = '';

        if (empty($nombre)) {
            $mensaje = "❌ Parámetros inválidos. El nombre del elemento a eliminar no puede estar vacío.";
        } else {
            $rutaElemento = $raiz;
            if (!empty($path)) {
                $rutaElemento .= '/' . $path;
            }
            $rutaElemento .= '/' . $nombre;

            $rutaElementoReal = realpath($rutaElemento);

            // Lista explícita de rutas protegidas contra eliminación
            $rutasProtegidas = [ // Usar rutas absolutas construidas, no realpath
                $raiz . '/Subidasmd',
                $raiz . '/Media',
                $raiz . '/Media/imagenes',
                $raiz . '/Media/videos',
                $raiz . '/Media/audios',
            ];

            if ($rutaElementoReal === false || strpos($rutaElementoReal, $raiz) !== 0) {
                $mensaje = "❌ Error de seguridad: La ruta del elemento a eliminar está fuera del directorio permitido.";
            } elseif (in_array($rutaElementoReal, $rutasProtegidas, true)) {
                $mensaje = "❌ No se permite eliminar esta carpeta protegida del sistema.";
            } else {
                if (is_dir($rutaElementoReal)) {
                    if (esDirectorioVacio($rutaElementoReal)) {
                        if (@rmdir($rutaElementoReal)) {
                            $mensaje = "✅ Carpeta '" . htmlspecialchars($nombre) . "' eliminada con éxito.";
                        } else {
                            $mensaje = "❌ Error al eliminar la carpeta '" . htmlspecialchars($nombre) . "'.";
                        }
                    } else {
                        $mensaje = "❌ La carpeta '" . htmlspecialchars($nombre) . "' no está vacía y no puede ser eliminada.";
                    }
                } elseif (is_file($rutaElementoReal)) {
                    if (@unlink($rutaElementoReal)) {
                        $mensaje = "✅ Archivo '" . htmlspecialchars($nombre) . "' eliminado con éxito.";
                    } else {
                        $mensaje = "❌ Error al eliminar el archivo '" . htmlspecialchars($nombre) . "'.";
                    }
                } else {
                    $mensaje = "❌ El elemento '" . htmlspecialchars($nombre) . "' no existe o no es un archivo ni una carpeta.";
                }
            }
        }

        $_SESSION['flash_message'] = $mensaje;
        header("Location: " . BASE_URL . "/admin/dashboard.php#gestionPaginas");
        exit;
    }
}