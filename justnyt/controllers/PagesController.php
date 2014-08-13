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
            \justnyt\views\JustNytLayout::quickRender(
                "pages/index",
                array(
                    "title" => "Parhautta &mdash; Just nyt!"
                    )
                )
        );
    }

    public function volunteer() {
        $this->respond(
            \justnyt\views\JustNytLayout::quickRender(
                "pages/volunteer",
                array(
                    "title" => "Kuraattoriksi kuraattorin paikalle",
                    )
                )
        );
    }

    public function faq() {
        $this->respond(
            \justnyt\views\JustNytLayout::quickRender(
                "pages/faq",
                array(
                    "title" => "Kysymyksiä ja vastauksia"
                    )
                )
        );
    }

    public function curators() {
        $curators = \justnyt\models\CuratorQuery::create("cr")
            ->useProfileQuery("pr")
                ->where("pr.Alias IS NOT NULL")
                ->where("pr.Alias != ''")
                ->endUse()
            ->joinProfile("pr")
            ->where("cr.ActivatedOn IS NOT NULL")
            ->orderByActivatedOn("DESC")
            ->find();

        $this->respond(
            \justnyt\views\JustNytLayout::quickRender(
                "pages/curators",
                array(
                    "title" => "Kuraattorit",
                    "curators" => $curators
                    )
                )
        );
    }

    public function history() {
        $recommendations = \justnyt\models\RecommendationQuery::create("r")
            ->latestApproved()
            ->find();

        $this->respond(
            \justnyt\views\JustNytLayout::quickRender(
                "pages/history",
                array(
                    "title" => "Parhauden historiaa",
                    "recommendations" => $recommendations
                    )
                )
        );
    }
}
