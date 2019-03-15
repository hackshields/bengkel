<?php

namespace app\models\base;

class Pembeli extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pembeli";
    }
    public function rules()
    {
        return array(array(array("username", "password", "nama"), "required"), array(array("username", "password"), "string", "max" => 50), array(array("nama"), "string", "max" => 100), array(array("alamat"), "string", "max" => 200), array(array("longitude", "latitude"), "string", "max" => 10));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "username" => "Username", "password" => "Password", "nama" => "Nama", "alamat" => "Alamat", "longitude" => "Longitude", "latitude" => "Latitude");
    }
    public function getPembeliCarts()
    {
        return $this->hasMany(\app\models\PembeliCart::className(), array("pembeli_id" => "id"));
    }
}

?>