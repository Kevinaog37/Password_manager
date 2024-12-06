<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ('app/config/config.php');

// Obtener la URL solicitada
$url = isset($_GET['url']) ? $_GET['url'] : 'Login/index';
$url = rtrim($url, '/'); // Quitar la barra final
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// Determinar controlador, método y parámetros
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'LoginController';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

// Ruta del controlador
$controllerPath = __DIR__ . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName();

    // Llamar al método si existe
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "Método '$methodName' no encontrado en el controlador '$controllerName'.";
    }
} else {
    echo "Controlador '$controllerName' no encontrado.";
}
