<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../router.php';
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_titulo'])) {
    $titulo_recibido = trim($_POST['nuevo_titulo']);

    try {
        $pdo = DatabaseSingleton::getInstance()->getConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO site_config (config_key, config_value) 
             VALUES ('site_title', :new_title) 
             ON DUPLICATE KEY UPDATE config_value = :updated_title"
        );
        $stmt->execute([
            'new_title' => $titulo_recibido,
            'updated_title' => $titulo_recibido
        ]);
        $_SESSION['flash_message'] = '✅ ¡Éxito! El título se ha guardado en la base de datos.';
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = '❌ Error de base de datos: ' . $e->getMessage();
    }
}

header('Location: ' . BASE_URL . '/admin/dashboard.php#config');
exit;
