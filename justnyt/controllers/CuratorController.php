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

    public function volunteer() {
        $candidateEmail = $this->request->POST->email;
        $check = \justnyt\models\CandidateQuery::create("cd")
            ->joinCurator("cr")
            ->useCuratorQuery("cr")
                ->where("cr.ActivatedOn IS NULL")
                ->endUse()
            ->findByEmail($candidateEmail);

        // Silently ignore duplicate entries
        if (count($check) < 1) {
            try {
                $curator = new \justnyt\models\Candidate();
                $curator->setCreatedOn(time());
                $curator->setEmail($candidateEmail);
                $curator->save();
            } catch (\Exception $e) {
                throw new \glue\exceptions\http\E500Exception("Virhe tietojen tallennuksessa");
            }
        }

        $this->response->setContent(
            \glue\ui\View::quickRender(
                "layout", array(
                    "title" => "Olet jonossa",
                    "content" => \glue\ui\View::quickRender("kuraattori/volunteer")
                )
            )
        );
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
