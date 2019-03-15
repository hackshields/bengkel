<?php

namespace app\models\base;

class Role extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "role";
    }
    public function rules()
    {
        return array(array(array("name"), "required"), array(array("name"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "name" => "Name");
    }
    public function getRoleMenus()
    {
        return $this->hasMany(\app\models\RoleMenu::className(), array("role_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("role_id" => "id"));
    }
}

?>