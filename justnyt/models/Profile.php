<?php

namespace justnyt\models;

use justnyt\models\Base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function getAllCuratorRecommendations() {
        $email = $this->getEmail();
        $query = <<<EOT
SELECT profile.PROFILE_ID, profile.ALIAS, profile.HOMEPAGE, profile.EMAIL, profile.IMAGE, profile.DESCRIPTION,

curator.CURATOR_ID, curator.CANDIDATE_ID, curator.PROFILE_ID, curator.TOKEN, curator.INVITE_TOKEN, curator.CREATED_ON, curator.ACTIVATED_ON, curator.DEACTIVATED_ON,
recommendation.RECOMMENDATION_ID, recommendation.CURATOR_ID, recommendation.RECOMMENDATION_HINT_ID, recommendation.CREATED_ON, recommendation.SCRAPED_ON, recommendation.APPROVED_ON, recommendation.GRAPHIC_CONTENT, recommendation.SHORTLINK, recommendation.URL, recommendation.TITLE
FROM `profile`
INNER JOIN `curator` ON (profile.PROFILE_ID=curator.PROFILE_ID)
INNER JOIN `recommendation` ON (curator.CURATOR_ID=recommendation.CURATOR_ID)
WHERE profile.EMAIL = :email
AND recommendation.APPROVED_ON IS NOT NULL
AND recommendation.APPROVED_ON < NOW()
ORDER BY curator.ACTIVATED_ON DESC,recommendation.APPROVED_ON DESC
EOT;
        $con = \Propel\Runtime\Propel::getConnection();
        $stmt = $con->prepare($query);
        $stmt->bindParam(":email", $email);
        $res = $stmt->execute();

        return $stmt;
    }
}
