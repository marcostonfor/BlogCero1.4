<?php
require_once __DIR__ . '/componentsInterface.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/footer.php';
class FactoryForComponents {

    public static function renderComponents($type): ComponentsInterface {
        return match ($type) {
            'header' => new Header(),
            'footer' => new Footer(),
            default => throw new InvalidArgumentException("Problema con el formulario"),
        }; 
    }
}