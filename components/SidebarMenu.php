<?php

namespace app\components;

class SidebarMenu extends \yii\bootstrap\Widget
{
    public static function getMenu($roleId, $parentId = NULL)
    {
        $output = array();
        foreach (\app\models\Menu::find()->where(array("parent_id" => $parentId))->all() as $menu) {
            $obj = array("label" => $menu->name, "icon" => $menu->icon, "url" => SidebarMenu::getUrl($menu), "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id));
            if (count($menu->menus) != 0) {
                $obj["items"] = SidebarMenu::getMenu($roleId, $menu->id);
            }
            $output[] = $obj;
        }
        return $output;
    }
    private static function roleHasAccess($roleId, $menuId)
    {
        $roleMenu = \app\models\RoleMenu::find()->where(array("menu_id" => $menuId, "role_id" => $roleId))->one();
        if ($roleMenu) {
            return TRUE;
        }
        return FALSE;
    }
    private static function getUrl($menu)
    {
        if ($menu->controller == NULL) {
            return "#";
        }
        return array($menu->controller . "/" . $menu->action);
    }
}

?>