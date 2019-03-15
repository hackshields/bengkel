<?php

namespace app\components;

class ActionButton
{
    public static function getButtons()
    {
        return array("class" => "yii\\grid\\ActionColumn", "template" => "{view} {update} {delete}", "buttons" => array("view" => function ($url, $model, $key) {
            return \yii\helpers\Html::a("<i class='fa fa-eye'></i>", array("view", "id" => $model->id), array("class" => "btn btn-success", "title" => "Lihat Data"));
        }, "update" => function ($url, $model, $key) {
            return \yii\helpers\Html::a("<i class='fa fa-pencil'></i>", array("update", "id" => $model->id), array("class" => "btn btn-warning", "title" => "Edit Data"));
        }, "delete" => function ($url, $model, $key) {
            return \yii\helpers\Html::a("<i class='fa fa-trash'></i>", array("delete", "id" => $model->id), array("class" => "btn btn-danger", "title" => "Hapus Data", "data-confirm" => "Apakah Anda yakin ingin menghapus data ini ?"));
        }), "contentOptions" => array("nowrap" => "nowrap", "style" => "text-align:center;width:140px"));
    }
}

?>