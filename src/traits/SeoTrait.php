<?php

namespace DevGroup\Entity\traits;

trait SeoTrait
{
    public function SeoTraitRules()
    {
        return [
            [['title', 'h1', 'breadcrumbs_label', 'meta_description'], 'string', 'max' => 255],
        ];
    }
}
