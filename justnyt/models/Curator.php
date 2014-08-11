<?php

namespace justnyt\models;

use justnyt\models\Base\Curator as BaseCurator;

class Curator extends BaseCurator
{
    public function activate() {
        $this->setActivatedOn(time());

        return $this->save();
    }
}
