<?php

namespace app\models;

class ViewWilayah extends base\ViewWilayah
{
    public function fields()
    {
        return array("id", "desa_nama", "kec_id", "kec_nama", "kab_id", "kab_nama", "prop_id", "prop_nama", "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-wilayah-gunakan", "desa_id" => $model->id, "kec_id" => $model->kec_id, "kab_id" => $model->kab_id, "prop_id" => $model->prop_id));
        });
    }
}

?>