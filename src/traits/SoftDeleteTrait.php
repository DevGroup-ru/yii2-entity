<?php

namespace DevGroup\Entity\traits;

use yii\db\ActiveRecord;
use yii\base\ModelEvent;
use Yii;

/**
 * Class SoftDeleteTrait
 * @property string $isDeletedAttribute
 * @package DevGroup\Entity\traits
 */
trait SoftDeleteTrait
{
    /**
     * @var bool whether to use a soft deletion.
     */
    protected $softMode = true;

    /**
     * Get a default attribute name.
     * If you need to set custom attribute name just add a field `isDeletedAttribute` to your model.
     * @return string
     */
    protected function getIsDeletedAttribute()
    {
        return 'is_deleted';
    }

    /**
     * Init a trait.
     * There is an event attaching here.
     */
    public function SoftDeleteTraitInit()
    {
        /** @var ActiveRecord $this */
        $this->on(
            ActiveRecord::EVENT_BEFORE_DELETE,
            [$this, 'SoftDeleteTraitInitHandler'],
            null,
            false
        );
    }

    /**
     * Get attribute labels list
     * @return array attributes list
     */
    public function SoftDeleteTraitAttributeLabels()
    {
        return [
            $this->isDeletedAttribute => Yii::t('entity', 'Deleted'),
        ];
    }

    /**
     * Get trait rules
     * @return array rules list
     */
    public function SoftDeleteTraitRules()
    {
        return [
            [$this->isDeletedAttribute, 'filter', 'filter' => 'boolval'],
        ];
    }

    /**
     * @param ModelEvent $event
     */
    public function SoftDeleteTraitInitHandler(ModelEvent $event)
    {
        if ($event->sender->softMode === true) {
            if ($event->sender->{$event->sender->isDeletedAttribute} != true) {
                $event->sender->{$event->sender->isDeletedAttribute} = true;
                $event->sender->save(true, [$event->sender->isDeletedAttribute]);
            }
            $event->isValid = false;
        }
    }

    /**
     * Delete a record from database.
     * @return false|int
     * @throws \Exception
     */
    public function hardDelete()
    {
        $this->softMode = false;
        /** @var ActiveRecord $this */
        return $this->delete();
    }

    /**
     * Restore a record after soft deleting.
     * @return bool
     */
    public function restore()
    {
        /** @var ActiveRecord $this */
        if ($this->{$this->isDeletedAttribute} != false) {
            $this->{$this->isDeletedAttribute} = false;
            return $this->save(true, [$this->isDeletedAttribute]);
        }
        return true;
    }
}
