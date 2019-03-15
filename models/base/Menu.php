<?php

namespace app\models\base;

class Menu extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "menu";
    }
    public function rules()
    {
        return array(array(array("name", "controller", "icon"), "required"), array(array("order", "parent_id"), "integer"), array(array("name", "controller", "action", "icon"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "name" => "Nama", "controller" => "Controller", "action" => "Action", "icon" => "Ikon", "order" => "Urutan", "parent_id" => "Menu Induk");
    }
    public function getParent()
    {
        return $this->hasOne(\app\models\Menu::className(), array("id" => "parent_id"));
    }
    public function getMenus()
    {
        return $this->hasMany(\app\models\Menu::className(), array("parent_id" => "id"));
    }
    public function getRoleMenus()
    {
        return $this->hasMany(\app\models\RoleMenu::className(), array("menu_id" => "id"));
    }
}

?>