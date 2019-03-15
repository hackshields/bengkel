<?php

namespace app\models\base;

class Absensi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "absensi";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "karyawan_id"), "required"), array(array("jaringan_id", "karyawan_id", "absensi_status_id", "status_kerja", "status", "created_by", "updated_by"), "integer"), array(array("jam_masuk", "jam_pulang", "created_at", "updated_at"), "safe"), array(array("keterangan"), "string", "max" => 100));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "karyawan_id" => "Karyawan ID", "absensi_status_id" => "Absensi Status ID", "keterangan" => "Keterangan", "jam_masuk" => "Jam Masuk", "jam_pulang" => "Jam Pulang", "status_kerja" => "Status Kerja", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
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
    public function getAbsensiStatus()
    {
        return $this->hasOne(\app\models\AbsensiStatus::className(), array("id" => "absensi_status_id"));
    }
    public function getKaryawan()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "karyawan_id"));
    }
}

?>