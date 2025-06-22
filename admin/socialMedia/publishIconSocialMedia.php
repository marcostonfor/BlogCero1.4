<?php
require_once __DIR__ . '/../../config.php';
class PublishIconSocialMedia
{
    public function publish()
    {
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . '; charset=utf8',  DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SELECT clase, unicode FROM social_media WHERE publicado = 1");
            $iconos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $output_html = "<ul id='lista-iconos-publicada' style='list-style:none;padding:0;display:flex;gap:10px;'>";

            foreach ($iconos as $icono) {
                $class = htmlspecialchars($icono['clase'], ENT_QUOTES, 'UTF-8');
                $unicode = $icono['unicode']; // Se espera un valor hexadecimal limpio, ej: "f082"

                // Aseguramos que el unicode sea una cadena hexadecimal no vacía
                if (!empty($unicode) && ctype_xdigit($unicode)) {
                    $output_html .= "<li><a href='#'><i class='{$class}' style='font-size:24px'>&#x{$unicode};</i></a></li>";
                }
            }

            $output_html .= "</ul>";
            return $output_html;

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
