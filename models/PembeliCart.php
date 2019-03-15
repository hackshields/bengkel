<?php

namespace app\models;

class PembeliCart extends base\PembeliCart
{
    public function fields()
    {
        return array("id", "pembeli_id", "pembeli_nama" => function ($model) {
            return $model->pembeli->nama;
        }, "suku_cadang_id", "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "jumlah", "jaringan_id", "pembeli_cart_status_id", "status" => function ($model) {
            return $model->pembeliCartStatus->nama;
        }, "action" => function ($model) {
            if ($model->pembeli_cart_status_id == 1) {
                return \yii\helpers\Html::a("Terima", "#", array("class" => "easyui-linkbutton btn-terima", "data_id" => $model->id));
            }
        });
    }
}

?>