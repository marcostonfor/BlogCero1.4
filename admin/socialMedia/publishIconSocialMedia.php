<?php
require_once __DIR__ . '/../../router.php'; // Usar router para consistencia
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

class PublishIconSocialMedia
{
    public function publish(int $userId)
    {
        try {
            $pdo = DatabaseSingleton::getInstance()->getConnection();

            // La consulta AHORA filtra por el ID del usuario para mostrar solo sus iconos
            $stmt = $pdo->prepare("SELECT clase, url FROM social_media WHERE publicado = 1 AND user_id = :user_id LIMIT 5");
            $stmt->execute([':user_id' => $userId]);
            $iconos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($iconos)) {
                return ''; // No mostrar nada si el usuario no tiene iconos
            }

            $output_html = "<ul id='lista-iconos-publicada' style='list-style:none;padding:0;display:flex;gap:10px;'>";

            foreach ($iconos as $icono) {
                $class = htmlspecialchars($icono['clase'], ENT_QUOTES, 'UTF-8');
                // Usar '#' como fallback si la URL no está definida o está vacía
                $url = htmlspecialchars($icono['url'] ?? '#', ENT_QUOTES, 'UTF-8'); 

                // Renderizar el icono usando la clase de Font Awesome y la URL
                // Se añade target='_blank' y rel='noopener noreferrer' para enlaces externos seguros.
                $output_html .= "<li><a href='{$url}' target='_blank' rel='noopener noreferrer'><i class='{$class}'></i></a></li>";
            }

            $output_html .= "</ul>";
            return $output_html;

        } catch (PDOException $e) {
            // En producción, es mejor registrar el error que mostrarlo.
            error_log("Error al publicar iconos sociales: " . $e->getMessage());
            return "<!-- Error al cargar iconos -->";
        }
    }
}
