<?php

namespace DevGroup\Entity\widgets;

use DevGroup\Users\helpers\ModelMapHelper;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class BaseActionsInfoWidget
 * @package DevGroup\Entity\widgets
 */
class BaseActionsInfoWidget extends Widget
{
    const ATTRIBUTE_TYPE_USER = 'user';
    const ATTRIBUTE_TYPE_DATE = 'date';

    /**
     * @var array
     */
    protected $attributesList = [
        'createdByAttribute' => self::ATTRIBUTE_TYPE_USER,
        'createdAtAttribute' => self::ATTRIBUTE_TYPE_DATE,
        'updatedByAttribute' => self::ATTRIBUTE_TYPE_USER,
        'updatedAtAttribute' => self::ATTRIBUTE_TYPE_DATE,
    ];

    /**
     * @var array
     */
    protected $users = [];

    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @var string
     */
    public $viewFile = 'base-actions-info-default';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $attributes = [];
        foreach ($this->attributesList as $attributeNameAttribute => $type) {
            $attributeName = $this->model->{$attributeNameAttribute};
            if ($this->model->hasAttribute($attributeName)) {
                $attributes[] = [
                    'label' => $this->model->getAttributeLabel($attributeName),
                    'value' => $this->getValue($this->model->{$attributeName}, $type),
                    'type' => $type,
                ];
            }
        }
        echo $this->render(
            $this->viewFile,
            [
                'attributes' => $attributes,
            ]
        );
    }

    /**
     * Get pretty value by type
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    protected function getValue($value, $type)
    {
        switch ($type) {
            case self::ATTRIBUTE_TYPE_USER:
                return $this->getUsername($value);
            case self::ATTRIBUTE_TYPE_DATE:
                return date('Y-m-d h:i:s', $value);
            default:
                return $value;
        }
    }

    /**
     * @param int $id
     * @return string
     */
    protected function getUsername($id)
    {
        if (empty($id)) {
            return \Yii::t('entity', 'Guest');
        }
        if (!isset($this->users[$id])) {
            $this->users[$id] = call_user_func([ModelMapHelper::User()['class'], 'find'])
                ->select(new Expression("CONCAT(`username`, ' (', `id`, ')')"))
                ->where(['id' => $id])
                ->scalar();
        }
        return isset($this->users[$id]) ? $this->users[$id] : \Yii::t('entity', 'Unknown user');
    }
}
