<?php
namespace justnyt\controllers;

class CuratorController extends \glue\Controller
{
    protected function getCurator($token) {
        $curator = \justnyt\models\CuratorQuery::create()->getActiveCuratorByToken($token);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E403Exception();
        }

        return $curator;
    }

    public function home($token) {
        $curator = $this->getCurator($token);

        $this->response->setContent(
            \glue\ui\View::quickRender(
                "layout", array(
                    "content" => \glue\ui\View::quickRender(
                        "kuraattori/home", array(
                            "token" => $token,
                            "host" => $_SERVER["HTTP_HOST"]
                            )
                        ),
                    "title" => "Tervetuloa kuraattorikaudellesi"
                )
            )
        );
    }
}
