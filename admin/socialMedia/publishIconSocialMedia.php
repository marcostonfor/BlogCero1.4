<?php
require_once __DIR__ . '/../../config.php';
class PublishIconSocialMedia
{
    public function publish()
    {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . '; charset=utf8',  DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Nota: Para consistencia, considera usar DatabaseSingleton::getInstance()->getConnection()
            // si esta clase se instancia en un contexto donde el Singleton es accesible y preferido.

            // Seleccionar 'clase' y 'url' de la base de datos
            $stmt = $pdo->query("SELECT clase, url FROM social_media WHERE publicado = 1");
            $iconos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            return "Error: " . $e->getMessage();
            // En un entorno de producción, es mejor no exponer el mensaje de error de la base de datos.
            // Considera loguear el error y devolver un mensaje genérico como:
            // return "Error al cargar los iconos de redes sociales.";
        }
    }
}
