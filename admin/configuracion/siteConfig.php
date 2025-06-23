<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = '❌ No hay usuario logueado.';
    header('Location: ' . BASE_URL . '/admin/dashboard.php#config');
    exit;
}

require_once __DIR__ . '/../../router.php';
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

try {
    $pdo = DatabaseSingleton::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];

        // 1. Elimina todos los registros de configuración de este usuario
        $pdo->prepare("DELETE FROM site_config WHERE user_id = :user_id")->execute(['user_id' => $user_id]);

        // 2. Guardar título del sitio
        $titulo_recibido = trim($_POST['nuevo_titulo'] ?? '');
        if (isset($_POST['nuevo_titulo'])) {
            $stmt = $pdo->prepare(
                "INSERT INTO site_config (config_key, config_value, user_id) 
                 VALUES ('site_title', :new_title, :user_id) 
                 ON DUPLICATE KEY UPDATE config_value = :updated_title"
            );
            $stmt->execute([
                'new_title' => $titulo_recibido,
                'updated_title' => $titulo_recibido,
                'user_id' => $user_id
            ]);
        }

        // 3. Guardar entradas del menú
        $menu_keys = ['menu_home', 'menu_articles_main', 'menu_articles_sub', 'menu_about'];
        foreach ($menu_keys as $key) {
            if (isset($_POST[$key])) {
                $value = trim($_POST[$key]);
                $stmt = $pdo->prepare("
                    INSERT INTO site_config (config_key, config_value, user_id) 
                    VALUES (:key, :val_insert, :user_id)
                    ON DUPLICATE KEY UPDATE config_value = :val_update
                ");
                $stmt->execute([
                    'key' => $key,
                    'val_insert' => $value,
                    'val_update' => $value,
                    'user_id' => $user_id
                ]);
            }
        }
        $_SESSION['flash_message'] = '✅ ¡Configuración guardada correctamente!';
    }
} catch (PDOException $e) {
    $_SESSION['flash_message'] = '❌ Error de base de datos: ' . $e->getMessage();
}

header('Location: ' . BASE_URL . '/admin/dashboard.php#config');
exit;
