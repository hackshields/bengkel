<?php

namespace app\models\base;

class Motor extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "motor";
    }
    public function rules()
    {
        return array(array(array("kode", "merek_id", "nama", "warna", "motor_group_id", "motor_jenis_id"), "required"), array(array("merek_id", "motor_group_id", "motor_jenis_id", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 30), array(array("nama", "warna"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "merek_id" => "Merek", "nama" => "Nama", "warna" => "Warna", "motor_group_id" => "Group", "motor_jenis_id" => "Jenis", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getMerek()
    {
        return $this->hasOne(\app\models\Merek::className(), array("id" => "merek_id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getMotorGroup()
    {
        return $this->hasOne(\app\models\MotorGroup::className(), array("id" => "motor_group_id"));
    }
    public function getMotorJenis()
    {
        return $this->hasOne(\app\models\MotorJenis::className(), array("id" => "motor_jenis_id"));
    }
}

?>