<?php

namespace app\models;

class Rak extends base\Rak
{
    public function fields()
    {
        return array("id", "gudang_id", "gudang_nama" => function ($model) {
            return $model->gudang->nama;
        }, "kode", "nama", "rak_jenis_id", "rak_jenis_nama" => function ($model) {
            return $model->rakJenis->nama;
        });
    }
    public static function getUserActiveData()
    {
        $user = \Yii::$app->user->identity;
        return static::find()->where(array("status" => 1, "jaringan_id" => $user->jaringan_id))->all();
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