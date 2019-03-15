<?php

namespace app\models\base;

class PerintahKerjaSukuCadang extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "perintah_kerja_suku_cadang";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "perintah_kerja_id", "suku_cadang_id"), "required"), array(array("jaringan_id", "perintah_kerja_id", "suku_cadang_id", "rak_id", "hpp", "harga", "diskon_r", "quantity", "total", "beban_pembayaran_id", "created_by", "updated_by"), "integer"), array(array("diskon_p"), "number"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "perintah_kerja_id" => "Perintah Kerja ID", "suku_cadang_id" => "Suku Cadang ID", "rak_id" => "Rak ID", "hpp" => "Hpp", "harga" => "Harga", "diskon_p" => "Diskon P", "diskon_r" => "Diskon R", "quantity" => "Quantity", "total" => "Total", "beban_pembayaran_id" => "Beban Pembayaran ID", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPerintahKerja()
    {
        return $this->hasOne(\app\models\PerintahKerja::className(), array("id" => "perintah_kerja_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getRak()
    {
        return $this->hasOne(\app\models\Rak::className(), array("id" => "rak_id"));
    }
    public function getBebanPembayaran()
    {
        return $this->hasOne(\app\models\BebanPembayaran::className(), array("id" => "beban_pembayaran_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>