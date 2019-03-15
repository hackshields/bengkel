<?php

echo "<aside class=\"main-sidebar\">\n\n    <section class=\"sidebar\">\n\n        <!-- Sidebar user panel -->\n        <div class=\"user-panel\">\n            <div class=\"pull-left image\">\n                ";
echo yii\helpers\Html::img(array("uploads/" . Yii::$app->user->identity->photo_url), array("class" => "img-circle"));
echo "            </div>\n            <div class=\"pull-left info\">\n                <p>";
echo Yii::$app->user->identity->name;
echo "</p>\n\n                <a href=\"#\"><i class=\"fa fa-circle text-success\"></i> Online</a>\n            </div>\n        </div>\n\n        <!-- search form -->\n        <form action=\"#\" method=\"get\" class=\"sidebar-form\">\n            <div class=\"input-group\">\n                <input type=\"text\" name=\"q\" class=\"form-control\" placeholder=\"Search...\"/>\n              <span class=\"input-group-btn\">\n                <button type='submit' name='search' id='search-btn' class=\"btn btn-flat\"><i class=\"fa fa-search\"></i>\n                </button>\n              </span>\n            </div>\n        </form>\n        <!-- /.search form -->\n        ";
$items = app\components\SidebarMenu::getMenu(Yii::$app->user->identity->role_id);
echo "        ";
echo dmstr\widgets\Menu::widget(array("options" => array("class" => "sidebar-menu"), "items" => $items));
echo "\n    </section>\n\n</aside>\n";

?>