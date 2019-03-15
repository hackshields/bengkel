<?php

namespace app\models\base;

class BebanPembayaran extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "beban_pembayaran";
    }
    public function rules()
    {
        return array(array(array("nama"), "required"), array(array("status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("nama"), "string", "max" => 20));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "nama" => "Nama", "status" => "Status", "created_at" => "Created At", "created_by" => "Created By", "updated_at" => "Updated At", "updated_by" => "Updated By");
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getNotaJasaDetails()
    {
        return $this->hasMany(\app\models\NotaJasaDetail::className(), array("beban_pembayaran_id" => "id"));
    }
    public function getPengeluaranPartDetails()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("beban_pembayaran_id" => "id"));
    }
    public function getPerintahKerjaJasas()
    {
        return $this->hasMany(\app\models\PerintahKerjaJasa::className(), array("beban_pembayaran_id" => "id"));
    }
    public function getPerintahKerjaSukuCadangs()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("beban_pembayaran_id" => "id"));
    }
}

?>