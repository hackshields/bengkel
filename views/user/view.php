<?php

$this->title = "User " . $model->name;
$this->params["breadcrumbs"][] = array("label" => "Users", "url" => array("index"));
$this->params["breadcrumbs"][] = array("label" => (string) $model->name, "url" => array("view", "id" => $model->id));
$this->params["breadcrumbs"][] = "View";
echo "<div class=\"giiant-crud user-view\">\n\n    <!-- menu buttons -->\n    <p class='pull-left'>\n        ";
echo dmstr\helpers\Html::a("<span class=\"glyphicon glyphicon-pencil\"></span> " . "Edit", array("update", "id" => $model->id), array("class" => "btn btn-info"));
echo "        ";
echo dmstr\helpers\Html::a("<span class=\"glyphicon glyphicon-plus\"></span> " . "New", array("create"), array("class" => "btn btn-success"));
echo "    </p>\n    <p class=\"pull-right\">\n        ";
echo dmstr\helpers\Html::a("<span class=\"glyphicon glyphicon-list\"></span> " . "List Users", array("index"), array("class" => "btn btn-default"));
echo "    </p>\n\n    <div class=\"clearfix\"></div>\n\n    <!-- flash message -->\n    ";
if (Yii::$app->session->getFlash("deleteError") !== NULL) {
    echo "        <span class=\"alert alert-info alert-dismissible\" role=\"alert\">\n            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                <span aria-hidden=\"true\">&times;</span></button>\n            ";
    echo Yii::$app->session->getFlash("deleteError");
    echo "        </span>\n    ";
}
echo "\n    <div class=\"panel panel-default\">\n        <div class=\"panel-heading\">\n            <h2>\n                ";
echo $model->name;
echo "            </h2>\n        </div>\n\n        <div class=\"panel-body\">\n\n\n            ";
$this->beginBlock("app\\models\\User");
echo "\n            ";
echo yii\widgets\DetailView::widget(array("model" => $model, "attributes" => array("username", "name", array("format" => "html", "attribute" => "role_id", "value" => $model->getRole()->one() ? dmstr\helpers\Html::a($model->getRole()->one()->name, array("role/view", "id" => $model->getRole()->one()->id)) : "<span class=\"label label-warning\">?</span>"), "photo_url:url", "last_login", "last_logout")));
echo "\n            <hr/>\n\n            ";
echo dmstr\helpers\Html::a("<span class=\"glyphicon glyphicon-trash\"></span> " . "Delete", array("delete", "id" => $model->id), array("class" => "btn btn-danger", "data-confirm" => "" . "Are you sure to delete this item?" . "", "data-method" => "post"));
echo "            ";
$this->endBlock();
echo "\n\n\n            ";
echo dmstr\bootstrap\Tabs::widget(array("id" => "relation-tabs", "encodeLabels" => false, "items" => array(array("label" => "<b class=\"\"># " . $model->id . "</b>", "content" => $this->blocks["app\\models\\User"], "active" => true))));
echo "        </div>\n    </div>\n</div>\n";

?>