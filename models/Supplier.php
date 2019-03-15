<?php

namespace app\models;

class Supplier extends base\Supplier
{
    public function fields()
    {
        return array("id", "jaringan_id", "kode", "nama", "alamat", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "kodepos", "no_telp", "email", "nama_pic", "no_telp_pic", "status", "created_at", "updated_at", "created_by", "updated_by", "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-supplier-gunakan", "data_id" => $model->id));
        });
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            $sNone = self::find()->where(array("kode" => "NOT_FOUND"))->one();
            return $sNone->id;
        }
        $kGroup = self::find()->where(array("kode" => $kode))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        $sNone = self::find()->where(array("kode" => "NOT_FOUND"))->one();
        return $sNone->id;
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
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>