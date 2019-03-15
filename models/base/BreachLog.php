<?php

namespace app\models\base;

class BreachLog extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "breach_log";
    }
    public function rules()
    {
        return array(array(array("datetime", "ip_address", "user_agent", "url"), "required"), array(array("datetime"), "safe"), array(array("user_agent", "url", "data"), "string"), array(array("ip_address"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "datetime" => "Datetime", "ip_address" => "Ip Address", "user_agent" => "User Agent", "url" => "Url", "data" => "Data");
    }
}

?>