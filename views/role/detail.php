<?php

$this->title = "Hak Akses - " . $model->name;
$this->params["breadcrumbs"][] = array("label" => "Hak Akses", "url" => array("index"));
$this->params["breadcrumbs"][] = array("label" => "Set Menu untuk " . $model->name, "url" => array("view", "id" => $model->id));
$form = yii\bootstrap\ActiveForm::begin(array("id" => "my-form"));
echo "<div class=\"box box-success\">\n    <div class=\"box-header\">\n        <h3 class=\"box-title\">Pilih Menu untuk Hak Akses ";
echo $model->name;
echo "</h3>\n    </div>\n    <div class=\"box-body\">\n        ";
getallchild($model->id, NULL);
echo "\n    </div>\n    <div class=\"box-footer\">\n        <button class=\"btn btn-info\" type=\"button\" id=\"select_all_btn\">\n            <i class=\"fa fa-check\"></i> Select/Deselect All\n        </button>\n        <button class=\"btn btn-success\" type=\"submit\">\n            <i class=\"fa fa-save\"></i> Simpan\n        </button>\n    </div>\n</div>\n";
yii\bootstrap\ActiveForm::end();
echo "\n";
$this->registerJs("\n\n\$(\"#select_all_btn\").click(function(){\n    \$(\".minimal\").iCheck(\"toggle\");\n});\n\n\$(\".select-all\").on(\"ifClicked\", function(){\n\n    if(\$(this).prop(\"checked\")){\n        \$(this).closest(\".form-group\").find(\".actions\").iCheck(\"uncheck\");\n    }else{\n        \$(this).closest(\".form-group\").find(\".actions\").iCheck(\"check\");\n    }\n});\n\n");
function isChecked($role_id, $menu_id)
{
    $role_menu = app\models\RoleMenu::find()->where(array("menu_id" => $menu_id, "role_id" => $role_id))->one();
    if ($role_menu) {
        return true;
    }
    return false;
}
function hasAccessToAction($role_id, $action_id)
{
    $role_menu = app\models\RoleAction::find()->where(array("action_id" => $action_id, "role_id" => $role_id))->one();
    if ($role_menu) {
        return true;
    }
    return false;
}
function showCheckbox($name, $value, $label, $checked = false)
{
    echo "            <label>\n                <input type=\"checkbox\" name=\"";
    echo $name;
    echo "\" value=\"";
    echo $value;
    echo "\" class=\"minimal actions\" ";
    echo $checked ? "checked" : "";
    echo ">\n            </label>\n            <label style=\"padding: 0px 20px 0px 5px\"> ";
    echo $label;
    echo "</label>\n            ";
}
function getAllChild($role_id, $parent_id = NULL, $level = 0)
{
    foreach (app\models\Menu::find()->where(array("parent_id" => $parent_id))->all() as $menu) {
        echo "                    <div class=\"form-group\" style=\"padding-left: ";
        echo $level * 20;
        echo "px\">\n                        <label>\n                            <input type=\"checkbox\" name=\"menu[]\" value=\"";
        echo $menu->id;
        echo "\" class=\"minimal\" ";
        echo ischecked($role_id, $menu->id) ? "checked" : "";
        echo ">\n                        </label>\n                        <label style=\"padding-left: 10px\"> ";
        echo $menu->name;
        echo "</label>\n                    </div>\n                ";
        $camelName = yii\helpers\Inflector::id2camel($menu->controller);
        $fullControllerName = "app\\controllers\\" . $camelName . "Controller";
        if (class_exists($fullControllerName)) {
            $reflection = new ReflectionClass($fullControllerName);
            $methods = $reflection->getMethods();
            echo "<div class=\"form-group\" style=\"padding-left: " . ($level * 20 + 10) . "px;\">";
            echo "<label><input type=\"checkbox\" class=\"minimal select-all\" ></label><label style=\"padding: 0px 20px 0px 5px\"> Select All</label>";
            foreach ($methods as $method) {
                if (substr($method->name, 0, 6) == "action" && $method->name != "actions") {
                    $camelAction = substr($method->name, 6);
                    $id = yii\helpers\Inflector::camel2id($camelAction);
                    $name = yii\helpers\Inflector::camel2words($camelAction);
                    $action = app\models\Action::find()->where(array("action_id" => $id, "controller_id" => $menu->controller))->one();
                    if ($action == NULL) {
                        $action = new app\models\Action();
                        $action->action_id = $id;
                        $action->controller_id = $menu->controller;
                        $action->name = $name;
                        $action->save();
                    }
                    showcheckbox("action[]", $action->id, $name, hasaccesstoaction($role_id, $action->id));
                }
            }
            echo "</div>";
        }
        getAllChild($role_id, $menu->id, $level + 1);
    }
}

?>