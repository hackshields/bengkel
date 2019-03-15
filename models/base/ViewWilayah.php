<?php

namespace app\models\base;

class ViewWilayah extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "view_wilayah";
    }
    public function rules()
    {
        return array(array(array("id", "desa_nama", "kec_id", "kec_nama", "kab_id", "kab_nama", "prop_id", "prop_nama"), "required"), array(array("id"), "string", "max" => 10), array(array("desa_nama", "kec_nama", "kab_nama", "prop_nama"), "string", "max" => 255), array(array("kec_id"), "string", "max" => 7), array(array("kab_id"), "string", "max" => 4), array(array("prop_id"), "string", "max" => 2));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "desa_nama" => "Desa Nama", "kec_id" => "Kec ID", "kec_nama" => "Kec Nama", "kab_id" => "Kab ID", "kab_nama" => "Kab Nama", "prop_id" => "Prop ID", "prop_nama" => "Prop Nama");
    }
}

?>