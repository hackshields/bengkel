<?php

namespace app\models;

class PenerimaanPartTipe extends base\PenerimaanPartTipe
{
    const PEMBELIAN = 1;
    const RETUR = 2;
    const PENYESUAIAN = 3;
    const CLAIM_MD = 4;
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