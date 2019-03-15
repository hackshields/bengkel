<?php

namespace app\models\base;

class RakJenis extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "rak_jenis";
    }
    public function rules()
    {
        return array(array(array("kode", "nama"), "required"), array(array("status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 6), array(array("nama"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "nama" => "Nama", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getRaks()
    {
        return $this->hasMany(\app\models\Rak::className(), array("jenis_rak" => "id"));
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