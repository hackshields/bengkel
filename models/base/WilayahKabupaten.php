<?php

namespace app\models\base;

class WilayahKabupaten extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "wilayah_kabupaten";
    }
    public function rules()
    {
        return array(array(array("wilayah_provinsi_id"), "required"), array(array("wilayah_provinsi_id"), "integer"), array(array("nama", "ibukota"), "string", "max" => 100), array(array("k_bsni"), "string", "max" => 3));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "wilayah_provinsi_id" => "Wilayah Provinsi ID", "nama" => "Nama", "ibukota" => "Ibukota", "k_bsni" => "K Bsni");
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("wilayah_kabupaten_id" => "id"));
    }
    public function getWilayahProvinsi()
    {
        return $this->hasOne(\app\models\WilayahPropinsi::className(), array("id" => "wilayah_provinsi_id"));
    }
    public function getWilayahKecamatans()
    {
        return $this->hasMany(\app\models\WilayahKecamatan::className(), array("wilayah_kabupaten_id" => "id"));
    }
}

?>