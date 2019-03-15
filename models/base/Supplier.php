<?php

namespace app\models\base;

class Supplier extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "supplier";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "nama"), "required"), array(array("jaringan_id", "wilayah_propinsi_id", "wilayah_kabupaten_id", "wilayah_kecamatan_id", "wilayah_desa_id", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode", "no_telp", "no_telp_pic"), "string", "max" => 20), array(array("nama", "email"), "string", "max" => 100), array(array("alamat"), "string", "max" => 200), array(array("kodepos"), "string", "max" => 6), array(array("nama_pic"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "kode" => "Kode", "nama" => "Nama", "alamat" => "Alamat", "wilayah_propinsi_id" => "Wilayah Propinsi ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "wilayah_desa_id" => "Wilayah Desa ID", "kodepos" => "Kodepos", "no_telp" => "No Telp", "email" => "Email", "nama_pic" => "Nama Pic", "no_telp_pic" => "No Telp Pic", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getPenerimaanParts()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("supplier_id" => "id"));
    }
    public function getPurchaseOrders()
    {
        return $this->hasMany(\app\models\PurchaseOrder::className(), array("supplier_id" => "id"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getWilayahPropinsi()
    {
        return $this->hasOne(\app\models\WilayahPropinsi::className(), array("id" => "wilayah_propinsi_id"));
    }
    public function getWilayahKabupaten()
    {
        return $this->hasOne(\app\models\WilayahKabupaten::className(), array("id" => "wilayah_kabupaten_id"));
    }
    public function getWilayahKecamatan()
    {
        return $this->hasOne(\app\models\WilayahKecamatan::className(), array("id" => "wilayah_kecamatan_id"));
    }
    public function getWilayahDesa()
    {
        return $this->hasOne(\app\models\WilayahDesa::className(), array("id" => "wilayah_desa_id"));
    }
}

?>