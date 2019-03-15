<?php

namespace app\models\base;

class Merek extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "merek";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("created_at", "updated_at"), "safe"), array(array("created_by", "updated_by"), "integer"), array(array("nama"), "string", "max" => 100));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getCheckpoints()
    {
        return $this->hasMany(\app\models\Checkpoint::className(), array("merek_id" => "id"));
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("merek_id" => "id"));
    }
    public function getJasaGroups()
    {
        return $this->hasMany(\app\models\JasaGroup::className(), array("merek_id" => "id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getMotors()
    {
        return $this->hasMany(\app\models\Motor::className(), array("merek_id" => "id"));
    }
    public function getSukuCadangs()
    {
        return $this->hasMany(\app\models\SukuCadang::className(), array("merek_id" => "id"));
    }
}

?>