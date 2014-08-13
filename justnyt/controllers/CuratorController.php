<?php
namespace justnyt\controllers;

class CuratorController extends \glue\Controller
{
    protected function getCurator($token, $throw = true) {
        $curator = \justnyt\models\CuratorQuery::create()->getActiveCuratorByToken($token);

        if ($throw && is_null($curator)) {
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
            \justnyt\views\JustNytLayout::quickRender(
                "curator/volunteer",
                array(
                    "title" => "Olet jonossa"
                    )
                )
        );
    }

    public function activate($token) {
        $curator = \justnyt\models\CuratorQuery::create("cr")
            ->where("cr.ActivatedOn IS NULL")
            ->findOneByToken($token);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E404Exception("Token not found");
        }

        if ($this->request->isPost()) {
            $curator->activate();
            throw new \glue\exceptions\http\E303Exception("/kuraattori/$token/tervetuloa");
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/activate",
                array(
                    "title" => "Aktivoi tilisi",
                    "token" => $token
                    )
                )
        );
    }

    public function createToken($token) {
        $curator = $this->getCurator($token);
        $candidate = \justnyt\models\CuratorQuery::create("cr")
            ->where("cr.ActivatedOn IS NULL")
            ->findOne();

        $volunteer = $check = \justnyt\models\CandidateQuery::create("cd")
            ->joinCurator("cr")
            ->useCuratorQuery("cr")
                ->where("cr.ActivatedOn IS NULL")
                ->endUse()
            ->orderByCreatedOn("ASC")
            ->findOne();

        if (is_null($candidate)) {
            $candidate = new \justnyt\models\Curator();
            $candidate->generateToken();
            $candidate->save();
        }

        $activationUrl = sprintf("http://%s/kuraattori/%s/tervetuloa", $_SERVER["HTTP_HOST"], $candidate->getToken());
        $mailSent = false;

        if ($this->request->isPost() && intval($this->request->POST->volunteer) == 1) {
            $msg = new \Nette\Mail\Message();
            $msg->setFrom("JustNyt <justnytfi@gmail.com>")
                ->addTo($volunteer->getEmail())
                ->setSubject("JustNyt tarvitsee kuraattoria")
                ->setBody(\glue\ui\View::quickRender(
                    "curator/email-body", array(
                        "url" => $activationUrl
                        )
                    )
                );

            $mailer = new \Nette\Mail\SendmailMailer();
            $mailer->send($msg);

            $candidate->setCandidate($volunteer);
            $candidate->save();

            $mailSent = true;
            // var_dump($volunteer->getEmail(), $mailer->send($msg));die();
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/create-token",
                array(
                    "title" => "Kutsu seuraava kuraattori",
                    "token" => $token,
                    "mailSent" => $mailSent,
                    "activationUrl" => $activationUrl,
                    "volunteers" => ! is_null($volunteer)
                    )
                )
        );
    }

    public function profile($token) {
        $curator = $this->getCurator($token);
        $profile = $curator->getProfile();

        if (is_null($profile)) {
            $profile = new \justnyt\models\Profile();
        }

        if ($this->request->isPost()) {
            try {
                $profile->setAlias($this->request->POST->alias);
                $profile->setHomepage($this->request->POST->homepage);
                $profile->setDescription($this->request->POST->description);

                $curator->setProfile($profile);
                $curator->save();
            } catch (\Exception $e) {
                throw new \glue\exceptions\http\E500Exception("Error saving profile", 0, $e);
            }
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/profile",
                array(
                    "title" => "Muokkaa profiiliasi",
                    "token" => $token,
                    "alias" => $profile->getAlias(),
                    "homepage" => $profile->getHomepage(),
                    "description" => $profile->getDescription()
                    )
                )
        );
    }

    public function pending($token) {
        $curator = $this->getCurator($token);
        $upcoming = \justnyt\models\RecommendationQuery::create("r")
            ->upcomingApproved()
            ->find();

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/pending",
                array(
                    "title" => "Muokkaa profiiliasi",
                    "token" => $token,
                    "currentTime" => new \DateTime(),
                    "upcoming" => $upcoming
                    )
                )
        );
    }

    public function home($token) {
        $curator = $this->getCurator($token, false);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E303Exception("/kuraattori/$token/aktivoi");
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/home",
                array(
                    "title" => "Tervetuloa kuraattorikaudellesi",
                    "token" => $token,
                    "host" => $_SERVER["HTTP_HOST"]
                    )
                )
        );
    }
}
