<?php

namespace app\models;

class ContactForm extends \yii\base\Model
{
    public $name = NULL;
    public $email = NULL;
    public $subject = NULL;
    public $body = NULL;
    public $verifyCode = NULL;
    public function rules()
    {
        return array(array(array("name", "email", "subject", "body"), "required"), array("email", "email"), array("verifyCode", "captcha"));
    }
    public function attributeLabels()
    {
        return array("verifyCode" => "Verification Code");
    }
    public function contact($email)
    {
        if ($this->validate()) {
            \Yii::$app->mailer->compose()->setTo($email)->setFrom(array($this->email => $this->name))->setSubject($this->subject)->setTextBody($this->body)->send();
            return true;
        }
        return false;
    }
}

?>