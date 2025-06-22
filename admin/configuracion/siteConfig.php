<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../router.php';
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

try {
    $pdo = DatabaseSingleton::getInstance()->getConnection();

    // Guardar título del sitio
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_titulo'])) {
        $titulo_recibido = trim($_POST['nuevo_titulo']);

        $stmt = $pdo->prepare(
            "INSERT INTO site_config (config_key, config_value) 
             VALUES ('site_title', :new_title) 
             ON DUPLICATE KEY UPDATE config_value = :updated_title"
        );
        $stmt->execute([
            'new_title' => $titulo_recibido,
            'updated_title' => $titulo_recibido
        ]);
    }

    // Guardar entradas del menú
    $menu_keys = ['menu_home', 'menu_articles_main', 'menu_articles_sub', 'menu_about'];

    foreach ($menu_keys as $key) {
        if (isset($_POST[$key])) {
            $value = trim($_POST[$key]);
            $stmt = $pdo->prepare("
    INSERT INTO site_config (config_key, config_value) 
    VALUES (:key, :val_insert)
    ON DUPLICATE KEY UPDATE config_value = :val_update
");
            $stmt->execute([
                'key' => $key,
                'val_insert' => $value,
                'val_update' => $value
            ]);

        }
    }

    $_SESSION['flash_message'] = '✅ ¡Configuración guardada correctamente!';
} catch (PDOException $e) {
    $_SESSION['flash_message'] = '❌ Error de base de datos: ' . $e->getMessage();
}

// Redirigir
header('Location: ' . BASE_URL . '/admin/dashboard.php#config');
exit;
