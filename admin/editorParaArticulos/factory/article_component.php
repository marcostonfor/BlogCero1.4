<?php
require_once __DIR__ . '/post_publish_interface.php';
require_once __DIR__ . '/publish_view.php';

class Article_component
{
    public static function create(string $type): Post_publish_interface
    {
        switch ($type) {
            case 'view':
                return new Publish_view();
            default:
                throw new InvalidArgumentException("Tipo de publicador no válido: $type");
        }
    }
}