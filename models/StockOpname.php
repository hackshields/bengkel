<?php

namespace app\models;

class StockOpname extends base\StockOpname
{
    public function fields()
    {
        return array("id", "no_opname", "tanggal_opname", "tanggal_opname_format" => function ($model) {
            return \app\components\Tanggal::toReadableDate($model->tanggal_opname, false);
        }, "petugas_id", "petugas_nama" => function ($model) {
            return $model->petugas->name;
        }, "status_opname_id", "status_opname_nama" => function ($model) {
            return $model->statusOpname->nama;
        });
    }
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("no_opname" => $kode, "jaringan_id" => Jaringan::getCurrentID()))->one();
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