<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    public function redirect() {
        throw new \glue\exceptions\http\E303Exception("http://kakspistenolla.com");
    }
}
