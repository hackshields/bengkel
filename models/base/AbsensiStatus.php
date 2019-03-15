<?php

namespace app\models\base;

class AbsensiStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "absensi_status";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("nama"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getAbsensis()
    {
        return $this->hasMany(\app\models\Absensi::className(), array("absensi_status_id" => "id"));
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