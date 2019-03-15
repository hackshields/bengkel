<?php

namespace app\models\base;

class PembeliCart extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pembeli_cart";
    }
    public function rules()
    {
        return array(array(array("pembeli_id", "suku_cadang_id", "jumlah"), "required"), array(array("pembeli_id", "suku_cadang_id", "jumlah", "jaringan_id", "pembeli_cart_status_id"), "integer"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "pembeli_id" => "Pembeli ID", "suku_cadang_id" => "Suku Cadang ID", "jumlah" => "Jumlah", "jaringan_id" => "Jaringan ID", "pembeli_cart_status_id" => "Pembeli Cart Status ID");
    }
    public function getPembeli()
    {
        return $this->hasOne(\app\models\Pembeli::className(), array("id" => "pembeli_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getPembeliCartStatus()
    {
        return $this->hasOne(\app\models\PembeliCartStatus::className(), array("id" => "pembeli_cart_status_id"));
    }
}

?>