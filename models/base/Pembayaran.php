<?php

namespace app\models\base;

class Pembayaran extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "pembayaran";
    }
    public function rules()
    {
        return array(array(array("kode", "nama"), "required"), array(array("status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 10), array(array("nama"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "kode" => "Kode", "nama" => "Nama", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getPenerimaanParts()
    {
        return $this->hasMany(\app\models\PenerimaanPart::className(), array("pembayaran_id" => "id"));
    }
}

?>