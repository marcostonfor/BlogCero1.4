<?php

/**
 * Limpia y sanitiza una cadena de ruta de directorio proporcionada por el usuario.
 *
 * Esta función es un componente de seguridad esencial. Su propósito es tomar una cadena
 * que representa una ruta y normalizarla de una manera que prevenga ataques de Path Traversal.
 *
 * @param string $ruta La cadena de ruta de entrada, potencialmente insegura.
 * @return string La ruta sanitizada y segura.
 */
if (!function_exists('limpiarRuta')) {
    function limpiarRuta($ruta)
    {
        $ruta = trim($ruta, '/\\');
        if ($ruta === '') {
            return '';
        }

        $partes = explode('/', str_replace('\\', '/', $ruta));
        $partesLimpias = array_filter($partes, function ($parte) {
            return $parte !== '' && $parte !== '.' && $parte !== '..';
        });

        return implode('/', $partesLimpias);
    }
}