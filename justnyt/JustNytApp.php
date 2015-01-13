<?php
namespace justnyt;

class JustNytApp extends \glue\Runnable
{
    protected function configure() {
        \glue\net\Response::setGlobalHeader("Strict-Transport-Security", "max-age=14515200; includeSubDomains");

        return parent::configure();
    }
}
