<?php

namespace app\models\base;

class ViewKpb extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "view_kpb";
    }
    public function rules()
    {
        return array(array(array("pkb_id", "jaringan_id", "konsumen_id", "motor_id", "kpb_id", "km"), "integer"), array(array("jaringan_id", "no_pkb", "motor_kode", "motor_nama", "kpb_nama"), "required"), array(array("tanggal_service", "tanggal_beli"), "safe"), array(array("no_pkb"), "string", "max" => 20), array(array("no_mesin", "no_rangka", "motor_nama"), "string", "max" => 50), array(array("nopol"), "string", "max" => 12), array(array("motor_kode", "kpb_nama"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("pkb_id" => "Pkb ID", "jaringan_id" => "Jaringan ID", "tanggal_service" => "Tanggal Service", "no_pkb" => "No Pkb", "konsumen_id" => "Konsumen ID", "no_mesin" => "No Mesin", "no_rangka" => "No Rangka", "nopol" => "Nopol", "motor_id" => "Motor ID", "motor_kode" => "Motor Kode", "motor_nama" => "Motor Nama", "tanggal_beli" => "Tanggal Beli", "kpb_id" => "Kpb ID", "kpb_nama" => "Kpb Nama", "km" => "Km");
    }
}

?>