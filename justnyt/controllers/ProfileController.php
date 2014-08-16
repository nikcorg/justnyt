<?php
namespace justnyt\controllers;

class ProfileController extends \glue\Controller
{
    public function lookup() {
        $profiles = \justnyt\models\ProfileQuery::create()
            ->select(array("ProfileId", "Alias", "Homepage", "Description"))
            ->withColumn("Email IS NOT NULL", "Reserved");

        if (null != $this->request->GET->email) {
            $profiles->filterByEmail($this->request->GET->email);
        }

        if (null != $this->request->GET->alias) {
            $profiles->filterByAlias($this->request->GET->alias);
        }

        $this->response->setJSONContent($profiles->find()->toJSON());
    }

    public function profile($curatorId, $profileId, $alias) {
        $curator = \justnyt\models\CuratorQuery::create("cr")
            ->joinWith("Profile")
            ->joinProfile("pr")
            ->where("pr.Alias IS NOT NULL")
            ->where("pr.Alias != ''")
            ->where("pr.ProfileId = ?", $profileId)
            ->where("cr.CuratorId = ?", $curatorId)
            ->findOne();

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $profile = $curator->getProfile();

        if (! is_null($profile->getEmail())) {
            $recommendations = null;
            $profiles = \justnyt\models\ProfileQuery::create("pr")
                ->joinWith("Profile.Curator")
                ->joinWith("Curator.Recommendation")
                ->useCuratorQuery("cr")
                    ->useRecommendationQuery("re")
                        ->endUse()
                    ->endUse()
                ->where("pr.Email = ?", $profile->getEmail())
                ->orderBy("cr.ActivatedOn", "DESC")
                ->orderBy("re.ApprovedOn", "ASC")
                ->find();
        } else {
            $profiles = null;
            $recommendations = $curator->getRecommendations();
        }

        $this->response->setContentType("text/html; charset=utf-8");
        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "profile/profile",
                array(
                    "title" => $profile->getAlias(),
                    "sessionBegin" => $curator->getActivatedOn(),
                    "sessionEnd" => $curator->getDeactivatedOn(),
                    "profile" => $profile,
                    "recommendations" => $recommendations,
                    "profiles" => $profiles
                    )
                )
        );
    }
}
