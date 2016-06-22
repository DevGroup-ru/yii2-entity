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
    /**
     * @var bool whether to use a Blameable behavior
     */
    public $useBlameable = true;

    /**
     * @var bool whether to use a Timestamp behavior
     */
    public $useTimestamp = true;

    /**
     * Get default attributes for Blameable behavior.
     * If you need to set a custom attributes, just add a `blameableAttributes` field to your model.
     * @return array
     */
    protected function getBlameableAttributes()
    {
        return [];
    }

    /**
     * Get default value of createdByAttribute for Blameable behavior.
     * If you need to set a custom name of attribute, just add a `createdByAttribute` field to your model.
     * @return array
     */
    protected function getCreatedByAttribute()
    {
        return 'created_by';
    }

    /**
     * Get default value of updatedByAttribute for Blameable behavior.
     * If you need to set a custom name of attribute, just add an `updatedByAttribute` field to your model.
     * @return array
     */
    protected function getUpdatedByAttribute()
    {
        return 'updated_by';
    }

    /**
     * Get default attributes for Timestamp behavior.
     * If you need to set a custom attributes, just add a `timestampAttributes` field to your model.
     * @return array
     */
    protected function getTimestampAttributes()
    {
        return [];
    }

    /**
     * Get default value of createdAtAttribute for Timestamp behavior.
     * If you need to set a custom name of attribute, just add an `createdAtAttribute` field to your model.
     * @return array
     */
    protected function getCreatedAtAttribute()
    {
        return 'created_at';
    }

    /**
     * Get default value of updatedAtAttribute for Timestamp behavior.
     * If you need to set a custom name of attribute, just add an `updatedAtAttribute` field to your model.
     * @return array
     */
    protected function getUpdatedAtAttribute()
    {
        return 'updated_at';
    }

    /**
     * Init a trait.
     * There is an event attaching here.
     */
    public function BaseActionsInfoTraitInit()
    {
        /** @var ActiveRecord|self $this */
        if ($this->useBlameable) {
            $this->attachBehavior(
                'blameable',
                [
                    'class' => BlameableBehavior::class,
                    'attributes' => $this->blameableAttributes,
                    'createdByAttribute' => $this->createdByAttribute,
                    'updatedByAttribute' => $this->updatedByAttribute,
                    // @todo add value attribute
                ]
            );
        }
        if ($this->useTimestamp) {
            $this->attachBehavior(
                'timestamp',
                [
                    'class' => TimestampBehavior::class,
                    'attributes' => $this->timestampAttributes,
                    'createdAtAttribute' => $this->createdAtAttribute,
                    'updatedAtAttribute' => $this->updatedAtAttribute,
                    // @todo add value attribute
                ]
            );
        }
    }
}
