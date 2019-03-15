<?php

namespace app\models;

class PengeluaranPartTipe extends base\PengeluaranPartTipe
{
    const DIRECT_SALES = 1;
    const WORKSHOP = 2;
    const PENYESUAIAN = 3;
    const MUTASI = 4;
    const RUSAK = 5;
    const PROMO = 6;
    const ONLINE_SALES = 7;
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