<?php

?>

<ul>
    <li><a href="<?php echo BASE_URL; ?>/public/home.php" class="menuBlogLink">Home</a></li>
    <li><a href="<?php echo BASE_URL; ?>/mdParser/usePreviewer.php" class="menuBlogLink"> <strong>Guía del lenguaje</strong> <br><small>markdown</small></a></li>
    <li><a href="<?php echo BASE_URL; ?>/public/about.php" class="menuBlogLink">Sobre mi:</a></li>
</ul>
<link href="https://fonts.cdnfonts.com/css/frijole" rel="stylesheet">
<style>
    #navigationToolbar {
        position: relative;
        width: 100%;
        height: auto;
        margin: 0.5rem auto;
        background-color: #006080;        
    }

    #navigationToolbar nav ul {
        list-style-type: none;
        display: flex;
        justify-content: stretch;
        align-items: baseline;
        gap: 0.5rem;
        font-family: 'Frijole', sans-serif;
    }

    #navigationToolbar nav ul li {
        text-align: center;
    }

    #navigationToolbar nav ul li a {
        color: #c0c0c0;
        text-decoration: none;
    }

    #navigationToolbar nav ul li a strong {
        padding: 0.03125rem 0.0625rem;
        background-color: #808080;
        border-radius: 0.1250rem;
    }

    #navigationToolbar nav ul li a small {
        display: block;
        padding: 0.0625rem;
        background-color: #e6e6e6;
        margin-top: 0.5em;
    }
</style>