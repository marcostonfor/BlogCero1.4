<?php

function mostrarEstructuraDirectorio($directorioRaiz, $subRutaActual = '')
{
    $htmlLista = '';
    $rutaAbsolutaActual = rtrim($directorioRaiz . DIRECTORY_SEPARATOR . $subRutaActual, DIRECTORY_SEPARATOR);

    // @ para suprimir warnings si el directorio no es legible, aunque $directorioRaiz ya está validado
    $elementos = @scandir($rutaAbsolutaActual);

    if ($elementos === false)
        return ''; // No se pudo leer el directorio

    $subdirectoriosEncontrados = false;
    foreach ($elementos as $elemento) {
        if ($elemento === '.' || $elemento === '..')
            continue;

        $rutaAbsolutaElemento = $rutaAbsolutaActual . DIRECTORY_SEPARATOR . $elemento;
        if (is_dir($rutaAbsolutaElemento)) {
            if (!$subdirectoriosEncontrados) {
                $htmlLista .= '<ul>';
                $subdirectoriosEncontrados = true;
            }
            $rutaRelativaParaMostrar = trim($subRutaActual . DIRECTORY_SEPARATOR . $elemento, DIRECTORY_SEPARATOR);
            $htmlLista .= '<li><i class="fa fa-folder"></i> ' . htmlspecialchars($rutaRelativaParaMostrar);
            $htmlLista .= mostrarEstructuraDirectorio($directorioRaiz, $rutaRelativaParaMostrar); // Llamada recursiva
            $htmlLista .= '</li>';
        }
    }
    if ($subdirectoriosEncontrados)
        $htmlLista .= '</ul>';
    return $htmlLista;
}