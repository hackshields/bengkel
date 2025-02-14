<?php

namespace app\models\base;

class Gudang extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "gudang";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "nama"), "required"), array(array("jaringan_id", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 6), array(array("nama"), "string", "max" => 30), array(array("lokasi"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan", "kode" => "Kode", "nama" => "Nama", "lokasi" => "Lokasi", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
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
    public function getRaks()
    {
        return $this->hasMany(\app\models\Rak::className(), array("gudang_id" => "id"));
    }
    public function getSukuCadangs()
    {
        return $this->hasMany(\app\models\SukuCadang::className(), array("gudang_id" => "id"));
    }
}

?>