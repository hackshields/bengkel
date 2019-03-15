<?php

namespace app\models\base;

class ViewNjb extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "view_njb";
    }
    public function rules()
    {
        return array(array(array("id", "status_njb_id", "jaringan_id", "total"), "integer"), array(array("no_njb", "no_pkb", "jaringan_id"), "required"), array(array("tanggal_service"), "safe"), array(array("no_njb", "no_pkb"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "no_njb" => "No Njb", "no_pkb" => "No Pkb", "tanggal_service" => "Tanggal Service", "status_njb_id" => "Status Njb ID", "jaringan_id" => "Jaringan ID", "total" => "Total");
    }
}

?>