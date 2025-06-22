<?php
require_once __DIR__ . '/componentsInterface.php';
require_once __DIR__ . '/header.php';
class FactoryForComponents {

    public static function renderComponents($type): ComponentsInterface {
        return match ($type) {
            'header' => new Header(),
            default => throw new InvalidArgumentException("Problema con el formulario"),
        }; 
    }
}