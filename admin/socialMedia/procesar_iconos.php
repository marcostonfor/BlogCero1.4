<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../../router.php';
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = '❌ Debes iniciar sesión para realizar esta acción.';
    header('Location: ' . BASE_URL . '/admin/dashboard.php#socialMedia');
    exit;
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iconosSeleccionados = isset($_POST['opciones_control']) ? $_POST['opciones_control'] : [];

    $iconDefinitions = [
        'facebook' => ['clase' => 'fa-brands fa-facebook-f'],
        'twitter' => ['clase' => 'fa-brands fa-twitter'],
        'instagram' => ['clase' => 'fa-brands fa-instagram'],
        'linkedin' => ['clase' => 'fa-brands fa-linkedin-in'],
        'github' => ['clase' => 'fa-brands fa-github'],
        'youtube' => ['clase' => 'fa-brands fa-youtube'],
        'pinterest' => ['clase' => 'fa-brands fa-pinterest'],
        'tumbler' => ['clase' => 'fa-brands fa-tumblr'],
        'flicker' => ['clase' => 'fa-brands fa-flickr'],
        'reddit' => ['clase' => 'fa-brands fa-reddit'],
        'skype' => ['clase' => 'fa-brands fa-skype'],
        'soundcloud' => ['clase' => 'fa-brands fa-soundcloud'],
        'whatsapp' => ['clase' => 'fa-brands fa-whatsapp'],
        'stackoverflow' => ['clase' => 'fa-brands fa-stack-overflow'],
        'behance' => ['clase' => 'fa-brands fa-behance'],
        'spotify' => ['clase' => 'fa-brands fa-spotify'],
        'vimeo' => ['clase' => 'fa-brands fa-vimeo-v'],
    ];

    $pdo = null;
    try {
        $pdo = DatabaseSingleton::getInstance()->getConnection();
        $pdo->beginTransaction();

        $pdo->exec("UPDATE social_media SET publicado = 0 WHERE user_id = " . (int)$user_id);

        if (!empty($iconosSeleccionados)) {
            $stmt = $pdo->prepare("
                INSERT INTO social_media (nombre, clase, publicado, user_id) 
                VALUES (:nombre, :clase, 1, :user_id) 
                ON DUPLICATE KEY UPDATE 
                    clase = VALUES(clase), 
                    publicado = 1
            ");
            foreach ($iconosSeleccionados as $nombreIcono) {
                if (isset($iconDefinitions[$nombreIcono])) {
                    $definicion = $iconDefinitions[$nombreIcono];
                    $stmt->execute([
                        ':nombre' => $nombreIcono,
                        ':clase' => $definicion['clase'],
                        ':user_id' => $user_id
                    ]);
                }
            }
        }
        $pdo->commit();
        $_SESSION['flash_message'] = '✅ Iconos actualizados correctamente.';
    } catch (PDOException $e) {
        if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
        $_SESSION['flash_message'] = '❌ Error al actualizar los iconos: ' . $e->getMessage();
    }

    header('Location: ' . BASE_URL . '/admin/dashboard.php#socialMedia');
    exit;
}

header('Location: ' . BASE_URL . '/admin/dashboard.php#socialMedia');
exit;