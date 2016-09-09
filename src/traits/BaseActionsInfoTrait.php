<?php

namespace DevGroup\Entity\traits;

use Closure;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * Class BaseActionsInfoTrait
 * This trait attaches a timestamp and a blameable behaviors.
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
     * @var boolean whether to skip this behavior when the `$owner` has not been
     * modified
     * @since 2.0.8
     * In case, when the property is `null`, the value of `Yii::$app->user->id` will be used as the value.
     */
    public $blameableValue;

    /**
     * @var boolean whether to skip this behavior when the `$owner` has not been
     * modified
     * @since 2.0.8
     * In case, when the value is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    public $timestampValue;

    /**
     * Get default attributes for Blameable behavior.
     * If you need to set a custom attributes, just add a `blameableAttributes` field to your model.
     * @return array
     */
    protected function getBlameableAttributes()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => [$this->createdByAttribute, $this->updatedByAttribute],
            ActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAttribute,
        ];
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
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
            ActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
        ];
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


    protected function getValueInternal($event, $attributeName)
    {
        if ($this->$attributeName instanceof Closure || is_array($this->$attributeName) && is_callable($this->$attributeName)) {
            return call_user_func($this->$attributeName, $event);
        }
        return $this->$attributeName;
    }

    protected function getBlameableValue($event)
    {
        if ($this->blameableValue === null) {
            $user = Yii::$app->get('user', false);
            return $user && !$user->isGuest ? $user->id : null;
        }
        return $this->getValueInternal($event, 'blameableValue');
    }

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    protected function getTimestampValue($event)
    {
        if ($this->timestampValue === null) {
            return time();
        }
        return $this->getValueInternal($event, 'timestampValue');
    }

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributesInternal($event)
    {
        if (empty($event->data['attributes']) === false) {
            $methodName = $event->data['methodName'];
            $value = $this->$methodName($event);
            foreach ((array) $event->data['attributes'] as $attribute) {
                if (is_string($attribute)) {
                    $this->$attribute = $value;
                }
            }
        }
    }

    /**
     * Init a trait.
     * There is an event attaching here.
     */
    public function BaseActionsInfoTraitInit()
    {
        /** @var ActiveRecord|self $this */
        foreach ($this->blameableAttributes as $eventName => $attributes) {
            $this->on(
                $eventName,
                [$this, 'evaluateAttributesInternal'],
                [
                    'attributes' => $attributes,
                    'methodName' => 'getBlameableValue',
                ]
            );
        }
        foreach ($this->timestampAttributes as $eventName => $attributes) {
            $this->on(
                $eventName,
                [$this, 'evaluateAttributesInternal'],
                [
                    'attributes' => $attributes,
                    'methodName' => 'getTimestampValue',
                ]
            );
        }
    }
}
