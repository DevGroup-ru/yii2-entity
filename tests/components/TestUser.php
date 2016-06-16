<?php
/**
 * Created by PhpStorm.
 * User: fps
 * Date: 16.06.16
 * Time: 13:52
 */

namespace tests\components;


use yii\web\User;

class TestUser extends User
{
    protected function renewAuthStatus()
    {}

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getIsGuest()
    {
        return $this->id == null;
    }
}
