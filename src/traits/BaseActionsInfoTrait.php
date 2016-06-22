<?php

namespace DevGroup\Entity\traits;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class BaseActionsInfoTrait
 * This trait attaches a timeatamp and a blameable behaviors.
 *
 * @property array $blameableAttributes array list of attributes that are to be automatically filled with the value specified via [[value]].
 * The array keys are the ActiveRecord events upon which the attributes are to be updated,
 * and the array values are the corresponding attribute(s) to be updated. You can use a string to represent
 * a single attribute, or an array to represent a list of attributes. For example,
 *
 * ```php
 * [
 *     ActiveRecord::EVENT_BEFORE_INSERT => ['attribute1', 'attribute2'],
 *     ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
 * ]
 * ```
 *
 * @property array $timestampAttributes array list of attributes that are to be automatically filled with the value specified via [[value]].
 * The array keys are the ActiveRecord events upon which the attributes are to be updated,
 * and the array values are the corresponding attribute(s) to be updated. You can use a string to represent
 * a single attribute, or an array to represent a list of attributes. For example,
 *
 * ```php
 * [
 *     ActiveRecord::EVENT_BEFORE_INSERT => ['attribute1', 'attribute2'],
 *     ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
 * ]
 * ```
 * @package DevGroup\Entity\traits
 */
trait BaseActionsInfoTrait
{
    protected function getBlameableAttributes()
    {
        return [];
    }

    protected function getCreatedByAttribute()
    {
        return 'created_by';
    }

    protected function getUpdatedByAttribute()
    {
        return 'updated_by';
    }

    protected function getTimestampAttributes()
    {
        return [];
    }

    protected function getCreatedAtAttribute()
    {
        return 'created_at';
    }

    protected function getUpdatedAtAttribute()
    {
        return 'updated_at';
    }

    public function BaseActionsInfoTraitInit()
    {
        /** @var ActiveRecord $this */
        $this->attachBehavior(
            'blameable',
            [
                'class' => BlameableBehavior::class,
                'attributes' => $this->blameableAttributes,
                'createdByAttribute' => $this->createdByAttribute,
                'updatedByAttribute' => $this->updatedByAttribute,
            ]
        );
        $this->attachBehavior(
            'timestamp',
            [
                'class' => TimestampBehavior::class,
                'attributes' => $this->timestampAttributes,
                'createdAtAttribute' => $this->createdAtAttribute,
                'updatedAtAttribute' => $this->updatedAtAttribute,
            ]
        );
    }
}
