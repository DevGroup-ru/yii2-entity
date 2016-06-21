<?php

namespace tests\models;

use DevGroup\Entity\traits\BaseActionsInfoTrait;
use DevGroup\Entity\traits\EntityTrait;
use yii\db\ActiveRecord;

class Slide extends ActiveRecord
{
    use EntityTrait;
    use BaseActionsInfoTrait;

    public $blameableAttributes = [
        ActiveRecord::EVENT_BEFORE_INSERT => ['updated_by'],
        ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
    ];

    public $createdAtAttribute = 'create_time';
    public $updatedAtAttribute = 'update_time';

    protected $rules = [
        [['src', 'alt', 'description'], 'string', 'max' => 255],
        ['src', 'required'],
    ];

    public static function tableName()
    {
        return 'slide';
    }
}
