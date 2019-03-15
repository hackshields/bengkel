<?php

namespace app\models;

class StatusNsc extends base\StatusNsc
{
    const ENTRY = 1;
    const CLOSE = 2;
    const BATAL = 3;
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = self::find()->where(array("kode" => $kode))->one();
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