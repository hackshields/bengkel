<?php

namespace app\models;

class RegisterForm extends \yii\base\Model
{
    public $username = NULL;
    public $password = NULL;
    public $name = NULL;
    public $agreeTerm = NULL;
    private $role_id = 3;
    public function rules()
    {
        return array(array(array("username", "password", "name"), "required"));
    }
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = md5($this->password);
            $user->name = $this->name;
            $user->role_id = $this->role_id;
            if ($user->save()) {
                return true;
            }
            if ($user->errors) {
                $this->addErrors($user->errors);
            }
            return false;
        }
        return false;
    }
}

?>