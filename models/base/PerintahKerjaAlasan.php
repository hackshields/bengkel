<?php

namespace app\models\base;

class PerintahKerjaAlasan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "perintah_kerja_alasan";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("created_at", "updated_at", "updated_by"), "safe"), array(array("created_by"), "integer"), array(array("nama"), "string", "max" => 40));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getPerintahKerjas()
    {
        return $this->hasMany(\app\models\PerintahKerja::className(), array("perintah_kerja_alasan_id" => "id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
}

?>