<?php

namespace app\models\base;

class JaringanKategori extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "jaringan_kategori";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("created_at", "updated_at"), "safe"), array(array("created_by", "updated_by"), "integer"), array(array("nama"), "string", "max" => 100));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getJaringans()
    {
        return $this->hasMany(\app\models\Jaringan::className(), array("jaringan_kategori_id" => "id"));
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