<?php

class Header implements ComponentsInterface
{
    public function pageComponents(): void
    {
        // Conectarse a la base de datos y obtener el título del sitio.
        // Usamos la constante ROOT_PATH para una ruta absoluta y el nombre de archivo corregido.
        require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';
        
        $titulo_actual = "Blog Cero"; // Título por defecto
        try {
            $pdo = DatabaseSingleton::getInstance()->getConnection();
            $stmt = $pdo->prepare("SELECT config_value FROM site_config WHERE config_key = 'site_title'");
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $titulo = $result;
            if ($result !== false) {
                $titulo_actual = htmlspecialchars((string) $result, ENT_QUOTES, 'UTF-8');
            }
        } catch (PDOException $e) {
            // En caso de error, se mantiene el título por defecto. No se detiene la ejecución.
        }
        ?>
        <style>
            #contentToolbar {
                display: flex;
                justify-content: space-around;
                align-items: center;
                gap: 10rem;
            }

            .social-media {
                background-color: #5f9ea0;
                padding: 0.5rem 1rem;
            }

            .social-media,
            .social-media * {
                border-radius: 1rem;
            }

            #lista-iconos-publicada li {
                padding: 0.5rem;
                background-color: #ffe4c4;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <header>
            <section id="navigationToolbar">
                <article>
                    <h1><?php echo $titulo_actual; ?></h1>
                </article>
                <article id="contentToolbar">
                    <nav id="menuBlog">
                        <?php require_once __DIR__ . '/partials/menuBlog.php'; ?>
                    </nav>
                    <aside class="social-media">
                        <?php
                        require_once __DIR__ . '/../admin/socialMedia/publishIconSocialMedia.php';
                        $iconList = new PublishIconSocialMedia();
                        echo $iconList->publish(); ?>
                    </aside>
                    <?php require_once __DIR__ . '/../system_login/allLogin.php'; ?>
                </article>
            </section>
        </header>
        <?php
    }
}