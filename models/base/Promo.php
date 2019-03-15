<?php

namespace app\models\base;

class Promo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "promo";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "nama", "tanggal_awal", "tanggal_akhir"), "required"), array(array("jaringan_id", "diskon_r", "diskon_jasa_r", "status", "created_by", "updated_by"), "integer"), array(array("diskon_p", "diskon_jasa_p"), "number"), array(array("tanggal_awal", "tanggal_akhir", "created_at", "updated_at"), "safe"), array(array("nama"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "nama" => "Nama", "diskon_p" => "Diskon P", "diskon_r" => "Diskon R", "diskon_jasa_p" => "Diskon Jasa P", "diskon_jasa_r" => "Diskon Jasa R", "tanggal_awal" => "Tanggal Awal", "tanggal_akhir" => "Tanggal Akhir", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
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
}

?>