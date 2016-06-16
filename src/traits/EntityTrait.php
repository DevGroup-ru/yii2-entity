<?php

namespace DevGroup\Entity\traits;

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
     * Get all model rules.
     * This method merges a model rules (it must consists in $model->rules) with rules of all used traits (it must be defined as `public function TraitnameRules`).
     * @return mixed
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

    public function EntityTraitInit()
    {
        foreach (static::getTraits() as $name) {
            if ($name === 'EntityTrait') {
                continue;
            }
            $this->callTraitMethod($name, 'Init');
        }
    }

    public function init()
    {
        parent::init();
        $this->EntityTraitInit();
    }
}
