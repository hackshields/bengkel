<?php

namespace app\models\base;

class NotaJasaDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "nota_jasa_detail";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "nota_jasa_id", "jasa_id", "nama_jasa"), "required"), array(array("jaringan_id", "nota_jasa_id", "jasa_id", "harga", "diskon_r", "total", "dpph", "dpp", "pph", "ppn", "operasional", "beban_pembayaran_id", "created_by", "updated_by"), "integer"), array(array("diskon_p"), "number"), array(array("created_at", "updated_at"), "safe"), array(array("nama_jasa"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "nota_jasa_id" => "Nota Jasa ID", "jasa_id" => "Jasa ID", "nama_jasa" => "Nama Jasa", "harga" => "Harga", "diskon_p" => "Diskon P", "diskon_r" => "Diskon R", "total" => "Total", "dpph" => "Dpph", "dpp" => "Dpp", "pph" => "Pph", "ppn" => "Ppn", "operasional" => "Operasional", "beban_pembayaran_id" => "Beban Pembayaran ID", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getNotaJasa()
    {
        return $this->hasOne(\app\models\NotaJasa::className(), array("id" => "nota_jasa_id"));
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
    public function getJasa()
    {
        return $this->hasOne(\app\models\Jasa::className(), array("id" => "jasa_id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>