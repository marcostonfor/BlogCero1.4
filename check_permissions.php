<?php
$folder = __DIR__;  // carpeta que quieres gestionar

// Función para cambiar recursivamente permisos y propietario
function setPermissionsRecursively($path, $ownerUser = null, $ownerGroup = null, $dirPerm = 0755, $filePerm = 0644)
{
    if (!file_exists($path)) {
        return false;
    }

    // Cambiar propietario si se especifica
    if ($ownerUser !== null && $ownerGroup !== null) {
        @chown($path, $ownerUser);
        @chgrp($path, $ownerGroup);
    }

    if (is_dir($path)) {
        @chmod($path, $dirPerm);

        $items = scandir($path);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..')
                continue;
            $fullPath = $path . DIRECTORY_SEPARATOR . $item;
            setPermissionsRecursively($fullPath, $ownerUser, $ownerGroup, $dirPerm, $filePerm);
        }
    } else {
        @chmod($path, $filePerm);
    }

    return true;
}

// Detectar usuario y grupo bajo el que corre PHP (intento)
$currentUser = exec('whoami');
$currentGroup = exec('groups ' . $currentUser . ' | cut -d" " -f1');

$success = setPermissionsRecursively($folder, $currentUser, $currentGroup, 0755, 0644);

if (!$success) {
    echo "Error: No se pudo establecer permisos en $folder\n";
    exit(1);
}

// Confirmar si carpeta es escribible
if (is_writable($folder)) {
    echo "Permisos establecidos correctamente para $folder y sus contenidos.\n";
} else {
    echo "Advertencia: La carpeta $folder NO es escribible tras intentar cambiar permisos.\n";
}
