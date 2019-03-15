<?php

$this->title = "Pengguna";
$this->params["breadcrumbs"][] = $this->title;
echo "\n<p>\n    ";
echo yii\helpers\Html::a("<i class=\"fa fa-plus\"></i> Tambah", array("create"), array("class" => "btn btn-success"));
echo "</p>\n\n<div class=\"box box-info\">\n    <div class=\"box-body\">\n\n        ";
yii\widgets\Pjax::begin(array("id" => "pjax-main", "enableReplaceState" => false, "linkSelector" => "#pjax-main ul.pagination a, th a", "clientOptions" => array("pjax:success" => "function(){alert(\"yo\")}")));
echo "\n        ";
echo yii\grid\GridView::widget(array("layout" => "{summary}{pager}{items}{pager}", "dataProvider" => $dataProvider, "pager" => array("class" => yii\widgets\LinkPager::className(), "firstPageLabel" => "First", "lastPageLabel" => "Last"), "filterModel" => $searchModel, "tableOptions" => array("class" => "table table-striped table-bordered table-hover"), "headerRowOptions" => array("class" => "x"), "columns" => array(app\components\ActionButton::getButtons(), "username", "name", array("class" => yii\grid\DataColumn::className(), "attribute" => "role_id", "value" => function ($model) {
    if ($rel = $model->getRole()->one()) {
        return yii\helpers\Html::a($rel->name, array("role/view", "id" => $rel->id), array("data-pjax" => 0));
    }
    return "";
}, "format" => "raw"))));
echo "        ";
yii\widgets\Pjax::end();
echo "    </div>\n</div>\n";

?>