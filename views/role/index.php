<?php

$this->title = "Hak Akses";
$this->params["breadcrumbs"][] = $this->title;
echo "\n<p>\n    ";
echo yii\helpers\Html::a("<i class=\"fa fa-plus\"></i> Tambah", array("create"), array("class" => "btn btn-success"));
echo "</p>\n\n<div class=\"box box-info\">\n    <div class=\"box-body\">\n        ";
yii\widgets\Pjax::begin(array("id" => "pjax-main", "enableReplaceState" => false, "linkSelector" => "#pjax-main ul.pagination a, th a", "clientOptions" => array("pjax:success" => "function(){alert(\"yo\")}")));
echo "\n        ";
echo yii\grid\GridView::widget(array("layout" => "{summary}{pager}{items}{pager}", "dataProvider" => $dataProvider, "pager" => array("class" => yii\widgets\LinkPager::className(), "firstPageLabel" => "First", "lastPageLabel" => "Last"), "filterModel" => $searchModel, "tableOptions" => array("class" => "table table-striped table-bordered table-hover"), "headerRowOptions" => array("class" => "x"), "columns" => array(array("class" => "yii\\grid\\ActionColumn", "template" => "{update} {delete} {role-menu}", "buttons" => array("view" => function ($url, $model, $key) {
    return yii\helpers\Html::a("<i class='fa fa-eye'></i>", array("view", "id" => $model->id), array("class" => "btn btn-success", "title" => "Lihat Data"));
}, "update" => function ($url, $model, $key) {
    return yii\helpers\Html::a("<i class='fa fa-pencil'></i>", array("update", "id" => $model->id), array("class" => "btn btn-warning", "title" => "Edit Data"));
}, "delete" => function ($url, $model, $key) {
    return yii\helpers\Html::a("<i class='fa fa-trash'></i>", array("delete", "id" => $model->id), array("class" => "btn btn-danger", "title" => "Hapus Data", "data-confirm" => "Apakah Anda yakin ingin menghapus data ini ?"));
}, "role-menu" => function ($url, $model, $key) {
    return yii\helpers\Html::a("<i class='fa fa-cog'></i>", array("detail", "id" => $model->id), array("class" => "btn btn-info", "title" => "Detail"));
}), "contentOptions" => array("nowrap" => "nowrap", "style" => "text-align:center;width:140px")), "name")));
echo "        ";
yii\widgets\Pjax::end();
echo "    </div>\n</div>\n";

?>