<?php

namespace app\models;

class Jasa extends base\Jasa
{
    public static function getCurrentActive()
    {
        return Jasa::find()->where(array("jaringan_id" => \Yii::$app->user->identity->jaringan_id))->all();
    }
    public function fields()
    {
        return array("id", "jaringan_id", "kode", "nama", "jasa_group_id", "jasa_group_nama" => function ($model) {
            return $model->jasaGroup->nama;
        }, "frt", "harga", "pph", "operasional", "status", "created_at", "updated_at", "created_by", "updated_by", "action" => function ($model) {
            return \yii\helpers\Html::button("Gunakan", array("class" => "btn-jasa-gunakan", "data_id" => $model->id));
        });
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("kode" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($kGroup) {
            return $kGroup->id;
        }
        return null;
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