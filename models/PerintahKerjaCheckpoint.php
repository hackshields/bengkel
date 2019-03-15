<?php

namespace app\models;

class PerintahKerjaCheckpoint extends base\PerintahKerjaCheckpoint
{
    public function fields()
    {
        return array("id", "checkpoint_item_id", "checkpoint_item_kode" => function ($model) {
            return $model->checkpointItem->kode;
        }, "checkpoint_item_nama" => function ($model) {
            return $model->checkpointItem->nama;
        }, "checkpoint_item_motor_jenis" => function ($model) {
            return $model->checkpointItem->motorJenis->nama;
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
        $this->is_need_update = 1;
        if (\Yii::$app->user->isGuest) {
            BreachLog::addLog();
            return false;
        }
        return true;
    }
}

?>