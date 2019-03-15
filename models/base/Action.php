<?php

namespace app\models\base;

class Action extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "action";
    }
    public function rules()
    {
        return array(array(array("controller_id", "action_id", "name"), "required"), array(array("controller_id", "action_id", "name"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "controller_id" => "Controller ID", "action_id" => "Action ID", "name" => "Name");
    }
    public function getRoleActions()
    {
        return $this->hasMany(\app\models\RoleAction::className(), array("action_id" => "id"));
    }
}

?>