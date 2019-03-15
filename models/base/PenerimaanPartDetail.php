<?php

namespace app\models\base;

class PenerimaanPartDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "penerimaan_part_detail";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "penerimaan_part_id", "suku_cadang_id"), "required"), array(array("jaringan_id", "penerimaan_part_id", "suku_cadang_id", "harga_beli", "quantity_order", "quantity_supp", "diskon_r", "rak_id", "total_harga", "created_by", "updated_by"), "integer"), array(array("diskon_p"), "number"), array(array("created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "penerimaan_part_id" => "Penerimaan Part ID", "suku_cadang_id" => "Suku Cadang ID", "harga_beli" => "Harga Beli", "quantity_order" => "Quantity Order", "quantity_supp" => "Quantity Supp", "diskon_p" => "Diskon P", "diskon_r" => "Diskon R", "rak_id" => "Rak ID", "total_harga" => "Total Harga", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPenerimaanPart()
    {
        return $this->hasOne(\app\models\PenerimaanPart::className(), array("id" => "penerimaan_part_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
    public function getRak()
    {
        return $this->hasOne(\app\models\Rak::className(), array("id" => "rak_id"));
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