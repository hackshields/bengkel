<?php

namespace app\models\base;

class ViewStokKosong extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "view_stok_kosong";
    }
    public function rules()
    {
        return array(array(array("id", "jaringan_id", "suku_cadang_id", "jumlah"), "integer"), array(array("jaringan_id", "suku_cadang_id", "kode", "nama", "jumlah"), "required"), array(array("kode"), "string", "max" => 50), array(array("kode_plasa"), "string", "max" => 6), array(array("nama", "nama_sinonim"), "string", "max" => 100));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan ID", "suku_cadang_id" => "Suku Cadang ID", "kode" => "Kode", "kode_plasa" => "Kode Plasa", "nama" => "Nama", "nama_sinonim" => "Nama Sinonim", "jumlah" => "Jumlah");
    }
}

?>