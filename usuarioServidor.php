<?php
$folder = __DIR__; // o una ruta específica
if (is_writable($folder)) {
    echo "La carpeta $folder es escribible.";
} else {
    echo "La carpeta $folder NO es escribible.";
}
