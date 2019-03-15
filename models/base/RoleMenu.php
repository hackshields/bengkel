<?php

namespace app\models\base;

class RoleMenu extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "role_menu";
    }
    public function rules()
    {
        return array(array(array("role_id", "menu_id"), "required"), array(array("role_id", "menu_id"), "integer"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "role_id" => "Role ID", "menu_id" => "Menu ID");
    }
    public function getRole()
    {
        return $this->hasOne(\app\models\Role::className(), array("id" => "role_id"));
    }
    public function getMenu()
    {
        return $this->hasOne(\app\models\Menu::className(), array("id" => "menu_id"));
    }
}

?>