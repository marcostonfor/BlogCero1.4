<?php


class Header implements ComponentsInterface
{
    public function pageComponents(): void
    {
        ?>
        <style>
            #contentToolbar {
                display: flex;
                justify-content: space-around;
                align-items: center;
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
        <header>
            <section id="navigationToolbar">
                <article>
                    <h1>Blog Cero</h1>
                </article>
                <article id="contentToolbar">
                    <nav id="menuBlog">
                        <?php require_once __DIR__ . '/partials/menuBlog.php'; ?>
                    </nav>
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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