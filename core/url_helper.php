<?php
/**
 * Helpers para la construcción de URLs.
 *
 * @package     BlogCero
 * @subpackage  Core
 * @since       1.5.0
 */

/**
 * Genera una URL absoluta para un recurso (asset) del proyecto.
 *
 * Toma una ruta relativa desde la raíz del proyecto y le prefija
 * la constante BASE_URL para crear una URL completa y robusta.
 *
 * @param string $path La ruta al recurso desde la raíz del proyecto (ej. 'MD/Media/images/mi-foto.jpg').
 * @return string La URL absoluta al recurso.
 */
function asset($path) {
    // Asegurarse de que BASE_URL está definida y no hay barras duplicadas.
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}