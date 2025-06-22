<?php
// Define la ruta absoluta del directorio raíz del proyecto en el sistema de archivos.
// Asume que config.php está en la raíz del proyecto.
define('PROJECT_ROOT_DIR', __DIR__);

/**
 * Define una URL base para que todos los enlaces y recursos
 * funcionen correctamente sin importar la estructura de directorios.
 */

// Calcula la ruta base del proyecto dinámicamente.
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = dirname(dirname($script_name));

$config_file_path = str_replace('\\', '/', __FILE__);
$document_root_path = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

$relative_path_from_doc_root = str_replace($document_root_path, '', $config_file_path);
$base_url = dirname($relative_path_from_doc_root);

define('BASE_URL', rtrim($base_url, '/'));

// --- Configuración de la Base de Datos --- //

/**
 * Host de la base de datos (ej: localhost, 127.0.0.1)
 */
define('DB_HOST', '%%DB_HOST%%');

/**
 * Nombre de la base de datos.
 */
define('DB_NAME', '%%DB_NAME%%');

/**
 * Usuario de la base de datos.
 */
define('DB_USER', '%%DB_USER%%');

/**
 * Contraseña del usuario de la base de datos.
 */
define('DB_PASS', '%%DB_PASS%%');

