<?php
// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Funciones personalizadas para manejar errores y excepciones
function customError($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno] $errstr - $errfile:$errline";
    die();
}

set_error_handler("customError");

function customException($exception) {
    echo "<b>Exception:</b> " , $exception->getMessage();
    die();
}

set_exception_handler('customException');

// Requerimos la conexión a la BBDD
require_once 'config/database.php';

// Opciones por defecto
define("DEFAULT_CONTROLLER", "acceso_controlador");
define("DEFAULT_ACTION", "mostrar_vista");

// Si no se indica controlador o acción, se llama a los valores por defecto
if (!isset($_GET["controller"])) {
    $_GET["controller"] = constant("DEFAULT_CONTROLLER");
}

if (!isset($_GET["action"])) {
    $_GET["action"] = constant("DEFAULT_ACTION");
}

/* ----- VARIABLES ----- */
define('BASE_URL', "http://localhost/alejandria/"); // Ruta Base de la app
$controller_path =  "controladores/" . $_GET['controller'] . ".php"; // Ruta de los controladores

/* Comprobamos que el controlador existe */
if (!file_exists($controller_path)) {
    die("Controller file not found: " . $controller_path);
}

// Requerimos el controlador correspondiente y creamos una nueva instancia de éste
require_once $controller_path;
$controllerName = $_GET['controller'] . "";

if (!class_exists($controllerName)) {
    die("Controller class not found: " . $controllerName);
}

$controller = new $controllerName();

// Diferenciamos entre peticiones Ajax y las que no lo son para devolver el tipo de dato adecuado
function esPeticionAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

$data = array("data" => array());
if (esPeticionAjax()) {
    // Si es petición Ajax, se devuelven los datos en JSON
    if (method_exists($controller, $_GET["action"])) {
        $response = $controller->{$_GET["action"]}();
        // Devuelve la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    // Si no se encuentra el controlador o el método, devuelve un error 404
    header("HTTP/1.0 404 Not Found");
    exit;
} else {
    if (method_exists($controller, $_GET["action"])) {
        $data = $controller->{$_GET["action"]}();
    }
}

// Requerimos las vistas
require_once "vistas/includes/header.php";
require_once "vistas/secciones/" . $controller->view . ".php";
require_once "vistas/includes/footer.php";
