<?php

// Variables que definen el nombre actual del hosting
$myhost = "http://localhost";
$myproject = "petcare-registro-eval-PIII";
$mysite = $myhost . "/" . $myproject;
date_default_timezone_set('America/Costa_Rica');

// Variables estáticas que definen las rutas absolutas del proyecto
define('__ROOT__', $_SERVER["DOCUMENT_ROOT"]);
define('__SITE_PATH__', $mysite);
define('__CLS_PATH', __ROOT__ . "/" . $myproject . "/app_core/classes/");
define('__CTR_PATH', __ROOT__ . "/" . $myproject . "/app_core/controllers/");
define('__VWS_PATH', __ROOT__ . "/" . $myproject . "/app_core/views/");
define('__VWS_HOST_PATH', $mysite . "/app_core/views/");
define('__CTR_HOST_PATH', $mysite . "/app_core/controllers/");
define('__JS_PATH', $mysite . "/app_design/js/");
define('__CSS_PATH', $mysite . "/app_design/css/");
define('__IMG_PATH', $mysite . "/app_design/img/");

// GLOBAL FUNCTIONS
set_error_handler("my_error_handler", E_ALL);
require_once(__CLS_PATH . "cls_message.php");

// Maneja globalmente los warnings y excepciones de PHP
function my_error_handler(int $errno, string $errostr, string $errfile, int $errline) : bool {
    try {
        $MSG = new cls_Message();
        throw new Exception($errostr);
    } catch(Exception $e) {
        $MSG->show_message($e->getMessage(), "warning", "");        
    }
    // Indica que el error ha sido manejado
    return true;
}
?>