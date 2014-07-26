<?php
namespace justnyt\controllers;

class PagesController extends \glue\Controller
{
    protected function respond($content) {
        $this->response->setContentType("text/html; charset=utf-8");
        $this->response->setContent($content);
    }

    public function index() {
        $this->respond(
            \glue\ui\View::quickRender("layout", array(
                    "title" => "Parhautta &mdash; Just nyt!",
                    "content" => \glue\ui\View::quickRender("pages/index")
                )
            )
        );
    }

    public function volunteer() {
        $this->respond(
            \glue\ui\View::quickRender("layout", array(
                    "title" => "Kuraattoriksi kuraattorin paikalle",
                    "content" => \glue\ui\View::quickRender("pages/volunteer")
                )
            )
        );
    }

    public function faq() {
        $this->respond(
            \glue\ui\View::quickRender("layout", array(
                    "title" => "Kysymyksiä ja vastauksia",
                    "content" => \glue\ui\View::quickRender("pages/faq")
                )
            )
        );
    }

    public function curators() {
        $this->respond(
            \glue\ui\View::quickRender("layout", array(
                    "title" => "Kuraattorit",
                    "content" => \glue\ui\View::quickRender("pages/curators")
                )
            )
        );
    }

    public function history() {
        $this->respond(
            \glue\ui\View::quickRender("layout", array(
                    "title" => "Parhauden historiaa",
                    "content" => \glue\ui\View::quickRender("pages/history")
                )
            )
        );
    }
}
