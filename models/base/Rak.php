<?php

namespace app\models\base;

class Rak extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "rak";
    }
    public function rules()
    {
        return array(array(array("jaringan_id", "gudang_id", "kode", "nama", "rak_jenis_id"), "required"), array(array("jaringan_id", "gudang_id", "rak_jenis_id", "status", "created_by", "updated_by"), "integer"), array(array("created_at", "updated_at"), "safe"), array(array("kode"), "string", "max" => 6), array(array("nama"), "string", "max" => 30));
    }
    public function attributeLabels()
    {
        return array("id" => "ID", "jaringan_id" => "Jaringan", "gudang_id" => "Gudang", "kode" => "Kode", "nama" => "Nama", "rak_jenis_id" => "Jenis Rak", "status" => "Status", "created_at" => "Created At", "updated_at" => "Updated At", "created_by" => "Created By", "updated_by" => "Updated By");
    }
    public function getPenerimaanPartDetails()
    {
        return $this->hasMany(\app\models\PenerimaanPartDetail::className(), array("rak_id" => "id"));
    }
    public function getPengeluaranPartDetails()
    {
        return $this->hasMany(\app\models\PengeluaranPartDetail::className(), array("rak_id" => "id"));
    }
    public function getPerintahKerjaSukuCadangs()
    {
        return $this->hasMany(\app\models\PerintahKerjaSukuCadang::className(), array("rak_id" => "id"));
    }
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "created_by"));
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), array("id" => "updated_by"));
    }
    public function getJaringan()
    {
        return $this->hasOne(\app\models\Jaringan::className(), array("id" => "jaringan_id"));
    }
    public function getGudang()
    {
        return $this->hasOne(\app\models\Gudang::className(), array("id" => "gudang_id"));
    }
    public function getRakJenis()
    {
        return $this->hasOne(\app\models\RakJenis::className(), array("id" => "rak_jenis_id"));
    }
    public function getStockOpnameDetails()
    {
        return $this->hasMany(\app\models\StockOpnameDetail::className(), array("rak_id" => "id"));
    }
    public function getStockOpnameRecounts()
    {
        return $this->hasMany(\app\models\StockOpnameRecount::className(), array("rak_id" => "id"));
    }
    public function getSukuCadangJaringans()
    {
        return $this->hasMany(\app\models\SukuCadangJaringan::className(), array("rak_id" => "id"));
    }
}

?>