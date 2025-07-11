<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../../router.php'; // Usar router para consistencia
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

class PublishIconSocialMedia
{
    public function publish(int $userId = 1) // Por defecto, el ID es 1
    {
        try {
            $pdo = DatabaseSingleton::getInstance()->getConnection();

            // Consulta filtrada por el ID fijo del único usuario
            $stmt = $pdo->prepare("SELECT clase, url FROM social_media 
                                   WHERE publicado = 1 AND user_id = :user_id 
                                   LIMIT 5");
            $stmt->execute([':user_id' => $userId]);
            $iconos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($iconos)) {
                return ''; // No mostrar nada si no hay iconos
            }

            $output_html = "<ul id='lista-iconos-publicada' style='list-style:none;padding:0;display:flex;gap:10px;'>";

            foreach ($iconos as $icono) {
                $class = htmlspecialchars($icono['clase'], ENT_QUOTES, 'UTF-8');
                $url = htmlspecialchars($icono['url'] ?? '#', ENT_QUOTES, 'UTF-8');

                $output_html .= "<li><a href='{$url}' target='_blank' rel='noopener noreferrer'><i class='{$class}'></i></a></li>";
            }

            $output_html .= "</ul>";
            return $output_html;

        } catch (PDOException $e) {
            error_log("Error al publicar iconos sociales: " . $e->getMessage());
            return "<!-- Error al cargar iconos -->";
        }
    }
}
