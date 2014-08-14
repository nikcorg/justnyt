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
        "\\justnyt\\controllers\\PagesController",
        RequestMethods::GET,
        "index"
        )
    ->addAction("faq", null, RequestMethods::GET, "faq")
    ->addAction("kuraattoriksi", null, RequestMethods::GET, "volunteer")
    ->addAction("kuraattorit", null, RequestMethods::GET, "curators")
    ->addAction("historiaa", null, RequestMethods::GET, "history")
    ->addAction("email-info", null, RequestMethods::GET, "emailInfo")
);

Router::addRoute(
    Route::factory(
        "/feed",
        "\\justnyt\\controllers\\FeedController",
        RequestMethods::GET,
        "index"
        )
    ->addAction(
        "rss",
        null,
        RequestMethods::GET,
        "rss"
        )
);

Router::addRoute(
    Route::factory(
        "/parhautta",
        "\\justnyt\\controllers\\RedirectController",
        RequestMethods::GET,
        "redirect"
        )
);

Router::addRoute(
    Route::factory(
        "/s",
        "\\justnyt\\controllers\\RedirectController",
        RequestMethods::NONE
        )
    ->addAction(
        ":hash",
        array("hash" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "hashlookup"
        )
);

Router::addRoute(
    Route::factory(
        "/kuraattori",
        "\\justnyt\\controllers\\CuratorController",
        RequestMethods::NONE
        )
    ->addAction(
        "vapaaehtoiseksi",
        null,
        RequestMethods::POST,
        "volunteer"
        )
    ->addAction(
        ":token/aktivoi",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET | RequestMethods::POST,
        "activate"
        )
    ->addAction(
        ":token/tervetuloa",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "home"
        )
    ->addAction(
        ":token/profiili",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET | RequestMethods::POST,
        "profile"
        )
    ->addAction(
        ":token/jonossa",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "pending"
        )
    ->addAction(
        ":token/seuraava",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET | RequestMethods::POST,
        "createToken"
        )
);

Router::addRoute(
    Route::factory(
        "/kuraattori",
        "\\justnyt\\controllers\\RecommendationController",
        RequestMethods::NONE
        )
    ->addAction(
        ":token/esikatsele",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "prepare"
        )
    ->addAction(
        ":token/suosittelut/:id",
        array("token" => RouteVariableTypes::ALNUM, "id" => RouteVariableTypes::NUMBER),
        RequestMethods::POST | RequestMethods::PUT,
        "approve"
        )
    ->addAction(
        ":token/scrape/:id",
        array("token" => RouteVariableTypes::ALNUM, "id" => RouteVariableTypes::NUMBER),
        RequestMethods::GET,
        "scrape"
        )
);
