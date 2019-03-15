<?php

namespace app\models\base;

class JasaGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "jasa_group";
    }
    public function rules()
    {
        return array(array(array("kode", "nama", "merek_id"), "required"), array(array("merek_id", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 30), array(array("nama"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "nama" => "Nama", "merek_id" => "Merek", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getJasas()
    {
        return $this->hasMany(\app\models\Jasa::className(), array("jasa_group_id" => "id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getMerek()
    {
        return $this->hasOne(\app\models\Merek::className(), array("id" => "merek_id"));
    }
}

?>