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

\glue\utils\Config::setConfig(
    array(
        "minOnline" => new \DateInterval("PT3H"),
        "delays" => array(
            "Heti" => new \DateInterval("PT0H"),
            "+1h" => new \DateInterval("PT1H"),
            "+3h" => new \DateInterval("PT3H"),
            "+6h" => new \DateInterval("PT6H"),
            "+9h" => new \DateInterval("PT9H"),
            "+12h" => new \DateInterval("PT12H")
        )
    ),
    "recommendations"
);

Router::addRoute(
    Route::factory(
        "/",
        "\\justnyt\\controllers\\PagesController",
        RequestMethods::GET | RequestMethods::HEAD,
        "index"
    )
    ->addAction("faq", null, RequestMethods::GET | RequestMethods::HEAD, "faq")
    ->addAction("kuraattoriksi", null, RequestMethods::GET | RequestMethods::HEAD, "volunteer")
    ->addAction("kuraattorit", null, RequestMethods::GET | RequestMethods::HEAD, "curators")
    ->addAction("historiaa", null, RequestMethods::GET | RequestMethods::HEAD, "history")
    ->addAction("email-info", null, RequestMethods::GET, "emailInfo")
    ->addAction("ilmianna-blogikirjoitus", null, RequestMethods::GET | RequestMethods::POST | RequestMethods::HEAD, "submitUrl")
);

Router::addRoute(
    Route::factory(
        "/profiles",
        "\\justnyt\\controllers\\ProfileController",
        RequestMethods::GET,
        "lookup"
    )
);
Router::addRoute(
    Route::factory(
        "/profiilit",
        "\\justnyt\\controllers\\ProfileController",
        RequestMethods::NONE,
        null
    )
    ->addAction(
        ":cid-:pid/:alias",
        array(
            "cid" => RouteVariableTypes::NUMBER,
            "pid" => RouteVariableTypes::NUMBER,
            "alias" => RouteVariableTypes::SLUG
        ),
        RequestMethods::GET | RequestMethods::HEAD,
        "profile"
    )
);

Router::addRoute(
    Route::factory(
        "/feed",
        "\\justnyt\\controllers\\FeedController",
        RequestMethods::GET | RequestMethods::HEAD,
        "index"
    )
    ->addAction(
        "rss",
        null,
        RequestMethods::GET | RequestMethods::HEAD,
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
        "/referral-cloak",
        "\\justnyt\\controllers\\RedirectController",
        RequestMethods::GET,
        "cloak"
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
        RequestMethods::GET | RequestMethods::HEAD,
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
        ":token/julkaistut",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "approved"
    )
    ->addAction(
        ":token/seuraava",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET | RequestMethods::POST,
        "invite"
    )
    ->addAction(
        ":token/vinkatut",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "hints"
    )
);

Router::addRoute(
    Route::factory(
        "/kuraattori",
        "\\justnyt\\controllers\\RecommendationController",
        RequestMethods::NONE
    )
    ->addAction(
        ":token/uusi-suositus",
        array("token" => RouteVariableTypes::ALNUM),
        RequestMethods::GET,
        "create"
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
