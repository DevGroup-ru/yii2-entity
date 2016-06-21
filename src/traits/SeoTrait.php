<?php

namespace DevGroup\Entity\traits;

use Yii;

trait SeoTrait
{
    public function SeoTraitRules()
    {
        return [
            [['title', 'h1', 'breadcrumbs_label', 'meta_description'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => '#^[A-Za-z\d-_]+$#'],
            ['slug', 'string', 'max' => 80],
            ['slug', 'required'],
        ];
    }

    public function SeoTraitAttributeLabels()
    {
        return [
            'title' => Yii::t('entity', 'Title'),
            'h1' => Yii::t('entity', 'H1'),
            'breadcrumbs_label' => Yii::t('entity', 'Breadcrumbs label'),
            'meta_description' => Yii::t('entity', 'Meta description'),
            'slug' => Yii::t('entity', 'Last url part'),
        ];
    }
}
