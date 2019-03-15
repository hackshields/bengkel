<?php

namespace app\models;

class JasaGroup extends base\JasaGroup
{
    const ASS1 = 1;
    const ASS2 = 2;
    const ASS3 = 3;
    const ASS4 = 4;
    const CL = 5;
    const GO = 6;
    const HR = 7;
    const JR = 8;
    const LR = 9;
    const PL = 10;
    const PR = 11;
    public static function findIdByKode($kode)
    {
        if ($kode == "") {
            return null;
        }
        $kGroup = JasaGroup::find()->where(array("kode" => $kode))->one();
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