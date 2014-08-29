<?php
if (getenv("MAINTENANCE")) {
    header("Content-Type: text/html; charset=utf-8", true, 503);
    readfile(dirname(__FILE__) . "/maintenance.html");
    die();
}

define("GLUE_APPHOME", dirname(__DIR__));
define("GLUE_CONFIG", GLUE_APPHOME . "/config.php");
define("GLUE_RUNNER", "\\justnyt\\JustNytApp");

if (getenv("APP_ENVIRONMENT") !== "production") {
    define("GLUE_DEBUG", true);
}

require GLUE_APPHOME . "/glue/bootstrap.php";
