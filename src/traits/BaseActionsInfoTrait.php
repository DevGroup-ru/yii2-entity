<?php

namespace DevGroup\Entity\traits;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class BaseActionsInfoTrait
 * This trait attaches a timeatamp and a blameable behaviors.
 * @package DevGroup\Entity\traits
 */
trait BaseActionsInfoTrait
{
    public function BaseActionsInfoTraitInit()
    {
        /** @var ActiveRecord $this */
        $this->attachBehavior(
            'blameable',
            [
                'class' => BlameableBehavior::class,
                // @todo: add an ability to set custom field names
            ]
        );
        $this->attachBehavior(
            'timestamp',
            [
                'class' => TimestampBehavior::class,
                // @todo: add an ability to set custom field names
            ]
        );
    }
}
