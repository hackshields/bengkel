<?php

namespace app\models;

class SukuCadangJaringan extends base\SukuCadangJaringan
{
    public function fields()
    {
        return array("id", "kode" => function ($model) {
            return $model->sukuCadang->kode;
        }, "nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "suku_cadang_nama" => function ($model) {
            return $model->sukuCadang->nama;
        }, "suku_cadang_nama_sinonim" => function ($model) {
            return $model->sukuCadang->nama_sinonim;
        }, "suku_cadang_id", "jaringan_id", "gudang_id", "gudang_nama" => function ($model) {
            return $model->gudang->nama;
        }, "rak_id", "rak_nama" => function ($model) {
            return $model->rak->nama;
        }, "harga_beli", "quantity", "hpp", "quantity_booking", "quantity_max", "quantity_min", "opname_terakhir" => function ($model) {
            return $model->opname_terakhir == "0000-00-00" ? "-" : $model->opname_terakhir;
        }, "status", "created_at", "updated_at", "created_by", "updated_by");
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
        if ($this->gudang_id == null) {
            $this->gudang_id = Jaringan::getDefaultGudangID();
        }
        if ($this->rak_id == null) {
            $this->rak_id = Jaringan::getDefaultRakID();
        }
        if ($this->harga_jual == null) {
            $jaringan = Jaringan::find()->where(array("id" => Jaringan::getCurrentID()))->one();
            $this->harga_jual = $this->sukuCadang->het * $jaringan->persentase_harga_jual / 100;
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