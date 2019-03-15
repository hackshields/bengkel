<?php

namespace app\models\base;

class WilayahPropinsi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "wilayah_propinsi";
    }
    public function rules()
    {
        return array(array(array("nama"), "string", "max" => 100), array(array("p_bsni"), "string", "max" => 5));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "p_bsni" => "P Bsni");
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getKaryawans()
    {
        return $this->hasMany(\app\models\Karyawan::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getKonsumens()
    {
        return $this->hasMany(\app\models\Konsumen::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getKonsumenGroups()
    {
        return $this->hasMany(\app\models\KonsumenGroup::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getSuppliers()
    {
        return $this->hasMany(\app\models\Supplier::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), array("wilayah_propinsi_id" => "id"));
    }
    public function getWilayahKabupatens()
    {
        return $this->hasMany(\app\models\WilayahKabupaten::className(), array("wilayah_provinsi_id" => "id"));
    }
}

?>