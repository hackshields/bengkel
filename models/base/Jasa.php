<?php

namespace app\models\base;

class Jasa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "jasa";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "kode", "nama", "jasa_group_id"), "required"), array(array("jaringan_id", "jasa_group_id", "frt", "harga", "operasional", "pilih", "status", "created_by", "updated_by"), "integer"), array(array("pph"), "number"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 15), array(array("nama"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan", "kode" => "Kode", "nama" => "Nama", "jasa_group_id" => "Group", "frt" => "Estimasi Waktu", "harga" => "Harga", "pph" => "PPH (%)", "operasional" => "Operasional", "pilih" => "Pilih", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getJasaGroup()
    {
        return $this->hasOne(\app\models\JasaGroup::className(), array("id" => "jasa_group_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPerintahKerjaJasas()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("jasa_id" => "id"));
    }
}

?>