<?php
require_once __DIR__ . '/../../mdParser/Parsedown.php';

header('Content-Type: text/html'); // O 'application/json' si devuelves JSON
 
$raw_input = file_get_contents('php://input');
$input = json_decode($raw_input, true);
 
// Comprobamos si la decodificación JSON ha fallado.
if (json_last_error() !== JSON_ERROR_NONE) {
    // Si falla, enviamos una respuesta de error clara.
    http_response_code(400); // Bad Request
    echo "Error: El servidor no pudo procesar el JSON enviado.\n";
    echo "Error de JSON: " . json_last_error_msg() . "\n";
    echo "Datos recibidos: " . $raw_input;
    exit;
}
 
$markdown = $input['text'] ?? '';  // 'text' coincide con lo enviado en JS
 
if (isset($input['text'])) {
    $parser = new Parsedown();
    echo $parser->text($input['text']);
} else {
    // Si la clave 'text' no está en el JSON, también es un error.
    http_response_code(400);
    echo "Error: La clave 'text' no se encontró en los datos enviados.";
}
exit;
