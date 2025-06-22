<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/Parsedown.php';
require_once __DIR__ . '/previewer.php';
require_once __DIR__ . '/../components/factoryForComponents.php';

$header = FactoryForComponents::renderComponents('header');
// Crear una instancia de Parsedown
$parser = new Parsedown();

// Markdown inicial (puede estar vacío si solo se usa el archivo)
$mdInicial = "";

// Crear una instancia de Previewer
$previewer = new Previewer($parser, $mdInicial);
$previewer->setArchivo('00-README.md');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.8.1/github-markdown-dark.css">
    <link href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/previewer.css">
</head>

<body>
    <div id="header">
        <?php $header->pageComponents();  ?>
    </div>
    <section id="navigation">
        <nav>
            <?php require_once __DIR__ . '/../dinamicLink/dinamicLink.php'; ?>
        </nav>
    </section>
    <section class="previewermd markdown-body">
        <?php
        // Renderizar el Markdown del archivo mdExample.md
        try {
            $archivo = $_GET['md'] ?? '00-README.md';
            $previewer->setArchivo($archivo);
            $markdown = $previewer->rendermd($archivo);
            echo $parser->text($markdown);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
</body>

</html>