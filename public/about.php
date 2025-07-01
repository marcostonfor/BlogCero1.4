<?php
require_once __DIR__ . '/../components/factoryForComponents.php';
require_once __DIR__ . '/../router.php';

$header = FactoryForComponents::renderComponents('header');
$footer = FactoryForComponents::renderComponents('footer');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre mi:</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php
    $header->pageComponents();
    ?>
    <div id="footer">
        <?php $footer->pageComponents(); ?>
    </div>
</body>

</html>