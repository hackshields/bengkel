<?php

namespace app\models\base;

class Pit extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pit";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "pit_number"), "required"), array(array("jaringan_id", "status"), "integer"), array(array("pit_number"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "pit_number" => "Pit Number", "status" => "Status");
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
}

?>