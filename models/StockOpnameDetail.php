<?php

namespace app\models;

class StockOpnameDetail extends base\StockOpnameDetail
{
    public function fields()
    {
        return array("id", "stock_opname_id", "suku_cadang_id", "suku_cadang_kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "rak_id", "rak_nama" => function ($model) {
            return $model->rak->nama;
        }, "quantity_oh", "quantity_sy", "keterangan", "action" => function ($model) {
            return \yii\helpers\Html::a("Edit", "#", array("class" => "easyui-linkbutton editstok", "data_id" => $model->id, "quantity_oh" => $model->quantity_oh)) . " " . \yii\helpers\Html::a("Delete", "#", array("class" => "easyui-linkbutton deletedetail", "data_id" => $model->id));
        });
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
            $this->updated_by = \Yii::$app->user->id;
        }
        if ($this->rak_id == null) {
            $this->rak_id = Jaringan::getDefaultRakID();
        }
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>