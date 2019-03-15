<?php

$this->title = "Manajemen Menu";
$this->params["breadcrumbs"][] = $this->title;
echo "\n<style>\n    .sorterer {\n        text-align: center;\n        background: #0000aa;\n        color: #ffffff;\n        cursor: move;\n    }\n    table tr.sorting-row td {background-color: #8b8;}\n</style>\n\n<div class=\"row\">\n    <div class=\"col-sm-12\">\n        <div class=\"box box-info\">\n            <div class=\"box-header\">\n                ";
echo yii\helpers\Html::a("<i class=\"fa fa-plus\"></i> Tambah Menu Baru", array("create"), array("class" => "btn btn-info"));
echo "                <button id=\"simpanBtn\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Simpan</button>\n            </div>\n            <div class=\"box-body\">\n                <table class=\"table table-responsive\" id=\"tableSorter\">\n                    <thead>\n                    <tr>\n                        <th>No</th>\n                        <th>Nama Menu</th>\n                        <th>Controller</th>\n                        <th>Ikon</th>\n                        <th>Induk</th>\n                        <th style=\"width: 50px\">#</th>\n                    </tr>\n                    </thead>\n                    <tbody>\n                    ";
$parents = yii\helpers\ArrayHelper::map(app\models\Menu::find()->where(array("parent_id" => NULL))->all(), "id", "name");
$no = 1;
foreach (app\models\Menu::find()->where(array("parent_id" => NULL))->orderBy("`order` ASC")->all() as $menu) {
    $name = yii\helpers\Html::textInput("name", $menu->name, array("class" => "form-control name"));
    $controller = yii\helpers\Html::textInput("controller", $menu->controller, array("class" => "form-control controller"));
    $parent = yii\helpers\Html::dropDownList("parent_id", $menu->parent_id, $parents, array("class" => "form-control parent_id", "prompt" => "-"));
    $button = "<i class='fa fa-arrows'></i>";
    $icp = yii\helpers\Html::textInput("icon", $menu->iconNoPrefix, array("class" => "form-control icon icp-auto"));
    echo "<tr style='background-color: #FFFCE7;' data='" . $menu->id . "'>\n                            <td>" . $no . "</td>\n                            <td>" . $name . "</td>\n                            <td>" . $controller . "</td>\n                            <td>" . $icp . "</td>\n                            <td>" . $parent . "</td>\n                            <td class='sorterer'>" . $button . "</td>\n                            </tr>";
    $no++;
    foreach (app\models\Menu::find()->where(array("parent_id" => $menu->id))->orderBy("`order` ASC")->all() as $menu2) {
        $name = yii\helpers\Html::textInput("name", $menu2->name, array("class" => "form-control name"));
        $controller = yii\helpers\Html::textInput("controller", $menu2->controller, array("class" => "form-control controller"));
        $parent = yii\helpers\Html::dropDownList("parent_id", $menu2->parent_id, $parents, array("class" => "form-control parent_id", "prompt" => "-"));
        $button = "<i class='fa fa-arrows'></i>";
        $icp = yii\helpers\Html::textInput("icon", $menu2->iconNoPrefix, array("class" => "form-control icon icp-auto"));
        echo "<tr data='" . $menu2->id . "'>\n                            <td>" . $no . "</td>\n                            <td>" . $name . "</td>\n                            <td>" . $controller . "</td>\n                            <td>" . $icp . "</td>\n                            <td>" . $parent . "</td>\n                            <td class='sorterer'>" . $button . "</td>\n                            </tr>";
        $no++;
    }
}
echo "                    </tbody>\n                </table>\n            </div>\n        </div>\n    </div>\n</div>\n\n";
$this->registerJs("\n\nnew RowSorter(\"#tableSorter\", {\n    handler: \"td.sorterer\",\n});\n\n\$(\"#simpanBtn\").click(function(){\n    var arr = [];\n    \$(\"tbody tr\").each(function(){\n        var obj = [];\n        obj.push(\$(this).attr(\"data\"));\n        obj.push(\$(this).find(\".name\").val());\n        obj.push(\$(this).find(\".controller\").val());\n        obj.push(\$(this).find(\".parent_id\").val());\n        obj.push(\$(this).find(\".icon\").val());\n        arr.push(obj.join(\"[=]\"));\n    });\n    console.log(arr.join(\"||\"));\n    \$.ajax({\n        url : \"" . yii\helpers\Url::to(array("save")) . "\",\n        data : {\n            str : arr.join(\"||\"),\n        },\n        type : \"post\",\n        success: function(){\n            alert(\"Menu berhasil disimpan\");\n        }\n    });\n    return false;\n});\n\n\$(\".icp-auto\").iconpicker();\n\n");

?>