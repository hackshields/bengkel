<?php

namespace app\models\base;

class WilayahKecamatan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "wilayah_kecamatan";
    }
    public function rules()
    {
        return array(array(array("wilayah_kabupaten_id"), "required"), array(array("wilayah_kabupaten_id"), "integer"), array(array("nama"), "string", "max" => 100));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "wilayah_kabupaten_id" => "Wilayah Kabupaten ID", "nama" => "Nama");
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getWilayahDesas()
    {
        return $this->hasMany(\app\models\WilayahDesa::className(), array("wilayah_kecamatan_id" => "id"));
    }
    public function getWilayahKabupaten()
    {
        return $this->hasOne(\app\models\WilayahKabupaten::className(), array("id" => "wilayah_kabupaten_id"));
    }
}

?>