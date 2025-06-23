<?php
require_once __DIR__ . '/../components/factoryForComponents.php';
require_once __DIR__ . '/../router.php';

$header = FactoryForComponents::renderComponents('header');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre mi:</title>
</head>

<body>
    <?php
    $header->pageComponents();
    ?>
</body>

</html>