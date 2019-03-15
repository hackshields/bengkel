<?php

namespace app\models\base;

class HariAktif extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "hari_aktif";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "tanggal"), "required"), array(array("jaringan_id", "online_id", "is_need_update", "created_by", "updated_by"), "integer"), array(array("tanggal", "created_at", "updated_at"), "safe"));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "tanggal" => "Tanggal", "online_id" => "Online ID", "is_need_update" => "Is Need Update", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>