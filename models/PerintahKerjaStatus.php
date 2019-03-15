<?php

namespace app\models;

class PerintahKerjaStatus extends base\PerintahKerjaStatus
{
    const TUNGGU = 1;
    const DIKERJAKAN = 2;
    const SELESAI = 3;
    const NOTA = 4;
    const BATAL = 5;
    const TUNDA = 6;
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