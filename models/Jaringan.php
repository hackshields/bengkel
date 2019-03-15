<?php

namespace app\models;

class Jaringan extends base\Jaringan
{
    public static function getCurrentID()
    {
        return \Yii::$app->user->identity->jaringan_id;
    }
    public static function getDefaultGudangID()
    {
        $gudang = Gudang::find()->where(array("status" => 1, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($gudang == null) {
            $gudang = new Gudang();
            $gudang->jaringan_id = Jaringan::getCurrentID();
            $gudang->kode = "0001";
            $gudang->nama = "Gudang Default";
            $gudang->save();
        }
        return $gudang->id;
    }
    public static function getDefaultRakID()
    {
        $rak = Rak::find()->where(array("status" => 1, "jaringan_id" => Jaringan::getCurrentID()))->one();
        if ($rak == null) {
            $rak = new Rak();
            $rak->jaringan_id = Jaringan::getCurrentID();
            $rak->kode = "0001";
            $rak->nama = "Rak Default";
            $rak->save();
        }
        return $rak->id;
    }
    public static function getInfoCetak()
    {
        $jaringan = Jaringan::find()->where(array("id" => self::getCurrentID()))->one();
        return "<div style='font-size: 12px'>" . $jaringan->nama . "<br>" . $jaringan->alamat . ", " . ucwords(strtolower($jaringan->wilayahKabupaten->nama)) . "<br>Telp. :" . $jaringan->no_telepon . "</div>";
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