<?php

namespace DevGroup\Entity\traits;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * Class EntityTrait
 * @package DevGroup\Entity\traits
 */
trait EntityTrait
{
    protected static $traitsList = [];
    protected static $rulesList = [];
    protected static $attributeLabelsList = [];

    protected static function getTraits()
    {
        if (isset(static::$traitsList[static::class]) === false) {
            static::$traitsList[static::class] = [];
            foreach (class_uses(static::class) as $value) {
                static::$traitsList[static::class][$value] = StringHelper::basename($value);
            }
        }
        return static::$traitsList[static::class];
    }

    /**
     * Call a trait method and return a result or null in not exists.
     * This method builds a full method name, checks it and calls if exists.
     * @param string $traitName
     * @param string $methodName
     * @return null|mixed
     */
    protected function callTraitMethod($traitName, $methodName)
    {
        return method_exists($this, $traitName . $methodName)
            ? $this->{$traitName . $methodName}()
            : null;
    }

    /**
     * Call trait event methods.
     * @param string $eventName
     */
    protected function callEvents($eventName)
    {
        foreach (static::getTraits() as $name) {
            if ($name === 'EntityTrait') {
                continue;
            }
            $this->callTraitMethod($name, $eventName);
        }
    }

    /**
     * Get all model rules.
     * This method merges a model rules (it must consists in $model->rules) with rules of all used traits (it must be defined as `public function TraitnameRules`).
     * @return array
     */
    public function rules()
    {
        if (isset(static::$rulesList[static::class]) === false) {
            static::$rulesList[static::class] = isset($this->rules) === true
                ? $this->rules
                : [];
            foreach (static::getTraits() as $name) {
                if (null !== $rules = $this->callTraitMethod($name, 'Rules')) {
                    static::$rulesList[static::class] = ArrayHelper::merge(
                        static::$rulesList[static::class],
                        $rules
                    );
                }
            }
        }
        return static::$rulesList[static::class];
    }

    /**
     * Get all attribute labels.
     * This method merges a model attributeLabels with attribute labels of all used traits.
     * @return array
     */
    public function attributeLabels()
    {
        if (isset(static::$attributeLabelsList[static::class]) === false) {
            static::$attributeLabelsList[static::class] = isset($this->attributeLabels) === true
                ? $this->attributeLabels
                : [];
            foreach (static::getTraits() as $name) {
                if (null !== $attributeLabels = $this->callTraitMethod($name, 'AttributeLabels')) {
                    static::$attributeLabelsList[static::class] = ArrayHelper::merge(
                        static::$attributeLabelsList[static::class],
                        $attributeLabels
                    );
                }
            }
        }
        return static::$attributeLabelsList[static::class];
    }

    public function EntityTraitInit()
    {
        if (isset(Yii::$app->i18n->translations['entity']) === false) {
            Yii::$app->i18n->translations['entity'] = [
                'class' => \yii\i18n\PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@vendor/devgroup/yii2-entity/src/messages',
            ];
        }
        $this->callEvents('Init');
    }

    public function init()
    {
        parent::init();
        $this->EntityTraitInit();
    }
}
