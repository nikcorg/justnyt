<?php
define("GLUE_APPHOME", dirname(__DIR__));
define("GLUE_CONFIG", GLUE_APPHOME . "/config.php");
define("GLUE_RUNNER", "\\justnyt\\JustNytApp");

if (getenv("APP_ENVIRONMENT") !== "prod") {
    define("GLUE_DEBUG", true);
}

require GLUE_APPHOME . "/glue/bootstrap.php";
