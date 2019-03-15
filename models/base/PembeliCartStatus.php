<?php

namespace app\models\base;

class PembeliCartStatus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pembeli_cart_status";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("nama"), "string", "max" => 50));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama");
    }
    public function getPembeliCarts()
    {
        return $this->hasMany(\app\models\PembeliCart::className(), array("pembeli_cart_status_id" => "id"));
    }
}

?>