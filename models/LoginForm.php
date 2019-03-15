<?php

namespace app\models;

class LoginForm extends \yii\base\Model
{
    public $username = NULL;
    public $password = NULL;
    public $rememberMe = true;
    private $_user = false;
    public function rules()
    {
        return array(array(array("username", "password"), "required"), array("rememberMe", "boolean"), array("password", "validatePassword"));
    }
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, "Incorrect username or password.");
            }
        }
    }
    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }
        return false;
    }
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}

?>