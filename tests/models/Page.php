<?php

namespace tests\models;

use DevGroup\Entity\traits\BaseActionsInfoTrait;
use DevGroup\Entity\traits\EntityTrait;
use DevGroup\Entity\traits\SeoTrait;
use yii\db\ActiveRecord;

class Page extends ActiveRecord
{
    use EntityTrait;
    use SeoTrait;
    use BaseActionsInfoTrait;

    protected $rules = [
        ['url', 'string', 'max' => 255],
        ['url', 'required'],
    ];

    public static function tableName()
    {
        return 'page';
    }
}
