<?php

namespace app\models\base;

class SukuCadangJaringan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "suku_cadang_jaringan";
    }
    public function rules()
    {
        return array(array(array("suku_cadang_id", "jaringan_id"), "required"), array(array("suku_cadang_id", "jaringan_id", "gudang_id", "rak_id", "harga_beli", "harga_jual", "quantity", "hpp", "quantity_booking", "quantity_max", "quantity_min", "quantity_online_booking", "quantity_online", "promo_id", "status", "created_by", "updated_by", "online_id", "is_need_update"), "integer"), array(array("opname_terakhir", "created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "suku_cadang_id" => "Suku Cadang ID", "jaringan_id" => "Jaringan ID", "gudang_id" => "Gudang ID", "rak_id" => "Rak ID", "harga_beli" => "Harga Beli", "harga_jual" => "Harga Jual", "quantity" => "Quantity", "hpp" => "Hpp", "quantity_booking" => "Quantity Booking", "quantity_max" => "Quantity Max", "quantity_min" => "Quantity Min", "quantity_online_booking" => "Quantity Online Booking", "quantity_online" => "Quantity Online", "promo_id" => "Promo ID", "opname_terakhir" => "Opname Terakhir", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By", "online_id" => "Online ID", "is_need_update" => "Is Need Update");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getPromo()
    {
        return $this->hasOne(\app\models\Promo::className(), array("id" => "promo_id"));
    }
    public function getGudang()
    {
        return $this->hasOne(\app\models\Gudang::className(), array("id" => "gudang_id"));
    }
    public function getRak()
    {
        return $this->hasOne(\app\models\Rak::className(), array("id" => "rak_id"));
    }
    public function getSukuCadang()
    {
        return $this->hasOne(\app\models\SukuCadang::className(), array("id" => "suku_cadang_id"));
    }
}

?>