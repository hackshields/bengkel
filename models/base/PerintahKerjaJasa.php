<?php

namespace app\models\base;

class PerintahKerjaJasa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "perintah_kerja_jasa";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "perintah_kerja_id", "jasa_id"), "required"), array(array("jaringan_id", "perintah_kerja_id", "jasa_id", "harga", "diskon_r", "total", "dpph", "dpp", "pph", "ppn", "operasional", "beban_pembayaran_id", "created_by", "updated_by"), "integer"), array(array("diskon_p"), "number"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "perintah_kerja_id" => "Perintah Kerja ID", "jasa_id" => "Jasa ID", "harga" => "Harga", "diskon_p" => "Diskon P", "diskon_r" => "Diskon R", "total" => "Total", "dpph" => "Dpph", "dpp" => "Dpp", "pph" => "Pph", "ppn" => "Ppn", "operasional" => "Operasional", "beban_pembayaran_id" => "Beban Pembayaran ID", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPerintahKerja()
    {
        return $this->hasOne(\app\models\PerintahKerja::className(), array("id" => "perintah_kerja_id"));
    }
    public function getJasa()
    {
        return $this->hasOne(\app\models\Jasa::className(), array("id" => "jasa_id"));
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