<?php

// Definir la ruta raíz del proyecto para que los 'require' sean siempre robustos y fiables.
// __DIR__ aquí es la raíz del proyecto, ya que router.php está en la raíz.
define('ROOT_PATH', __DIR__);

// El router ahora depende de config.php para obtener las constantes.
// Esto asegura que la configuración se carga una sola vez.
require_once ROOT_PATH . '/config.php';
