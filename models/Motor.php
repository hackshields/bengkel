<?php

namespace app\models;

class Motor extends base\Motor
{
    public function fields()
    {
        return array("id", "kode", "merek_id", "merek_nama" => function ($model) {
            return $model->merek->nama;
        }, "nama", "warna", "motor_group_id", "motor_group_nama" => function ($model) {
            return $model->motorGroup->nama;
        }, "motor_jenis_id", "motor_jenis_nama" => function ($model) {
            return $model->motorJenis->nama;
        }, "status", "created_at", "updated_at", "created_by", "updated_by");
    }
    public function getNamaLengkap()
    {
        return "[" . $this->kode . "] - " . $this->nama . " (" . $this->warna . ")";
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