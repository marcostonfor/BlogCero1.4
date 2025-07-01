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



    try {
        $pdo = DatabaseSingleton::getInstance()->getConnection();
        $pdo->beginTransaction();

        // Asegurarse de que solo se trabajen valores únicos y máximo 5
        $iconosSeleccionados = array_unique($iconosSeleccionados);
        $iconosSeleccionados = array_slice($iconosSeleccionados, 0, 5);

        // Paso 1: Eliminar TODOS los iconos anteriores del usuario.
        // Esto asegura que si el usuario deselecciona todo, la tabla quede vacía para él.
        $stmtDelete = $pdo->prepare("DELETE FROM social_media WHERE user_id = :user_id");
        $stmtDelete->execute([':user_id' => $user_id]);

        if (!empty($iconosSeleccionados)) {
            // Paso 2: Preparar una única inserción masiva para mayor eficiencia.
            $sql = "INSERT INTO social_media (nombre, clase, publicado, user_id) VALUES ";
            $placeholders = [];
            $valuesToBind = [];

            foreach ($iconosSeleccionados as $nombreIcono) {
                if (isset($iconDefinitions[$nombreIcono])) {
                    $placeholders[] = '(?, ?, ?, ?)';
                    $valuesToBind[] = $nombreIcono;
                    $valuesToBind[] = $iconDefinitions[$nombreIcono]['clase'];
                    $valuesToBind[] = 1; // publicado
                    $valuesToBind[] = $user_id;
                }
            }

            // Solo ejecutar si hay valores válidos para insertar.
            if (!empty($placeholders)) {
                $sql .= implode(', ', $placeholders);
                $stmtInsert = $pdo->prepare($sql);
                $stmtInsert->execute($valuesToBind);
            }
            $_SESSION['flash_message'] = '✅ Iconos actualizados correctamente.';
        } else {
            // Si no se seleccionó ningún icono, el borrado anterior es la única acción necesaria.
            $_SESSION['flash_message'] = '✅ Todos los iconos han sido eliminados.';
        }
        $pdo->commit(); // Confirmar todos los cambios (borrado y/o inserciones)
    } catch (PDOException $e) {
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['flash_message'] = '❌ Error en la actualización: ' . $e->getMessage();
    }

    header('Location: ' . BASE_URL . '/admin/dashboard.php#socialMedia');
    exit;
}

header('Location: ' . BASE_URL . '/admin/dashboard.php#socialMedia');
exit;
