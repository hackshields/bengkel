<?php

namespace app\models\base;

class Setting extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "setting";
    }
    public function rules()
    {
        return array(array(array("key", "value"), "required"), array(array("key"), "string", "max" => 50), array(array("value"), "string", "max" => 200));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "key" => "Key", "value" => "Value");
    }
}

?>