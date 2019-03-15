<?php

namespace app\models\base;

class RoleAction extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "role_action";
    }
    public function rules()
    {
        return array(array(array("role_id", "action_id"), "required"), array(array("role_id", "action_id"), "integer"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "role_id" => "Role ID", "action_id" => "Action ID");
    }
    public function getRole()
    {
        return $this->hasOne(\app\models\Role::className(), array("id" => "role_id"));
    }
    public function getAction()
    {
        return $this->hasOne(\app\models\Action::className(), array("id" => "action_id"));
    }
}

?>