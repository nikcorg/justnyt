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
            ->findOneByInviteToken($token);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E404Exception("Token not found");
        }

        if ($this->request->isPost()) {
            $currentCurator = \justnyt\models\CuratorQuery::create("cr")
                ->where("cr.ActivatedOn IS NOT NULL")
                ->orderByActivatedOn("DESC")
                ->findOne();

            try {
                $curator->activate();
                $currentCurator->deactivate();

                if (null != $currentCurator->getProfile()->getEmail()) {
                    $approved = $currentCurator->getApprovedRecommendations();

                    $msg = new \Nette\Mail\Message();
                    $msg->setFrom("JustNyt <justnytfi@gmail.com>")
                        ->addTo($currentCurator->getProfile()->getEmail())
                        ->setSubject("Kuraattorinkautesi on päättynyt")
                        ->setBody(
                            \glue\ui\View::quickRender(
                                "email/account-deactivated",
                                array(
                                    "approved" => $approved
                                )
                            )
                        );

                    $mailer = new \Nette\Mail\SendmailMailer();
                    $mailer->send($msg);
                }
            } catch (\Exception $e) {
                throw new \glue\exceptions\http\E500Exception("Error activating curator", 0, $e);
            }

            throw new \glue\exceptions\http\E303Exception("/kuraattori/".$curator->getToken()."/tervetuloa");
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

    protected function getFreeCandidate() {
        $volunteer = \justnyt\models\CandidateQuery::create("cd")
            ->nextFree()
            ->joinCurator("cr")
            ->useCuratorQuery("cr")
                ->where("cr.ActivatedOn IS NULL")
                ->endUse()
            ->findOne();

        return $volunteer;
    }

    protected function getInvitedCandidate() {
        $volunteer = \justnyt\models\CandidateQuery::create("cd")
            ->invitePending()
            ->joinCurator("cr")
            ->useCuratorQuery("cr")
                ->where("cr.ActivatedOn IS NULL")
                ->endUse()
            ->findOne();

        return $volunteer;
    }

    protected function getInactiveCurator() {
        $curator = \justnyt\models\CuratorQuery::create("cr")
            ->where("cr.ActivatedOn IS NULL")
            ->findOne();

        // if (is_null($curator)) {
        //     $curator = new \justnyt\models\Curator();
        //     $curator->generateToken();
        //     $curator->save();
        // }

        return $curator;
    }

    protected function doSendInviteMail($candidate, $next) {
        $activationUrl = sprintf(
            "http://%s/kuraattori/%s/tervetuloa",
            $_SERVER["HTTP_HOST"],
            $next->getInviteToken()
        );

        $msg = new \Nette\Mail\Message();
        $msg->setFrom("JustNyt <justnytfi@gmail.com>")
            ->addTo($candidate->getEmail())
            ->setSubject("JustNyt tarvitsee kuraattoria")
            ->setBody(
                \glue\ui\View::quickRender(
                    "email/curator-invite",
                    array(
                        "url" => $activationUrl
                    )
                )
            );

        $candidate->setInvitedOn(time());
        $candidate->setInvitesSent($candidate->getInvitesSent() + 1);
        $candidate->save();

        $mailer = new \Nette\Mail\SendmailMailer();
        return $mailer->send($msg);
    }

    protected function doRedactInvite($candidate) {
        $msg = new \Nette\Mail\Message();
        $msg->setFrom("JustNyt <justnytfi@gmail.com>")
            ->addTo($candidate->getEmail())
            ->setSubject("JustNyt tarvitsee kuraattoria")
            ->setBody(
                \glue\ui\View::quickRender(
                    "email/curator-invite-redacted",
                    array(
                        "url" => $activationUrl
                    )
                )
            );

        $candidate->setInvitedRedactedOn(time());
        $candidate->save();

        $mailer = new \Nette\Mail\SendmailMailer();
        return $mailer->send($msg);
    }

    protected function deleteInactiveCurator() {
        $next = $this->getInactiveCurator();

        if (null != $next) {
            $next->delete();
        }
    }

    protected function doHandleInvite($curator) {
        $action = $this->request->POST->action;
        $invited = $this->getInvitedCandidate();
        $volunteer = $this->getFreeCandidate();

        // var_dump($invited->toJSON()); die();

        if ($action == "next-in-queue") {
            $this->deleteInactiveCurator();

            $next = new \justnyt\models\Curator();
            $next->setCandidate($volunteer);
            $next->save();

            $this->doSendInviteMail($volunteer, $next);
        } elseif ($action == "manual-invite") {
            $next = new \justnyt\models\Curator();
            $next->save();
        } elseif ($action == "redact-invite") {
            if (null != $invited) {
                $invited->setInviteRedactedOn(time());
                $invited->save();
            }

            $next = $this->getInactiveCurator();
            $next->delete();
        }

        throw new \glue\exceptions\http\E303Exception("/kuraattori/" . $curator->getToken() . "/seuraava");
    }

    public function invite($token) {
        $curator = $this->getCurator($token);

        if ($this->request->isPost()) {
            return $this->doHandleInvite($curator);
        }

        $next = $this->getInactiveCurator();
        $invited = $this->getInvitedCandidate();
        $volunteer = $this->getFreeCandidate();

        if (null != $next && null != $next->getCandidateId()) {
            $graceUntil = $invited->getInvitedOn()->add(new \DateInterval("PT2H"));
            $now = \DateTime::createFromFormat("U", $_SERVER["REQUEST_TIME"]);

            return $this->response->setContent(
                \justnyt\views\JustNytLayout::quickRender(
                    "curator/invite-sent",
                    array(
                        "title" => "Kutsu lähetettiin",
                        "curator" => $curator,
                        "graceUntil" => $graceUntil,
                        "graceElapsed" => $now > $graceUntil
                    )
                )
            );
        } elseif (null != $next && null == $next->getCandidateId()) {
            $activationUrl = sprintf(
                "http://%s/kuraattori/%s/tervetuloa",
                $_SERVER["HTTP_HOST"],
                $next->getInviteToken()
            );

            return $this->response->setContent(
                \justnyt\views\JustNytLayout::quickRender(
                    "curator/invite-manual",
                    array(
                        "title" => "Kutsu seuraava kuraattori",
                        "curator" => $curator,
                        "activationUrl" => $activationUrl,
                    )
                )
            );
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/invite-successor",
                array(
                    "title" => "Kutsu seuraava kuraattori",
                    "curator" => $curator,
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
            $alias = trim($this->request->POST->alias);
            $email = trim($this->request->POST->email);
            $homepage = trim($this->request->POST->homepage);
            $description = trim(strip_tags($this->request->POST->description));

            $aliasIsSet = null != $alias;
            $emailIsSet = null != $email;

            $check = true;

            // TODO: reduce number of queries, even though this is probably a rarely invoked action
            if ($emailIsSet) {
                /* if email is set, it needs to be checked it matches the alias or no other reserved alias */
                $bothMatch = $aliasIsSet && count(
                    \justnyt\models\ProfileQuery::create("pr")
                        ->where("pr.Alias = ?", $alias)
                        ->where("pr.Email = ?", $email)
                        ->find()
                ) == 1;
                $aliasNotReserved = count(
                    \justnyt\models\ProfileQuery::create("pr")
                        ->where("pr.Alias = ?", $alias)
                        ->where("pr.Email IS NOT NULL")
                        ->find()
                ) == 0;

                $check = $bothMatch || $aliasNotReserved;
            } else {
                /* if email is not set, alias needs to be verified it's not reserved */
                $aliasNotReserved = count(
                    \justnyt\models\ProfileQuery::create("pr")
                        ->where("pr.Alias = ?", $alias)
                        ->where("pr.Email IS NOT NULL")
                        ->find()
                ) == 0;

                $check = $aliasNotReserved;
            }

            if ($check) {
                $emailExists = \justnyt\models\ProfileQuery::create("pr")
                    ->where("pr.Email = ?", $email)
                    ->findOne();

                if (null != $emailExists) {
                    $profile = $emailExists;
                }

                try {
                    $profile->setAlias($this->request->POST->alias);
                    $profile->setHomepage($this->request->POST->homepage);
                    $profile->setDescription($this->request->POST->description);
                    $profile->setEmail($this->request->POST->email);

                    $curator->setProfile($profile);
                    $curator->save();
                } catch (\Exception $e) {
                    throw new \glue\exceptions\http\E500Exception("Error saving profile", 0, $e);
                }
            } else {
                // TODO: display an error message
            }
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/profile",
                array(
                    "title" => "Muokkaa profiiliasi",
                    "curator" => $curator,
                    "alias" => $profile->getAlias(),
                    "homepage" => $profile->getHomepage(),
                    "description" => $profile->getDescription(),
                    "email" => $profile->getEmail(),
                    "scripts" => array("/assets/js/app.js")
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
                    "title" => "Julkaisujono",
                    "curator" => $curator,
                    "currentTime" => new \DateTime(),
                    "upcoming" => $upcoming
                )
            )
        );
    }

    public function approved($token) {
        $curator = $this->getCurator($token);
        $approved = $curator->getApprovedRecommendations();

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/approved",
                array(
                    "title" => "Julkaistut suositukset",
                    "curator" => $curator,
                    "approved" => $approved
                )
            )
        );
    }

    public function hints($token) {
        $curator = $this->getCurator($token);
        $hints = \justnyt\models\RecommendationHintQuery::create("rh")
            ->where("rh.DroppedOn IS NULL")
            ->useRecommendationQuery("r")
                ->endUse()
            ->groupByRecommendationHintId()
            ->having("COUNT(r.RecommendationId) = 0")
            ->orderByCreatedOn("DESC")
            ->find();

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "curator/hints",
                array(
                    "title" => "Selaa vinkkejä",
                    "curator" => $curator,
                    "hints" => $hints,
                    "scripts" => array("/assets/js/app.js")
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
                    "curator" => $curator,
                    "host" => $_SERVER["HTTP_HOST"]
                )
            )
        );
    }
}
