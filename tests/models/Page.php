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

    protected $attributeLabels = [
        'url' => 'Page url',
    ];

    public static function tableName()
    {
        return 'page';
    }
}
