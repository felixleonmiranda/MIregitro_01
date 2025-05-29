<?php
require __DIR__ . '/../controller/RegistroController.php';

// Parsear la URL
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

// Definir las rutas
if ($request_method === 'GET' && $request_uri === '/registro') {
    $controller = new RegistroController();
    $controller->mostrarFormulario();
} elseif ($request_method === 'POST' && $request_uri === '/registro') {
    $controller = new RegistroController();
    $controller->procesarRegistro();
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Página no encontrada";
}
?>