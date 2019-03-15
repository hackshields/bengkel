<?php

namespace app\models\base;

class WilayahDesa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "wilayah_desa";
    }
    public function rules()
    {
        return array(array(array("wilayah_kecamatan_id"), "required"), array(array("wilayah_kecamatan_id"), "integer"), array(array("nama"), "string", "max" => 100), array(array("kodepos"), "string", "max" => 5));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "wilayah_kecamatan_id" => "Wilayah Kecamatan ID", "nama" => "Nama", "kodepos" => "Kodepos");
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("wilayah_desa_id" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("wilayah_desa_id" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("wilayah_desa_id" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("wilayah_desa_id" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("wilayah_desa_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("wilayah_desa_id" => "id"));
    }
    public function getWilayahKecamatan()
    {
        return $this->hasOne(\app\models\WilayahKecamatan::className(), array("id" => "wilayah_kecamatan_id"));
    }
}

?>