<?php
require_once __DIR__ . '/parser/Parsedown.php';

header('Content-Type: text/html'); // O 'application/json' si devuelves JSON

$input = json_decode(file_get_contents('php://input'), true);
$markdown = $input['text'] ?? '';  // 'text' coincide con lo enviado en JS

$parser = new Parsedown();
$html = $parser->text($markdown);

echo $html;
exit;
