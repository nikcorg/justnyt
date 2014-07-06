<?php
// Include Composer's autoloader for vendor-packages support
require GLUE_APPHOME . "/vendor/autoload.php";

use glue\net\Router;
use glue\net\Route;
use glue\net\RouteVariableTypes;
use glue\net\RequestMethods;

\glue\ui\View::setTemplateBaseDir(GLUE_APPHOME . "/justnyt/templates");
\glue\io\Logger::setDefaultLogDir(GLUE_APPHOME . "/logs");

if (file_exists(GLUE_APPHOME . DIRECTORY_SEPARATOR . "config.local.php")) {
    include GLUE_APPHOME . DIRECTORY_SEPARATOR . "config.local.php";
}

Router::addRoute(
    Route::factory(
        "/",
        "\\justnyt\\controllers\\IndexController",
        RequestMethods::GET,
        "index"
        )
    ->addAction("faq", null, RequestMethods::GET, "faq")
    ->addAction("kuraattoriksi", null, RequestMethods::GET, "recommend")
    ->addAction("kuraattorit", null, RequestMethods::GET, "curators")
    ->addAction("historiaa", null, RequestMethods::GET, "history")
);
